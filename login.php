<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- FONTAWESOME -->
    <script src="https://use.fontawesome.com/4afb2ef8c1.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <!-- error modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php if (isset($_SESSION["modal_title"])) { echo $_SESSION["modal_title"]; } ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php if (isset($_SESSION["login_error"])) { echo $_SESSION["login_error"]; } ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION["login_error"])):
        echo "<script>
        $(document).ready(function(){
          // Show the Modal on load
          $('#myModal').modal('show');
        });
        </script>";
    endif;
    session_unset(); ?>

    <div class="container">
        <!-- login form -->
        <form action="login_action.php" method="POST" class="form-wrap">
            <div class="form-group">
                <label for="userName">Username</label>
                <input type="text" class="form-control" id="userName" name="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="userPass">Password</label>
                <input type="password" class="form-control" id="userPass" name="password" placeholder="Enter password" required>
            </div>
            <input type="submit" name="login" value="Login" class="btn btn-primary" style="float: right;" type="button">
            <a href="index.php" class="btn btn-secondary mr-2" type="button" style="float: right;">Cancel</a>
        </form>
    </div>
</body>
</html>