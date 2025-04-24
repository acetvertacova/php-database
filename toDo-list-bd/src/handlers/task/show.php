<?php

$pdo = getPDO();
try {
    $pdo = getPDO();
    $tasks = getAll($pdo);
} catch (Exception $e) {
    echo "Error " . $e->getMessage();
}
