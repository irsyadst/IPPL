<?php
include __DIR__ . "/../server/database.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /server/login.php");
    exit;
}

// Ambil semua pesanan selesai
$sql = "
SELECT 
    o.id_order,
    u.fullname AS nama_pemesan,
    o.total AS total_harga,
    o.tanggal
FROM orders o
JOIN user u ON o.id_user = u.id_user
WHERE o.status = 'selesai'
ORDER BY o.tanggal DESC
";

$result = mysqli_query($db, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Hitung total pemasukan
$totalPemasukan = 0;
foreach ($orders as $order) {
    $totalPemasukan += $order['total_harga'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <link rel="stylesheet" href="/../assets/style/admin.css">
    <style>
        body { display: flex; font-family: Arial, sans-serif; }
        .sidebar {
            width: 220px; background-color: #2c3e50; color: white;
            height: 100vh; padding: 20px; box-sizing: border-box;
        }
        .sidebar h2 { font-size: 24px; }
        .sidebar a {
            display: block; color: white; text-decoration: none;
            margin: 15px 0; font-size: 16px;
        }
        .sidebar a:hover { background-color: #34495e; padding-left: 10px; }
        .content {
            margin-left: 240px; padding: 30px; width: 100%;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-box {
            margin-top: 20px;
            background-color: #ecf0f1;
            padding: 20px;
            font-size: 18px;
            border-radius: 5px;
            width: fit-content;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_dashboard.php">📋 Pesanan</a>
        <a href="tambah_admin.php">➕ Tambah Admin</a>
        <a href="kelola_menu.php">🛠️ Kelola Menu</a>
        <a href="laporan_keuangan.php">📊 Laporan Keuangan</a>
        <a href="/server/logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <h1>📊 Laporan Keuangan</h1>

        <div class="total-box">
            <strong>Total Pemasukan:</strong> Rp<?= number_format($totalPemasukan) ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pemesan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id_order']) ?></td>
                        <td><?= htmlspecialchars($order['nama_pemesan']) ?></td>
                        <td><?= htmlspecialchars($order['tanggal']) ?></td>
                        <td>Rp<?= number_format($order['total_harga']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
