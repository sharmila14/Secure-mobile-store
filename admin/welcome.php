<?php
include '../connect1.php';
session_start();

if(!$_SESSION['email'])
{

    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}

?>

<html >
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
    
 


	
	<div id="navbar">
	
	
	<a href="logout.php">Logout here</a>
		
	
	</div>
	
	
<div id="search" align="center">  
           <div align="center" style="float:left;  width:450px; margin:auto;"></div>
		  
		 <div align="center" style=" width:450px; float:left">		
		</div>
			
</div>

	</div>  

<div id="container">


<div id="leftsidebar">	
	<div style="padding-right:10px;padding-left:10px">
			
	<div align="center" style="margin-top:10px" id="user4">
	


	<div align="center" style="margin-top:10px" id="user4">
	<table  style="display: inline-block;" style="float: left;" cellspacing="50" border="1" align="top">
	
	<tr>
	<td colspan="1"  align="top" id="slides" >
	<h3>INSERT ITEM</h3>
	<p align="center">	<?php 
		if (isset($_COOKIE["category"])){
		  if($_COOKIE["category"]==1){
		echo "<font color='red'><br>Success!!</font>";
		setcookie("category",1, time()-11); }}
		if (isset($_COOKIE["category"])){
		  if($_COOKIE["category"]==2){
		echo "<font color='red'><br>Success!!</font>";
		setcookie("category",2, time()-11); }}
		if (isset($_COOKIE["file"])){
		  if($_COOKIE["file"]==1){
		echo "<font color='red'><br>Success!!</font>";
		setcookie("file",1, time()-11); }}
		if (isset($_COOKIE["file"])){
		  if($_COOKIE["file"]==2){
		echo "<font color='red'><br>Success!!</font>";
		setcookie("file",2, time()-11); }}

?></p>
	<form NAME="register" enctype="multipart/form-data" action="itemregister.php" method="post">

		
<p align="center">CATEGORY:<br /><INPUT TYPE="hidden" > 
 <select name="category" >
  	<option value=" ">CATEGORY 
    <option value="apple" >Apple    
    <option value="samsung" >Samsung
     <option value="accessories" >Accessories
        </select>	</p>
       

<p  align="center">CAGEROIES:(do not leave any preceding space))<br /><input type="text"  accept="text/html" size="20"name="manufacturer"
 value=" "/ ></p>
<p  align="center">MODEL:<br /><input type="text"  accept="text/html" size="20"name="model" value=" "/ ></p>
<p  align="center">QUANTITY:<br /><input type="text"  accept="text/html" size="20"name="qty" value=" "/ ></p>
		
<p align="right">PICTURE:<input name="photo" type="file" /></p>

<p  align="center">DESCRIPTION:<br /><textarea name="description"cols="25" rows="10"class="validate[optional] " ></textarea>
</p>


<p  align="center">PRICE:<input type="text"  accept="text" size="20"name="price" value=""/ ></p>

	
	<input name="registeritem" type="hidden" value="registeritem"  />
