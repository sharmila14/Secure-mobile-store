<!DOCTYPE html>
<head>
  <title> ProfilePage </title>
</head>
<body>
<a href="testposts.php">Posts</a>
<a href="testlogout.php">Log Off</a>
<?php
session_start();

if (isset($_SESSION["loggedin"])):
  $durn = $_SESSION["loggedin"]["duration"];
  $start = $_SESSION["loggedin"]["start"];

  if ((time() - $start) > $durn):
    unset($_SESSION["loggedin"]["duration"]);
    unset($_SESSION["loggedin"]["start"]);
    unset($_SESSION["loggedin"]["name"]);
    unset($_SESSION["loggedin"]);

    header("Location: testfunc.php?status=error&msg=Session has been expired after $durn seconds.");
  else:
    $_SESSION["loggedin"]["start"] = time();
    echo "<h2>Welcome to Profile Page: ".$_SESSION["loggedin"]["name"]."</h2>";
  endif;
else:
  header("Location: testfunc.php?status=error&msg=No sesion found. Please login");
endif;

   ?>
</body>
</html>
