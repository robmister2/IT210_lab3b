<?php
// ./actions/register_action.php

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// REGISTER USER
if (!isset($_POST['username'])) {
	//echo(print_r($_POST,TRUE));
	//echo(print_r($_GET,TRUE));
	die("no username");
}
if (!isset($_POST['password_1'])) {
	die("no password");
}
if (!isset($_POST['password_2'])) {
	die("no confirmed password");
}

// receive all input values from the form
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
$password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

if ($password_1 != $password_2) {
	header("Location: ../views/register.php?error=Passwords do not match :c");
	exit();
	//die("The two passwords do not match");
}

// first check the database to make sure 
// a user does not already exist with the same username
$stmt = $conn->prepare("SELECT username FROM user WHERE username=?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($found);
$stmt->fetch();

if ($found) { // if user exists
	header("Location: ../views/register.php?error=Username already taken");
	exit();
}
$stmt->close();


$stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
$password_1 = password_hash($password_1, PASSWORD_BCRYPT);
$stmt->bind_param("ss", $username, $password_1);
if (!$stmt->execute()) {
	echo ("Statement failed: " . $stmt->error . "<br>");
}
$stmt->close();


$id = mysqli_insert_id($conn);
$stmt = $conn->prepare("UPDATE `user` SET `logged_in`=true WHERE ID = $id");
if (!$stmt->execute()) {
	echo ("Statement failed: " . $stmt->error . "<br>");
}
$stmt->close();

session_start();
$_SESSION['logged_in'] = true;
$_SESSION['username'] = $username;
$_SESSION['id'] = $id;

header("Location: ../index.php");
