<?php
class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM `users`";
        $result = mysqli_query($this->conn, $query);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $users;
    }

    public function signup($username, $email, $password, $city)
    {
        $response = array();
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if (!$row) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->conn->prepare("INSERT INTO `users`(`username`, `email`, `password`, `city`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
                $stmt->bind_param("ssss", $username, $email, $hashedPassword, $city);
                $stmt->execute();
                $stmt->close();

                $response["status"] = "success";
                $response["message"] = "Your account has been created successfully!";
            } else {
                $response["status"] = "error";
                $response["message"] = "User already exists. Try again!";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Invalid email. Enter a valid email!";
        }

        return $response;
    }
}
