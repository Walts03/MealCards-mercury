<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require 'db.php';
// Get the posted data
$postData = file_get_contents("php://input");
$request = json_decode($postData);

if (isset($request->username) && isset($request->password)) {
  $username = trim($request->username);
  $password = trim($request->password);

  if (!empty($username) && !empty($password)) {
    // Check if the username already exists
    $query = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();

    if ($query->fetchColumn() > 0) {
      echo json_encode(['success' => false, 'message' => 'Username already exists']);
      exit;
    }

    // Insert the new user into the database
    $query = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);

    if ($query->execute()) {
      echo json_encode(['success' => true, 'message' => 'Registration successful']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Please fill all the required fields']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
