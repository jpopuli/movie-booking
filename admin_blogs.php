<?php

require "./model.php";

session_start();

if (!isset($_SESSION["username"])) {
    header("location:index.php");
}

// instance of Model class
$modelObj = new Model();

if (isset($_POST["create_blog"])) {
    $table_name = "blog_tb";
    $blog_date = date("D M d, Y G:i"); // get the current date

    $filename = $_FILES['blogImg']['name'];
    // Select file type
    $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // valid file extensions
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    // folder
    if ($filename != "") {
        // folder
        $folder = 'uploads/' . $filename;
    } else {
        $folder = "";
    }

    // Check extension
    if (in_array($imageFileType, $extensions_arr)) {
        // Upload files and store in database
        move_uploaded_file($_FILES["blogImg"]["tmp_name"], $folder);
    }

    $data = array(
        "blog_title" => $modelObj->escapeString($_POST["blogTitle"]),
        "blog_date" => $blog_date,
        "blog_desc" => $modelObj->escapeString($_POST["blogDesc"]),
        "blog_img" => $folder
    );

    $sql = $modelObj->createRecord($table_name, $data);

    if ($sql) {
        echo '<script>alert("created successfuly")</script>';
        echo '<script>window.location.href = "admin_blogs.php"</script>';
    } else {
        echo '<script>alert("error")</script>';
    }
}

// if delete
if (isset($_GET["deleteId"])) {
    $deleteId = $_GET["deleteId"];
    $table_name = "blog_tb";
    $row_name = "blog_id";

    $sql = $modelObj->deleteRecord($table_name, $row_name, $deleteId);

    if ($sql) {
        echo '<script>alert("deleted successfuly")</script>';
        echo '<script>window.location.href = "admin_blogs.php"</script>';
    } else {
        echo "error";
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

    <script src="https://cdn.tiny.cloud/1/i6fxfutje62g2wf84y87i79e10pnnx05ysiw7bvzmzt0sw1z/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

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
                <li class="nav-item">
                    <a class="nav-link" href="admin_homepage.php">Booking Offerings</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="admin_blogs.php">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
                </li>
            </ul>
        </div>
    </nav>



    <div class="container mt-4">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addBlogModalForm">Create Blog</button>
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <td>Cover Photo</td>
                        <td>Blog Title</td>
                        <td>Date Created</td>
                        <td>Content</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <!-- data loop -->
                    <?php
                    $table_name = "blog_tb";
                    $movies = $modelObj->readRecord($table_name);
                    foreach ($movies as $movie) {
                    ?>
                        <tr>
                            <td><img src="<?php echo $movie['blog_img']; ?>" class="img-fluid" alt="img"></td>
                            <td><?php echo $movie['blog_title']; ?></td>
                            <td><?php echo $movie['blog_date']; ?></td>
                            <td><?php echo $movie['blog_desc']; ?></td>
                            <td class="">
                                <!-- edit button -->
                                <a href="update_blogs.php?updateId=<?php echo $movie['blog_id']; ?>" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Edit" type="button">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <!-- delete button -->
                                <a href="admin_blogs.php?deleteId=<?php echo $movie['blog_id']; ?>" class="btn btn-danger mt-2" data-toggle="tooltip" data-placement="right" title="Delete" type="button" onclick="return confirm('Are you sure you want to delete this blog ?');">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- MODAL for creating blogs -->
        <div class="modal fade" id="addBlogModalForm" tabindex="-1" role="dialog" aria-labelledby="addBlogModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <!-- header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBlogModalTitle">New Blog</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- body/content -->
                    <div class="modal-body">
                        <!-- add form -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="blogTitle">Blog Title</label>
                                <input type="text" class="form-control" id="blogTitle" name="blogTitle">
                            </div>
                            <!-- replaceable -->
                            <div class="form-group">
                                <label for="blogDesc">Content</label>
                                <textarea style="resize: none;" name="blogDesc" class="form-control" id="tiny"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="blogImg">Cover Image</label>
                                <input type="file" class="form-control" name="blogImg" id="blogImg">
                            </div>
                            <!-- footer -->
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <input type="submit" name="create_blog" value="Save" class="btn btn-primary" type="button">
                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL -->
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