<?php
session_start();

$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} else {
	//echo "Database Connection Success";
}
$currentUser = $_SESSION['id'];
$taskname = mysqli_real_escape_string($conn, $_POST['taskname']);
$taskdate = mysqli_real_escape_string($conn, $_POST['taskdate']);
$taskdone = 0;

$stmt = $conn->prepare("INSERT INTO task (user_id, text, date, done) VALUES (?, ?, ?, ?)");
//$password_1 = password_hash($password_1, PASSWORD_BCRYPT);
$stmt->bind_param("ssss",$currentUser, $taskname, $taskdate, $taskdone);
if (!$stmt->execute()) {
	echo ("Statement failed: " . $stmt->error . "<br>");
}
$stmt->close();


header("Location: ../index.php");