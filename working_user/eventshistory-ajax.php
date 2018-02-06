<?php

$eid = $_POST['eventid'];
$btn = $_POST['button'];
$uname = $_POST['uname'];
require './connect.php';

  $sqlQuery = "SELECT DISTINCT e.EventId, e.EventName, e.EventDesc, e.SportCategory, sp.SportName, v.VenueName, v.Address1, v.Address2, e.EventHost, s.EventScore, s.Comments
  FROM Players p, Events e, Scores s, Venues v, Sports sp
  WHERE e.EventId = :eid and p.Event = e.EventId and s.Event = e.EventId and e.Venue = v.VenueId and e.EventStatus = 'Completed' and e.SportCategory = sp.SportId";
  $record = $pdoConn->prepare($sqlQuery);
  $record->execute(['eid' => $eid]);
  $res = $record->fetch(PDO::FETCH_ASSOC);

  echo "<div>	<a href='#close' title='Close' class='close'>x</a> </div>
        <h3> Completed Event Details </h3>";
  echo "<p> <span> Event Name : </span>".$res['EventName']."<br />";
  echo "<span> Description : </span>".$res['EventDesc']."<br />";
  if(!empty($res['EventScore'])):
    echo "<span> Event Scores : </span>".$res['EventScore']."<br />";
  else:
    echo "<span> Event Scores : </span> Scores unavailable <br />";
  endif;
  echo "<span> Category of Sport : </span>".$res['SportName']."<br />";
  echo "<span> Venue : </span>".$res['VenueName']."<br />";
  echo "<span> Location : </span>".$res['Address1']." ".$res['Address2']."<br />";
  if(!empty($res['Comments'])):
    echo "<span> Comments about the event : </span>".$res['Comments']."<br />";
  else:
    echo "<span> Comments about the event : </span>None </span><br />";
  endif;
  echo "<span> Hosted By : </span>".$res['EventHost']."<br />";

//echo "<a href='".$_SERVER['HTTP_REFERER']."'> Close </a>";

?>
