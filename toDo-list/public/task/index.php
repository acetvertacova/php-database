<?php

$filePath = '../../storage/tasks.json';
$tasks = json_decode(file_get_contents($filePath), true);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Task ID is missing or invalid.';
    exit;
}

$id = intval($_GET['id']);
$task = $tasks[$id - 1] ?? null;

if (!$task) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task by id</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-gray-800">

    <div class="container mx-auto py-10">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow-md space-y-6">
            <h1 class="text-3xl font-bold text-blue-700"><?php echo htmlspecialchars($task['title']); ?></h1>

            <div class="space-y-2">
                <p><strong>Priority:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>

                    <div>
                        <strong>Categories:</strong>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <?php foreach ($task['categories'] as $category): ?>
                                <span class="bg-gray-200 rounded-full text-slate-600 px-3 py-1 text-sm">
                                    <?php echo htmlspecialchars($category); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <strong>Steps:</strong>
                        <ol class="list-decimal list-inside mt-1 text-gray-700">
                            <?php foreach ($task['steps'] as $step): ?>
                                <li><?php echo htmlspecialchars($step); ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
            </div>

            <a href="../index.php" class="inline-block mt-4">
                <button class="bg-blue-700 hover:bg-blue-600 px-4 py-2 text-white rounded-md transition">
                    ← Back to tasks
                </button>
            </a>
        </div>
    </div>

</body>
</html>



