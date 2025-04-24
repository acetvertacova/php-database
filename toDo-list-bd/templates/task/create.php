<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Create new task</title>
</head>

<?php
require_once '../src/handlers/task/create.php';
?>

<body class="bg-sky-100 py-8">

    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-semibold text-gray-800 mb-8">Create New Task</h2>

        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-lg">

            <div class="mb-4">
                <label for="title" class="block text-lg font-semibold text-gray-700">Task's Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <?php printErrors($errors, 'title'); ?>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-lg font-semibold text-gray-700">Priority</label>
                <input type="text" id="priority" name="priority" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
                <?php printErrors($errors, 'priority'); ?>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-lg font-semibold text-gray-700">Description</label>
                <textarea id="description" name="description" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                <?php printErrors($errors, 'description'); ?>
            </div>

            <div class="mb-4">
                <label for="category" class="block text-lg font-semibold text-gray-700">Category</label>
                <textarea id="category" name="category" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                <?php printErrors($errors, 'category'); ?>
            </div>

            <div class="mb-4">
                <label for="steps" class="block text-lg font-semibold text-gray-700">Steps</label>
                <textarea id="steps" name="steps" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                <?php printErrors($errors, 'steps'); ?>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition">Add Task</button>
            </div>
        </form>
    </div>

</body>

</html>