<?php

session_start();

if (isset($_SESSION["loggedin"])):
    unset($_SESSION["loggedin"]["duration"]);
    unset($_SESSION["loggedin"]["start"]);
    unset($_SESSION["loggedin"]["name"]);
    unset($_SESSION["loggedin"]);

    header("Location: ./authlogin.php?status=success&msg=You are signed out successfully");
else:
  header("Location: ./authlogin.php?status=error&msg=Definitely consider relogging in");
endif;
#header("Location: ./authlogin.php");


 ?>
