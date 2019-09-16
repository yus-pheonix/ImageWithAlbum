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
          <li class="nav-item">
            <a class="nav-link" href="AddImage.php">Add Image</a>
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
        <form class="text-center border border-light p-5" method="post" id="addAlbumForm">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Album Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="albumName" placeholder="Album Name" name="albumName">
                </div>
                <div class="cols-sm-10 alert-danger">
                    <span id="albumNameErr"></span>
                </div>
                <button class="btn btn-info btn-block my-4" type="submit" name="submit" id="addButton">Add Album</button>
                <button class="btn btn-info btn-block my-4" name="cancel" id="cancelButton">Cancel</button>
            </div>
        </form>


<?php
  require 'ConnectDatabase.php';
  $userId = $_SESSION['userId'];
  $output = '';
  $output .= '
 <table class="table table-bordered table-striped">
  <tr>
   <th>Sr. No</th>
   <th>Album Name</th>
   <th>User Name</th>
   <th>Edit</th>
   <th>Delete</th>
  </tr>
';
  $query = "SELECT albums.*, users.userName FROM albums inner join users ON albums.userId = users.id HAVING albums.userId = '$userId'";
  $responce = mysqli_query($conn, $query);
  $result = mysqli_fetch_all($responce, MYSQLI_ASSOC);
  $rows = mysqli_num_rows($responce);
  if($rows > 0){
    $count = 0;
    foreach($result as $row){
      $count ++; 
      $output .= '
      <tr>
      <td>'.$count.'</td>
      <td class="albumName">'.$row["albumName"].'</td>
      <td>'.$row["userName"].'</td>
      <td><button type="button" class="btn btn-warning btn-xs edit" id="'.$row["id"].'">Edit</button></td>
      <td><button type="button" class="btn btn-danger btn-xs delete" id="'.$row["id"].'" data-image_name="'.$row["albumName"].'">Delete</button></td>
      </tr>
      ';
    }
  }else{
    $output .= '
      <tr>
      <td colspan="5" align="center">No Data Found</td>
      </tr>
    ';
    }
    $output .= '</table>';
    echo $output;

?>
</div>
</body>
</html>

<?php

}

?>