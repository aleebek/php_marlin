<?php 
session_start();
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

$query='INSERT INTO users SET name="'.$name.'", password = "'.$password.'", email="'.$email.'"';
mysqli_query($link, $query) or die(mysqli_error($link));


header("Location: /php_marlin/login.php");
exit;

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






