<?php
include __DIR__ . "/../server/database.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_menu = (int) $_POST['id_menu'];
    $status = $_POST['status'];

    // Validasi status
    if (!in_array($status, ['aktif', 'nonaktif'])) {
        die("Status tidak valid.");
    }

    // Update status menu di database
    $stmt = $db->prepare("UPDATE menu SET status = ? WHERE id_menu = ?");
    $stmt->bind_param("si", $status, $id_menu);

    if ($stmt->execute()) {
        header("Location: kelola_menu.php"); // Kembali ke halaman kelola menu setelah update
        exit;
    } else {
        echo "Gagal memperbarui status.";
    }
}
?>

