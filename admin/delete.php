<?php
session_start();

var_dump($_SESSION);
var_dump($_COOKIE);
var_dump($_GET);

$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

$id = $_GET['id'];

$query='DELETE FROM comments WHERE id="'.$id.'"';

var_dump($query);

mysqli_query($link, $query) or die(mysqli_error($link));

header("Location: /php_marlin/admin.php");
exit;