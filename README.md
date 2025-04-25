# Laboratory №5: Database

## 🚀 Installation and Project Launch Instructions
 
### Step 1: Installing PHP 

1. Download the latest version of PHP from the official website: https://www.php.net/downloads.
2. Add the PHP path to the environment variables (`Path`).
3. Verify the installation by running the following command in the terminal: `php -v`.

### Step 2: Launching the project

1. Cloning the repository:
   1.1 On GitHub, navigate to the main page of the repository.
   1.2 Above the list of files, click <> Code.

   <img scr="https://docs.github.com/assets/cb-13128/mw-1440/images/help/repository/code-button.webp">
   1.3 Copy the URL for the repository.
   1.4 Open Terminal, сhange the current working directory to the location where you want the cloned directory.
   1.5 Type `git clone`, and then paste the URL you copied earlier.
   1.6 Press Enter to create your local clone.
2. Navigating to the project folder in terminal: `cd [absolute-path-to-the-project-folder]`.
3. Starting the PHP server: `php -S localhost:8080 -t public/`.

## Lab's Description

This lab project is a To-Do list web application built with pure `PHP` and a `PostgreSQL` database. The goal of the lab is to demonstrate key backend development concepts, such as:

- Setting up a basic project architecture
- Performing database migrations and seeding
- Handling HTTP requests for CRUD operations
- Using templates for rendering dynamic content

## Project Structure 

        php-database/
        │
        ├── db/                          # db related files
        │   ├── migrations/              # migragions for table creation
        │   │   ├── 20250423133621_category_create_migration.php
        │   │   └── 20250423135751_task_create_migration.php
        │   └── seeds/                   # seed classes for data insertion into tables
        │       ├── CategorySeed.php
        │       └── TaskSeed.php
        │
        ├── public/                      # app entry point
        │   └── index.php
        │
        ├── src/                         
        │   ├── handlers/task/           
        │   │   ├── create.php           # handle task creation
        │   │   ├── delete.php           # handle task deletion
        │   │   ├── edit.php             # handle task editing
        │   │   └── show.php             # handle displaying tasks
        │   └── helpers.php              # utility functions
        │
        ├── templates/                   # HTML templates
        │   ├── task/                    # task realted templates
        │   │   ├── create.php
        │   │   ├── edit.php
        │   │   ├── show.php
        │   │   └── layout.php           # common layout template
        │   └── errors/                  
        │       └── 404.php              # error page
        ├── phinx.php                   # phinx configuration for migrations
        |...

## Usage Examples

1. **Using Phinx**

> `Phinx` is a PHP library that makes it easy to manage database migrations for your PHP app. You can view the instructions for installing and running Phinx on the official website¹.

I’ve created two main tables using migrations:

1.1 `Category Table` stores tasks' categories.

| Column      | Type      | Description                          |
|-------------|-----------|--------------------------------------|
| id          | integer   | Primary key (auto-increment)         |
| name        | string    | Name of the category                 |
| created_at  | datetime  | Timestamp of creation                |

<img src="/toDo-list-bd/usage/category-table.png">

1.2 `Task Table` stores tasks linked to categories.

| Column      | Type      | Description                                          |
|-------------|-----------|------------------------------------------------------|
| id          | integer   | Primary key                                          |
| title       | string    | Title of the task (max 20 characters)                |
| description | text      | Short task description (max 200 chars)               |
| priority    | text      | Task priority (e.g., High, Medium)                   |
| steps       | text      | Detailed steps (max 1000 characters)                 |
| category_id | integer   | Foreign key to category(id)                          |
| created_at  | datetime  | Timestamp of creation                                |

<img src="/toDo-list-bd/usage/task-table.png">

> [!IMPORTANT]
> A foreign key constraint is set so that if a category is deleted, the task’s category_id is set to NULL.

```php
    ->addForeignKey('category_id', 'category', 'id', ['delete' => 'SET_NULL'])
```

2. **Routing**

To get the URL of the current page in PHP, the superglobal array `$_SERVER` is used—specifically, the element `$_SERVER['REQUEST_URI']`. This parameter contains the path and the query string (if present) that come after the domain name. 

I needed to get only the path without the query string, so I used the `parse_url()` function with the `PHP_URL_PATH` parameter

```
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
```

Example:

| Full URL                                 | URL Value  | 
|------------------------------------------|------------|
| `http://example.com/article?category=php`| `/article` | 
| `http://example.com/contact?name=John`   | `/contact` | 


