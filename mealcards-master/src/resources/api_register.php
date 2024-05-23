<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$conn = mysqli_connect('feenix-mariadb.swin.edu.au', 's103808977', '300903', 's103808977_db');

mysqli_set_charset($conn, 'utf8');

$table = "users";

$response = array(
  "success" => false,
  "message" => "Registration failed"
);

switch ($method) {
  case 'POST':
    $username = mysqli_real_escape_string($conn, $input['username']);
    $password = mysqli_real_escape_string($conn, $input['password']);

    // Check if the username already exists
    $checkUserQuery = "SELECT COUNT(*) FROM `$table` WHERE username='$username'";
    $checkResult = mysqli_query($conn, $checkUserQuery);
    $userCount = mysqli_fetch_array($checkResult)[0];

    if ($userCount > 0) {
      $response['message'] = 'Username already exists';
    } else {
      // Insert the new user into the database
      $insertQuery = "INSERT INTO `$table` (username, password) VALUES ('$username', '$password')";
      if (mysqli_query($conn, $insertQuery)) {
        $response['success'] = true;
        $response['message'] = 'Registration successful';
      }
    }
    break;
  default:
    echo json_encode($response);
    mysqli_close($conn);
    exit();
}

echo json_encode($response);

mysqli_close($conn);
