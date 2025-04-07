<?php

$filePath = '../storage/tasks.json';

$tasks = json_decode(file_get_contents($filePath), true);

$latestTasks = array_slice($tasks, -2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-sky-100 py-8">

<div class="container mx-auto px-4">

    <h2 class="text-3xl font-semibold text-gray-800 mb-8">#last-tasks</h2>

    <?php if (!empty($latestTasks)): ?>
        <?php foreach ($latestTasks as $task): ?>
            
            <div class="grid gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                    <h3 class="text-3xl font-bold text-blue-700 py-2"><?php echo htmlspecialchars($task['title']); ?></h3>
                    
                    <p><strong>Priority:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                
                    <p class="mt-2"><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>

                <div class="mt-4">
                    <strong>Categories:</strong></p>
                            <?php foreach ($task['categories'] as $category): ?>
                                    <span class="bg-gray-200 rounded-full text-slate-600 px-3 py-1 text-sm"><?php echo htmlspecialchars($category); ?></span>
                            <?php endforeach; ?>
                </div>

                <div class="mt-4">
                    <strong class="list-decimal list-inside mt-1 text-gray-700">Steps:</strong>
                    <ol class="list-inside list-decimal text-gray-800">
                        <?php foreach ($task['steps'] as $step): ?>
                            <li class="ml-4"><?php echo htmlspecialchars($step); ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        <?php endforeach; ?>
            </div>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</div>
</body>

</html>