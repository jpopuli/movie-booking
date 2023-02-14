<?php

    require "./model.php";

    session_start();

    if (!isset($_SESSION["username"])) {
        header("location:index.php");
    }

    // instance of Model class
    $modelObj = new Model();

    if (isset($_POST["create"])) {
        $table_name = "movies_tb";

        $filename = $_FILES['moviePic']['name'];
        // Select file type
        $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	
        // valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
        
        // folder
        $folder = 'uploads/'.$filename;

        // Check extension
        if(in_array($imageFileType, $extensions_arr) ) {
            // Upload files and store in database
	        move_uploaded_file($_FILES["moviePic"]["tmp_name"], $folder);
	    }

        $data = array(
            "mvTitle" => $modelObj->escapeString($_POST["movieTitle"]),
            "mvDescription" => $modelObj->escapeString($_POST["movieDesc"]),
            "mvStart" => $_POST["movieStart"],
            "mvEnd" => $_POST["movieEnd"],
            "mvTickets" => $_POST["movieTickets"],
            "mvImg" => $folder,
            "mvTrailer" => $_POST["movieTrailer"],
            "mvGenre" => $modelObj->escapeString($_POST["movieGenre"]),
            "ticketPrice" => $_POST["ticketPrice"]
        );

        $sql = $modelObj->createRecord($table_name, $data);
        
        if ($sql) {
            echo '<script>alert("created successfuly")</script>';
            echo '<script>window.location.href = "admin_homepage.php"</script>';
        } else {
            echo '<script>alert("error")</script>';
        }
    }

    // if delete button is press
    if (isset($_GET["deleteId"])) {
        $deleteId = $_GET["deleteId"];
        $table_name = "movies_tb";
        $row_name = "mvId";

        $sql = $modelObj->deleteRecord($table_name, $row_name, $deleteId);

        if ($sql) {
            echo '<script>alert("deleted successfuly")</script>';
            echo '<script>window.location.href = "admin_homepage.php"</script>';
        } else {
            echo $sql;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <script src="https://use.fontawesome.com/4afb2ef8c1.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Website name -->
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <!-- Hidden burger menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- nav links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="admin_homepage.php">Booking Offerings <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_blogs.php">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="container mt-4">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addMovieModalForm">Add a Movie</button>
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <td>Cover Photo</td>
                        <td>Movie Title</td>
                        <td>Genre</td>
                        <td>Description</td>
                        <td>Show Schedule</td>
                        <td>Tickets</td>
                        <td>Price</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <!-- data loop -->
                    <?php
                    $table_name = "movies_tb";
                        $movies = $modelObj->readRecord($table_name);
                        foreach($movies as $movie) {
                    ?>
                    <tr>
                        <td><img src="<?php echo $movie['mvImg']; ?>" class="img-fluid" alt="img"></td>
                        <td><?php echo $movie['mvTitle']; ?></td>
                        <td><?php echo $movie['mvGenre']; ?></td>
                        <td><?php echo $movie['mvDescription']; ?></td>
                        <td><?php echo $movie['mvStart']; ?> to <?php echo $movie['mvEnd']; ?></td>
                        <td><?php echo $movie['mvTickets']; ?></td>
                        <td><?php echo $movie['ticketPrice']; ?></td>
                        <td class="">
                            <!-- edit button -->
                            <a href="update_movie.php?updateId=<?php echo $movie['mvId']; ?>" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Edit" type="button">
                                <i class="fa fa-edit"></i>
                            </a>
                            <!-- delete button -->
                            <a href="admin_homepage.php?deleteId=<?php echo $movie['mvId']; ?>" class="btn btn-danger mt-2" data-toggle="tooltip" data-placement="right" title="Delete" type="button" onclick="return confirm('Are you sure you want to delete this movie ?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- add modal -->
        <div class="modal fade" id="addMovieModalForm" tabindex="-1" role="dialog" aria-labelledby="addMovieModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMovieModalTitle">New Movie</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- body/content -->
                    <div class="modal-body">
                        <!-- add form -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="movieTitle">Movie Title</label>
                                <input type="text" class="form-control" id="movieTitle" name="movieTitle" required>
                            </div>
                            <div class="form-group">
                                <label for="movieGenre">Genre</label>
                                <input type="text" class="form-control" id="movieGenre" name="movieGenre" required>
                            </div>
                            <div class="form-group">
                                <label for="movieDesc">Description</label>
                                <textarea name="movieDesc" class="form-control" id="movieDesc" cols="10" rows="8" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="movieStart">Start Showing</label>
                                <input type="date" class="form-control" id="movieStart" name="movieStart" required>
                            </div>
                            <div class="form-group">
                                <label for="movieEnd">End</label>
                                <input type="date" class="form-control" id="movieEnd" name="movieEnd" required>
                            </div>
                            <div class="form-group">
                                <label for="movieTickets">Ticket Quantity</label>
                                <input type="number" class="form-control" id="movieTickets" name="movieTickets" min="1" max="800" required>
                            </div>
                            <div class="form-group">
                                <label for="movieTicketsPrice">Ticket Price</label>
                                <input type="number" class="form-control" id="movieTicketsPrice" name="ticketPrice" min="100" max="500" required>
                            </div>
                            <div class="form-group">
                                <label for="movieTrailer">Embed Trailer</label>
                                <input type="text" class="form-control" id="movieTrailer" name="movieTrailer" required>
                            </div>
                            <div
                             class="form-group">
                                <label for="moviePic">Cover Image</label>
                                <input type="file" class="form-control" name="moviePic" id="moviePic" required>
                            </div>
                            <!-- footer -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <input type="submit" name="create" value="Save" class="btn btn-primary" type="button">
                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL -->



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>