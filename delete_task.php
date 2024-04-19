<?php
require_once 'connection.php'; // Menggunakan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Delete task from database
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task_id]);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
} else {
    // Jika request tidak sesuai, kembalikan ke halaman utama
    header("Location: index.php");
    exit();
}
?>