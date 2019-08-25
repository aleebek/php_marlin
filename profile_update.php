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

function check_email_exist($email) {   
    global $link; 
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result->num_rows !== 0) {
        $_SESSION['error_email'] = "Пользователь с таким email уже существует"; 
        $_SESSION['email'] = $_REQUEST['email'];
        return_to_profile();
    } 
}

check_empty_field('name');
check_empty_field('email');
$name = $_REQUEST['name'];
$email = $_REQUEST['email'];

if (strcmp($_SESSION['current_user'],$email)) {
    check_email_exist($email);
}


$id = $_SESSION['current_user_id'];
$query = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

if (empty($_FILES['image']['tmp_name'])) {
    
    $query='UPDATE users SET name="'.$name.'", email = "'.$email.'" WHERE id="'.$id.'"';
} else {
    $image = 'img/'.uniqid().'.jpg';
    move_uploaded_file($_FILES['image']['tmp_name'], $image);
    $query='UPDATE users SET name="'.$name.'", email = "'.$email.'", image = "'.$image.'" WHERE id="'.$id.'"';
}

var_dump($query);


mysqli_query($link, $query) or die(mysqli_error($link));
$_SESSION['success_update'] = 'ok';
return_to_profile();