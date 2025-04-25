<?php

/**
 * This script retrieves all tasks from the database.
 * It uses the getAll() helper function and handles any exceptions that may occur.
 */
$pdo = getPDO();
try {
    $pdo = getPDO();
    $tasks = getAll($pdo);
} catch (Exception $e) {
    echo "Error " . $e->getMessage();
}
