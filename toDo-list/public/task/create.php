<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LL_04</title>
</head>
<body>
<form method="POST" action="../../src/handlers/handler.php" enctype="multipart/form-data">
        <div>
            <label for="title">Task's title</label>
            <input type="text" id="title" name="title" required/>
        </div>

        <div>
            <label for="priority">Priority</label>
            <select id="priority" name="priority" required>
                <option value="Urgent">Urgent</option>
                <option value="High">Hight</option>
                <option value="Low">Low</option>
            </select>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div>
            <label for="categories">Categories</label>
            <select id="categories" name="categories[]" multiple required>
                <option value="Education">Education</option>
                <option value="Professional">Professional</option>
                <option value="Financial">Financial</option>
                <option value="Personal">Personal</option>
            </select>
        </div>

        <div>
          <ol id="stepsList" type="1">Steps:
            <li>
              <input type="text" name="steps[]" required/>
            </li>
          </ol>
            <button type="button" id="addStepButton">Add step</button>
            <button type="button" id="removeStepButton">Remove step</button>

            <script src="script.js"></script>

        </div>

        <button type="submit">Add task</button>
    </form>

</body>
</html>

