<?php

    session_start();

    require "./user_action.php";
    

    $user = new User();

    if (isset($_POST['login'])) {
        $username = $user->escape_string($_POST['username']);
        $password = $user->escape_string($_POST['password']);

        $userType = $user->checkUserType($username, $password);

        if ($userType) {
            $_SESSION["username"] = $username;
            header('location:admin_homepage.php');
        } else {
            $_SESSION["modal_title"] = "Invalid Credentials";
            $_SESSION["login_error"] = "Please check your <b>username</b> and <b>password</b>";
            header("location:login.php");
        }
    }
?>