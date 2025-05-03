<?php
include __DIR__ . "/../server/database.php";
session_start();

// Ambil semua data pesanan lengkap
$sql = "
SELECT 
    o.id_order,
    u.fullname AS nama_pemesan,
    GROUP_CONCAT(m.nama_menu SEPARATOR ', ') AS menu,
    SUM(oi.qty) AS jumlah,
    o.total AS total_harga,
    o.status,
    o.tanggal
FROM orders o
JOIN user u ON o.id_user = u.id_user
JOIN order_items oi ON o.id_order = oi.id_order
JOIN menu m ON oi.id_menu = m.id_menu
GROUP BY o.id_order
ORDER BY o.tanggal DESC
";

$result = mysqli_query($db, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Pisahkan data menjadi 2: aktif dan selesai
$orders_aktif = array_filter($orders, fn($order) => $order['status'] !== 'selesai');
$orders_selesai = array_filter($orders, fn($order) => $order['status'] === 'selesai');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
        <h1>📋 Pesanan Aktif</h1>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Pesanan</th>
                    <th>Nama Pemesan</th>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders_aktif)): ?>
                    <tr><td colspan="8">Tidak ada pesanan aktif.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders_aktif as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['tanggal']) ?></td>
                            <td><?= htmlspecialchars($order['id_order']) ?></td>
                            <td><?= htmlspecialchars($order['nama_pemesan']) ?></td>
                            <td><?= htmlspecialchars($order['menu']) ?></td>
                            <td><?= htmlspecialchars($order['jumlah']) ?></td>
                            <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($order['status']) ?></td>
                            <td>
                                <form method="post" action="update_order.php">
                                    <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
                                    <select name="status">
                                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="diproses" <?= $order['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                                        <option value="selesai" <?= $order['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <h1>📜 Riwayat Pesanan Selesai</h1>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Pesanan</th>
                    <th>Nama Pemesan</th>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders_selesai)): ?>
                    <tr><td colspan="7">Belum ada pesanan yang selesai.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders_selesai as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['tanggal']) ?></td>
                            <td><?= htmlspecialchars($order['id_order']) ?></td>
                            <td><?= htmlspecialchars($order['nama_pemesan']) ?></td>
                            <td><?= htmlspecialchars($order['menu']) ?></td>
                            <td><?= htmlspecialchars($order['jumlah']) ?></td>
                            <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                            <td><em>Selesai</em></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
