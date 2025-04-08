# Laboratory №4: Form processing and validation

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
3. Starting the PHP server: `php -S localhost:8080`.
4. Opening the project in a browser: `http://localhost:8000/filename.php`.

## Lab's Description

This is a simple PHP-based task management application. It allows users to create tasks with various attributes, view recent tasks, and see individual task details. The application uses JSON for data storage and Tailwind CSS for basic styling.

## 🧩 Technologies

    - PHP for backend logic
    - Tailwind CSS for frontend styling
    - JSON file for data storage (no database required)
    - JavaScript for dynamic steps in task creation

## 📃 Project Documentation

toDo-list/
├── public/
│   ├── index.php             # Displays the latest two tasks
│   ├── task/
│   │   ├── create.php        # Form for creating a new task
│   │   └── index.php?id=X     # View a specific task by ID
│
├── src/
│   ├── handlers/
│   │   └── handler.php       # Handles task creation and validation
│   └── helpers.php           # Validation and error display helpers
│
├── storage/
│   └── tasks.json            # JSON file storing all tasks


## Usage Examples

Go to `/public/task/create.php` to add a new task. After submission, you will be redirected to the homepage (`index.php`). 

Form is displayed with fields: title, priority, description, categories, and steps. On submit, the form posts to itself and is processed by handler.php. If there are validation errors, they are shown under each field via printErrors().

1. JavaScript allows adding/removing steps dynamically:

```js
    document.getElementById('addStepButton').addEventListener('click', function() {
        
        //Gets the ordered list (<ol id="stepsList">) where the step inputs will be inserted.
        const stepsList = document.getElementById('stepsList'); 

        //Gets all current <li> elements (step list items) inside stepsList.
        const steps = stepsList.getElementsByTagName('li');

        //This condition prevents the user from adding multiple empty steps.
        if (steps.length === 0 || steps[steps.length - 1].querySelector('input').value.trim() !== ''){
            let newStep = document.createElement('li');
            let newInput = document.createElement('input');

            newInput.setAttribute('name', 'steps[]');
            newStep.appendChild(newInput);
        
            document.getElementById('stepsList').appendChild(newStep);
        }else{
        //If the last input is empty, the script shows an alert, asking the user to fill it before adding a new one.
            alert('Please fill in the previous step before adding a new one.');
        }
    });

    //This removes the last step (<li>) from the list when the "Remove step" button is clicked.
    document.getElementById('removeStepButton').addEventListener('click', function() {
        let stepsList = document.getElementById('stepsList');
        stepsList.removeChild(stepsList.lastElementChild);
    });

```

2. `printErrors()` prints any validation errors related to the 'field' from the $errors array.

`$errors:` An associative array where keys are field names ('title', 'priority', etc.) and values are arrays of error messages for those fields.

`$field:` The specific field name you want to check for errors (e.g., 'title' or 'steps').

```php
    function printErrors(array $errors, string $field)
    {
        //If $errors[$field] exists, it loops through that array. If it doesn’t exist, ?? [] returns an empty array — so the loop won’t run and no error will be shown.
        foreach ($errors[$field] ?? [] as $error) {
            echo "<p class='text-red-500 text-sm'>* $error</p>";
        }

    }
```
🔍 Example in Action

```php
    //Suppose the $errors array looks like this:
    $errors = [
        'title' => ['Title is required'],
    ];

    //And you call:
    printErrors($errors, 'title');

    //You will get:
    <p class='text-red-500 text-sm'>* Title is required</p>

```

3. Validation functions

Loops through each $postArray field. If it's an array (multiple select): checks if it’s empty `(count($value) === 0)`. If it’s a string: checks if it’s blank (trim($value) === ''). Adds an error to `$errors[$key]` with a message like: `"Title is required!" or "Categories are required!"`.

```php
    function fieldRequired(array $postArray, array &$errors)
    {
        foreach ($postArray as $key => $value) {
            if (is_array($value)) {
                if (count($value) === 0) {
                    $errors[$key][] = ucfirst($key) . ' are required!';
                }
            } else {
                if (trim($value) === '') {
                    $errors[$key][] = ucfirst($key) . ' is required!';
                }
            }
        }
    }
```

Checks if a specific field's length is between 3 and 250 characters. Uses strlen() to check the length of `$postArray[$field]`. If it’s too short or too long, adds an error: `"Description should contain from 3 to 250 symbols!"`.

```php
function fieldLength(array $postArray, string $field, array &$errors)
{
    if (strlen($postArray[$field]) < 3 || strlen($postArray[$field]) > 250) {
        $errors[$field][] = ucfirst($field) . ' should contain from 3 to 250 symbols!';
    }
}
```

4. In the file `public/index.php`, display the last 2 tasks from storage/tasks.txt.


```php
    $filePath = '../storage/tasks.json'; //Loads tasks from tasks.json.
    $tasks = json_decode(file_get_contents($filePath), true); //Decodes JSON into a PHP array.
    $latestTasks = array_slice($tasks, -2); //Takes only the last two tasks using array_slice().
```

5. Pagination: Display the specific task based on its id, which is passed through the URL as a GET parameter.

```php
    //Validates id
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { ... }
```

Converts id to an integer. Adjusts for zero-based array ($id - 1).

```php
    $id = intval($_GET['id']);
    $task = $tasks[$id - 1] ?? null;
```
## The Control Questions

1. What HTTP methods are used to send form data?

    - **GET:** The GET method sends data through the URL (address bar). This means that all `'key=value'` pairs of the sent fields are appended to the page address in the format of 'query parameters'.

    - **POST:** The POST method sends data 'invisibly', in the body of the HTTP request. When the button is clicked, the browser forms a request to the server, but instead of appending the parameters to the URL, it embeds them inside (in the so-called request body).

2. What is data validation, and how is it different from filtering?

`Data filtering` is the process of removing or modifying undesirable characters from user input. `Data validation` is the process of checking if the entered data complies with specific rules.

In short: Validation checks if the data is correct, while filtering ensures the data is safe and well-formatted.

3. What PHP functions are used for data filtering?

    - `trim()` - Strip whitespace (or other characters) from the beginning and end of a string.
    - `htmlspecialchars()` - Convert special characters to HTML entities(& -> &amp;).
    - `htmlentities()` - Convert all applicable characters to HTML entities.
    - `strip_tags()` - Strip HTML and PHP tags from a string.
    - `filter_var()` - Filters a variable with a specified filter.
    - `stripslashes()` - Un-quotes a quoted string. 

## Source List 

- [PHP Documentation](https://www.php.net/docs.php);
- [Form validation](https://www.w3schools.com/php/php_form_validation.asp);
- [Tailwind Docs](https://www.w3schools.com/php/php_form_validation.asp); 
- [Git Course](https://github.com/MSU-Courses/advanced-web-programming/tree/main/07_Forms_And_Validation);
























