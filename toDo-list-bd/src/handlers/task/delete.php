<?php

/**
 * This script deletes a task from the database based on the ID provided via GET.
 * It redirects to the homepage after successful deletion or shows an error message if something goes wrong.
 */
require_once __DIR__ . '/../../helpers.php';

$pdo = getPDO();

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    try {
        delete($pdo, $id);
        header("Location: /");
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid task ID.";
}
exit;
