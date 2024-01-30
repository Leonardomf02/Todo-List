<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styleindex.css">
</head>

<body>

    <body style="background-image: url('./assets/images/back6.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover; background-position: center;">
        <header class="header">
            <div class="logo">
                <img src="./assets/images/log10.png" alt="LevelUpToDo" />
            </div>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3 formcontainer my-form">
                    <div class="mt-4"><br></div>
                    <form method="post" action="./controllers/authController.php" class="border rounded-3 p-4 border-white login-form bg-white mt-5">
                        <h1 class="d-flex justify-content-center mt-1 display-4">LOGIN</h1>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="login_email" name="login_email" placeholder="name@example.com" required>
                            <label for="login_email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="login_password" name="login_password" placeholder="123456789" required>
                            <label for="login_password">Password</label>
                        </div>
                        <button type="submit" name="login" id="login-btn" class="btn btn-primary">Login</button>
                        <div class="d-flex justify-content-center flex-column align-items-center mt-2">
                            <p class="mb-2">Don't have an account yet?</p>
                            <a href="./views/register.php">Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="./assets/js/auth-index.js"></script>
    </body>

</html>