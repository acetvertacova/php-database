<?php
require_once __DIR__ . '/../../helpers.php';
$errors = [];

try {
    $pdo = getPDO();
    $id = $_GET['id'] ?? null;

    if (!$id) {
        die("No task ID provided.");
    }

    $stmt = $pdo->prepare("SELECT t.title, t.description, t.priority, t.steps , c.name as category FROM task t
    LEFT JOIN category c ON t.category_id = c.id
    WHERE t.id = :id");

    $stmt->execute([':id' => $id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Task not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $priority = $_POST['priority'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $steps = $_POST['steps'];

        fieldRequired($_POST, $errors);
        fieldLength($_POST, $errors);

        if (empty($errors)) {
            update($pdo, $title, $priority, $description, $category, $steps, $id);
            header("Location: /");
        }
    }
} catch (Exception $e) {
    echo "Error " . $e->getMessage();
    header("Location errors/404.php");
}
