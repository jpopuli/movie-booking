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
        $blog = $modelObj->fetchRecordById("blog_tb", "blog_id", $editId);
    }

    // update record in movie table
    if (isset($_POST["update"])) {
        $result = $modelObj->updateBlog($_POST["update"]);
        
        if ($result) {
            echo "<script>alert('Updated successfully')</script>";
            echo "<script>window.location.href='admin_blogs.php';</script>";
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
    <title>Update Blog</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <script src="https://use.fontawesome.com/4afb2ef8c1.js"></script>

    <script src="https://cdn.tiny.cloud/1/i6fxfutje62g2wf84y87i79e10pnnx05ysiw7bvzmzt0sw1z/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Website name -->
        <a class="navbar-brand" href="#">Update Blog</a>
        <!-- Hidden burger menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- nav links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_blogs.php" onclick="return confirm('Proceed? Any changes will not be save.');">Cancel</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- add form -->
        <form action="" method="POST" enctype="multipart/form-data" style="width:50%;margin: 0 auto" class="mt-4">
            <div class="form-group">
                <label for="blogTitle">Blog Title</label>
                <input type="text" class="form-control" id="blogTitle" name="updateTitle" value="<?php echo $blog["blog_title"] ?>" required>
            </div>
            <!-- replaceable -->
            <div class="form-group">
                <label for="blogDesc">Description</label>
                <textarea style="resize: none;" name="updateDesc" class="form-control" id="tiny" required><?php echo $blog["blog_desc"] ?></textarea>
            </div>
            <div class="form-group">
                <label for="blogImg">Cover Image</label>
                <input type="text" name="defaultImg" value="<?php echo $blog['blog_img']; ?>" hidden>
                <input type="file" class="form-control" name="updatePic" id="blogImg">
            </div>
            <!-- footer -->
            <div class="modal-footer">
                <input type="hidden" name="updateId" value="<?php echo $blog["blog_id"]; ?>">
                <input type="submit" name="update" value="Save" class="btn btn-primary" type="button">
            </div>
        </form>
    </div>

    <script>
        tinymce.init({
            selector: 'textarea#tiny'
        });

        // Prevent Bootstrap dialog from blocking focusin
        $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
            e.stopImmediatePropagation();
        }
        });

    </script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>