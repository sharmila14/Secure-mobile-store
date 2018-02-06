<?php
session_start();
include("functions/function.php");
try{
	
	$Email=$_POST["Email"];
	$Password=$_POST["Password"];
	$hashed_Password=crypt($Password);
	//$Password=hash_hmac('sha512',$Password,'secret');
	$hostname="student-db.cse.unt.edu";
	$user="ks0593";
	$pwd="ks0593";
		$count=0;
	if($conn=mysql_connect($hostname,$user,$pwd))
	{
		$conn2=mysql_select_db("ks0593");
	
	$sql=mysql_query("select * from signup where email='$Email' and password='$hashed_Password'");
	
	while($row = mysql_fetch_row($sql))
		$count++;
		
		
		if($count==0)
		{
		$_SESSION['errors']=array("Your Email id or Password was incorrect. Please try again");
		header("location:checkout.php");
		exit();
		}
		$ip = getIp(); 
		
		$sel_cart = mysql_query("select * from cart where ipaddr='$ip'");
		
		//$run_cart = mysql_query($con, $sel_cart); 
		
		$check_cart = mysql_num_rows($sel_cart); 
		
		if($count>0 AND $check_cart==0){
		
		$_SESSION['email']=$Email; 
		
		echo "<script>alert('You logged in successfully, Thanks!')</script>";
		echo "<script>window.open('index.php','_self')</script>";
		
		}
		else {
		$_SESSION['email']=$Email; 
		
		echo "<script>alert('You logged in successfully, Thanks!')</script>";
		echo "<script>window.open('checkout.php','_self')</script>";
		
		
		}
		
		
		//$_SESSION["email"]=$Email; 
        		//header("Location:index.php");
				
		}
			
				
			
		
	
		else{
			throw new exception("Please enter a valid Username and Password");
		}
	
}
catch(Exception $ex)
{
	echo $ex->getmessage();
}
    
mysql_close($conn);


?>
