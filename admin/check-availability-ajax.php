<?php
/* this is check_availability_ajax.php  file */
  require_once('../connect1.php');
	if(!empty($_POST["username"])){
			$sql = "SELECT AppUserName FROM Users WHERE AppUserName = :uname";
			$rec = $pdoConn->prepare($sql);
			$rec->execute(['uname' => $_POST["username"]]);
			$userdetails = $rec->fetch(PDO::FETCH_ASSOC);

		  if($userdetails>0) {
			  //echo 'true';
			  echo " <span> is not available.</span>";
		  } else {
			  //echo 'false';
			  echo "<span> is available</span>";
		  }
	}else{
		echo "<span>This field is mandatory</span>";
	}
?>
