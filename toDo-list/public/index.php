<?php

$tasks = file(__DIR__ . '/../../storage/tasks.json', FILE_IGNORE_NEW_LINES);
$tasks = array_map('json_decode', $tasks);
$latestTasks[] = array_slice($tasks, -2);

if (!empty($latestTasks)) {

    array_map(function($task) {
        echo json_encode($task, JSON_PRETTY_PRINT);    
    }, $latestTasks);
}