<?php 
session_start();

if (isset($_SESSION['error_name'])) $error_name = $_SESSION['error_name'];
if (isset($_SESSION['error_email'])) $error_email = $_SESSION['error_email'];
if (isset($_SESSION['error_password'])) $error_password = $_SESSION['error_password'];
if (isset($_SESSION['error_password_confirmation'])) $error_password_confirmation = $_SESSION['error_password_confirmation'];
if (isset($_SESSION['email'])) $email = $_SESSION['email'];
if (isset($_SESSION['success_comment'])) $success_comment = $_SESSION['success_comment'];
session_destroy();
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
                                <a class="nav-link" href="login.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.html">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>

                            <div class="card-body">
                                <form method="POST" action="create_user.php">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control <?php if (isset($error_name)) echo 'is-invalid'; else echo 'valid'; ?> " name="name" autofocus>
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_name)) echo $error_name;?>
                                            </div>
                                                <!-- @error('name') is-invalid @enderror -->
                                                <!-- <span class="invalid-feedback" role="alert">
                                                    <strong>Ошибка валидации</strong>
                                                </span> -->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="text" class="form-control <?php if (isset($error_email)) echo 'is-invalid'; else echo 'valid'; ?>" name="email" value = "<?php if (isset($email)) echo $email ?>">
                                            <!-- type="email" -->
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_email)) echo $error_email;?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control <?php if (isset($error_password)) echo 'is-invalid'; else echo 'valid'; ?>" name="password"  autocomplete="new-password">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_password)) echo $error_password;?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control <?php if (isset($error_password_confirmation)) echo 'is-invalid'; else echo 'valid'; ?>" name="password_confirmation"  autocomplete="new-password">
                                            <div class="invalid-feedback">
                                                <?php if (isset($error_password_confirmation)) echo $error_password_confirmation;?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Register
                                            </button>
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
