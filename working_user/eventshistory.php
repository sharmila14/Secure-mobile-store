<?php
session_start();
require './connect.php';

if(!isset($_SESSION["loggedin"]["uname"])):
  header("Location: ../auth/authlogin.php");
endif;

/* Session information check starts */
if(!isset($_SESSION["loggedin"]["uname"])):
  header("Location: ../auth/authlogin.php");
endif;

if(isset($_SESSION["loggedin"]["uname"])):
  $query = "SELECT PreferredLoc FROM Users WHERE AppUserName = :user";
  $prefloc = $pdoConn->prepare($query);
  $prefloc->execute(['user' => $_SESSION["loggedin"]["uname"]]);
  $queryRes = $prefloc->fetch(PDO::FETCH_ASSOC);
  #var_dump($queryRes);
endif;

if (isset($_SESSION["loggedin"])):
  $durn = $_SESSION["loggedin"]["duration"];
  $start = $_SESSION["loggedin"]["start"];

  if ((time() - $start) > $durn):
    unset($_SESSION["loggedin"]["duration"]);
    unset($_SESSION["loggedin"]["start"]);
    unset($_SESSION["loggedin"]["name"]);
    unset($_SESSION["loggedin"]);

    header("Location: ../auth/authlogin.php?status=error&msg=Session has been expired after $durn seconds.");
  else:
    $_SESSION["loggedin"]["start"] = time();    /* to track if the user is not idle */
    //echo "<h2>Welcome to Posts Page: ".$_SESSION["loggedin"]["name"]."</h2>";
  endif;
else:
  header("Location: ../auth/authlogin.php?status=error&msg=No session found. Please login");
endif;
/* Session information check ends */

if(isset($_GET['newscoreupdate']) && $_GET['newscoreupdate'] == 'success'):
  echo "Score update has been successful!";
endif;

if(isset($_GET['delscore']) && $_GET['delscore'] == "success"):
  echo "
  <div id='msg' class='modalDialog'>
      <div>	<a href='#close' title='Close' class='close'>x</a>
      <h3> Score Deletion Confirmation </h3>
      <p> Score has been deleted! </p>
      </div>
  </div>";
elseif(isset($_GET['delscore']) && $_GET['delscore'] == "failure"):
  echo "
  <div id='msg' class='modalDialog'>
      <div>	<a href='#close' title='Close' class='close'>x</a>
      <h3> Score Deletion Failed </h3>
      <p> There was an error while deletion. Please try again! </p>
      </div>
  </div>
  ";
endif;

if(isset($_GET['scoreupdate']) && $_GET['scoreupdate'] == "success"):
  echo "
  <div id='msg' class='modalDialog'>
      <div>	<a href='#close' title='Close' class='close'>x</a>
      <h3> Score Update Confirmation </h3>
      <p> Score has been updated! </p>
      </div>
  </div>";
elseif(isset($_GET['scoreupdate']) && $_GET['scoreupdate'] == "failure"):
  echo "
  <div id='msg' class='modalDialog'>
      <div>	<a href='#close' title='Close' class='close'>x</a>
      <h3> Score Update Failed </h3>
      <p> There was an error during updation. Please try again! </p>
      </div>
  </div>
  ";
endif;

?>

<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Go!Play. Events History </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./eventshistory.css">
  <script type="text/javascript">
  function hideText() {
    document.getElementById('prefloc').style.visibility = 'hidden';
  }
  </script>
</head>

