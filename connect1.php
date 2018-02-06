<?php

$server = 'student-db.cse.unt.edu';
$database = 'ri0057';
$username = 'ri0057';
$password = 'PVYzx8kA71R41Ru0';

try {
  $pdoConn = new PDO("mysql:host=$server;dbname=$database",$username, $password);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}


?>
