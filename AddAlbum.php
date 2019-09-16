<?php
session_start();
if(!isset($_SESSION['userId'])){
    header("Location: HomePage.php"); 
    exit();
  }else{
    class ErrorMessages {
        public $albumNameErr;
    }

    function testData($regex, $data){
       return preg_match($regex, $data);
    }

    function cleanData($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $isError = false;
        $albumName = $_POST['albumName'];
        $messages = new ErrorMessages();
        $userId = $_SESSION['userId'];
        $albumId = $_POST['albumId'];
        $isUpdate = $_POST['isUpdate'];

        if(empty($albumName)){
            $isError = true;
            $messages -> albumNameErr = 'Album Name Cannot be empty';
        }else if(testData('/^[a-zA-Z ]*$/', $albumName)){
            $albumName = cleanData($albumName);
        }else{
            $isError = true;
            $messages -> albumNameErr = 'Enter valid Album name';
        }

        if($isError == false){
            require 'connectDatabase.php';
            $query = "SELECT * FROM albums WHERE albumName = '$albumName' AND userId = '$userId'";
            $responce = mysqli_query($conn, $query);
            $numRows = mysqli_num_rows($responce);
            if($numRows > 0){
                $isError = true;
                $messages -> albumNameErr = 'Album Name already exist please enter new name';
            }else if(!empty($albumId) && $isUpdate == 'yes'){
                $query = "UPDATE albums SET albumName = '$albumName' WHERE id = '$albumId' AND userId = '$userId'";
            }else{
                $query = "INSERT INTO albums(albumName, userId) VALUES ('$albumName', '$userId')";
            } 
            if(mysqli_query($conn, $query)){
                echo true;
            }else{
                die('error inserting data into database');
            }

        }else{
            echo json_encode($messages);
        }
    }
}

?>