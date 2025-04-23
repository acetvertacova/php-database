<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>LL_04</title>
</head>

<body>
    <form method="post" action="/public/task/create.php" enctype="multipart/form-data">
        <div>
            <label for="title">Task's title</label>
            <input type="text" id="title" name="title" />
        </div>

        <div>
            <label for="priority">Priority</label>
            <select id="priority" name="priority">
                <option value="Urgent">Urgent</option>
                <option value="High">Hight</option>
                <option value="Low">Low</option>
            </select>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div>
            <label for="categories">Categories</label>
            <select id="categories" name="categories[]" multiple>
                <option value="Education">Education</option>
                <option value="Professional">Professional</option>
                <option value="Financial">Financial</option>
                <option value="Personal">Personal</option>
            </select>
        </div>

        <div>
            <ol id="stepsList" type="1">Steps:
            </ol>
            <button type="button" id="addStepButton">Add step</button>
            <button type="button" id="removeStepButton">Remove step</button>
        </div>
        <script>
            document.getElementById('addStepButton').addEventListener('click', function() {
                const stepsList = document.getElementById('stepsList');
                const steps = stepsList.getElementsByTagName('li');

                if (steps.length === 0 || steps[steps.length - 1].querySelector('input').value.trim() !== '') {
                    let newStep = document.createElement('li');
                    let newInput = document.createElement('input');

                    newInput.setAttribute('name', 'steps[]');
                    newStep.appendChild(newInput);

                    document.getElementById('stepsList').appendChild(newStep);
                } else {
                    alert('Please fill in the previous step before adding a new one.');
                }
            });

            document.getElementById('removeStepButton').addEventListener('click', function() {
                let stepsList = document.getElementById('stepsList');
                stepsList.removeChild(stepsList.lastElementChild);
            });
        </script>

        <button type="submit">Add task</button>
    </form>

</body>

</html>