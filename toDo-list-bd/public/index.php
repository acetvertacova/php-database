<?php
require_once('../src/helpers.php');
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$layout = __DIR__ . '/../templates/layout.php';
$templatesDir = __DIR__ . '/../templates/task/';

switch ($url) {
    case '/':
        template('show.php');
        break;
    case '/edit':
        template('edit.php');
        break;
    case '/create':
        template('create.php');
        break;
    default:
        template('errors/404.php');
        http_response_code(404);
        break;
}
