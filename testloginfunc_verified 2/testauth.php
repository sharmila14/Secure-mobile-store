<?php

require '../connect.php';
session_start();

/*Session will stay alive for 10 seconds if user remains idle.*/
$session_duration = 10;

if (isset($_POST)):
  $username = $_POST["username"];
  $password = $_POST["password"];

  if ($username != '' AND $password != ''):
    $sql = "SELECT * FROM Users WHERE AppUserName = :uname";
    $rec = $pdoConn->prepare($sql);
    $rec->execute(['uname' => $username]);
    $userdetails = $rec->fetch(PDO::FETCH_ASSOC);

    if (count($userdetails) > 0 && password_verify($password, $userdetails['AppUserPassword'])):
      $fullname = $userdetails['UserFName']." ".$userdetails['UserLName'];
      echo $fullname;
      $_SESSION["loggedin"] = array("start" => time(), "duration"=>$session_duration, "name" => $fullname);
      header("Location: testprofile.php");
    else:
      header("Location: testfunc.php?status=error&msg=Incorrect username/password");
    endif;
  else:
    header("Location: testfunc.php?status=error&msg=Missing username or password");
  endif;
else:
  header("Location: testfunc.php?status=error&msg=Please Login");
endif;


 ?>
