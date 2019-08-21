<?php 
session_start();
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);



  
$id = $_SESSION['current_user_id'];


if(empty($_REQUEST['text'])) {
    $_SESSION['error_text'] = 'Обязательное поле';
} else {    
    $text = $_REQUEST['text'];
}

if(empty($_REQUEST['text'])) {
    header("Location: /php_marlin");
    exit;
    
} else {
    $date = date('Y-m-d');
    $query='INSERT INTO comments SET user_id="'.$id.'", date = "'.$date.'", text="'.$text.'"';
    echo $query;
    mysqli_query($link, $query) or die(mysqli_error($link));
    $_SESSION['success_comment'] = 'success';
    header("Location: /php_marlin");
    exit;
}








// if (mysqli_query($link, $query)) {
//     echo "New record created successfully";
//  } else {
//     echo "Error: " . $query . "" . mysqli_error($link);
//  }