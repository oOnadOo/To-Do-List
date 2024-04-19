<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST["task"];

    // Connect to database (Assuming you have already set up database connection)

    // Insert task into database
    $sql = "INSERT INTO tasks (task_name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task]);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
}
?>
