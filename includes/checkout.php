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
        'subtotal' => $subtotal
    ];
    $total += $subtotal;
}

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

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Sukses</title>
    <link rel="stylesheet" href="/../assets/style/menu.css">
</head>
<body>
<?php include __DIR__ . "/../layout/navbar.php"; ?>

    <div class="checkout-success">
        <h1>✅ Pesanan Berhasil!</h1>
        <p>Pesanan kamu telah diterima. ID Pesanan: <strong>#<?= $orderId ?></strong></p>
        <p>Total: <strong>Rp<?= number_format($total) ?></strong></p>
        <a href="menu.php" class="back-btn">← Kembali ke Menu</a>
    </div>

<?php include __DIR__ . "/../layout/footer.html"; ?>
</body>
</html>

<?php $db->close(); ?>
