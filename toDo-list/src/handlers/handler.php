<?php
/**
 * Includes helper functions that are used for validation of form data.
 */
require_once __DIR__ . '/../helpers.php';

/**
 * Path to the tasks JSON file where tasks are stored.
 * @var string
 */
$filePath = __DIR__ . '/../../storage/tasks.json';

/**
 * Array to hold validation errors for each field.
 * @var array
 */
$errors = [];

/**
 * Processes the POST request to create a new task.
 * The task data is validated and saved to the JSON file if there are no errors.
 */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

     /**
     * Validates the required fields and ensures that necessary fields are provided.
     * 
     * @param array $postArray - The associative array containing POST data.
     * @param array &$errors - The array where validation errors are stored.
     */
    fieldRequired(['title' => ($_POST['title'] ?? ''),
            'priority' => ($_POST['priority'] ?? ''),
            'description' => ($_POST['description'] ?? ''),
            'categories' => $_POST['categories'] ?? [],
            'steps' => $_POST['steps'] ?? []], $errors);
            
    /**
     * Validates the length of specific fields.
     * The title and description fields should have lengths within the specified range.
     * 
     * @param array $postArray - The associative array containing POST data.
     * @param string $field - The specific field (title or description) to validate.
     * @param array &$errors - The array where validation errors are stored.
     */
    fieldLength($_POST, 'title', $errors);
    fieldLength($_POST, 'description', $errors);

    /**
     * If no errors occurred during validation, the new task is saved to the JSON file.
     */
    if (empty($errors)) {
        $newTask = [
            'title' => trim($_POST['title'] ?? ''),
            'priority' => trim($_POST['priority'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'categories' => $_POST['categories'] ?? [],
            'steps' => $_POST['steps'] ?? []
        ];

        // Retrieve existing tasks from the JSON file.
        $tasks = json_decode(file_get_contents($filePath), true);
        // Add the new task to the list of tasks.
        $tasks[] = $newTask;

        // Save the updated list of tasks back to the JSON file.
        file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT));

        // Redirect the user to the task listing page after successfully adding the task.
        header('Location: /public/index.php');
        exit;
    }

}
