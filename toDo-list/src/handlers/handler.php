<?php

require_once __DIR__ . '/../helpers.php';

$filePath = __DIR__ . '/../../storage/tasks.json';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    fieldRequired(['title' => ($_POST['title'] ?? ''),
            'priority' => ($_POST['priority'] ?? ''),
            'description' => ($_POST['description'] ?? ''),
            'categories' => $_POST['categories'] ?? [],
            'steps' => $_POST['steps'] ?? []], $errors);
            
    fieldLength($_POST, 'title', $errors);
    fieldLength($_POST, 'description', $errors);

    if (empty($errors)) {
        $newTask = [
            'title' => trim($_POST['title'] ?? ''),
            'priority' => trim($_POST['priority'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'categories' => $_POST['categories'] ?? [],
            'steps' => $_POST['steps'] ?? []
        ];

        $tasks = json_decode(file_get_contents($filePath), true);
        $tasks[] = $newTask;

        file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT));

        header('Location: /public/index.php');
        exit;
    }

}
