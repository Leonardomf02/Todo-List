<?php
include '../models/db.php';
include '../models/User.php';

header('Content-Type: application/json');

$db = new DB();
$conn = $db->getConnection();
$userModel = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    loginUser();
}

function loginUser() {
    global $userModel;

    $login_email = $_POST['login_email'];
    $login_password = md5($_POST['login_password']);
    $response = array();

    if (filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
        $user = $userModel->getUserByEmail($login_email);

        if ($user) {
            if (password_verify($login_password, $user['password'])) {
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = $user['status'];
                $_SESSION['city'] = $user['city'];
                $_SESSION['usertype'] = $user['usertype'];
                $_SESSION['logged_in'] = true;

                $response["status"] = "success";
                $response["message"] = "Logged in successfully.";
                $response["username"] = $user['username'];
                $response["usertype"] = $user['usertype'];

                $response["redirect"] = "home.php";
            } else {
                $response["status"] = "error";
                $response["message"] = "Wrong password. Try again!";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "User does not exist. Try again!";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Invalid email. Enter a valid email!";
    }

    echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    signupUser();
}

function signupUser() {
    global $userModel;

    $signup_username = $_POST['username']; 
    $signup_email = $_POST['email']; 
    $signup_password = md5($_POST['password']); 
    $signup_city = $_POST['signup_city']; 

    $response = $userModel->signup($signup_username, $signup_email, $signup_password, $signup_city);

    echo json_encode($response);
}
?>
