<?php
include __DIR__ . "/../server/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_order = $_POST['id_order'];
    $status = $_POST['status'];

    mysqli_query($db, "UPDATE orders SET status = '$status' WHERE id_order = $id_order");
}

header("Location: admin_dashboard.php");
exit;