<body>
  <div class="banner">
    <div id="applogo">
      <a href="../index.php"><img class="img-responsive" src="../images/Logo_216x80.png" /></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="./index.php"> Home</a>
      	<a href="#"> About</a>
      	<a href="./locationSearch.php"> Explore</a>
      	<a href="#msgDialog"> Events</a>
      	<a href="#msgDialog"> Scores</a>
      	<a href="#"> Contact</a>
      	<a href="../auth/authregister.php"> Register</a>
      	<a href="../auth/authlogin.php"> Login</a>
			<?php else: ?>
      	<a href="../locationSearch.php"> Explore</a>
        <a href="../createEvent.php"> Host Event</a>
      	<a href="./upcomingevents.php"> Events</a>
      	<a href="#"> Scores</a>
        <a href="#"> Notifications</a>
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>

  <div class="main">
    <div id="inner">
        <h2> HISTORY OF EVENTS </h2> <br/ >
        <div id="content1">
          <details>
            <summary id="summary1">Events Participated</summary>
            <br />
            <?php $sql = "SELECT p.User, e.EventId, e.EventName, e.SportCategory, sp.SportName, e.EventStatus, e.EventHost, e.StartTime, e.EndTime, e.EventDesc, v.VenueName, v.Address1, v.Address2, s.EventScore, s.Comments
            from Events e, Players p, Venues v, Scores s, Sports sp
            where e.EventId = p.Event and e.EventId = s.Event and e.Venue = v.VenueId and p.User = :user and e.EventHost != p.User and e.EventStatus = 'Completed' and e.SportCategory = sp.SportId";
            $rec = $pdoConn->prepare($sql);
            #var_dump($rec);
            $rec->execute(['user' => $_SESSION["loggedin"]["uname"]]);
            $res = $rec->fetchAll();
            if ($rec->rowCount() > 0): ?>
            <table id="t1" float="center" cellpadding="3px" width="100%">
              <tr>
                <th>Event Name</th>
                <th>Played at</th>
                <th>Event Status</th>
                <th>Event Scores</th>
                <th></th>
              </tr>
            <?php foreach ($res as $r): ?>
              <tr>
                <td> <?php echo $r['EventName']; ?></td>
                <td> <?php echo $r['VenueName']; ?></td>
                <td> <?php echo $r['EventStatus']; ?></td>
                <td> <?php echo (is_null($r['EventScore']) ? 'Scores Unavailable' : $r['EventScore']); ?></td>
                <td> <a id="btn1" href="#viewevent" data-eid="<?= $r['EventId']; ?>" class="event1">More...</a></td>
              </tr>
            <?php endforeach; ?>
          </table>
          <?php else: ?>
            <p style="text-align: center;">You have not participated in any of the events yet. You can search for your location and join an upcoming event <a href="../locationSearch.php">here</a> !</p>
          <?php endif; ?>
        </details>
      </div>

      <br /> <br /> <br /><br />

      <div id="content2">
        <details>
          <summary id="summary2">Events Hosted</summary>
          <br />
          <?php
          $sql = "SELECT e.EventId, e.EventName, e.EventStatus, v.VenueName, s.EventScore from Scores s, Events e, Venues v
          WHERE s.Event = e.EventId and e.Venue = v.VenueId and e.EventStatus = 'Completed' and e.EventHost = :user and s.EventScore is not null;";
          $rec = $pdoConn->prepare($sql);
          #var_dump($rec);
          $rec->execute(['user' => $_SESSION["loggedin"]["uname"]]);
          $res = $rec->fetchAll();
          if ($rec->rowCount() > 0): ?>
            <table id="t1" float="center" width="100%">
              <tr>
                <th> Event Name </th>
                <th> Event Venue </th>
                <th> Event Status </th>
                <th> Event Scores </th>
                <th> </th>
              </tr>
              <?php foreach ($res as $r): ?>
              <tr>
                <td> <?php echo $r['EventName']; ?> </td>
                <td> <?php echo $r['VenueName']; ?> </td>
                <td> <?php echo $r['EventStatus']; ?> </td>
                <td> <?php echo (is_null($r['EventScore']) ? 'Scores Unavailable' : $r['EventScore']); ?> </td>
                <td> <a href="#editsc" class="event2" data-eid="<?= $r['EventId']; ?>" data-ename="<?= $r['EventName']; ?>" data-escore="<?= $r['EventScore']; ?>">Edit Score</a>&nbsp;&nbsp;
                <a href="#delsc" class="event3" data-eid="<?= $r['EventId']; ?>">Delete Score</a> </td>
              </tr>
              <?php endforeach; ?>
            </table>
        <?php else: ?>
          <p style="text-align: center;">Looks like you have forgot to submit scores for some of your hosted events. </p>
          <p style="text-align: center;"> <a href="./submitscores.php">Submit</a>&nbsp; scores for the events that you have hosted to view them here! </p>
        <?php endif; ?>
      </details>
      </div>
      <br /><br />

      <script>
        $(document).on('click', '.event1', function() {
          var myuname = "<?php echo $_SESSION['loggedin']['uname']; ?>";
          var myeId = $(this).data('eid');
          //alert(myeId);
          //alert(myuname);
          dataStr = "eventid=" + myeId + "&button=" + this.id + "&uname=" + myuname;
          $.ajax({
              type: "POST",
              url: "eventshistory-ajax.php",
              data: dataStr,
              dataType: "html",
              cache: false,
              success: function(response) {
                //alert(response);
                $('#container1').html(response);
              }
            });
          });
      </script>

      <div id="viewevent" class="modalDialog">
        <div>	<a href="#close" title="Close" class="close">x</a>
          <div id="container1">
          </div>
        </div>
      </div>

      <div id="editsc" class="modalDialog">
        <div>	<a href="#close" title="Close" class="close">x</a>
          <h3> Score Updation </h3><br />
          <form action="./updatenewscores.php" method="POST">
            <input id="eveId" name="eveId" type="hidden" />
            <span><label for="eveName"> Event Name : </span><input id="eveName" name="eveName" type="text" readonly /></label><br /><br />
            <span><label for="eveScore"> Event Score : </span><input id="eveScore" name="eveScore" type="text" readonly /></label><br /><br />
            <span><label for="newEveScore"> New Event Score : </span><input id="newEveScore" name="newEveScore" type="text" required/></label><br /><br /><br />
            <input type="submit" value="Update Score" />
          </form>
        </div>
      </div>
      <script>
        $(document).on('click', '.event2', function () {
           var eventId = $(this).data('eid');
           //alert(eventId);
           $(".modalDialog #eveId").val( eventId );
           var eventName = $(this).data('ename');
           //alert(eventName);
           $(".modalDialog #eveName").val( eventName);
           var eventScore = $(this).data('escore');
           //alert(eventScore);
           $(".modalDialog #eveScore").val( eventScore);
           //document.getElementById("eveId").readOnly = true;
           document.getElementById("eveName").readOnly = true;
           document.getElementById("eveScore").readOnly = true;
         });
      </script>
    </div>

      <div id="delsc" class="modalDialog">
        <div>	<a href="#close" title="Close" class="close">x</a>
            <h3> Score Deletion </h3>
            <p> Want to delete the existing scores for this event? </p><br />
            <form action="./deletescores.php" method="POST">
              <input id="eveId" name="eveId" type="hidden" />
              <input type="submit" value="Delete Score" />
            </form>
          </div>
        </div>
        <script>
        $(document).on('click', '.event3', function () {
           var eventId = $(this).data('eid');
           //alert(eventId);
           $(".modalDialog #eveId").val( eventId );
         });
        </script>
      </div>

      </div>    <!-- divwrap ends -->
    </div>
  </div>

  <div class="footer">
    <div>
      <span> Powered by University of North Texas </span>
    </div>
  </div>


</body>
</html>
