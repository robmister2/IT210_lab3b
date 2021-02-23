<?php
session_start();
// ./actions/logout_action.php

// Read variables and create connection
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
$stmt = $conn->prepare("UPDATE `user` SET `logged_in`=false WHERE ID = $currentUser");

if ($stmt && !$stmt->execute()) {
	echo ("Statement failed: " . $stmt->error . "<br>");
}
$stmt->close();

session_unset();
session_destroy();

header("Location: ../views/login.php");


?>
