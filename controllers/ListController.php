<?php
session_start();

include '../models/db.php';
include '../models/List.php';
include '../models/Todo.php';

header('Content-Type: application/json');

$db = new DB();
$conn = $db->getConnection();

$listModel = new Lists($conn);
$todoModel = new Todo($conn);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $user_id = $_SESSION['user_id'];
            $list = $listModel->getList($user_id, $id);
            echo json_encode($list);
        } else {
            $user_id = $_SESSION['user_id'];
            $lists = $listModel->getUserLists($user_id);
            foreach ($lists as $key => $list) {
                $todos = $todoModel->getUserTodos($user_id, $list['id']);
                $lists[$key]['todos'] = $todos;
            }
            echo json_encode($lists);
        }
        break;

    case 'POST':
        $user_id = $_SESSION['user_id'];
        $name = $_POST['name'];
        $result = $listModel->addList($user_id, $name);
        if ($result) {
            $last_id = $conn->insert_id;
            echo json_encode(['success' => true, 'list' => ['id' => $last_id, 'name' => $name]]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    case 'PUT':
    case 'PATCH':
        parse_str(file_get_contents("php://input"), $post_vars);
        $user_id = $_SESSION['user_id'];
        $id = $post_vars['id'];
        $name = $post_vars['name'];
        $query = $listModel->updateList($user_id, $id, $name); 
        echo json_encode(['success' => $query]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $post_vars);
        $user_id = $_SESSION['user_id'];
        $id = $post_vars['id'];
        $todoModel->deleteTasksFromList($user_id, $id);
        $query = $listModel->deleteList($user_id, $id);
        echo json_encode(['success' => $query]);
        break;
}
