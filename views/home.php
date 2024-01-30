<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/stylehome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.3/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.3/vfs_fonts.js"></script>
</head>

<body id="body-pd">

    <div class="topnav">
        <div class="topnav-left">
            <a href="#"><img class="navbar-logo" src="../assets/images/log30.png" alt=""></a>
        </div>
        <div class="topnav-centered">
            <p class="navbar-text">
                Hello, <?php echo $_SESSION['username']; ?>.
                <span id="weather-info"></span>
            </p>
        </div>
        <div class="navbar logout-btn">
            <a class="btn logout-btn" href="../controllers/logout.php">Logout</a>
        </div>
    </div>

    <div id="lists-button" class="mt-3 ml-3">
        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="container mt-5 custom-container"> 
        <div class="row">
            <div class="col-12">
                <div id="add-todo-form" class="mt-5">
                    <div class="d-flex align-items-center">
                        <div class="list-name-container">
                            <span id="selected-list-name" class="list-name flex-grow-1"></span>
                        </div>
                    </div>
                    <div id="date-info" class="date-info"></div>
                    <form action="../controllers/TodoController.php" method="post" class="d-flex">
                        <input type="text" class="form-control" id="add-todo" name="add-todo" placeholder="New task" style="flex: 4;" maxlength="148">
                        <select class="form-control" id="status" name="status" style="flex: 1;" required>
                            <option value="" disabled selected>Status</option>
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <select class="form-control" id="priority" name="priority" style="flex: 1;" required>
                            <option value="" disabled selected>Priority</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                        <input type="date" class="form-control" id="due-date" name="due-date" style="flex: 1;" required>
                        <button class="btn btn-primary" name="add-todo-btn" id="add-todo-btn" type="submit">Add</button>
                    </form>
                </div>

                <table class="table border rounded mt-4">
                    <thead>
                        <tr>
                            <th scope="col" class="col-1">#</th>
                            <th scope="col" class="col-4 text-start">Tasks</th>
                            <th scope="col" class="col-2 text-center">Status</th>
                            <th scope="col" class="col-2 text-center">Due Date</th>
                            <th scope="col" class="col-1 text-center">Priority</th>
                            <th scope="col" class="col-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="filters d-flex justify-content-between mb-3 mt-3">
                    <div class="col-md-2">
                        <button onclick="generatePDF()" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </div>

                    <div class="d-flex">
                        <div class="col-md-7">
                            <select id="priority-filter" class="form-select">
                                <option selected value="">All Priorities</option>
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="col-md-5 ms-md-3"> 
                            <select id="status-filter" class="form-select">
                                <option selected value="">All Status</option>
                                <option value="Not Started">Not Started</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="staticBackdropLabel">My Lists</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="add-list-form" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="list-input" name="name" placeholder="New List">
                    <button class="btn btn-primary" type="submit">+</button>
                </div>
            </form>
            <ul id="list-container"></ul>
        </div>
    </div>

    <script>
        var userCityId = "<?php echo $_SESSION['city']; ?>";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../assets/js/todo.js"></script>
    <script src="../assets/js/weather.js"></script>
    <script src="../assets/js/pdf.js"></script>
    <script src="../assets/js/lists.js"></script>
    <script src="../assets/js/global.js"></script>
</body>

</html>