<?php

    include "./model.php";

    session_start();

    $modelObj = new Model;

    if (isset($_GET["movie_id"])) {
        $curr_movie_id = $_GET["movie_id"];
        $movies_tb = "movies_tb";
        $transaction_tb = "transaction_tb";
        $customers_tb = "customers_tb";

        $mv_id = $_GET["movie_id"];
        $movies = $modelObj->readRecord($movies_tb, "WHERE mvId = '$mv_id'");
    }

    if (isset($_POST["submit"])) {
        // customer info
        $customer_fname = $_POST["bookFirstName"];
        $customer_lname = $_POST["bookLastName"];
        $customer_email = $_POST["bookEmail"];

        // passing the customer info to the query function
        $customer_data = array(
            "customer_fname" => $customer_fname,
            "customer_lname" => $customer_lname,
            "customer_email" => $customer_email
        );
        // result - customer record is created
        $insert_customer_result = $modelObj->createRecord($customers_tb, $customer_data);

        // next
        if ($insert_customer_result) {  //if insert successfully
            // insert the transaction made by customer
            $transaction_date = date("D M d, Y G:i"); // get the current date
            $transaction_move_id = $mv_id;  // get the current movie id 
            // get the id of the customer who made the transaction
            $customers_id = $modelObj->readRecord($customers_tb, "WHERE customer_email = '$customer_email'");
            foreach($customers_id as $customer) {
                $customer = $customer["customer_id"];
            }
            $customer_id = $customer;
            $customer_tickets = $_POST["bookTickets"]; // ordered tickets
            $ticket_price = $_POST["ticketPrice"];
            $total_cost = $customer_tickets * $ticket_price;

            // insert the transaction data
            $transaction_data = array(
                "transaction_date" => $transaction_date,
                "movie_id" => $transaction_move_id,
                "customer_id" => $customer_id,
                "no_of_tickets" => $customer_tickets,
                "total_cost" => $total_cost
            );

            // result of created transaction data
            $insert_transaction_info = $modelObj->createRecord($transaction_tb, $transaction_data);
            // if inserted succesfully
            if ($insert_transaction_info) {
                // get the current tickets from movie table
                $current_amt_tickets = $modelObj->readRecord($movies_tb, "WHERE mvId = '$mv_id'");

                foreach ($current_amt_tickets as $ticket) {
                    $tickets = $ticket["mvTickets"]; // get the current amount of tickets
                }

                $update_ticket = $tickets - $customer_tickets; 
                // update the no of tickets in movie table
                $tb_tickets = $modelObj->updateRecord($update_ticket,$mv_id);

                if ($tb_tickets) {
                    echo "tickets updated";
                } else {
                    echo "tickets not updated";
                }
                // customer info or transaction info
                $_SESSION["customer_id"] = $customer_id;
                $_SESSION["customer_email"] = $customer_email;
                $_SESSION["customer_name"] = $customer_fname." ".$customer_lname;
                header("location:contact_action.php");
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- FONTAWESOME -->
    <script src="https://use.fontawesome.com/4afb2ef8c1.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <!-- Website name -->
        <a class="navbar-brand" href="#">Booking Page</a>
        <!-- Hidden burger menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- nav links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php#movie-list">Back to Homepage</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- BOOKING FORM -->
    <div class="booking-page-form">
        <!-- form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="bookMovieTitle">Movie Title</label>
                <?php foreach($movies as $movie): ?>
                    <input type="text" class="form-control" id="bookMovieTitle" name="bookMovieTitle" value="<?php echo $movie["mvTitle"] ?>" readonly>
                    <input type="number" class="form-control" id="bookMovieId" name="bookMovieId" value="<?php echo $movie["mvId"] ?>" hidden>
            </div>
            <div class="form-group d-flex">
                <!-- book tickets -->
                <div class="book-ticket mr-1">
                    <label for="bookTotalTickets">Available Tickets</label>
                    <input type="number" class="form-control" id="bookTotalTickets" name="bookTotalTickets" value="<?php echo $movie["mvTickets"] ?>" readonly>
                </div>
                <!-- tickets price -->
                <div class="ticket-price">
                    <label for="ticketPrice">Ticket Price <span>(&#8369)</span></label>
                    <input type="number" class="form-control" id="ticketPrice" name="ticketPrice" value="<?php echo $movie["ticketPrice"] ?>" readonly>
                </div>
            </div>
            <div class="form-group name-section d-flex">
                <div class="bookFirstName mr-1">
                    <label for="bookFirstName">First Name</label>
                    <input type="text" class="form-control" id="bookFirstName" name="bookFirstName" placeholder="Enter your first name" required>
                </div>
                <div class="bookLastName">
                    <label for="bookLastName">Last Name</label>
                    <input type="text" class="form-control" id="bookLastName" name="bookLastName" placeholder="Enter your last name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="bookEmail">Email</label>
                <input type="email" class="form-control" id="bookEmail" name="bookEmail" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
                <label for="bookTickets">No of Tickets</label>
                <!-- min tickets allowed is 1 and max is how many are left -->
                <input type="number" class="form-control" id="bookTickets" min="1" max="<?php echo $movie['mvTickets'] ?>" name="bookTickets" placeholder="Enter number of tickets" required>
            </div>
            <?php endforeach; ?>
            <!-- footer -->
            <div class="modal-footer">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary" type="button">
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>