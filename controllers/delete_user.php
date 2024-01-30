<?php
include '../models/db.php';
include '../models/List.php';
include '../models/Todo.php';

$db = new DB();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $listModel = new Lists($conn);
    $todoModel = new Todo($conn);

    $user_lists = $listModel->getUserLists($id);
    foreach($user_lists as $list){
        $todoModel->deleteTasksFromList($id, $list['id']);
    }


    $listModel->deleteAllListsFromUser($id);

    $query = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: ../views/userlist.php?msg=delete_success');
    } else {
        header('Location: ../views/userlist.php?msg=delete_failed');
    }
} else {
    header('Location: ../views/userlist.php?msg=no_id_provided');
}
?>
