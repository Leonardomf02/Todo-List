<?php
include '../models/db.php';
include '../models/User.php';
$db = new DB();
$conn = $db->getConnection();
$userModel = new User($conn);
$users = $userModel->getAllUsers();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styleuserlist.css">
</head>

<body>
    <div class="topnav">
        <div class="topnav-left">
            <a href="#"><img class="navbar-logo" src="../assets/images/log30.png" alt=""></a>
        </div>
        <div class="navbar logout-btn">
            <a href="homeadmin.php" class="btn logout-btn">Home</a>
        </div>
    </div>
    <div class="container">
        <h1>User List</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-brown">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['city']; ?></td>
                            <td><?php echo $user['usertype']; ?></td>
                            <td>
                                <a href="../controllers/delete_user.php?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-remove btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>