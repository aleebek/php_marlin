<?php
session_start();
var_dump($_SESSION);
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

function return_to_profile(){

    header("Location: /php_marlin/profile.php");
    exit;
}

function check_empty_field($field) {
    if(empty($_REQUEST[$field])) {
        $_SESSION['error_'.$field] = 'Обязательное поле';
        return_to_profile();
    } 
}

check_empty_field('current');
check_empty_field('password');
check_empty_field('password_confirmation');
$current = $_REQUEST['current'];
$password = $_REQUEST['password'];
$password_confirmation = $_REQUEST['password_confirmation'];
$current_hash = $_SESSION['hash'];

if (!password_verify($current , $current_hash)) {
    $_SESSION['error_current'] = 'Неверный пароль';
    return_to_profile();
}

if (strlen($password) < 6) {
    $_SESSION['error_password'] = 'Длина пароля должна быть не менее 6 символов';
    return_to_profile();
} else if (strcmp ( $password , $password_confirmation ) !== 0) {
    $_SESSION['error_password_confirmation'] = 'Пароль и его подтверждение не совпадают';
    return_to_profile();
} 

$hash = password_hash($password, PASSWORD_DEFAULT);
$query='UPDATE users SET password = "'.$hash.'" WHERE id="'.$id.'"';
mysqli_query($link, $query) or die(mysqli_error($link));
$_SESSION['success_password'] = 'ok';
return_to_profile();