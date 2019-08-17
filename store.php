<?php 
//в каждом php файле нужно подключаться к БД?
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

$query='INSERT INTO comments SET name="'.$_REQUEST['name'].'", date = "'.date('Y-m-d').'", text="'.$_REQUEST['text'].'"';


mysqli_query($link, $query);
header("Location: /php_marlin");
die();

// if (mysqli_query($link, $query)) {
//     echo "New record created successfully";
//  } else {
//     echo "Error: " . $query . "" . mysqli_error($link);
//  }