For *routing*, I used a simple method - a switch statement, which includes the appropriate file depending on the provided URL.

Depending on the URL path, the appropriate action is taken:

- `/` — shows the main page (`show.php`)
- `/edit` — shows the edit form
- `/create` — shows the create task form
- `/delete` — loads the task deletion script

```php
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
    case '/delete':
        require_once __DIR__ . '/../src/handlers/task/delete.php';
        break;
    default:
        template('errors/404.php');
        http_response_code(404);
        break;
}
```

3. **Templating**

The `template()` function is responsible for loading the right template and wrapping it in a common layout.

To summerize, I am: 

- Turning on buffering with `ob_start()`.
- Loading a template — its output goes into the buffer.
- Capturing that output into `$content`.
- Loading the layout file(`layout.php`), which uses `$content` to insert the template into the full page.

```php
//path: /src/helpers.php
function template(string $template)
{
    global $templatesDir, $layout;

    ob_start(); // starts output buffering
    require_once $templatesDir . '/' . $template;
    $content = ob_get_clean(); // returns all the content that was saved in the output buffer
    require_once $layout;
}
```

```html
    <header>
        ...
    </header>

    <main>
```
```php
        <?php echo $content; ?>
```
```html
    </main>

    <footer>
        ...
    </footer>
```
4. **PDO**

`PDO` provides a unified set of classes and methods for working with different DBMS (MySQL, PostgreSQL, SQLite, SQL Server, etc.) using drivers. 

*Database connection:*

The `$dsn` (Data Source Name) contains all the necessary information to connect to the database:

- `pgsql`: Specifies the database driver (`PostgreSQL`).
- `host=localhost`: The database is hosted locally.
- `dbname=your_bd_name`: Specifies the name of the database to connect to.

```php
    $dsn = "pgsql:host=localhost;dbname=your_db_name";
```

Credentials (`$user, $pass`): The `$user` and `$pass` variables store the username and password required to authenticate with the database:

```php
    $user = " ";
    $pass = " ";
```

`getPDO()` function:

`Exception Handling:` It uses a try-catch block to catch any PDOException that occurs while trying to connect to the database:

```php
    try {
        // create PDO object(open connection)
        $pdo = new PDO($dsn, $user, $pass);
        // set error handling mode to throw exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // if the connection fails, we end up here
        die("Error: " . $e->getMessage());
    }
```

5. **CRUD Operations**

5.1 CREATE

The HTML form is defined in `templates/task/create.php`, where the user can input details for a new task, such as: title, priority, description, category, steps. 

> [!IMPORTANT]
> `Displaying Errors`: After each input field, you call the `printErrors($errors, 'field_name')` function from `helpers.php`,  which likely displays any validation errors associated with that specific field. For example, if the user  doesn't provide a title or the title exceeds a certain length, an error message will be shown right below the field.

<img src="/toDo-list-bd/usage/validation.png">

`Form Submission`: When the user submits the form, the data is sent via a POST request. The form data is processed by the script in `src/handlers/task/create.php`, which is included at the top of the template.

Form Handling (`create.php` in `handlers/task`). Here's the breakdown of how the form is handled:

`Form Validation`: The script first checks if the request method is POST to ensure that the form has been submitted:

```php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
```

Then, it collects the submitted data ($_POST['title'], $_POST['priority'], etc.) and passes it to validation functions. 

```php
    $title = $_POST['title'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $steps = $_POST['steps'];
```

These functions validate the form data to ensure the required fields are filled and the lengths of inputs are within acceptable limits. Any errors are collected in the `$errors` array:

```php
    fieldRequired($_POST, $errors);
    fieldLength($_POST, $errors);
```

`Creating the Task`: If there are no validation errors `(empty($errors))`, the `create()` function is called, which likely interacts with the database to insert the new task. The form data is passed to the `create()` function:

```php
    create($pdo, $title, $priority, $description, $category, $steps);
```

```php
    function create(PDO $pdo, string $title, string $priority, string $description, string $category, string $steps)
    {
        // the function first calls categoryExists() to check if the category provided by the user already exists in the category table
        $categoryId = categoryExists($pdo, $category);

        // the function prepares an INSERT SQL query to insert the task data into the task table
        $stmt = $pdo->prepare("INSERT INTO task (title, priority, description, category_id, steps,created_at) VALUES (:title, :priority, :description, :category_id, :steps, NOW())");

        // the keys in the array passed to execute() correspond to the named parameters in the SQL query
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':priority' => $priority,
            ':steps' => $steps,                
            ':category_id' => $categoryId,
        ]);
    }
```

