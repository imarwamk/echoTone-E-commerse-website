<?php
session_start();
include '../../includes/db.php'; 
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/auth.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $query = "DELETE FROM products WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Error deleting product.'); window.location.href='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
}
?>
