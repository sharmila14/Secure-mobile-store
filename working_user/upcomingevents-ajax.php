<?php

$eid = $_POST['eventid'];
$btn = $_POST['button'];
if(isset($_POST['username'])):
$uname = $_POST['username'];
endif;
require '../connect.php';


if ($btn == "btn1"):
  $sqlQuery = "SELECT e.EventId, e.EventName, e.StartTime, e.EndTime, e.EventHost, e.EventDesc, e.SportCategory, s.SportName, v.VenueName, v.Address1, v.Address2
  from Events e, Venues v, Sports s
  where EventId = :eid and e.Venue = v.VenueId and e.SportCategory = s.SportId";
  $record = $pdoConn->prepare($sqlQuery);
  $record->execute([':eid' => $eid]);
else:
  $sqlQuery = "SELECT e.EventName, e.StartTime, e.EndTime, e.EventHost, e.EventDesc, e.SportCategory, s.SportName, v.VenueName, v.Address1, v.Address2
  from Events e, Venues v, Sports s
  where e.Venue = v.VenueId and e.EventId = :eid and e.SportCategory = s.SportId;";
  $record = $pdoConn->prepare($sqlQuery);
  $record->execute([':eid' => $eid]);
endif;

$res = $record->fetch(PDO::FETCH_ASSOC);

echo "<div>	<a href='#close' title='Close' class='close'>x</a> </div>";
if ($btn == "btn1"):
  echo "<h3> Event Details : ".$res['EventName']." </h3>";
else:
  echo "<h3> Hosting Event Details : ".$res['EventName']." </h3>";
endif;
echo "<p> <span> Event Name : </span>".$res['EventName']."<br />";
echo "<span> Description : </span>".$res['EventDesc']."<br />";
echo "<span> Category of Sport : </span>".$res['SportName']."<br />";
$time = strtotime($res['StartTime']);
$startTime = date("l, j F Y g:i A", $time);
echo "<span> Starts on : </span>".$startTime."<br />";
$time = strtotime($res['EndTime']);
$endTime = date("l, j F Y g:i A", $time);
echo "<span> Ends on : </span>".$endTime."<br />";
echo "<span> Venue : </span>".$res['VenueName']."<br />";
echo "<span> Location : </span>".$res['Address1']." ".$res['Address2']."<br />";
if ($btn == "btn1"):
  echo "<span> Hosted By : </span>".$res['EventHost']."<br />";
endif;
echo "</p>";


echo "<a href='".$_SERVER['HTTP_REFERER']."'> Close </a>";

?>
