<?php

class Todo {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserTodos($user_id, $list_id, $priority = null, $status = null) {
        $select = "SELECT * FROM `todolist` WHERE user_id = '$user_id' AND list_id = '$list_id'";
        
        if ($priority !== null) {
            $select .= " AND priority = '$priority'";
        }

        if ($status !== null) {
            $select .= " AND status = '$status'";
        }

        $select .= " ORDER BY FIELD(priority, 'High', 'Medium', 'Low'), due_date ASC";

        $s_query = mysqli_query($this->conn, $select);
        return mysqli_fetch_all($s_query, MYSQLI_ASSOC);
    }   

    public function addTask($user_id, $list_id, $task, $due_date, $priority, $status) {
        $stmt = $this->conn->prepare("INSERT INTO `todolist`(`user_id`, `list_id`, `tasks`, `due_date`, `priority`, `status`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
        $stmt->bind_param('iissss', $user_id, $list_id, $task, $due_date, $priority, $status);
        $query = $stmt->execute();
        return $query;
    }
       
    public function deleteTask($user_id, $id) {
        $delete = "DELETE FROM `todolist` WHERE user_id = '$user_id' AND id = '$id'";
        $d_query = mysqli_query($this->conn, $delete);
        return $d_query;
    }

    public function getTask($id) {
        $select = "SELECT * FROM `todolist` WHERE id = '$id'";
        $s_query = mysqli_query($this->conn, $select);
        return mysqli_fetch_assoc($s_query);
    }
    
    public function updateTask($id, $task, $due_date, $priority, $status) {
        $update = "UPDATE `todolist` SET `tasks` = '$task', `due_date` = '$due_date', `priority` = '$priority', `status` = '$status', `updated_at` = CURRENT_TIMESTAMP WHERE `id` = '$id'";
        $u_query = mysqli_query($this->conn, $update);
        return $u_query;
    }

    public function deleteTasksFromList($user_id, $list_id) {
        $delete = "DELETE FROM `todolist` WHERE user_id = '$user_id' AND list_id = '$list_id'";
        $d_query = mysqli_query($this->conn, $delete);
        return $d_query;
    }
}

