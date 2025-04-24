<?php
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
