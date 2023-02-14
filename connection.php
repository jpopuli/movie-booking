<?php
    class Connection {
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $db = "movie_booking_db";

        protected $connection;

        public function __construct() {
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);

            if ($this->connection) {
                // echo "connected";
            } else {
                echo "cant connect";
            }
        }
    }
?>