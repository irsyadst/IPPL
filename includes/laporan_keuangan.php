<?php
include __DIR__ . '/../server/database.php';
session_start();

// Ambil filter dari form
$filter = $_GET['filter'] ?? 'hari'; // default = hari ini

$whereClause = "WHERE o.status = 'selesai'";

// Tentukan rentang tanggal berdasarkan filter
if ($filter === 'hari') {
    $whereClause .= " AND DATE(o.tanggal) = CURDATE()";
} elseif ($filter === 'minggu') {
    $whereClause .= " AND YEARWEEK(o.tanggal, 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter === 'bulan') {
    $whereClause .= " AND MONTH(o.tanggal) = MONTH(CURDATE()) AND YEAR(o.tanggal) = YEAR(CURDATE())";
}

// Query untuk ambil data pesanan selesai
$sql = "
SELECT 
    o.id_order,
    u.fullname AS nama_pemesan,
    o.total AS total_harga,
    o.tanggal
FROM orders o
JOIN user u ON o.id_user = u.id_user
$whereClause
ORDER BY o.tanggal DESC
";

$result = mysqli_query($db, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Hitung total pendapatan
$totalPendapatan = array_sum(array_column($orders, 'total_harga'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <link rel="stylesheet" href="/../assets/style/admin.css">
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

    <div class="admin-dashboard">
        <h1>📊 Laporan Keuangan</h1>

        <form method="GET">
            <label for="filter">Tampilkan berdasarkan:</label>
            <select name="filter" onchange="this.form.submit()">
                <option value="hari" <?= $filter === 'hari' ? 'selected' : '' ?>>Hari</option>
                <option value="minggu" <?= $filter === 'minggu' ? 'selected' : '' ?>>Minggu</option>
                <option value="bulan" <?= $filter === 'bulan' ? 'selected' : '' ?>>Bulan </option>
            </select>
        </form>

        <h3>Total Pendapatan: Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></h3>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Pesanan</th>
                    <th>Nama Pemesan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="4">Tidak ada data.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= date('Y-m-d', strtotime($order['tanggal'])) ?></td>
                            <td><?= htmlspecialchars($order['id_order']) ?></td>
                            <td><?= htmlspecialchars($order['nama_pemesan']) ?></td>
                            <td>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
