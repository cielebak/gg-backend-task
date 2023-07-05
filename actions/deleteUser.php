<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the user ID from the request
  $id = $_POST['id'];

  // Read the JSON file
  $usersJson = file_get_contents('../dataset/users.json');
  $users = json_decode($usersJson, true);

  // Find the index of the user with the matching ID
  $index = array_search($id, array_column($users, 'id'));

  // Check if the user was found
  if ($index !== false) {
      // Remove the user from the array
      array_splice($users, $index, 1);

      // Save the updated array back to the JSON file with formatting
      file_put_contents('../dataset/users.json', json_encode($users, JSON_PRETTY_PRINT));

      // Return a success response
      echo 'User deleted successfully';
  } else {
      // Return an error response if the user was not found
      echo 'User not found';
  }
}
