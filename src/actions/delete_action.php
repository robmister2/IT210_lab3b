<?php
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

$item_id = mysqli_real_escape_string($conn, $_POST['item_id']);

$stmt = $conn->prepare("DELETE FROM task WHERE id = $item_id");
    
if ($stmt && !$stmt->execute()) {
    echo ("Statement failed: " . $stmt->error . "<br>");
}
$stmt->close();

header("Location: ../index.php");