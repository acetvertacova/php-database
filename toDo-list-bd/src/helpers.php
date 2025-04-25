<?php

/**
 * Loads a template and displays it within the layout.
 *
 * @param string $template Template filename (without path).
 * @return void
 */
function template(string $template)
{
    global $templatesDir, $layout;

    ob_start();
    require_once $templatesDir . '/' . $template;
    $content = ob_get_clean();
    require_once $layout;
}

/**
 * Creates and returns a PDO connection to the PostgreSQL database.
 *
 * @return PDO PDO database connection.
 */
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

/**
 * Checks if a category exists; if not, creates it and returns its ID.
 *
 * @param PDO $pdo Database connection.
 * @param string $category Category name.
 * @return int ID of the category.
 */
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

/**
 * Retrieves all tasks with their associated categories.
 *
 * @param PDO $pdo Database connection.
 * @return array Array of tasks.
 */
function getAll(PDO $pdo): array
{
    $sql = "SELECT title, description, priority, steps, c.name as category
            FROM task t
            LEFT JOIN category c ON t.category_id = c.id";

    $stmt = $pdo->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $tasks;
}

/**
 * Creates a new task in the database.
 *
 * @param PDO $pdo Database connection.
 * @param string $title Task title.
 * @param string $priority Task priority.
 * @param string $description Task description.
 * @param string $category Task category.
 * @param string $steps Task steps.
 * @return void
 */
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

/**
 * Updates an existing task in the database.
 *
 * @param PDO $pdo Database connection.
 * @param string $title Task title.
 * @param string $priority Task priority.
 * @param string $description Task description.
 * @param string $category Task category.
 * @param string $steps Task steps.
 * @param int $id Task ID.
 * @return void
 */
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

/**
 * Deletes a task from the database by ID.
 *
 * @param PDO $pdo Database connection.
 * @param int $id Task ID.
 * @return void
 */
function delete(PDO $pdo, int $id)
{
    $stmt = $pdo->prepare("DELETE FROM task WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

/**
 * Validates that required fields are present and not empty.
 *
 * @param array $postArray Form data ($_POST).
 * @param array $errors Reference to the array where errors are stored.
 * @return void
 */
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

/**
 * Validates the length of specific fields.
 *
 * @param array $postArray Form data ($_POST).
 * @param array $errors Reference to the array where errors are stored.
 * @return void
 */
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

/**
 * Prints validation errors for a specific form field.
 *
 * @param array $errors Array of errors.
 * @param string $field Form field name.
 * @return void
 */
function printErrors(array $errors, string $field)
{

    foreach ($errors[$field] ?? [] as $error) {
        echo "<p class='text-red-500 text-sm'>* $error</p>";
    }
}
