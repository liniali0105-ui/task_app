<?php
require 'db.php';

// Handle form submission (Adding a task)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
    $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
    $stmt->execute(['title' => $_POST['title']]);
    header("Location: index.php");
    exit;
}

// Fetch all tasks from database
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">My Task List</h1>
    
    <form action="index.php" method="POST" class="flex gap-2 mb-6">
        <input type="text" name="title" placeholder="New task title..." required class="border p-2 flex-1 rounded">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Task</button>
    </form>

    <ul class="bg-white rounded shadow divide-y">
        <?php foreach ($tasks as $task): ?>
            <li class="p-3 flex justify-between items-center">
                <span><?= htmlspecialchars($task['title']) ?></span>
                <span class="text-xs bg-gray-200 px-2 py-1 rounded"><?= $task['status'] ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>