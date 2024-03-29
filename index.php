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
//  как очистить сессию и не удалить данные о зашедшем пользователе?
//  if (isset($_SESSION['current_user'])) echo 'session '.$_SESSION['current_user']; 
//  if (isset($_COOKIE['email'])) echo 'cookie '.$_COOKIE['email'];


$host = '127.0.0.1';
$db_name   = 'my_database';
$db_user = 'root';
$db_pass = '';

$link = mysqli_connect($host, $db_user, $db_pass, $db_name);

mysqli_query($link, "SET NAMES 'utf8'");


$query = 'SELECT *, users.name as user_name 
FROM comments LEFT JOIN users ON users.id=comments.user_id 
WHERE comments.hidden IS NULL 
ORDER BY comments.id DESC';

$result = mysqli_query($link, $query) or die(mysqli_error($link));

for ($comments = []; $row = mysqli_fetch_assoc($result); $comments[] = $row);
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
				<div class="row justify-content-center <?php if (!empty($current_user)) echo 'd-none'?>">
					<div class="col-md-4">
						<div class="card">
							<div class="card-header text-center">
								<h3>У вас нет доступа</h3>
							</div>
							<div class="card-body text-center">
								<a href="login.php" class="btn btn-primary btn-lg">Login</a>
								<a href="register.php" class="btn btn-primary btn-lg">Register</a>
							</div>
						</div>
					</div>
				</div>
				<?php if (!empty($current_user)) :?>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">
								<div class="alert alert-success <?php if (!isset($success_comment)) echo 'd-none';?>" role="alert">
								Комментарий успешно добавлен
								</div>
								<?php foreach ($comments as $comment) { ?>
								<div class="media">
									<img src="<?php if (empty($comment['image'])) echo 'img/no-user.jpg'; else echo $comment['image'];?>" class="mr-3" alt="..." width="64" height="64">
									<div class="media-body">
									<h5 class="mt-0"><?php echo $comment['user_name'] ?></h5> 
									<span><small><?php echo date('d/m/Y' , strtotime($comment['date']))  ?></small></span>
									<p><?php echo $comment['text'] ?></p>
									</div>
								</div>
								<?php }?>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="/php_marlin/store.php" method="post">
                                	
									<div class="form-group">
										<label for="exampleFormControlTextarea1">Сообщение</label>
										<textarea name="text" class="form-control <?php if (isset($error_text)) echo 'is-invalid'; else echo 'valid';?>" id="exampleFormControlTextarea1" rows="3"></textarea>
										<div class="invalid-feedback">
											<?php if (isset($error_text)) echo $error_text;?>
										</div>
									</div>
                                  	<button type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
				<?php endif;?>
            </div>
        </main>
    </div>
</body>

</html>