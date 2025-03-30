<?php

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $newTask = [
        'title' => trim($_POST['title'] ?? ''),
        'priority' => trim($_POST['priority'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'categories' => $_POST['categories'] ?? [],
        'steps' => trim($_POST['steps'] ?? [])
    ];
    
    if (empty($_POST['title'])) {
        $errors['title'][] = 'Title is required';
    }
$existingTasks = json_decode(file_get_contents(__DIR__ . '/../../storage/tasks.json'), true);
$existingTasks[] = $newTask;

file_put_contents(__DIR__ . '/../../storage/tasks.json', json_encode($existingTasks, JSON_PRETTY_PRINT));

}

