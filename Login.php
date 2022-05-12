<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Page</title>
<link rel="stylesheet" type="text/css" href="cabsonline_style.css">
</head>

<body>
<H1>CabsOnlline</H1>
<H2>Login to CabsOnline</H2>
<form>
<table>?<tr><td width="64">
Email:</td><td width="140"><input type="text" name="emailfield"></td><tr>
<tr><td>
Password:</td><td><input type="password" name="passwordfield"></label></td><tr>
<tr><td>
<input type="submit" value="Login"/></br></td><td></td></tr></table>
<h2>New member? <a href="register.php">Register now</a></h2>
</form>
</body>
<?php
//check if email and pwd fields are sent
if(isset($_GET['emailfield'])&& isset($_GET['passwordfield']))
{
	//check if email and passwords are provided as spaces,if yes trim them and store them in variables
	$email=trim($_GET['emailfield']);
	$password=trim($_GET['passwordfield']);
	//after triming check if they are empty
	if(empty($email)||empty($password))
	{
		echo"Please enter email address and password";
		exit();
	}
	else
	{
		// call function to get customer id,if customer is present in the database.
		$Customer_No+ValidateUser($email,$password);
		//check if database retured empty,that means customnmer is not registered
		if(!empty($Customer_No))
		{
			//if customer id is 1 then , he is treatedas admin else normal customer
			if($Customer_No==1)
			{
				//rediecrt admin to admin page
				$host=$_SERVER['HTTP_HOST'];
				$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
				$query_string="admin.php";
				header("Location:http://$host$uri/$query_string");
			}
			else
			{
				//redierct customers to booking page
				$host=$_SERVER['HTTP_HOST'];
				$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
				$query_string='booking.php?Customer_id='.$Customer_No;
				header("Location:http://$host$uri/$query_string");
			}
		}
	}
}
//functin takes emal addres and pwd as i/p then retves the customerno from database and returns customer no
function ValidateUser($email,$password)
{
	$DBConnect=@mysqli_connect("localhost","root","","db")
	or die ("<p> Unable to connect to the database server.</p>"."<p>Error code".
	mysqli_connect_errno().":".mysqli_connect_error())."</p>";
	
	//constrct query based on p[assed email address and paswd
	$SQLstring="select Customer_No from customer where Email='".$email."' and password='".$password."'";
	//execute query at database
	$queryResult=@mysqli_query($DBConnect,$SQLstring)
	or die("<p>Unable to query the Booking table.</p>"."<p>Error code".
	mysqli_errno($DBConnect).":".mysqli_error($DBConnect))."</p>";
	$row = mysqli_fetch_row($queryResult);
	//check if the returned array has datai.e. count
	if(count($row)>0)
	{
		return $row[0];
	}
	else
	{
		echo "<br>Please provide registered email address and password";
		exit();
	}
	
}
?>
</html>