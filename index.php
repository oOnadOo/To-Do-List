<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todolist";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Untuk menambahkan task baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    $task_name = $_POST['task'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Memasukkan task baru ke dalam database
    $sql = "INSERT INTO tasks (task_name, start_date, end_date, status) VALUES (?, ?, ?, 'Pending')";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$task_name, $start_date, $end_date])) {
        // Task berhasil ditambahkan, refresh halaman untuk menampilkan perubahan
        header("Location: index.php");
        exit();
    } else {
        // Terjadi kesalahan saat menambahkan task
        echo "Error: Failed to add task.";
    }
}

// Untuk memperbarui task (termasuk status) yang ada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];

    // Memperbarui task (termasuk status) di database
    $sql = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$new_status, $task_id])) {
        // Task berhasil diperbarui, refresh halaman untuk menampilkan perubahan
        header("Location: index.php");
        exit();
    } else {
        // Terjadi kesalahan saat memperbarui task
        echo "Error: Failed to update task.";
    }
}

// Untuk menghapus task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])) {
    $task_id = $_POST['task_id'];

    // Menghapus task dari database
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$task_id])) {
        // Task berhasil dihapus, refresh halaman untuk menampilkan perubahan
        header("Location: index.php");
        exit();
    } else {
        // Terjadi kesalahan saat menghapus task
        echo "Error: Failed to delete task.";
    }
}

// Ambil data task dari database
$sql = "SELECT id, task_name, start_date, end_date, status FROM tasks";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="mb-4">To Do List</h1>
    <form action="index.php" method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="task" placeholder="Add a new task">
            <input type="date" class="form-control" name="start_date" placeholder="Start Date">
            <input type="date" class="form-control" name="end_date" placeholder="End Date">
            <button type="submit" class="btn btn-primary">Add Task</button>
        </div>
    </form>

    <div class="task-table">
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo $task['task_name']; ?></td>
                        <td><?php echo $task['start_date']; ?></td>
                        <td><?php echo $task['end_date']; ?></td>
                        <td><?php echo isset($task['status']) ? $task['status'] : 'Unknown'; ?></td>
                        <td>
                            <form action="index.php" method="POST">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <select name="new_status">
                                    <option value="Pending" <?php if ($task['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                <button type="submit" name="update_task" class="btn btn-primary btn-sm">Update</button>
                                <button type="submit" name="delete_task" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function showDateForm(taskId) {
        var dateForm = document.getElementById('date-form-' + taskId);
        dateForm.style.display = 'block';
    }
</script>
</body>
</html>
