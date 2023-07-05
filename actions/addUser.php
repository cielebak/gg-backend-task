<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the user data from the request
  $data = json_decode(file_get_contents('php://input'), true);

  // Validate the required fields
  $requiredFields = [
    'name',
    'username',
    'email',
    'addressStreet',
    'addressSuite',
    'addressCity',
    'addressZip',
    'phone',
    'companyName'
  ];

  $errors = [];

  foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
      $errors[] = $field . ' is required.';
    }
  }

  if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
  }

  if (count($errors) > 0) {
    // Return the validation errors as a JSON response
    echo json_encode(['errors' => $errors]);
    return;
  }

  // Read the JSON file
  $usersJson = file_get_contents('../dataset/users.json');
  $users = json_decode($usersJson, true);

  // Get the last user's ID
  $lastUser = end($users);
  $lastId = $lastUser['id'];

  // Increment the last ID by 1
  $newId = $lastId + 1;

  // Create a new user object with the provided data and new ID
  $newUser = [
    'id' => $newId,
    'name' => $data['name'],
    'username' => $data['username'],
    'email' => $data['email'],
    'address' => [
      'street' => $data['addressStreet'],
      'suite' => $data['addressSuite'],
      'city' => $data['addressCity'],
      'zipcode' => $data['addressZip'],
      'geo' => [
        'lat' => $data['addressLat'],
        'lng' => $data['addressLong'],
      ],
    ],
    'phone' => $data['phone'],
    'company' => [
      'name' => $data['companyName'],
      'catchPhrase' => '',
      'bs' => '',
    ],
  ];

  // Add the new user to the array
  $users[] = $newUser;

  // Save the updated array back to the JSON file with formatting and without escaping unicode characters
  file_put_contents('../dataset/users.json', json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

  // Return a success response with the new user ID
  echo 'User added successfully with ID: ' . $newId;
}
