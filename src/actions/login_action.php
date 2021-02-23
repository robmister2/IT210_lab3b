<?php
// ./actions/login_action.php

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

// This section for DEBUGGING ONLY! COMMENT-OUT WHEN FINISHED
/*echo "<p>mysql_servername: $mysql_servername</p>";
echo "<p>mysql_user: $mysql_user</p>";
echo "<p>mysql_password: $mysql_password</p>";
echo "<p>mysql_database: $mysql_database</p>"; */

$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} else {
	//echo "Database Connection Success";
}


// receive all input values from the form
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password_1 = mysqli_real_escape_string($conn, $_POST['password']);


$stmt = $conn->prepare("SELECT username FROM user WHERE username=?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($found);
$stmt->fetch();

if (!$found) { // if user does not exist 
	header("Location: ../views/login.php?error=Username does not exist :c");
	exit();
}

$passTest = password_verify($password_1, $user['password']);
if (!$passTest) { // if password is bad
	header("Location: ../views/login.php?error=Incorrect password");
	exit();
}

$id = $user['id'];
$stmt = $conn->prepare("UPDATE `user` SET `logged_in`=true WHERE ID = $id");
if (!$stmt->execute()) {
	echo ("Statement failed: " . $stmt->error . "<br>");
}
$stmt->close();

session_start();
$_SESSION['logged_in'] = true;
$_SESSION['username'] = $username;
$_SESSION['id'] = $user['id'];

header("Location: ../index.php");

