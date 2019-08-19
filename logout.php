<?php
session_start();
unset($_SESSION['current_user']);
setcookie('email', '', -1); 
setcookie('hash', '', -1); 
session_destroy();

//if (isset($_SESSION['current_user'])) echo 'session '.$_SESSION['current_user']; 
header("Location: /php_marlin");
exit;
