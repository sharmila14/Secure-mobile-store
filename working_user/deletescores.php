<?php
require './connect.php';

$eventid = $_POST['eveId'];

$sql = "UPDATE Scores SET EventScore = NULL WHERE Event = :id";
$psql = $pdoConn->prepare($sql);
$res = $psql->execute(['id' => $eventid]);
var_dump($res);


if($res):
  header("Location: ./eventshistory.php?delscore=success#msg");
else:
  header("Location: ./eventshistory.php?delscore=failure#msg");
endif;

 ?>
