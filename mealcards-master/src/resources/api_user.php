<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$conn = mysqli_connect('feenix-mariadb.swin.edu.au', 's103808977', '300903', 's103808977_db');

mysqli_set_charset($conn, 'utf8');

$table = "users";

$response = array(
	"success" => false,
	"message" => "Invalid username or password"
);

switch ($method) {
	case 'POST':
		$username = mysqli_real_escape_string($conn, $input['username']);
		$password = mysqli_real_escape_string($conn, $input['password']);
		$sql = "SELECT * FROM `$table` WHERE username='$username' AND password='$password'";
		break;
	default:
		echo json_encode($response);
		mysqli_close($conn);
		exit();
}

$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
	$user = mysqli_fetch_assoc($result);
	$response['success'] = true;
	$response['user'] = $user;
	unset($response['message']);
} else {
	$response['message'] = "Invalid username or password";
}

echo json_encode($response);

mysqli_close($conn);
