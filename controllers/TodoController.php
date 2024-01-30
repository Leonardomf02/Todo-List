<?php
session_start(); 

include '../models/db.php';
include '../models/Todo.php';

header('Content-Type: application/json');

$db = new DB();
$conn = $db->getConnection();

$todoModel = new Todo($conn);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $task = $todoModel->getTask($id);
            echo json_encode($task);
        } else {
            $user_id = $_SESSION['user_id'];
            $list_id = $_GET['list_id'];
            $priority = isset($_GET['priority']) ? $_GET['priority'] : null; 
            $status = isset($_GET['status']) ? $_GET['status'] : null; 
            $todos = $todoModel->getUserTodos($user_id, $list_id, $priority, $status);
            echo json_encode($todos);
        }
        break;


    case 'POST':
        if (isset($_POST['list_id'], $_POST['task'], $_POST['due_date'], $_POST['priority'], $_POST['status'])) {
            $user_id = $_SESSION['user_id'];
            $list_id = $_POST['list_id'];
            $task = $_POST['task'];
            $due_date = $_POST['due_date'];
            $priority = $_POST['priority'];
            $status = $_POST['status'];
            $query = $todoModel->addTask($user_id, $list_id, $task, $due_date, $priority, $status);
            echo json_encode(['success' => $query]);
        } else {
            echo json_encode(['error' => 'Missing required fields.']);
        }
        break;


    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = $put_vars['id'];
        $task = $put_vars['task'];
        $due_date = $put_vars['due_date'];
        $priority = $put_vars['priority'];
        $status = $put_vars['status'];
        $query = $todoModel->updateTask($id, $task, $due_date, $priority, $status);
        echo json_encode(['success' => $query]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $delete_vars);
        $user_id = $_SESSION['user_id'];
        if (isset($delete_vars['id'])) {
            $id = $delete_vars['id'];
            $query = $todoModel->deleteTask($user_id, $id);
            echo json_encode(['success' => $query]);
        } else {
            echo json_encode(['error' => 'ID not set.']);
        }
        break;
}
