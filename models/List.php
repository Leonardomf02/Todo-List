<?php

class Lists {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserLists($user_id) {
        $select = "SELECT * FROM `Lists` WHERE user_id = '$user_id' ORDER BY created_at DESC";
        $s_query = mysqli_query($this->conn, $select);
        return mysqli_fetch_all($s_query, MYSQLI_ASSOC);
    }    

    public function addList($user_id, $name) {
        $insert = "INSERT INTO `Lists`(`user_id`, `name`, `created_at`, `updated_at`) 
        VALUES ('$user_id', '$name', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $query = mysqli_query($this->conn, $insert);
        return $query;
    }     

    public function deleteList($user_id, $id) {
        $delete = "DELETE FROM `Lists` WHERE user_id = '$user_id' AND id = '$id'";
        $d_query = mysqli_query($this->conn, $delete);
        return $d_query;
    }   

    public function getList($user_id, $id) {
        $select = "SELECT * FROM `Lists` WHERE user_id = '$user_id' AND id = '$id'";
        $s_query = mysqli_query($this->conn, $select);
        return mysqli_fetch_assoc($s_query);
    }
    
    public function updateList($user_id, $id, $name) {
        $update = "UPDATE `Lists` SET `name` = '$name', `updated_at` = CURRENT_TIMESTAMP WHERE `user_id` = '$user_id' AND `id` = '$id'";
        $u_query = mysqli_query($this->conn, $update);
        return $u_query;
    }

    public function deleteAllListsFromUser($user_id) {
        $delete = "DELETE FROM `Lists` WHERE user_id = '$user_id'";
        $d_query = mysqli_query($this->conn, $delete);
        return $d_query;
    }
}
