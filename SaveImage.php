<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Include the database configuration file
    require 'ConnectDatabase.php';
    $userId = $_SESSION['userId'];
    $albumId = $_POST['albumSelect'];
    
    // File upload configuration
    $targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg','gif');

    if(!empty(array_filter($_FILES['files']['name']))){
        foreach($_FILES['files']['name'] as $key=>$val){
            // File upload path
            $fileName = basename($_FILES['files']['name'][$key]);
            $targetFilePath = $targetDir.$userId.$fileName;
            
            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){
                    // Image db insert sql
                    $query = "INSERT INTO images(imagePath, albumId, userId) VALUES ('$targetFilePath', '$albumId', '$userId')";
                    if(mysqli_query($conn, $query)){
                        $statusMsg = "file uploaded succesfully";
                    }else{
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                }else{
                    $statusMsg .= $_FILES['files']['name'][$key].', ';
                }
            }else{
                $statusMsg .= $_FILES['files']['name'][$key].', ';
            }
        }
    
    // Display status message
    echo $statusMsg;
}
}
?>