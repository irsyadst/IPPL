<?php
include __DIR__ . "/../server/database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_order = (int) $_POST['id_order'];
    $status = $_POST['status'];

    // Validasi status pesanan
    if (!in_array($status, ['pending', 'diproses', 'selesai'])) {
        die("Status pesanan tidak valid.");
    }

    // Update status pesanan di database
    $stmt = $db->prepare("UPDATE orders SET status = ? WHERE id_order = ?");
    $stmt->bind_param("si", $status, $id_order);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php"); // Kembali ke dashboard setelah update
        exit;
    } else {
        echo "Gagal memperbarui status pesanan.";
    }
}
?>
