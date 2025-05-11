<?php
session_start();
include __DIR__ . "/../server/database.php";

if (!isset($_GET['order_id'])) {
    header("Location: menu.php");
    exit;
}

$orderId = $_GET['order_id'];

// Ambil informasi pesanan dari database
$sql = "SELECT * FROM orders WHERE id_order = $orderId";
$result = mysqli_query($db, $sql);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    // Jika tidak ditemukan, redirect ke menu
    header("Location: menu.php");
    exit;
}

// Ambil daftar item pesanan
$sql_items = "SELECT oi.qty, oi.subtotal, m.nama_menu FROM order_items oi
              JOIN menu m ON oi.id_menu = m.id_menu
              WHERE oi.id_order = $orderId";
$result_items = mysqli_query($db, $sql_items);

$items = [];
while ($row = mysqli_fetch_assoc($result_items)) {
    $items[] = $row;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Sukses</title>
    <link rel="stylesheet" href="/../assets/style/checkout_sukses.css">
</head>
<body>
<?php include __DIR__ . "/../layout/navbar.php"; ?>

    <div class="checkout-success">
        <h1>Pesanan Berhasil!</h1>
        <p>Pesanan kamu telah diterima. ID Pesanan: <strong>#<?= $order['id_order'] ?></strong></p>
        <p>Total: <strong>Rp<?= number_format($order['total']) ?></strong></p>

        <h2>Detail Pesanan:</h2>
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
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama_menu']) ?></td>
                        <td>Rp<?= number_format($item['subtotal'] / $item['qty']) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>Rp<?= number_format($item['subtotal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="menu.php" class="back-btn">← Kembali ke Menu</a>
    </div>

<?php include __DIR__ . "/../layout/footer.html"; ?>
</body>
</html>

<?php $db->close(); ?>