`categoryExists()` function ensures that the task is linked to an existing category, or if the category doesn't exist, it gets created in the category table.

```php
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
```

<img src="/toDo-list-bd/usage/create.png">

<img src="/toDo-list-bd/usage/show-after-create.png">

5.2 READ

```php
    <?php

    $pdo = getPDO(); // connect to the database
    try {
        $pdo = getPDO();
        $tasks = getAll($pdo); // function from helpers.php, which fetches all tasks from the database
    } catch (Exception $e) {
        echo "Error " . $e->getMessage(); // if something goes wrong (e.g., connection issue or SQL error), the error message is printed
    }
```

```php
function getAll(PDO $pdo): array
{
    $sql = "SELECT title, description, priority, steps, c.name as category
            FROM task t
            LEFT JOIN category c ON t.category_id = c.id"; // to combine data from two tables(task, category), links them using the foreign key category_id from the task table.
    $stmt = $pdo->query($sql); // executing the query
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetching all rows as an array of associative arrays

    return $tasks;
}
```

*Task Display:* Inside a `foreach` loop, it iterates over each task in $tasks. Displays the task title, priority, description, category, and steps. The `htmlspecialchars()` function is used to prevent XSS attacks by escaping special HTML characters in task data.

```php
    <?php foreach ($tasks as $task): ?>
        <div class="grid gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h3 class="text-3xl font-bold text-blue-700 py-2"><?php echo htmlspecialchars($task['title']); ?></h3>

                 <p><strong>Priority:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>

                <p class="mt-2"><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>

                <div class="mt-4">
                    <strong>Category:</strong></p>
                    <span class="bg-gray-200 rounded-full text-slate-600 px-3 py-1 text-sm"><?php echo htmlspecialchars($task['category']); ?></span>
                </div>

                <p class="mt-2"><strong>Steps:</strong> <?php echo htmlspecialchars($task['steps']); ?></p>
                </div>
        </div>
    <?php endforeach; ?>
```

<img src="/toDo-list-bd/usage/show.png">

5.3 UPDATE

The script begins by checking if the id of the task to edit is provided via `$_GET['id']`. If not, it terminates and shows an error message.

```php
   $id = $_GET['id'] ?? null;

    if (!$id) {
        die("No task ID provided.");
    }
```

A query is executed to retrieve the task details from the database by the provided `id`, including the task's title, priority, description, steps, and category (using a LEFT JOIN to get the category name).

```php
    $stmt = $pdo->prepare("SELECT t.title, t.description, t.priority, t.steps , c.name as category FROM task t
        LEFT JOIN category c ON t.category_id = c.id
        WHERE t.id = :id");

        $stmt->execute([':id' => $id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC); // fetch() returns a single row from the result set and moves the pointer to the next row

        // if no task is found for the provided id, the script terminates and displays an error message
        if (!$task) {
        die("Task not found.");
    }
```

If the form is submitted `($_SERVER['REQUEST_METHOD'] === 'POST')`, it processes the input fields (title, priority, description, category, and steps), performs validation with `fieldRequired()` and `fieldLength()`, and if there are no errors, it calls the `update()` function to update the task in the database.


```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $priority = $_POST['priority'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $steps = $_POST['steps'];

        fieldRequired($_POST, $errors);
        fieldLength($_POST, $errors);

        if (empty($errors)) {
            update($pdo, $title, $priority, $description, $category, $steps, $id);
            // upon successful update, the user is redirected to the main page (/)
            header("Location: /"); 
        }
    }
```

If any exception occurs during the process, the error message is shown, and the user is redirected to an error page.

```php
    catch (Exception $e) {
        echo "Error " . $e->getMessage();
        header("Location errors/404.php");
    }
```

```php
    function update(PDO $pdo, string $title, string $priority, string $description, string $category, string $steps, int $id)
    {
        // first checks if the provided category exists in the database by calling the categoryExists() function
        $categoryId = categoryExists($pdo, $category); 

        // the UPDATE SQL query is executed to update the task details in the task table using the provided data (title, priority, description, steps, and categoryId)
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
```

The form is displayed with fields to edit the task's `title`, `priority`, `description`, `category`, and `steps`.

