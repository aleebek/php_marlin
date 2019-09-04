<?php 
session_start();

if (isset($_SESSION['error_name'])) {$error_name = $_SESSION['error_name']; unset($_SESSION['error_name']);}
if (isset($_SESSION['error_text'])) {$error_text = $_SESSION['error_text']; unset($_SESSION['error_text']);} 
if (isset($_SESSION['success_comment'])) {$success_comment = $_SESSION['success_comment']; unset($_SESSION['success_comment']);}
if (isset($_SESSION['current_user'])) $current_user = $_SESSION['current_user']; 
else if (isset($_COOKIE['email'])) {
	$current_user = $_COOKIE['email'];
	$_SESSION['current_user_id'] = $_COOKIE['id'];
	$_SESSION['current_user'] = $current_user;
} else {
	$current_user = null;
	session_destroy();
	// header("Location: /php_marlin/login.php");
    // exit;
}
$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

mysqli_query($link, "SET NAMES 'utf8'");

$query = 'SELECT *, users.name as user_name, comments.id as id  FROM comments LEFT JOIN users ON users.id=comments.user_id ORDER BY comments.id DESC';  

$result = mysqli_query($link, $query) or die(mysqli_error($link));

for ($comments = []; $row = mysqli_fetch_assoc($result); $comments[] = $row);
var_dump($comments);
var_dump($_SESSION);
var_dump($_COOKIE);




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
                <a class="navbar-brand" href="index.php">
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
						<li class="nav-item <?php if (empty($current_user)) echo 'd-none'?>">
							<a class="nav-link" href="profile.php">Profile</a>
						</li>
						<li class="nav-item <?php if (empty($current_user)) echo 'd-none'?>">
							<a class="nav-link" href="logout.php">Logout</a>
						</li>
						<li class="nav-item <?php if (!empty($current_user)) echo 'd-none'?>">
							<a class="nav-link" href="login.php">Login</a>
						</li>
						<li class="nav-item <?php if (!empty($current_user)) echo 'd-none'?>">
							<a class="nav-link" href="register.php">Register</a>
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
                            <div class="card-header"><h3>Админ панель</h3></div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach ($comments as $comment) { ?>
                                        <tr>
                                            <td>
                                                <img src="<?php if (empty($comment['image'])) echo 'img/no-user.jpg'; else echo $comment['image'];?>" alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td><?php echo $comment['user_name'] ?></td>
                                            <td><?php echo date('d/m/Y' , strtotime($comment['date']))  ?></td>
                                            <td><?php echo $comment['text'] ?></td>
                                            <td>
                                                <?php if (!empty($comment['hidden'])) :?>
                                                    <a href="admin/allow.php?id=<?php echo $comment['id'] ?>" class="btn btn-success">Разрешить</a>
                                                <?php else: ?>
                                                    <a href="admin/hide.php?id=<?php echo $comment['id'] ?>" class="btn btn-warning">Запретить</a>
                                                <?php endif;?>
                                                <a href="admin/delete.php?id=<?php echo $comment['id'] ?>" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
                                        <?php }?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
