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
    } else {
        $_SESSION[$field] = $_REQUEST[$field];
    }
}