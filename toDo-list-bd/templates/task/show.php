<?php

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

function getAllTasks(PDO $pdo): array
{
    $sql = "SELECT 
        t.title as title, 
        t.description as description, 
        p.name AS priority, 
        string_agg(c.name, ', ' ORDER BY c.name) AS category,
        string_agg(s.description, ', ' ORDER BY s.id) AS steps
    FROM task t
    LEFT JOIN priority p ON t.priority_id = p.id
    LEFT JOIN task_category tc ON t.id = tc.task_id
    LEFT JOIN category c ON tc.category_id = c.id
    LEFT JOIN step s ON s.task_id = t.id
    GROUP BY t.id, p.name
    ORDER BY t.id";

    $stmt = $pdo->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tasks as &$task) {
        $task['category'] = explode(', ', $task['category']);
        $task['steps'] = explode(',', $task['steps']);
    }

    return $tasks;
}

$pdo = getPDO();
$tasks = getAllTasks($pdo);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
</head>

<body class="bg-sky-100 py-8">

    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-semibold text-gray-800 mb-8">#tasks</h2>

        <?php foreach ($tasks as $task): ?>

            <div class="grid gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                    <h3 class="text-3xl font-bold text-blue-700 py-2"><?php echo htmlspecialchars($task['title']); ?></h3>

                    <p><strong>Priority:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>

                    <p class="mt-2"><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>

                    <div class="mt-4">
                        <strong>Categories:</strong></p>
                        <?php foreach ($task['category'] as $category): ?>
                            <span class="bg-gray-200 rounded-full text-slate-600 px-3 py-1 text-sm"><?php echo htmlspecialchars($category); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4">
                        <strong class="list-decimal list-inside mt-1 text-gray-700">Steps:</strong>
                        <ol class="list-inside list-decimal text-gray-800">
                            <?php foreach ($task['steps'] as $step): ?>
                                <li class="ml-4"><?php echo htmlspecialchars($step); ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
    </div>
</body>

</html>