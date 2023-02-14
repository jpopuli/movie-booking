<?php
    require "./model.php";

    session_start();

    if (!isset($_SESSION["username"])) {
        header("location:login.php");
    }

    $modelObj = new Model;

    // edit record
    if (isset($_GET["updateId"])) {
        $editId = $_GET["updateId"];
        $movie = $modelObj->fetchRecordById("movies_tb", "mvId", $editId);
    }

    // update record in movie table
    if (isset($_POST["update"])) {
        $result = $modelObj->updateMovie($_POST["update"]);
        
        if ($result) {
            echo "<script>alert('Updated successfully')</script>";
            echo "<script>window.location.href='admin_homepage.php';</script>";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movie</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <script src="https://use.fontawesome.com/4afb2ef8c1.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Website name -->
        <a class="navbar-brand" href="#">Update Movie</a>
        <!-- Hidden burger menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- nav links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_homepage.php" onclick="return confirm('Proceed? Any changes will not be save.');">Cancel</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data" style="width:50%;margin: 0 auto" class="mt-4">
            <div class="form-group">
                <label for="movieTitle">Movie Title</label>
                <input type="text" class="form-control" id="movieTitle" name="updateTitle" value="<?php echo $movie['mvTitle'] ?>" required>
            </div>
            <div class="form-group">
                <label for="movieGenre">Genre</label>
                <input type="text" class="form-control" id="movieGenre" name="updateGenre" value="<?php echo $movie['mvGenre'] ?>" required>
            </div>
            <div class="form-group">
                <label for="movieDesc">Description</label>
                <textarea name="updateDesc" class="form-control" id="movieDesc" cols="10" rows="8" required><?php echo $movie['mvDescription'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="movieStart">Start Showing</label>
                <input type="date" class="form-control" id="movieStart" name="updateStart" value="<?php echo $movie['mvStart'] ?>" required>
            </div>
            <div class="form-group">
                <label for="movieEnd">End</label>
                <input type="date" class="form-control" id="movieEnd" name="updateEnd" value="<?php echo $movie['mvEnd'] ?>" required>
            </div>
            <div class="form-group">
                <label for="movieTickets">Tickets Quantity</label>
                <input type="number" class="form-control" id="movieTickets" name="updateTickets" value="<?php echo $movie['mvTickets'] ?>" required>
            </div>
            <div class="form-group">
                <label for="movieTicketsPrice">Ticket Price</label>
                <input type="number" class="form-control" id="movieTicketsPrice" name="updatePrice" value="<?php echo $movie['ticketPrice'] ?>" required>
            </div>
            <div class="form-group">
                <label for="movieTrailer">Embed Trailer</label>
                <input type="text" class="form-control" id="movieTrailer" name="updateTrailer" value="<?php echo $movie['mvTrailer'] ?>" required>
            </div>
            <div
                class="form-group">
                <label for="moviePic">Cover Image</label>
                <input type="text" name="defaultImg" value="<?php echo $movie['mvImg'] ?>" hidden>
                <input type="file" class="form-control" name="updatePic" id="moviePic">
            </div>
            <!-- footer -->
            <div class="modal-footer">
                <input type="hidden" name="updateId" value="<?php echo $movie["mvId"]; ?>">
                <input type="submit" name="update" value="Save" class="btn btn-primary" type="button">
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>