Each input field is pre-filled with the current task values (`htmlspecialchars($task['field']`) for security.

After each input field, if any validation errors exist, the `printErrors()` function is used to display error messages for that specific field.

```php
    <div class="mb-4">
        <label for="title" class="block text-lg font-semibold text-gray-700">Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']) ?>" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
        <?php printErrors($errors, 'title'); ?>
    </div>
```

<img src="/toDo-list-bd/usage/edit.png">

<img src="/toDo-list-bd/usage/bd-update.png">

5.4 DELETE

```php
    <?php
    require_once __DIR__ . '/../../helpers.php'; // loads helper functions like getPDO() and delete()
    $pdo = getPDO(); // connects to the database

    $id = $_GET['id'] ?? null; // gets the task id from the URL

    if ($id && is_numeric($id)) { // checks if id is valid
        try {
            delete($pdo, $id); // calls delete($pdo, $id) to remove the task from the database
            header("Location: /"); // after successful deletion, redirects the user to /
        // if deletion fails or ID is invalid, it shows an error message.
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid task ID.";
    }
    exit;
```

```php
    function delete(PDO $pdo, int $id)
    {
        $stmt = $pdo->prepare("DELETE FROM task WHERE id = :id"); // this tells the database: “Find a task with this id and delete it."

        $stmt->execute([':id' => $id]); // this replaces :id in the query with the actual $id value, securely (prevents SQL injection).
    }
```

<img src="/toDo-list-bd/usage/delete.png">

## The Control Questions

1. What are the advantages of using a single entry point in a web application?

- *Increased Security:* Limits access to internal files and allows centralized application of protections (e.g., against SQL injection), reducing overall risk.
- *Simplified Maintenance:* Core logic is concentrated in one place, reducing code duplication and making architectural changes easier to manage.
- Manage *routing* more efficiently.

2. What are the advantages of using templates?

*Templating:*

- simplifies the separation of logic and presentation,
- reduces code duplication,
- speeds up development and makes the project more scalable,
- improves code readability and maintainability.

3. What are the advantages of storing data in a database compared to storing in files?

| **Advantage**       | **Database**                                                    | **File Storage**                 |
|---------------------|----------------------------------------------------------------------------------------------------|
|**Data Consistency** |Ensures integrity with transactions, unique keys, and constraints|Integrity must be maintained      |
|**Access Control**   |Controls access with users and roles, ensuring security          |Limited by the operating system   |
|**Concurrent Access**|Supports with locking mechanisms to avoid data conflicts         |Does not support                  |
|**Scalability**      |Easily scales to handle larger datasets and offers flexibility   |Difficult to manage large datasets|
|**Data Recovery**    |Built-in recovery mechanisms to restore data in case of failure  |Often not possible without backups|
|**Transaction**      |Supports transactions ensuring atomicity (all or nothing)        |No built-in transaction support   |

4. What is an SQL injection?

SQL injection usually occurs when you ask a user for input, like their username, and instead of a name, the user gives you an SQL statement that you will unknowingly run on your database.

Example:

The original purpose of the code was to create an SQL statement to delete a task, with a given task id.

```sql
    DELETE FROM task WHERE id = :id;
```
The user can enter some "smart" input like this:

`http://localhost:8081/delete?id=1 or 1=1`

Then, the SQL statement will look like this:

```sql
    DELETE FROM task WHERE id = 1 or 1=1;
```

In this case, `1=1` is always true. This turns the `WHERE` condition into a statement that will always evaluate to `true` (since 1=1 is always true), meaning all tasks in the task table will be deleted.

To prevent SQL injection in my project, I used prepared statement and in addition validation(`is_numeric($id)`). Prepared statements separate the SQL logic from the user input, meaning user input is treated as data and not executable code.

```php
    // Prepared statement with parameter binding to prevent SQL injection
    $stmt = $pdo->prepare("DELETE FROM task WHERE id = :id");
```

So, `id=1 OR 1=1` is just a string and will fail validation (`is_numeric()`) or be rejected by the database.

## Source List 

1. [Phinx] (https://phinx.org/)
2. [PHP Documentation](https://www.php.net/docs.php)
3. [Git Course](https://github.com/MSU-Courses/advanced-web-programming/tree/main/07_Forms_And_Validation)
4. [SQL Injection](https://www.w3schools.com/sql/sql_injection.asp)
5. [DB vs file system](https://www.w3schools.com/sql/sql_injection.asp)

























