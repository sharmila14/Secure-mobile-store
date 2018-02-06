<?php
session_start();
require './connect.php';

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

if(isset($_GET['scoresubmit']) && $_GET['scoresubmit'] == "success"):
  echo "
  <div id='msg' class='modalDialog'>
      <div>	<a href='#close' title='Close' class='close'>x</a>
      <h3> Score submission success! </h3>
      <p> Score has been added to your event! </p>
      </div>
  </div>
  ";
elseif(isset($_GET['scoresubmit']) && $_GET['scoresubmit'] == "failure"):
  echo "
  <div id='msg' class='modalDialog'>
      <div>	<a href='#close' title='Close' class='close'>x</a>
      </div>
      <h3> Score submission failed! </h3>
      <p> There was an error. Please try uploading your event's scores once again! </p>
  </div>
  ";
endif;

?>

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Go!Play. Score Submission </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="./submitscores.css">
</head>

<body>
  <div class="banner">
    <div id="applogo">
      <a href="./index.php"><img class="img-responsive" src="../images/Logo_216x80.png" /></a>
			<!--<label id="prefloc">Preferred location : <a href="../locationSearch.php"><?php #echo isset($_SESSION["loggedin"]["uname"]) ? $queryRes['PreferredLoc'] : "<script type='text/javascript'> hideText(); </script>" ; ?></a>-->
    </div>
    <div id="navbar">
			<?php if (!isset($_SESSION["loggedin"]["uname"])): ?>
      	<a href="../index.php"> Home</a>
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
      	<a href="./eventshistory.php"> Scores</a>
        <a href="#"> Notifications </a>
				<a href="./userhome.php"> Welcome, <?= $_SESSION["loggedin"]["fname"]; ?></label></a>
				<a href="../auth/authlogout.php">Sign Out</a>
		<?php endif; ?>
    </div>
  </div>


  <div class="main">
    <div id="inner">
      <div id="content5">
        <h2> SCORE SUBMISSION FOR COMPLETED EVENTS </h2> <br/ >
        <?php
        $sql = "SELECT s.Event, e.EventName, s.EventScore, e.StartTime, e.EndTime from Events e JOIN Scores s
        WHERE s.Event = e.EventId and e.EventHost = :host and e.EventStatus = 'Completed' and s.EventScore is null";
        $record = $pdoConn->prepare($sql);
        $record->bindParam(':host', $_SESSION["loggedin"]["uname"]);
        # var_dump($record);
        $record->execute();
        $result = $record->fetchAll();
        if ($record->rowCount() > 0): ?>
        <table id="t1">
          <tr>
            <th> Event Name </th>
            <th> Event Date </th>
            <th> </th>
          </tr>
        <?php foreach ($result as $r): ?>
            <tr>
              <td> <?php echo $r['EventName']; ?> </td>
              <?php $time = strtotime($r['EndTime']);
              $endtime = date("l, j F Y", $time); ?>
              <td> <?php echo $endtime; ?> </td>
              <td> <a href="#editscores" data-eid="<?php echo $r['Event']; ?>" data-ename="<?php echo $r['EventName']; ?>" class="edit-score-for-event"><input type="submit" value="Add Score"></input> </a></td>
            </tr>
        <?php endforeach; ?>
     </table>
     <?php else: ?>
       <p style="text-align: center;">All pending scores have been uploaded against your hosted events. </p>
     <?php endif; ?>
      </div>

      <!-- For Modal popup -->
      <!--<a href="#openModal">Open Modal</a>-->
      <div id="editscores" class="modalDialog">
        <div>	<a href="#close" title="Close" class="close">x</a>
          <h3> Add Scores to Event <?= $r['EventName']; ?></h3>
          <form action="./inserteventscores.php" method="post">
            <br/>
            <label for="eveid">Event Identifier : &nbsp;<input class="readonly" type="text" id="eveId" name="eid" value="" readonly /></label><br/><br/>
            <label for="eveName">Event Name : &nbsp;<input class="readonly" type="text" name="ename" id="eveName" value="" readonly /></label><br/><br/>
            <label for="eveScore">Event Scores : &nbsp;<input class="other" type="text" name="escore" id="eveScore" value="" required /></label><br/><br/>
            <label>Your comments about the event : </label><br/>
            <textarea class="other" rows="5" cols="50" name="ecomment" id="eveComment" value=""/></textarea><br/><br/><br /><br />
            <a href="#msg"><input type="submit" value="Add Scores"/></a>
          </form>
        </div>
        <script>
        $(document).on("click", ".edit-score-for-event", function () {
           var eventId = $(this).data('eid');
           //alert(eventId);
           $(".modalDialog #eveId").val( eventId );
           var eventName = $(this).data('ename');
           //alert(eventName);
           $(".modalDialog #eveName").val( eventName);
           document.getElementById("eveId").readOnly = true;
           document.getElementById("eveName").readOnly = true;
         });
        </script>
      </div>
    </div>

  </div>


  <div class="footer">
    <div>
      <span> Powered by University of North Texas </span>
    </div>
  </div>

</body>
</html>
