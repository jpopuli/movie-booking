<?php

    require "./connection.php";

    class User extends Connection {
        public function __construct() {
            parent::__construct();
        }

        public function checkUserType($username, $password) {
            $query = "SELECT * FROM login_tb WHERE userName = '$username' AND userPass = '$password'";
            $sql = mysqli_query($this->connection, $query);

            if ($sql->num_rows > 0) {
                $row = $sql->fetch_array();
                return $row["userType"];
            } else {
                return false;
            }
        }

        public function escape_string($value){
            return $this->connection->real_escape_string($value);
        }
    }

?>