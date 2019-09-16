<?php
    session_start();

    class ErrorMessages {
        public $nameErr;
        public $emailErr;
        public $userNameErr;
        public $passwordErr;
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
        $name = $_POST['name'];
        $email = $_POST['email'];
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $messages = new ErrorMessages();

        if(empty($name)){
            $isError = true;
            $messages -> nameErr = 'Name Cannot be empty';
        }elseif(testData('/^[a-zA-Z ]*$/', $name)){
            $name = cleanData($name);
        }else{
            $isError = true;
            $messages -> nameErr = 'Enter valid name';
        }

        if(empty($userName)){
            $isError = true;
            $messages -> userNameErr = 'username Cannot be empty';
        }elseif(testData('/^[a-zA-Z0-9]+([_\-]?[a-zA-Z0-9])*$/', $userName)){
            $userName = cleanData($userName);
        }else{
            $isError = true;
            $messages -> userNameErr = 'Enter valid username';
        }

        if(empty($email)){
            $isError = true;
            $messages -> emailErr = 'Email Cannot be empty';
        }elseif(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = cleanData($email);
        }else{
            $isError = true;
            $messages -> emailErr = 'Enter valid email address';
        }

        if(empty($password)){
            $isError = true;
            $messages -> passwordErr = 'Password Cannot be empty';
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        if($isError == false){
            require 'connectDatabase.php';
            $query = "SELECT * FROM users WHERE userName = '$userName'";
            $responce = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($responce);
            if($rows > 0){
                $messages -> userNameErr = 'user name already exist';
                echo json_encode($messages);
            }else{
                $query = "SELECT * FROM users WHERE email = '$email'";
                $responce = mysqli_query($conn, $query);
                $rows = mysqli_num_rows($responce);
                if($rows > 0){
                    $messages -> emailErr = 'Email already exist';
                    echo json_encode($messages);
                }else{
                    $query = "INSERT INTO users(name, userName, email, userPassword) VALUES ('$name', '$userName', '$email', '$password')";
                    if(mysqli_query($conn, $query)){
                        $query ="SELECT id FROM users WHERE userName = '$userName'";
                        $responce = mysqli_query($conn, $query);
                        $rows = mysqli_num_rows($responce);
                        if($rows > 0){
                            $userId = mysqli_fetch_array($responce)['id'];
                            $_SESSION['userId'] = $userId;
                            header("Location:PhotoDashboard.php"); 
                            exit();
                        }else{
                            die('Failed to retrieve login details please try again');
                        }
                    }else{
                        die('error inserting data into table');
                    }
                }
            }
            
        }else{
            echo json_encode($messages);
        }

    }

?>