<?php
require '../connect.php';

$eventid = $_POST['eveId'];
$neweventscore = $_POST['newEveScore'];

$sql = "UPDATE Scores SET EventScore = :score WHERE Event = :id";
$psql = $pdoConn->prepare($sql);
$res = $psql->execute(['score' => $neweventscore, 'id' => $eventid]);
var_dump($res);


if($res):
  header("Location: ./eventshistory.php?scoreupdate=success#msg");
else:
  header("Location: ./eventshistory.php?scoreupdate=failure#msg");
endif;

 ?>
