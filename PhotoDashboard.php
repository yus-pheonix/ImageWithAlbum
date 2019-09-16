<?php
  session_start();
  if(!isset($_SESSION['userId'])){
    header("Location: HomePage.php"); 
    exit();
  }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="index3.js"></script>
    <title>Photo Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
      <a class="navbar-brand" href="PhotoDashboard.php">Photo Gallery</a>

      <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="PhotoDashboard.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="AlbumDisplay.php">Add Album</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-md-0">
          <input class="form-control" type="text" placeholder="Search">
        </form>
      </div>
    </nav>
    <div class="container mt-3">
      <div class="cols-sm-10 alert-danger">
        <span id="message"></span>
      </div>
      </div>
</body>
</html>

<?php

}

?>