<?php

/**
 * This script handles the creation of a new task.
 * It validates form input and inserts the task into the database if validation passes.
 */
require_once __DIR__ . '/../../helpers.php';

$errors = [];

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getPDO();

        $title = $_POST['title'];
        $priority = $_POST['priority'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $steps = $_POST['steps'];

        fieldRequired($_POST, $errors);
        fieldLength($_POST, $errors);
        if (empty($errors)) {
            create($pdo, $title, $priority, $description, $category, $steps);
            header("Location: /");
        }
    } catch (Exception $e) {
        echo "Error " . $e->getMessage();
    }
}
