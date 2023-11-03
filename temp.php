    <!-- MODAL SHOW IF CONTACT SUCCESS -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php if (isset($_SESSION["modal_title"])) {
                            echo $_SESSION["modal_title"];
                        } ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php if (isset($_SESSION["admin_reply"])) {
                            echo $_SESSION["admin_reply"];
                        } ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- HOMEPAGE START -->
    <div class="container carousel-pg" id="home-page">
        <!-- CAROUSEL START -->
        <div id="mainCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#mainCarousel" data-slide-to="1"></li>
                <li data-target="#mainCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <!-- loop start -->
                <?php
                $table_name = "movies_tb";
                $movies = $modelObj->limitRecord($table_name, 3);
                $count = 0;
                foreach ($movies as $movie) : ?>
                    <div class="carousel-item <?php echo ($count == 0) ? 'active' : ' '; ?>" data-interval="2000">
                        <div class="carousel-content d-flex justify-content-between" style="background: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.6) ), <?php echo "url(" . $movie["mvImg"] . ")" ?>;background-repeat: no-repeat;background-size: cover;background-position: center;">
                            <div class="text">
                                <h2 class="text-uppercase"><?php echo $movie["mvTitle"]; ?></h2>
                                <p><?php echo $movie["mvDescription"]; ?></p>
                                <a href="#movie-list" class="btn btn-primary mt-3" type="button">Go to Movies</a>
                            </div>
                            <img src="<?php echo $movie['mvImg']; ?>" alt="Img" class="d-block">
                        </div>
                    </div>
                <?php $count++;
                endforeach; ?>
            </div>
            <a href="#mainCarousel" class="carousel-control-prev" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a href="#mainCarousel" class="carousel-control-next" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <!-- HOMEPAGE END -->

    <!-- MOVIE LIST START -->
    <div class="container movie-pg" id="movie-list">
        <div class="d-flex align-items-center justify-content-between">
            <h3 class="mt-4 mb-4">Recommendations</h3>
            <a href="view_all_movies.php" class="mr-2 mt-3"><u>View All Movies</u></a>
        </div>
        <!-- grid -->
        <div class="card-grid">
            <?php
            $table_name = "movies_tb";
            $movies = $modelObj->limitRecord($table_name, 5);

            foreach ($movies as $movie) :
            ?>
                <!-- CARD CONTAINER -->
                <div class="card">
                    <img src="<?php echo $movie["mvImg"]; ?>" alt="mg" class="card-img-top img-fluid">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $movie["mvTitle"]; ?></h5>
                        <p><?php echo $movie["mvGenre"]; ?></p>
                        <!-- open modal -->
                        <a href="" type="button" class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="<?php echo "#" . $movie["mvTitle"]; ?>">Watch Trailer</a>
                        <!-- if no tickets -->
                        <?php if ($movie["mvTickets"] == 0) { ?>
                            <a href="javascript:void(0)" style="cursor:default;" role="button" class="btn btn-secondary">Sold Out</a>
                        <?php } else { ?>
                            <a href="booking_action.php?movie_id=<?php echo $movie['mvId']; ?>" role="button" class="btn btn-primary">Book Now</a>
                        <?php } ?>
                    </div>
                </div>
                <!-- MODAL -->
                <div class="modal fade" id="<?php echo $movie["mvTitle"]; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" aria-labelledby="trailerLabel" aria-hidden="true">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="trailerLabel"><?php echo $movie["mvTitle"]; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" style="height: auto;">
                                <iframe style="width: 100%;height:250px" src="<?php echo $movie['mvTrailer']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <p class="font-weight-bold mt-3">Show Schedule</p>
                                <p><?php echo $movie["mvStart"] . " to " . $movie["mvEnd"]; ?></p>
                                <p class="font-weight-bold mt-3">Description:</p>
                                <p><?php echo $movie["mvDescription"]; ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- end of grid -->
    </div>
    <!-- MOVIE LISTT END -->

    <!-- ABOUT US PAGE START -->
    <div class="container mt-3 about-pg" id="about-us">
        <div class="about-pg-wrapper">
            <div class="text-left pl-3 pr-3">
                <h3 class="mt-4 mb-5">About Us</h3>
                <p class="mb-4 mr-5"><b style="font-family: 'Kaushan Script', cursive;font-size:22px;">SineMax</b>&nbsp;&nbsp;&nbsp;is an online movie booking website that allows potential customers to self-book and pay through our website.</p>
                <p class="mb-4 mr-5">We are open 24/7 so our dear potential customers can book a movie ticket at anytime and from anywhere just by some clicks.</p>
                <p class="mb-4 mr-5">Our website offers a wide variety of movies that provide enough satisfaction for our potential customers.</p>
            </div>
        </div>
    </div>
    <!-- ABOUT US PAGE END -->

    <!-- BLOG PAGE START -->
    <div class="container mt-3 blog-pg" id="blog-page">
        <div class="d-flex align-items-center justify-content-between">
            <h3 class="mt-4 mb-4">Our Blogs</h3>
            <a href="view_all_blogs.php" class="mr-2 mt-3"><u>View All Blogs</u></a>
        </div>
        <div class="blog-grid">
            <?php
            $table_name = "blog_tb";
            $limit = 3;
            $blogs = $modelObj->limitRecord($table_name, $limit);

            foreach ($blogs as $blog) :
            ?>
                <!-- card -->
                <div class="card blog">
                    <img src="<?php echo $blog["blog_img"]; ?>" alt="img" class="card-img-top d-block w-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $blog["blog_title"]; ?></h5>
                        <?php echo $blog["blog_desc"]; ?>
                        <a href="view_all_blogs.php" class="text-uppercase">Read More</i></a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <!-- END OF CARD WRAPPER -->

        <style>
            .blog .card-body p {
                -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
                mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
                height: 85px;
                overflow-y: hidden;
            }
        </style>
    </div>
    <!-- BLOG PAGE END -->

    <!-- CONTACT PAGE -->
    <div class="container contact-pg" id="contact-page">
        <h3 class="text-center mt-4 mb-4">Contact Us</h3>
        <div class="contact-form shadow" style="height: 445px;">
            <!-- Left Side -->
            <!-- CONTACT FORM -->
            <div class="left-box">
                <h5 class="text-center mt-3 mb-3">Write Us</h5>
                <form action="contact_action.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="customerName" id="" placeholder="Full Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="customerEmail" id="" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="customerMsg" class="form-control" id="" cols="30" rows="10" style="resize: none;height: 198px;" placeholder="Your message here..." required></textarea>
                    </div>
                    <input type="submit" name="contact_send" value="Send" class="btn btn-primary">
                </form>
            </div>
            <!-- Right Side -->
            <div class="right-box bg-primary">
                <h5 class="text-center mt-3 mb-5">Contact Info</h5>
                <div class="contacts">
                    <i class="fa fa-map-marker"></i>
                    <p>Nueva Ecija, Philippines</p>
                </div>
                <div class="contacts">
                    <i class="fa fa-phone"></i>
                    <p>+63 XXX XXX XXX</p>
                </div>
                <div class="contacts">
                    <i class="fa fa-envelope"></i>
                    <p>codingtesting26@gmail.com</p>
                </div>
                <div class="contacts">
                    <i class="fa fa-globe"></i>
                    <p>www.moviecompany.com</p>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <footer>
            <div class="icons">
                <i class="fa fa-facebook-f"></i>
                <i class="fa fa-twitter"></i>
                <i class="fa fa-google-plus"></i>
                <i class="fa fa-instagram"></i>
            </div>
            <div class="copy-right">© 2021 Copyright:<a href="#home-page">&nbsp;&nbsp;SineMax.com</a>
            </div>
        </footer>
    </div>