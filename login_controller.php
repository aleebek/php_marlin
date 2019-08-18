<?php
session_start();
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);


if(empty($_REQUEST['email'])) {
    $_SESSION['error_email'] = 'Обязательное поле';
} else {
    $email = $_REQUEST['email']; 
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($link, $query);
    if ($result->num_rows !== 0) {
        $row = mysqli_fetch_assoc($result);
        if(empty($_REQUEST['password'])) {
            $_SESSION['error_password'] = 'Обязательное поле';
        } else {
            $password = $_REQUEST['password']; 
            $hash = $row['password'];
            //var_dump($hash); 
            if (password_verify($password, $hash)) {
                //echo 'Success!';
                $_SESSION['current_user'] = $row['email'];
                header("Location: /php_marlin");
                exit;
            }
            else {
                //echo 'Invalid credentials';
                $_SESSION['error_password'] = 'Неверный пароль';
                header("Location: /php_marlin/login.php");
                exit;
            }   
        }
    } else {
        $_SESSION['error_email'] = "Пользователя с таким email не существует"; 
        $_SESSION['email'] = $_REQUEST['email'];
        header("Location: /php_marlin/login.php");
        exit;
    }
    
    //var_dump($row);    
} 

 