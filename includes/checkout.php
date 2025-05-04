<?php
session_start();
include __DIR__ . "/../server/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /server/login.php?msg=login_required");
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if (empty($cart)) {
    header("Location: keranjang.php");
    exit;
}

$total = 0;
$menuData = [];
$ids = implode(",", array_keys($cart));
$sql = "SELECT * FROM menu WHERE id_menu IN ($ids)";
$result = mysqli_query($db, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_menu'];
    $qty = $cart[$id];
    $subtotal = $qty * $row['harga'];
    $menuData[] = [
        'id_menu' => $id,
        'qty' => $qty,
        'subtotal' => $subtotal,
        'nama_menu' => $row['nama_menu'],
        'harga' => $row['harga']
    ];
    $total += $subtotal;
}

// Proses checkout jika tombol 'checkout' ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['checkout'])) {
    // ✅ Simpan ke tabel orders (dengan id_user)
    $id_user = $_SESSION['user_id'];
    mysqli_query($db, "INSERT INTO orders (id_user, total) VALUES ($id_user, $total)");
    $orderId = mysqli_insert_id($db);

    // Simpan ke tabel order_items
    foreach ($menuData as $item) {
        $id_menu = $item['id_menu'];
        $qty = $item['qty'];
        $subtotal = $item['subtotal'];
        mysqli_query($db, "INSERT INTO order_items (id_order, id_menu, qty, subtotal) VALUES ($orderId, $id_menu, $qty, $subtotal)");
    }

    // Kosongkan keranjang
    unset($_SESSION['cart']);

    // Redirect ke halaman sukses checkout
    header("Location: checkout_sukses.php?order_id=$orderId");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="/../assets/style/checkout.css">
</head>
<body>
<?php include __DIR__ . "/../layout/navbar.php"; ?>

    <div class="checkout-notice">
        <h1>Nota Pembelian</h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menuData as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_menu']) ?></td>
                        <td>Rp<?= number_format($item['harga']) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>Rp<?= number_format($item['subtotal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <strong>Total: Rp<?= number_format($total) ?></strong>
        </div>

        <form method="POST">
            <a href="keranjang.php" class="back-btn">← Kembali ke Keranjang</a>
            <button type="submit" name="checkout" class="checkout-btn">Konfirmasi Pesanan</button>
        </form>
    </div>

<?php include __DIR__ . "/../layout/footer.html"; ?>
</body>
</html>

<?php $db->close(); ?>
