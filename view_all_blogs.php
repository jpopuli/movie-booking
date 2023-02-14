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
    <title>Blog Page</title>

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
                        <a class="nav-link" href="index.php#blog-page">Homepage <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- NAVIGATION END -->


    <div class="content p-3 grid-blog">
        <div class="scroll-wrapper" style="height: 100vh;overflow:auto;padding-top: 60px;">
            <!-- blog content (left side)-->
            <!-- loop content -->
            <?php 
                $table_name = "blog_tb";
                $blogs = $modelObj->readRecord($table_name);
                foreach ($blogs as $blog):
            ?>
            <div class="card left-content shadow mb-3">
                <?php if ($blog['blog_img'] != ""):?>
                    <img src="<?php echo $blog['blog_img'];?>" alt="" class="card-img-top d-block w-100" style="height: 320px;">    
                <?php endif;?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $blog['blog_title'];?></h5>
                    <p><?php echo $blog['blog_date'];?></p>
                    <p><?php echo $blog['blog_desc'];?></p>
                    <a href="" class="btn btn-primary">
                        <i class="fa fa-thumbs-up"></i>
                    </a>
                    <a href="" class="btn btn-primary">
                        <i class="fa fa-comment"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- .right side of grid -->
        <div class="right-content" style="padding-top:60px;">
            <!-- right side -->
            <div class="card shadow">
                <div class="card-header">Recent Post</div>
                <ul class="list-group list-group-flush">
                    <?php
                    $blog_title = $modelObj->limitRecord("blog_tb", 3);
                    foreach ($blog_title as $title):
                    ?>
                    <li class="list-group-item"><?php echo $title["blog_title"] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- right side 2 -->
            <!-- <div class="card mt-4 shadow">
                <div class="card-header">Popular Post</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Blog Post 1</li>
                    <li class="list-group-item">Blog Post 2</li>
                    <li class="list-group-item">Blog Post 3</li>
                </ul>
            </div> -->
        </div>
    </div>


    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>