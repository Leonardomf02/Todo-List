<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styleregister.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../assets/images/log10.png" alt="LevelUpToDo" />
        </div>
    </header>
    <div class="motivational-phrase">
        <h1>Task by task,<br /> inch closer to the life you envision.</h1>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-md-6 formcontainer">
                <form method="post" action="../controllers/authController.php" class="border rounded p-4 border-white login-form">
                    <h1 class="text-center mb-5">SIGNUP</h1>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="c_password" name="c_password" placeholder="Confirm Password" required>
                    </div>
                    <div class="mb-3">
                        <select id="country" class="form-control" name="country" required>
                            <option value="">Country</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="state" class="form-control" name="state" required>
                            <option value="">State</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="city" class="form-control" name="signup_city" required>
                            <option value="">City</option>
                        </select>
                    </div>
                    <button type="submit" id="signup-btn" name="signup" class="btn btn-primary d-flex justify-content-center">Sign Up</button>
                    <div class="d-flex justify-content-center mt-3">
                        Already have an account? <a href="../index.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="../assets/js/auth-register.js"></script>
    <script src="../assets/js/location.js"></script>
</body>
</html>