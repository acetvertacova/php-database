<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Task</title>
</head>

<?php
require_once '../src/handlers/task/edit.php';
?>

<body class="bg-sky-100 py-8">

    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Edit Task</h2>

        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">

            <div class="mb-4">
                <label for="title" class="block text-lg font-semibold text-gray-700">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <?php printErrors($errors, 'title'); ?>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-lg font-semibold text-gray-700">Priority</label>
                <input type="text" id="priority" name="priority" value="<?= htmlspecialchars($task['priority']) ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <?php printErrors($errors, 'priority'); ?>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-lg font-semibold text-gray-700">Description</label>
                <textarea id="description" name="description" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($task['description']) ?></textarea>
                <?php printErrors($errors, 'description'); ?>
            </div>

            <div class="mb-4">
                <label for="category" class="block text-lg font-semibold text-gray-700">Category</label>
                <input type="text" id="category" name="category" value="<?= htmlspecialchars($task['category']) ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <?php printErrors($errors, 'category'); ?>
            </div>

            <div class="mb-4">
                <label for="steps" class="block text-lg font-semibold text-gray-700">Steps</label>
                <input type="text" id="steps" name="steps" value="<?= htmlspecialchars($task['steps']) ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <?php printErrors($errors, 'steps'); ?>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition">Update Task</button>
            </div>
        </form>

    </div>

</body>

</html>