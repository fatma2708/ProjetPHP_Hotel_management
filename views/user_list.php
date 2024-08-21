<?php
// user_list.php

// Include the UserController class
require_once $_SERVER['DOCUMENT_ROOT'] . '/hotelmanagement/controllers/UserController.php';

// Create an instance of the UserController class
$userController = new UserController($pdo);

// Call the index method to display the user list
$userController->index();
?>

<!-- Add a lot of cute styles to the user list -->
<style>
  /* Add a cute font to the table */
  table {
    font-family: 'Comic Sans MS', cursive;
  }

  /* Make the table headers cute */
  th {
    background-color: #ff69b4;
    color: #fff;
    padding: 10px;
    border-radius: 10px;
  }

  /* Make the table rows cute */
  tr {
    background-color: #f0f0f0;
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  /* Make the table data cute */
  td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  /* Add a cute hover effect to the table rows */
  tr:hover {
    background-color: #ffe6cc;
  }

  /* Make the delete button cute */
  .delete-button {
    background-color: #ff0000;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }

  /* Make the edit button cute */
  .edit-button {
    background-color: #008000;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
  }
</style>

<!-- Display the user list -->
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user) { ?>
      <tr>
        <td><?php echo $user['name']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td><?php echo $user['role']; ?></td>
        <td>
          <a href="user_edit.php?id=<?php echo $user['id']; ?>" class="edit-button">Edit</a>
          <a href="user_delete.php?id=<?php echo $user['id']; ?>" class="delete-button">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>