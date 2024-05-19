<?php
header("Content-Type: application/json");


$conn = mysqli_connect('feenix-mariadb.swin.edu.au', 's103808977', '300903', 's103808977_db');
mysqli_set_charset($conn, 'utf8');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'POST':
    $data = json_decode(file_get_contents("php://input"));
    $userId = $data->userId;
    $mealId = $data->mealId;
    $sql = "INSERT INTO favorites (user_id, meal_id) VALUES ('$userId', '$mealId')";
    if ($conn->query($sql) === TRUE) {
      echo json_encode(["message" => "Favorite added"]);
    } else {
      echo json_encode(["message" => "Error: " . $conn->error]);
    }
    break;
  case 'DELETE':
    $data = json_decode(file_get_contents("php://input"));
    $userId = $data->userId;
    $mealId = $data->mealId;
    $sql = "DELETE FROM favorites WHERE user_id = '$userId' AND meal_id = '$mealId'";
    if ($conn->query($sql) === TRUE) {
      echo json_encode(["message" => "Favorite removed"]);
    } else {
      echo json_encode(["message" => "Error: " . $conn->error]);
    }
    break;
  case 'GET':
    $userId = $_GET['userId'];
    $sql = "SELECT meal_id FROM favorites WHERE user_id = '$userId'";
    $result = $conn->query($sql);
    $favorites = [];
    while ($row = $result->fetch_assoc()) {
      $favorites[] = $row['meal_id'];
    }
    echo json_encode($favorites);
    break;
  default:
    echo json_encode(["message" => "Method not allowed"]);
    break;
}

$conn->close();