<p  align="center"><INPUT NAME="registeritem" TYPE="submit" VALUE="Register Item"/></p>
</FORM>
	
	</td>
	<td  align="center" width="400"  >
    <div style="height:550px;overflow:auto;">
    <table border="1" width="100%">
    <tr bgcolor="#993300" style="color:#FFF;">
   

			<h3>DELETE ITEM</h3>
		
	<form  method="post" action="welcome.php">
	<p>ITEM NUMBER: </p>         
	<p><input name="itemnumber" type="text" size="12"  /></p>
       <input name="itemdelete" type="hidden" value="item"  />
	<input align="center" type='hidden' NAME='e' value ='?<?php $username=$_REQUEST["e"]; echo $username; ?>' />
			<?php if (isset($_COOKIE["success11"])){  if($_COOKIE["success11"]==1){echo "<font color='red'>success !!</font>";setcookie("success11",1, time()-61); }}?> 	  
    <p><input name="submit" type="submit" value="DELETE" />	
       <input type="reset" name="Reset" value="Reset" /></p>      
      </form></div></div>
      
  
	  
        <div style="padding-right:10px;padding-left:10px" align="center">
	<div class="moduletable">
			<h3>DELETE ADMIN</h3>
		
	<form  method="post" action="welcome.php">
	<p>EMPLOYEE NUMBER: </p>         
	<p><input name="itemnumber" type="text" size="12"  /></p>
       <input name="tebo" type="hidden" value="admin"  />
	<input type='hidden' NAME='e' value ='?<?php $username=$_REQUEST["e"]; echo $username; ?>' />
			<?php if (isset($_COOKIE["success11"])){  if($_COOKIE["success11"]==1){echo "<font color='red'>success !!</font>";setcookie("success11",1, time()-61); }}?> 	  
    <p><input name="submit" type="submit"value="DELETE" />	
       <input type="reset" name="Reset" value="Reset" /></p>      

	 <div class="moduletable_menu" style="min-height:250px;" align="left" >			
	</form>			
	<div style="padding-right:10px;padding-left:10px" align="center">
	<div class="moduletable">
			<h3>ADMIN REG</h3>
	
	
	<form role="form" method="post" action="welcome.php">
                        
                            <div class="form-group">
							<p>USERNAME:</p>
                                <input class="form-control" placeholder="Username" name="name" type="text" autofocus>
                            </div>
							<p>EMAIL:</p>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
							<p>PASSWORD:</>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="pass" type="password" value="">
                            </div>


                            <input class="btn btn-lg btn-success btn-block" type="submit" value="REGISTER" name="register" >

                        
                    </form>
 
	  </div>	  
	</div>	
 </div>
    
    
    </div>
</div>
</div>
</div>
    
    </table>
    
    </div>
	</td>
	
	  	 
	
	</tr>
	 
	</table>
	

	
	</div>
		
	</div>	
 

		
			<div style="clear:right"></div>
			




</div>
</body>
</html>
<?php


if(isset($_POST['register']))
{
    $user_name=$_POST['name'];//here getting result from the post array after submitting the form.
    $user_pass=$_POST['pass'];//same
    $user_email=$_POST['email'];//same
	$user_pass_e=md5($user_pass);


    if($user_name=='')
    {
        //javascript use for input checking
        echo"<script>alert('Please enter the name')</script>";
exit();//this use if first is not work then other will not show
    }

    if($user_pass=='')
    {
        echo"<script>alert('Please enter the password')</script>";
exit();
    }

    if($user_email=='')
    {
        echo"<script>alert('Please enter the email')</script>";
    exit();
    }
//here query check weather if user already registered so can't register again.
    $check_email_query="select * from users1 WHERE user_email='$user_email'";
    $prefloc = $pdoConn->prepare($check_email_query);
     $prefloc->execute();
	 $numberofrows=$prefloc->rowCount();

    if($numberofrows>0)
    {
echo "<script>alert('Email $user_email is already exist in our database, Please try another one!')</script>";
exit();
    }
//insert the user into the database.
    $insert_user="insert into users1 (user_name,user_pass,user_email) VALUE ('$user_name','$user_pass_e','$user_email')";
	$prefloc2 = $pdoConn->prepare($insert_user);
     $prefloc2->execute();
    if($prefloc2->fetch(PDO::FETCH_ASSOC))
    {
        echo"<script>window.open('welcome.php','_self')</script>";
    }

}

else if(isset($_POST['tebo'])) {
    // The form has been submited
    // Check the values!
	

	$item=$_POST['itemnumber'];
	echo "item number : $item";
	$delete_admin= "delete from users1 where user_email = '".$item."'";
	 $prefloc3 = $pdoConn->prepare($delete_admin);
     $prefloc3->execute();
	        
	
	
	echo "deleted $item";
}

else
{
if(isset($_POST['itemdelete'])) {
    // The form has been submited
    // Check the values!
	echo "delete";
 
	$item=$_POST['itemnumber'];
	
	echo "$item";
	$delete_product= "delete from item where itemnumber='".$item."'";
	$prefloc4 = $pdoConn->prepare($delete_product);
    $prefloc4->execute();
	
	
	 
	
	echo "deleted $item";
}
}



?>
