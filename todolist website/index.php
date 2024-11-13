<?php
require 'config.php';

// Tambah todo
if(isset($_POST['submit'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    if(mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Hapus todo
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    if(mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Toggle status
if(isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $sql = "UPDATE tasks SET status = NOT status WHERE id=$id";
    if(mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Ambil semua todo
$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$todos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List App</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 20px auto;
        padding: 0 20px;
        background-color: #f5f5f5;
    }

    .container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    .todo-form {
        margin-bottom: 30px;
        display: flex;
        gap: 10px;
    }

    .todo-form input[type="text"] {
        flex: 1;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .todo-form button {
        padding: 12px 24px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .todo-form button:hover {
        background-color: #45a049;
    }

    .todo-list {
        list-style: none;
        padding: 0;
    }

    .todo-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .todo-item:hover {
        background-color: #f9f9f9;
    }

    .todo-item.completed {
        background-color: #f9f9f9;
    }

    .todo-item.completed .task-text {
        text-decoration: line-through;
        color: #888;
    }

    .task-text {
        flex-grow: 1;
        font-size: 16px;
    }

    .action-btn {
        padding: 8px 16px;
        margin-left: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        border-radius: 4px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .toggle-btn {
        background-color: #2196F3;
    }

    .toggle-btn:hover {
        background-color: #1976D2;
    }

    .delete-btn {
        background-color: #f44336;
    }

    .delete-btn:hover {
        background-color: #d32f2f;
    }

    .created-at {
        font-size: 12px;
        color: #888;
        margin-left: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Todo List App</h1>

        <!-- Form tambah todo -->
        <form class="todo-form" method="POST">
            <input type="text" name="task" placeholder="Tambah tugas baru..." required>
            <button type="submit" name="submit">Tambah</button>
        </form>

        <!-- Daftar todo -->
        <ul class="todo-list">
            <?php if(empty($todos)): ?>
            <li class="todo-item" style="justify-content: center; color: #888;">
                Belum ada tugas. Tambahkan tugas baru!
            </li>
            <?php endif; ?>

            <?php foreach($todos as $todo): ?>
            <li class="todo-item <?php echo $todo['status'] ? 'completed' : ''; ?>">
                <span class="task-text">
                    <?php echo htmlspecialchars($todo['task']); ?>
                    <span class="created-at">
                        <?php echo date('d/m/Y H:i', strtotime($todo['created_at'])); ?>
                    </span>
                </span>
                <a href="?toggle=<?php echo $todo['id']; ?>" class="action-btn toggle-btn">
                    <?php echo $todo['status'] ? 'Batal' : 'Selesai'; ?>
                </a>
                <a href="?delete=<?php echo $todo['id']; ?>" class="action-btn delete-btn"
                    onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                    Hapus
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>