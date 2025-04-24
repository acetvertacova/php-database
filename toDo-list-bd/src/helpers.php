<?php
function template(string $template)
{
    global $templatesDir, $layout;

    ob_start();
    require_once $templatesDir . '/' . $template;
    $content = ob_get_clean();
    require_once $layout;
}

function getPDO(): PDO
{
    $dsn = "pgsql:host=localhost;dbname=postgres";
    $user = "user";
    $pass = "root";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function categoryExists(PDO $pdo, string $category): int
{
    $stmt = $pdo->prepare("SELECT id FROM category WHERE name = :category");
    $stmt->execute([':category' => $category]);
    $categoryId = $stmt->fetchColumn();

    if (!$categoryId) {
        $stmt = $pdo->prepare("INSERT INTO category (name, created_at) VALUES (:category, NOW())");
        $stmt->execute([':category' => $category,]);
        $categoryId = $pdo->lastInsertId();
    }

    return $categoryId;
}
function getAll(PDO $pdo): array
{
    $sql = "SELECT title, description, priority, steps, c.name as category
            FROM task t
            LEFT JOIN category c ON t.category_id = c.id";

    $stmt = $pdo->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tasks;
}

function create(PDO $pdo, string $title, string $priority, string $description, string $category, string $steps)
{
    $categoryId = categoryExists($pdo, $category);

    $stmt = $pdo->prepare("INSERT INTO task (title, priority, description, category_id, steps, created_at)
    VALUES (:title, :priority, :description, :category_id, :steps, NOW())");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':priority' => $priority,
        ':steps' => $steps,
        ':category_id' => $categoryId,
    ]);
}

function update(PDO $pdo, string $title, string $priority, string $description, string $category, string $steps, int $id)
{
    $categoryId = categoryExists($pdo, $category);
    $stmt = $pdo->prepare("UPDATE task SET title = :title, priority = :priority, description = :description, category_id = :category_id, steps = :steps, created_at = NOW() WHERE id = :id");

    $stmt->execute([
        ':title' => $title,
        ':priority' => $priority,
        ':description' => $description,
        ':category_id' => $categoryId,
        ':steps' => $steps,
        ':id' => $id,
    ]);
}

function delete(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("DELETE FROM task WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

function fieldRequired(array $postArray, array &$errors)
{
    $requiredFields = ['title', 'priority', 'description', 'category', 'steps'];

    foreach ($requiredFields as $key) {
        $value = trim($postArray[$key] ?? '');

        if ($value === '') {
            $errors[$key][] = 'Field `' . ucfirst($key) . '` is required!';
        }
    }
}

function fieldLength(array $postArray, array &$errors)
{
    $fields = ['title', 'description', 'steps'];

    foreach ($fields as $field) {
        $value = trim($postArray[$field]);

        if (strlen($value) < 3 || strlen($value) > 250) {
            $errors[$field][] = ucfirst($field) . ' should contain from 3 to 250 symbols!';
        }
    }
}

function printErrors(array $errors, string $field)
{

    foreach ($errors[$field] ?? [] as $error) {
        echo "<p class='text-red-500 text-sm'>* $error</p>";
    }
}
