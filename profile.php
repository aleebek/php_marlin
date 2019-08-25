<?php 
session_start();
var_dump($_SESSION);
if (isset($_SESSION['error_name'])) {$error_name = $_SESSION['error_name']; unset($_SESSION['error_name']);}
if (isset($_SESSION['error_email'])) {$error_email = $_SESSION['error_email']; unset($_SESSION['error_email']);} 
if (isset($_SESSION['error_current'])) {$error_current = $_SESSION['error_current']; unset($_SESSION['error_current']);} 
if (isset($_SESSION['error_password'])) {$error_password = $_SESSION['error_password']; unset($_SESSION['error_password']);} 
if (isset($_SESSION['error_password_confirmation'])) {$error_password_confirmation = $_SESSION['error_password_confirmation']; unset($_SESSION['error_password_confirmation']);} 
if (isset($_SESSION['success_update'])) {$success_update = $_SESSION['success_update']; unset($_SESSION['success_update']);}
if (isset($_SESSION['success_password'])) {$success_password = $_SESSION['success_password']; unset($_SESSION['success_password']);}
if (isset($_SESSION['current_user'])) {
    $current_user = $_SESSION['current_user']; 
    $id = $_SESSION['current_user_id'];
} else if (isset($_COOKIE['email'])) {
    $current_user = $_COOKIE['email'];
    $id = $_COOKIE['id'];
    $_SESSION['current_user_id'] = $_COOKIE['id'];
    
	$_SESSION['current_user'] = $current_user;
} else {
	$current_user = null;
	session_destroy();
	header("Location: /php_marlin/login.php");
    exit;
}
//  как очистить сессию и не удалить данные о зашедшем пользователе?
//  if (isset($_SESSION['current_user'])) echo 'session '.$_SESSION['current_user']; 
//  if (isset($_COOKIE['email'])) echo 'cookie '.$_COOKIE['email'];


$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

mysqli_query($link, "SET NAMES 'utf8'");

$query = "SELECT * FROM users WHERE id='$id'";

$result = mysqli_query($link, $query) or die(mysqli_error($link));
$row = mysqli_fetch_assoc($result);


var_dump($row);
//var_dump($_SESSION);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                            
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                            <div class="alert alert-success <?php if (!isset($success_update)) echo 'd-none';?>" role="alert">
                                Профиль успешно обновлен
							</div>
                          

                            <form action="profile_update.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" class="form-control <?php if (isset($error_name)) echo 'is-invalid'; else echo 'valid'; ?>" name="name" value="<?php echo $row['name'];?>">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_name)) echo $error_name;?>
                                            </div>
                                           
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="email" class="form-control <?php if (isset($error_email)) echo 'is-invalid'; else echo 'valid'; ?>" name="email" value="<?php echo $row['email'];?>">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_email)) echo $error_email;?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image" id="exampleFormControlInput1" enctype="multipart/form-data">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="<?php if (empty($row['image'])) echo 'img/no-user.jpg'; else echo $row['image'];?> " alt="" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
                            <div class="alert alert-success <?php if (!isset($success_password)) echo 'd-none';?>" role="alert">
							    Пароль успешно обновлен
                            </div>

                            <form action="password_update.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" class="form-control <?php if (isset($error_current)) echo 'is-invalid'; else echo 'valid'; ?>" name="current">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_current)) echo $error_current;?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" class="form-control <?php if (isset($error_password)) echo 'is-invalid'; else echo 'valid'; ?>" name="password">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_password)) echo $error_password;?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            
                                            <input type="password" class="form-control <?php if (isset($error_password_confirmation)) echo 'is-invalid'; else echo 'valid'; ?>" name="password_confirmation">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_password_confirmation)) echo $error_password_confirmation;?>
                                            </div>
                                        </div>

                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>
</body>
</html>
