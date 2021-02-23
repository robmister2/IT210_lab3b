<?php
session_start();
if (!$_SESSION['logged_in']) {
    header("Location: ../views/login.php");
}
?>
<!DOCTYPE html>

<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


    <nav class="navbar navbar-expand-lg navbar-light">
        <form action="actions/logout_action.php" method="post">
            <button type="submit" class="btn btn-success" id="deleteButton">Log Out</button>
        </form>
        <a class="navbar-brand" href="#">Menu</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Waffle <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Proteins</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Specials</a>
        </li>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            </ul>
        </div>
    </nav>
    <div class="container">

<body>
    <h1>
        Task List
    </h1>

    <?php

    if (isset($_GET['error'])) {
        echo $_GET['error'];
    }
    ?>
    <div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitch1">
    <label class="custom-control-label" for="customSwitch1">Hide Completed</label>
  </div>
  <div class="custom-control custom-switch" id= "datesToggle">
    <input type="checkbox" class="custom-control-input" id="customSwitch2">
    <label class="custom-control-label" for="customSwitch2">Sort by Date</label>
  </div>

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



$currentUser = $_SESSION['id'];
$stmt = $conn->prepare("SELECT text, date, FROM task WHERE user_id=?");
$stmt->bind_param('s', $currentUser); //FIXME WTF
if (!$stmt->execute()) {
	echo ("Statement failed: " . $stmt->error . "<br>");
}
$result = $conn->query($stmt);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "task: " . $row["text"]. " - Date: " . $row["date"];
  }
} else {
  echo "0 results";
}

$stmt->close();

?>

  <ul class="list-group mb-5" id="taskList">
    
  </ul>

<div class="container">
  <form id = "myForm" action="actions/create_action.php" method="post">
      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex3"></label>
        <input class="form-control" id="ex3" type="text" name = taskname required>
      <div class="col-xs-4">
        <label for="ex4"></label>
        <input class="form-control" id="ex4" type ='date' name = taskdate required>
      </div>
      </div>

      <button type="submit" class="btn btn-success" id="myBtn">Submit</button>

  </form>
  
</div>

    <div class="container">

        <form action="views/login.php" method="get">
            <button type="submit" class="btn btn-success">Login</button>
        </form>


        <form action="views/register.php" method="get">
            <button type="submit" class="btn btn-success">Register</button>
        </form>

    </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>


</html>