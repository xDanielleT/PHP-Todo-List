<?php
session_start();

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Add a new task
if (isset($_POST['add'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $_SESSION['tasks'][] = [
            'text' => $task,
            'completed' => false
        ];
    }
}

// Delete a task
if (isset($_POST['delete'])) {
    $index = $_POST['index'];
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reindex
}

// Toggle completed
if (isset($_POST['toggle'])) {
    $index = $_POST['index'];
    $_SESSION['tasks'][$index]['completed'] = !$_SESSION['tasks'][$index]['completed'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List with Checkboxes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>My To-Do List</h1>

        <!-- Add Task Form -->
        <form method="POST">
            <input type="text" name="task" placeholder="Enter a new task">
            <button type="submit" name="add">Add</button>
        </form>

        <!-- Task List -->
        <ul>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
                    <form method="POST" class="toggle-form">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <input type="checkbox" name="toggle" onchange="this.form.submit()" <?php echo $task['completed'] ? 'checked' : ''; ?>>
                        <span><?php echo htmlspecialchars($task['text']); ?></span>
                    </form>

                    <form method="POST" class="delete-form">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
