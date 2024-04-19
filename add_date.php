<?php
require_once 'connection.php'; // Menggunakan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST["task_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    // Insert dates into database
    $sql = "INSERT INTO task_dates (task_id, start_date, end_date) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task_id, $start_date, $end_date]);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
}
?>
