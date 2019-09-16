<?php
    $server = 'localhost';
    $username = 'root';
    $passwordAdmin = '';
    $database = 'photoGallery';
    
    $conn = mysqli_connect($server, $username, $passwordAdmin, $database) or die('Error connecting to database');

?>