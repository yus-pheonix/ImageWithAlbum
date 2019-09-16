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
    <title>Add Image</title>
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
        <form class="text-center border border-light p-5" method="post" id="addAlbumForm" action="SaveImage.php" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="images" class="col-sm-2 col-form-label">Select Album</label>
                <div class="col-sm-10">
                <select class="mdb-select md-form colorful-select dropdown-primary" name="albumSelect">
                    <option value="0" disabled selected>Choose your Album</option>
                    <?php echo optionDisplay();?>
                </select>
                </div>
                <label for="images" class="col-sm-2 col-form-label">Select Images</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="images" placeholder="Images" name="files[]" multiple>
                </div>
                <div class="cols-sm-10 alert-danger">
                    <span id="imageErr"></span>
                </div>
                <button class="btn btn-info btn-block my-4" type="submit" name="submit" id="addButton">Add Images</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php

}

function optionDisplay(){
    $userId = $_SESSION['userId'];
    require 'connectDatabase.php';
    $query = "SELECT * FROM albums WHERE userId = '$userId'";
    $responce = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($responce);
    if($rows > 0){
        for($i=0; $i<$rows; $i++){
            $data = mysqli_fetch_array($responce);
            ?>
            <option value="<?php echo $data[0]; ?>"><?php echo $data[1] ?></option>
            <?php
        }
    }
}

?>