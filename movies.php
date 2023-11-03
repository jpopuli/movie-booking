<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomePage</title>

  <?php include './includes/stylesheets.php' ?>

</head>

<body class="bg-dark">
  <?php include './includes/navbar.php' ?>

  <section class="movies mt-4">
    <div class="container">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search ...">
        <span class="input-group-text">
          <i class="fa-solid fa-magnifying-glass"></i>
        </span>
      </div>

      <div class="d-flex flex-row gap-2 overflow-x-auto my-3">
        <button class="btn btn-sm btn-secondary rounded-pill px-3">Comedy</button>
        <button class="btn btn-sm btn-secondary rounded-pill px-3">Drama</button>
        <button class="btn btn-sm btn-secondary rounded-pill px-3">Action</button>
        <button class="btn btn-sm btn-secondary rounded-pill px-3">Fantasy</button>
        <button class="btn btn-sm btn-secondary rounded-pill px-3">Romance</button>
      </div>

      <div class="d-flex flex-row justify-content-between align-items-center text-light">
        <h5>Showing Now</h5>
        <a href="#" class="text-secondary text-decoration-none">View All</a>
      </div>

      <div class="container mt-2">
        <div class="row row-cols-2 row-cols-sm-3 g-3">
          <!-- Movie Card 1 -->
          <div class="col">
            <div class="card border-0">
              <img src="./img/poster/inception.jpg" class="card-img-top" alt="Movie 1 Poster">
              <div class="card-body p-2">
                <h6 class="card-title text-center text-truncate" style="max-width:100%">Inception</h6>
                <a href="#" class="btn btn-sm btn-primary rounded-pill w-100 mt-2">Book Now</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card border-0">
              <img src="./img/poster/inception.jpg" class="card-img-top" alt="Movie 1 Poster">
              <div class="card-body p-2">
                <h6 class="card-title text-center text-truncate" style="max-width:100%">Inception</h6>
                <a href="#" class="btn btn-sm btn-primary rounded-pill w-100 mt-2">Book Now</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card border-0">
              <img src="./img/poster/inception.jpg" class="card-img-top" alt="Movie 1 Poster">
              <div class="card-body p-2">
                <h6 class="card-title text-center text-truncate" style="max-width:100%">Inception</h6>
                <a href="#" class="btn btn-sm btn-primary rounded-pill w-100 mt-2">Book Now</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card border-0">
              <img src="./img/poster/inception.jpg" class="card-img-top" alt="Movie 1 Poster">
              <div class="card-body p-2">
                <h6 class="card-title text-center text-truncate" style="max-width:100%">Inception</h6>
                <a href="#" class="btn btn-sm btn-primary rounded-pill w-100 mt-2">Book Now</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>



  <?php include './includes/scripts.php' ?>
</body>

</html>