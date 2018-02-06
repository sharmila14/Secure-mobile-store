<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Go!Play. Login Page</title>
  <link rel="stylesheet" type="text/css" href="testfunc.css">
</head>
<body>
  <div id="wrapper">
    <?php if (isset($_GET['status'])):
      $id = $_GET['status'];
      $message = $_GET['msg'];
      echo "<div id='$id'>$message</div>";
    endif;
    ?>
    <div id="form-wrapper">
      <h1> Login <h1>
        <form method="POST" action="testauth.php">
          <input type="text" name="username" placeholder="Enter username" />
          <input type="password" name="password" placeholder="Enter password" />
          <input type="submit" value="Sign In" />
        </form>
      </div>
    </div>
</body>
</html>
