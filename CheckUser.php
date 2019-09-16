<?php
    session_start();

    class ErrorMessages {
        public $userNameErr;
        public $passwordErr;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $isError = false;
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $messages = new ErrorMessages();

        if(empty($userName)){
            $isError = true;
            $messages -> userNameErr = 'username Cannot be empty';
        }

        if(empty($password)){
            $isError = true;
            $messages -> passwordErr = 'Password Cannot be empty';
        }

        if($isError == false){
            require 'connectDatabase.php';
            $query = "SELECT * FROM users WHERE userName = '$userName'";
            $responce = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($responce);
            if($rows > 0){
                $userId = mysqli_fetch_array($responce)['id'];
                $query = "SELECT userPassword FROM users WHERE userName = '$userName'";
                $responce = mysqli_query($conn, $query);
                $data = mysqli_fetch_array($responce);
                $hash = $data[0];
                if(password_verify($password, $hash)){
                    $_SESSION['userId'] = $userId;
                    echo true;
                    exit();
                }else{
                    $messages -> passwordErr = 'password is wrong please enter valid password';
                    echo json_encode($messages);
                }
            }else{
                $messages -> userNameErr = 'username does not exist please enter valid user name';
                echo json_encode($messages);
            }
        }else{
            echo json_encode($messages);
        }
    }
?>