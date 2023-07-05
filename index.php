<?php
require_once (__DIR__ . '/controllers/UserController.php');

$userController = new UserController();
$users = $userController->index();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Backend/Full-stack recruitment task</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header>
    <h1>Users</h1>
    <button class="btn" onclick="showAddUserModal()">Add user</button>
  </header>
  <main>
      <?php require_once (__DIR__. './partials/main.php'); ?>
  </main>
  <script src="assets/js/script.js"></script>
</body>
</html>
