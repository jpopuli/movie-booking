<?php
    include_once "./model.php";

    session_start();

    $modelObj = new Model;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- FONTAWESOME -->
    <script src="https://use.fontawesome.com/4afb2ef8c1.js"></script>
</head>
<body>
    <!-- NAVIGATION START -->
    <div class="container-fluid fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- Website name -->
            <a class="navbar-brand" href="#">Logo</a>
            <!-- Hidden burger menu -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- nav links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php#movie-list">Homepage <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- NAVIGATION END -->


    <div class="container movie-pg" style="padding-top: 95px;">
        <!-- grid -->
        <div class="card-grid">
            <?php
            $table_name = "movies_tb";
            $movies = $modelObj->readRecord($table_name);

            foreach ($movies as $movie):
            ?>
            <!-- CARD CONTAINER -->
            <div class="card">
                <img src="<?php echo $movie["mvImg"]; ?>" alt="mg" class="card-img-top img-fluid">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $movie["mvTitle"]; ?></h5>
                    <p><?php echo $movie["mvGenre"]; ?></p>
                    <a href="" type="button" class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="<?php echo "#".$movie["mvTitle"];?>">Watch Trailer</a>
                    <!-- if no tickets -->
                    <?php if ($movie["mvTickets"] == 0) {?>
                    <a href="javascript:void(0)" style="cursor:default;" role="button" class="btn btn-secondary">Sold Out</a>
                    <?php } else {?>
                    <a href="booking_action.php?movie_id=<?php echo $movie['mvId']; ?>" role="button" class="btn btn-primary">Book Now</a>
                    <?php }?>
                </div>
            </div>
            <!-- MODAL -->
            <div class="modal fade" id="<?php echo $movie["mvTitle"];?>" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" aria-labelledby="trailerLabel" aria-hidden="true">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="trailerLabel"><?php echo $movie["mvTitle"];?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="height: auto;">
                            <iframe style="width: 100%;height:250px" src="<?php echo $movie['mvTrailer'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <p class="font-weight-bold mt-3">Description:</p>
                            <p><?php echo $movie["mvDescription"];?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>