<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

error_log("Request method: $method");
error_log("Request input: " . print_r($input, true));

$conn = mysqli_connect('feenix-mariadb.swin.edu.au', 's103808977', '300903', 's103808977_db');
mysqli_set_charset($conn, 'utf8');

$response = array(
  "success" => false,
  "message" => "Action failed"
);

if (mysqli_connect_errno()) {
  $response['message'] = "Failed to connect to MySQL: " . mysqli_connect_error();
  echo json_encode($response);
  exit();
}

switch ($method) {
  case 'POST':
    error_log("Checking POST parameters");
    if (isset($input['user_id']) && isset($input['meal_id']) && isset($input['action'])) {
      $user_id = mysqli_real_escape_string($conn, $input['user_id']);
      $meal_id = mysqli_real_escape_string($conn, $input['meal_id']);
      $action = mysqli_real_escape_string($conn, $input['action']);

      error_log("POST request received with user_id: $user_id, meal_id: $meal_id, action: $action");

      if ($action === 'like') {
        handleLike($conn, $user_id, $meal_id, $response);
      } elseif ($action === 'dislike') {
        handleDislike($conn, $user_id, $meal_id, $response);
      } else {
        $response['message'] = "Invalid action: " . $action;
      }
    }
    break;

  case 'GET':
    if (isset($_GET['meal_id'])) {
      $meal_id = mysqli_real_escape_string($conn, $_GET['meal_id']);
      getMealLikes($conn, $meal_id, $response);
    }
    break;

  default:
    $response['message'] = "Invalid request method: " . $method;
    echo json_encode($response);
    mysqli_close($conn);
    exit();
}

echo json_encode($response);
mysqli_close($conn);

function handleLike($conn, $user_id, $meal_id, &$response)
{
  error_log("handleLike called with user_id: $user_id, meal_id: $meal_id");
  $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND meal_id = ?");
  if (!$stmt) {
    $response['message'] = "Prepare failed: " . $conn->error;
    error_log("Prepare failed: " . $conn->error);
    return;
  }
  $stmt->bind_param("ii", $user_id, $meal_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE likes SET type = 'like' WHERE user_id = ? AND meal_id = ?");
    if (!$stmt) {
      $response['message'] = "Prepare failed (update like): " . $conn->error;
      error_log("Prepare failed (update like): " . $conn->error);
      return;
    }
    $stmt->bind_param("ii", $user_id, $meal_id);
  } else {
    $stmt = $conn->prepare("INSERT INTO likes (user_id, meal_id, type) VALUES (?, ?, 'like')");
    if (!$stmt) {
      $response['message'] = "Prepare failed (insert like): " . $conn->error;
      error_log("Prepare failed (insert like): " . $conn->error);
      return;
    }
    $stmt->bind_param("ii", $user_id, $meal_id);
  }
  if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Meal liked';
    error_log("Meal liked: user_id: $user_id, meal_id: $meal_id");
    getMealLikes($conn, $meal_id, $response);
  } else {
    $response['message'] = 'Execute failed (like): ' . $stmt->error;
    error_log("Execute failed (like): " . $stmt->error);
  }
  $stmt->close();
}

function handleDislike($conn, $user_id, $meal_id, &$response)
{
  error_log("handleDislike called with user_id: $user_id, meal_id: $meal_id");
  $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND meal_id = ?");
  if (!$stmt) {
    $response['message'] = "Prepare failed: " . $conn->error;
    error_log("Prepare failed: " . $conn->error);
    return;
  }
  $stmt->bind_param("ii", $user_id, $meal_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE likes SET type = 'dislike' WHERE user_id = ? AND meal_id = ?");
    if (!$stmt) {
      $response['message'] = "Prepare failed (update dislike): " . $conn->error;
      error_log("Prepare failed (update dislike): " . $conn->error);
      return;
    }
    $stmt->bind_param("ii", $user_id, $meal_id);
  } else {
    $stmt = $conn->prepare("INSERT INTO likes (user_id, meal_id, type) VALUES (?, ?, 'dislike')");
    if (!$stmt) {
      $response['message'] = "Prepare failed (insert dislike): " . $conn->error;
      error_log("Prepare failed (insert dislike): " . $conn->error);
      return;
    }
    $stmt->bind_param("ii", $user_id, $meal_id);
  }
  if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Meal disliked';
    error_log("Meal disliked: user_id: $user_id, meal_id: $meal_id");
    getMealLikes($conn, $meal_id, $response);
  } else {
    $response['message'] = 'Execute failed (dislike): ' . $stmt->error;
    error_log("Execute failed (dislike): " . $stmt->error);
  }
  $stmt->close();
}

function getMealLikes($conn, $meal_id, &$response)
{
  error_log("getMealLikes called with meal_id: $meal_id");
  $stmt = $conn->prepare("SELECT 
        SUM(CASE WHEN type = 'like' THEN 1 ELSE 0 END) as likes,
        SUM(CASE WHEN type = 'dislike' THEN 1 ELSE 0 END) as dislikes
    FROM likes WHERE meal_id = ?");
  if (!$stmt) {
    $response['message'] = "Prepare failed: " . $conn->error;
    error_log("Prepare failed: " . $conn->error);
    return;
  }
  $stmt->bind_param("i", $meal_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
  $stmt->close();

  if ($data) {
    $response['data'] = $data;
    $response['success'] = true;
    $response['message'] = 'Likes and dislikes fetched';
    error_log("Likes and dislikes fetched for meal_id: $meal_id");
  } else {
    $response['message'] = 'No records found for meal_id: ' . $meal_id;
    error_log('No records found for meal_id: ' . $meal_id);
  }
}
