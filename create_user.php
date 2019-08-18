<?php 
session_start();
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);


if(empty($_REQUEST['name'])) {
    $_SESSION['error_name'] = 'Обязательное поле';
} else {    
    $name = $_REQUEST['name'];
}



if(empty($_REQUEST['password'])) {
    $_SESSION['error_password'] = 'Обязательное поле';
} else {    
    $password = $_REQUEST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    // var_dump($hash);
}

if(empty($_REQUEST['email'])) {
    $_SESSION['error_email'] = 'Обязательное поле';
} else if (filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
    $email = $_REQUEST['email'];
    // var_dump($email);
} else {
    $_SESSION['error_email'] = "E-mail адрес должен содержать @.";   
    $_SESSION['email'] = $_REQUEST['email'];
    header("Location: /php_marlin/register.php");
    exit;
}

if(empty($_REQUEST['email']) or empty($_REQUEST['name']) or empty($_REQUEST['password'])) {
    header("Location: /php_marlin/register.php");
    exit;
    
} else {
    $date = date('Y-m-d');
    $query='INSERT INTO users SET name="'.$name.'", password = "'.$hash.'", email="'.$email.'"';
    mysqli_query($link, $query) or die(mysqli_error($link));
    $_SESSION['success_comment'] = 'success';
    header("Location: /php_marlin/login.php");
    exit;
}




// if(empty($_REQUEST['name'])) {
//     $_SESSION['error_name'] = 'Обязательное поле';
// } else {    
//     $name = $_REQUEST['name'];
// }

// if(empty($_REQUEST['email'])) {
//     $_SESSION['error_email'] = 'Обязательное поле';
// } else {    
//     $text = $_REQUEST['text'];
// }

// if(empty($_REQUEST['text']) or empty($_REQUEST['name'])) {
//     header("Location: /php_marlin");
//     exit;
    
// } else {
    
//     $query='INSERT INTO users SET name="'.$name.'", password = "'.$password.'", email="'.$email.'"';
//     mysqli_query($link, $query);
//     $_SESSION['success_user'] = 'success';
//     header("Location: /php_marlin");
//     exit;
// }






