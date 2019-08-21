<?php
session_start();
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

function return_to_login(){

    header("Location: /php_marlin/login.php");
    exit;
}

function check_empty_field($field) {
    if(empty($_REQUEST[$field])) {
        $_SESSION['error_'.$field] = 'Обязательное поле';
        return_to_login();
    } else {
        $_SESSION[$field] = $_REQUEST[$field];
    }
}

function validate_email() {
    if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_email'] = "Введите корректный e-mail.";   
        $_SESSION['email'] = $_REQUEST['email'];
        return_to_login();
    }
}

function get_user_data_from_db() {
    global $link;
    $email = $_REQUEST['email']; 
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($link, $query);
    if ($result->num_rows == 0) {
        $_SESSION['error_email'] = "Пользователя с таким email не существует"; 
        $_SESSION['email'] = $_REQUEST['email'];
        return_to_login();
    }
    return mysqli_fetch_assoc($result);
}


check_empty_field('email');
validate_email();
check_empty_field('password');

$row = get_user_data_from_db();

$password = $_REQUEST['password']; 
$hash = $row['password'];
if (password_verify($password, $hash)) {
    
    if(isset($_REQUEST['remember'])) {
        setcookie('hash', $hash);
        setcookie('email', $row['email']);
        setcookie('id', $row['id']);
    }
    $_SESSION['current_user'] = $row['email'];
    $_SESSION['current_user_id'] = $row['id'];
    header("Location: /php_marlin");
    exit;
}
else {
    //echo 'Invalid credentials';
    $_SESSION['error_password'] = 'Неверный пароль';
    return_to_login();
} 




// if(empty($_REQUEST['email'])) {
//     $_SESSION['error_email'] = 'Обязательное поле';
// } else if (filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
//     $email = $_REQUEST['email']; 
//     $query = "SELECT * FROM users WHERE email='$email'";
//     $result = mysqli_query($link, $query);
//     if ($result->num_rows !== 0) {
//         $row = mysqli_fetch_assoc($result);
//         if(empty($_REQUEST['password'])) {
//             $_SESSION['error_password'] = 'Обязательное поле';
//         } else {
//             $password = $_REQUEST['password']; 
//             $hash = $row['password'];
//             //var_dump($hash); 
//             if (password_verify($password, $hash)) {
//                 //echo 'Success!';
//                 if(isset($_REQUEST['remember'])) {
//                     setcookie('hash', $hash);
//                     setcookie('email', $row['email']);
//                     setcookie('id', $row['id']);
//                 }
//                 $_SESSION['current_user'] = $row['email'];
//                 $_SESSION['current_user_id'] = $row['id'];
//                 header("Location: /php_marlin");
//                 exit;
//             }
//             else {
//                 //echo 'Invalid credentials';
//                 $_SESSION['error_password'] = 'Неверный пароль';
//                 header("Location: /php_marlin/login.php");
//                 exit;
//             }   
//         }
//     } else {
//         $_SESSION['error_email'] = "Пользователя с таким email не существует"; 
//         $_SESSION['email'] = $_REQUEST['email'];
//         header("Location: /php_marlin/login.php");
//         exit;
//     }
    
//     //var_dump($row);    
// } else {
//     $_SESSION['error_email'] = "E-mail адрес должен содержать @.";   
//     $_SESSION['email'] = $_REQUEST['email'];
//     header("Location: /php_marlin/login.php");
//     exit;
    
// }

 