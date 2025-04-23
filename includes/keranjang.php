<?php
session_start();
include __DIR__ . "/../server/database.php";

if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: /server/login.php?msg=login_required");
    exit;
}
// Tambah jumlah item
if (isset($_GET['tambah'])) {
    $tambahId = $_GET['tambah'];
    if (isset($_SESSION['cart'][$tambahId])) {
        $_SESSION['cart'][$tambahId]++;
    }
    header("Location: keranjang.php");
    exit;
}

// Kurangi jumlah item
if (isset($_GET['kurang'])) {
    $kurangId = $_GET['kurang'];
    if (isset($_SESSION['cart'][$kurangId])) {
        $_SESSION['cart'][$kurangId]--;
        if ($_SESSION['cart'][$kurangId] <= 0) {
            unset($_SESSION['cart'][$kurangId]);
        }
    }
    header("Location: keranjang.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_menu'])) {
    $id_menu = $_POST['id_menu'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id_menu])) {
        $_SESSION['cart'][$id_menu]++;
    } else {
        $_SESSION['cart'][$id_menu] = 1;
    }
    header("Location: menu.php");
    exit;
}


// Ambil data menu dari database berdasarkan ID yang ada di keranjang
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$menus = [];
$totalHarga = 0;

if (!empty($cartItems)) {
    $ids = implode(',', array_keys($cartItems));
    $sql = "SELECT * FROM menu WHERE id_menu IN ($ids)";
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id_menu'];
        $qty = $cartItems[$id];
        $row['qty'] = $qty;
        $row['subtotal'] = $qty * $row['harga'];
        $menus[] = $row;
        $totalHarga += $row['subtotal'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="/../assets/style/menu.css">
</head>

<body>
    <?php include __DIR__ . "/../layout/navbar.php"; ?>
    <h1>Keranjang Belanja</h1>

    <div class="cart-container">
        <?php if (!empty($menus)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_menu']) ?></td>
                            <td>Rp<?= number_format($item['harga']) ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>Rp<?= number_format($item['subtotal']) ?></td>
                            <td>
                                <a href="?tambah=<?= $item['id_menu'] ?>">➕</a>
                                <a href="?kurang=<?= $item['id_menu'] ?>">➖</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total">
                <strong>Total: Rp<?= number_format($totalHarga) ?></strong>
            </div>

            <div class="checkout-actions">
                <a href="checkout.php" class="checkout-btn">Checkout</a>
                <a href="menu.php" class="back-btn">← Kembali ke Menu</a>
            </div>
        <?php else: ?>
            <p>Keranjang kamu masih kosong. <a href="menu.php">Pilih menu</a></p>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . "/../layout/footer.html"; ?>
</body>

</html>

<?php $db->close(); ?>