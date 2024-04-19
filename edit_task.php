<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    // Fetch task from database based on id
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $task_name = $_POST["task"];

    // Update task in database
    $sql = "UPDATE tasks SET task_name = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$task_name, $id]);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Edit Task</h1>
    <form action="edit_task.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <div class="form-group">
            <input type="text" class="form-control" name="task" value="<?php echo $task['task_name']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
