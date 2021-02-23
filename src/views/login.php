<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


<body>
  <h1>
      Login
  </h1>

  <?php

if (isset($_GET['error'])) {
	echo $_GET['error'];

}
?>

<div class="container">
  <form action="../actions/login_action.php" method = "post">
      <div class="form-group row">
      <div class="col-xs-4">
        <label for="ex3">Username</label>
        <input class="form-control" id="ex3" type="text" name = "username" required>
      </div>
      <div class="col-xs-4">
        <label for="ex3">Password</label>
        <input class="form-control" id="ex3" type ='password' name = "password" required>
      </div>
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
  </form>
  
</div>
<!--<button type="submit" class="btn btn-success">New User</button> -->
  
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>