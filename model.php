<?php

    include "./user_action.php";

    class Model extends Connection {
        public function __construct() {
            parent::__construct();
        }

        // escape special characters
        public function escapeString($str) {
            return $this->connection->real_escape_string($str);
        }

        // crud operations

        // update movie tickets amount
        public function updateRecord($update_tickets, $update_id) {
            $query = "UPDATE `movies_tb` SET `mvTickets` = '{$update_tickets}' WHERE `movies_tb`.`mvId` = '{$update_id}'";
            $result = $this->connection->query($query);

            return $result;
        }

        // create
        public function createRecord($table_name, $data) {
            $key = array_keys($data); // get key (column name)
            $value = array_values($data); // get values (values to be inserted);

            $query ="INSERT INTO $table_name ( ". implode(',' , $key) .") VALUES('". implode("','" , $value) ."')";
            $result = mysqli_query($this->connection, $query) or 
            trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($this->connection), E_USER_ERROR);

            return $result;
        }

        // read
        public function readRecord($table_name, $where_set = "") {
            // check for optional where clause
            $whereQuery = "";
            if (!empty($where_set)) {
                // check to display if the 'where' keyword exists
                if (substr(strtoupper(trim($where_set)), 0, 5) != "WHERE") {
                    // not found, add keyword
                    $whereQuery = " WHERE ".$where_set;
                } else {
                    $whereQuery = " ".trim($where_set);
                }
            }

            $query = "SELECT * FROM " . $table_name.$whereQuery;
            $result = $this->connection->query($query);

            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            } else {
                echo "no records found";
            }
        }

        // delete
        public function deleteRecord($table_name, $row, $id) {
            $query = "DELETE FROM ".$table_name." WHERE ".$row." = '$id'";
            $result = $this->connection->query($query);

            return $result;
        }


        // limit the records
        public function limitRecord($table_name, $limit_count) {
            $query = "SELECT * FROM ".$table_name." LIMIT " .$limit_count;
            $result = $this->connection->query($query);

            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            } else {
                echo "no records found";
            } 
        }

        // show data instead of id
        public function displayTransaction($customerId) {
            $query = "SELECT transaction_tb.transaction_id, customers_tb.customer_fname, customers_tb.customer_lname, movies_tb.mvTitle, transaction_date, total_cost, no_of_tickets, movies_tb.mvStart, movies_tb.mvEnd, movies_tb.ticketPrice FROM ((transaction_tb INNER JOIN customers_tb ON transaction_tb.customer_id = customers_tb.customer_id) INNER JOIN movies_tb ON transaction_tb.movie_id = movies_tb.mvId) WHERE customers_tb.customer_id = $customerId";

            $result = $this->connection->query($query);
            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            } else {
                echo "no records found";
            }
        }

        // get data through id for update
        public function fetchRecordById($table_name, $row, $edit_id) {
            $query = "SELECT * FROM ".$table_name." WHERE ".$row." = '$edit_id'";
            $result = $this->connection->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            } else {
                echo "no record";
            }
        }

        // update movie records
        public function updateMovie($data) {
            $update_id = $_POST["updateId"];
            $movie_title = $this->connection->escape_string($_POST["updateTitle"]);
            $movie_genre = $this->connection->escape_string($_POST["updateGenre"]);
            $movie_desc = $this->connection->escape_string($_POST["updateDesc"]);
            $movie_start = $_POST["updateStart"];
            $movie_end = $_POST["updateEnd"];
            $movie_tickets = $_POST["updateTickets"];
            $movie_tickets_price = $_POST["updatePrice"];
            $movie_trailer = $this->connection->escape_string($_POST["updateTrailer"]);
            // image
            $movie_old_img = $_POST["defaultImg"];
            $filename = $_FILES['updatePic']['name']; // choosen file
            // Select file type
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            // valid file extensions
            $extensions_arr = array("jpg","jpeg","png","gif");

            if ($filename != "") {
                // folder
                $folder = 'uploads/'.$filename;
            } else {
                $folder = $movie_old_img;
            }

            // Check extension
            if(in_array($imageFileType, $extensions_arr) ) {
                // Upload files and store in database
                move_uploaded_file($_FILES["updatePic"]["tmp_name"], $folder);
            }

            if (!empty($update_id) && !empty($data)) {
                $query = "UPDATE movies_tb SET mvTitle = '$movie_title', mvDescription = '$movie_desc', mvStart = '$movie_start', mvEnd = '$movie_end', mvTickets = '$movie_tickets', mvImg = '$folder', mvTrailer = '$movie_trailer', mvGenre = '$movie_genre', ticketPrice = '$movie_tickets_price' WHERE mvId = '$update_id'";

                $result = mysqli_query($this->connection, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($this->connection), E_USER_ERROR);

                return $result;
            }
        }


        // update movie records
        public function updateBlog($data) {
            $update_id = $_POST["updateId"];
            $blog_title = $this->connection->escape_string($_POST["updateTitle"]);
            $blog_desc = $this->connection->escape_string($_POST["updateDesc"]);
            $blog_date = date("D M d, Y G:i"); // get the current date
            // image
            $movie_old_img = $_POST["defaultImg"];
            $filename = $_FILES['updatePic']['name']; // choosen file
            // Select file type
            $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            // valid file extensions
            $extensions_arr = array("jpg","jpeg","png","gif");

            if ($filename != "") {
                // folder
                $folder = 'uploads/'.$filename;
            } else {
                $folder = $movie_old_img;
            }

            // Check extension
            if(in_array($imageFileType, $extensions_arr) ) {
                // Upload files and store in database
                move_uploaded_file($_FILES["updatePic"]["tmp_name"], $folder);
            }

            if (!empty($update_id) && !empty($data)) {
                $query = "UPDATE blog_tb SET blog_title = '$blog_title', blog_date = '$blog_date', blog_desc = '$blog_desc', blog_img = '$folder' WHERE blog_id = '$update_id'";

                $result = mysqli_query($this->connection, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($this->connection), E_USER_ERROR);

                return $result;
            }
        }



    }   
?>