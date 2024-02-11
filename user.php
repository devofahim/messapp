<?php
require_once 'data/db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createMess($user_id, $mess_name) {
        $insert_query = "INSERT INTO mess (user_id, mess_name) VALUES ('$user_id', '$mess_name')";
        if (mysqli_query($this->db->conn, $insert_query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserDetails($username) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($this->db->conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function createUser($username, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')";

        if (mysqli_query($this->db->conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function authenticateUser($username, $password) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($this->db->conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                return true;
            }
        }
        return false;
    }

}


?>
