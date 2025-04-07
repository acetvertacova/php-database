<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LL_04</title>
</head>

<body>

  <?php 
  require_once '../../src/handlers/handler.php';
  ?> 

  <form method="post" action="/public/task/create.php" enctype="multipart/form-data">
    <div>
      <label for="title">Task's title</label>
      <input type="text" id="title" name="title" />

      <?php printErrors($errors, 'title'); ?>    

    </div>

    <div>
      <label for="priority">Priority</label>
      <select id="priority" name="priority">
        <option value="Urgent">Urgent</option>
        <option value="High">Hight</option>
        <option value="Low">Low</option>
      </select>

      <?php printErrors($errors, 'priority'); ?> 

    </div>

    <div>
      <label for="description">Description</label>
      <textarea id="description" name="description"></textarea>

      <?php printErrors($errors, 'description'); ?> 

    </div>

    <div>
      <label for="categories">Categories</label>
      <select id="categories" name="categories[]" multiple>
        <option value="Education">Education</option>
        <option value="Professional">Professional</option>
        <option value="Financial">Financial</option>
        <option value="Personal">Personal</option>
      </select>

      <?php printErrors($errors, 'categories'); ?> 

    </div>

    <div>
      <ol id="stepsList" type="1">Steps:
      </ol>
      <button type="button" id="addStepButton">Add step</button>
      <button type="button" id="removeStepButton">Remove step</button>

      <script src="script.js"></script>

      <?php printErrors($errors, 'steps'); ?> 

    </div>

    <button type="submit">Add task</button>
  </form>

</body>

</html>