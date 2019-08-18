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

if(empty($_REQUEST['text'])) {
    $_SESSION['error_text'] = 'Обязательное поле';
} else {    
    $text = $_REQUEST['text'];
}

if(empty($_REQUEST['text']) or empty($_REQUEST['name'])) {
    header("Location: /php_marlin");
    exit;
    
} else {
    $date = date('Y-m-d');
    $query='INSERT INTO comments SET name="'.$name.'", date = "'.$date.'", text="'.$text.'"';
    mysqli_query($link, $query);
    $_SESSION['success_comment'] = 'success';
    header("Location: /php_marlin");
    exit;
}








// if (mysqli_query($link, $query)) {
//     echo "New record created successfully";
//  } else {
//     echo "Error: " . $query . "" . mysqli_error($link);
//  }