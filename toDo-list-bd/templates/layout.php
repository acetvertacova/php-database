<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Task</title>
</head>

<body>
    <header>
        <nav class="border-b border-gray-200 p-4 text-base">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="font-medium text-lg text-gray-800">mini-task-manager</h1>
            </div>
        </nav>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer class="border-t border-gray-200 p-4 text-center text-gray-600">
        (c) <?php echo date('Y'); ?> Task Manager.
    </footer>
</body>

</html>