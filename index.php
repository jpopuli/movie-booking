<?php

declare(strict_types=1);

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>

    <?php include './includes/stylesheets.php' ?>

</head>

<body>
    <?php include './includes/navbar.php' ?>

    <section class="hero text-light d-flex justify-content-center align-items-center">
        <div class="container text-center">
            <h1 class="display-3 fw-bold">Unlock Your Movie Booking Experience</h1>
            <p><em>Plan your movie experience effortlessly.</p>
            <form class="d-md-flex flex-row mt-4" role="search">
                <input class="form-control me-2" type="search" placeholder="Enter city, theatre, or movie" aria-label="Search">
                <button class="btn btn-primary mt-2 mt-md-0" type="submit">Search</button>
            </form>
        </div>
    </section>



    <?php include './includes/scripts.php' ?>
</body>

</html>