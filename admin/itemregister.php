<?php

include '../connect1.php';

session_start();



if(!$_SESSION['email'])

{



    header("Location: login.php");//redirect to login page to secure the welcome page without login access.

}



?>



<html>

<head>

<title>E-MobileStore</title>

<meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title> E-Mobile Store</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <link rel="stylesheet" href="../working_user/upcomingevents.css">

  <script type="text/javascript">

  function hideText() {

    document.getElementById('prefloc').style.visibility = 'hidden';

  }

  </script>









</head>





<body>

<div class="banner">

    <div id="applogo">



    </div>

 





	

	<div id="navbar">

	

		<a href="./welcome.php">Admin Home</a>

		<a href="logout.php">Logout here</a>



		

	

	</div>

	

	





	</div>  



<div id="container">



<?php







if(isset($_POST['registeritem']))

{


$category=$_REQUEST["category"];

$manufacturer=$_REQUEST["manufacturer"];

$model=$_REQUEST["model"];

$qty=$_REQUEST["qty"];

$price=$_REQUEST["price"];

$description=$_REQUEST["description"];




$file=($_FILES['photo']['name']);




echo "$file";

if(($category!=NULL||$category!="")&&($file==NULL||$file==""))


{







	

//---------------------------------------------------------------------------------------------------------------------------------

$strSQL = "insert into item( `category`,`manufacturer`, `model`, `total`, `description`,`price`)

 VALUES

  ('$category', '$manufacturer','$model','$qty','$description','$price')"; 

  







	// The SQL statement is executed 



$prefloc = $pdoConn->prepare($strSQL);

$prefloc->execute();

$itemnumber=lastInsertId();



	setcookie("category",1, time()+10);



		

	}

  







//-------------------------------------------------------------------------------------------------------------------------------

$file=($_FILES['photo']['name']);

echo "$file";

if(($category==NULL||$category=="")&&($file!=NULL||$file!=""))

{



echo "$hello";





	//define a maxim size for the uploaded images in Kb

 define ("MAX_SIZE","100"); 



//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.

 function getExtension($str) {

         $i = strrpos($str,".");

         if (!$i) { return ""; }

         $l = strlen($str) - $i;

         $ext = substr($str,$i+1,$l);

         return $ext;

 }





 $errors=0;



	$file=($_FILES['photo']['name']);

 	

 	if ($file) 

 	{

 	

 		$filename = stripslashes($_FILES['photo']['name']);

 	

  		$extension = getExtension($filename);

 		$extension = strtolower($extension);

 

 $size=filesize($_FILES['photo']['tmp_name']);



if ($size > MAX_SIZE*1024)

{



	$errors=1;

}



$file1=time().$filename;



$newname="../images/".$file1;

	

	$str = "insert into item(`image`)

 VALUES

  ('$file1')"; 

  

$prefloc2 = $pdoConn->prepare($str);

     $prefloc2->execute();





	

	$itemnumber=lastInsertId();

//---------------------------------------------------------------------------------------------------------------------------------

 





 

 if(move_uploaded_file($_FILES['photo']['tmp_name'], $newname)) 

 { 

 setcookie("file",1, time()+10);

 

setcookie("file",2, time()+10); 

 } 

 else { 

 

 //Gives and error if its not 

 echo "Sorry, there was a problem uploading your file."; 

   } 

  }

 

}



//---------------------------------------------------------------------------------------------------------------------------------


if(($category!=NULL||$category!="")&&($file!=NULL||$file!=""))

{







	

	



	//define a maxim size for the uploaded images in Kb

 define ("MAX_SIZE","100"); 



//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.

 function getExtension($str) {

         $i = strrpos($str,".");

         if (!$i) { return ""; }

         $l = strlen($str) - $i;

         $ext = substr($str,$i+1,$l);

         return $ext;

 }





 $errors=0;

//checks if the form has been submitted





 

 	//reads the name of the file the user submitted for uploading

 	//$image=$_FILES['image']['name'];

	$file=($_FILES['photo']['name']);

 	//if it is not empty

 	if ($file) 

 	{

 	//get the original name of the file from the clients machine

 		$filename = stripslashes($_FILES['photo']['name']);

 	//get the extension of the file in a lower case format

  		$extension = getExtension($filename);

 		$extension = strtolower($extension);

 	//if it is not a known extension, we will suppose it is an error and will not  upload the file,  

	//otherwise we will do more tests



//get the size of the image in bytes

 //$_FILES['photo']['tmp_name'] is the temporary filename of the file

 //in which the uploaded file was stored on the server

 $size=filesize($_FILES['photo']['tmp_name']);



//compare the size with the maxim size we defined and print error if bigger

if ($size > MAX_SIZE*1024)

{



	$errors=1;

}



//we will give an unique name, for example the time in unix time format

$file1=time().$filename;

//the new name will be containing the full path where will be stored (images folder)

$newname="../images/".$file1;



echo "price $price";





 $dbh = new PDO("mysql:dbname=ri0057;host=student-db.cse.unt.edu", "ri0057", "PVYzx8kA71R41Ru0" );

  $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling	



$str = "insert into item( `category`,`manufacturer`, `model`, `total`,`description`,`price`,image)

 VALUES

  ('$category', '$manufacturer','$model', '$qty','$description','$price','$file1')"; 

  



	// The SQL statement is executed 

	$prefloc3 = $pdoConn->prepare($str);

     $prefloc3->execute();	

	

$itemnumber=$dbh->lastInsertId();



 //Writes the photo to the server 

 if(move_uploaded_file($_FILES['photo']['tmp_name'], $newname)) 

 { 

 

 //Tells you if its all ok 

 echo "<h1 align=center>The file was received</h1>"; 

 } 

 else { 

 

 //Gives and error if its not

   

 

 echo "Sorry, there was a problem uploading your file."; 

   } 

  }

 

}

	





	//$itemnumber=$_GET["itemnumber"];

   	exit;

}











?>

	



	

	</div>

		

	</div>	

 



		

			<div style="clear:right"></div>

			









</div>

</body>

</html>


