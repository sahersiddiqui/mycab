<?php 
error_reporting(E_ALL);
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'db';

$con=mysqli_connect("$dbHost","$dbUsername","$dbPassword","$dbName") or die(mysqli_error());

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REgister Page</title>
<link rel="stylesheet" type="text/css" href="cabsonline_style.css">
</head>

<body>
<H1>CabsOnline</H1>
<h2>Register to CabsOnline</h2>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<table>
<tr><td>Name:</td><td><input type="text" name="namefield" /></td></label></td></tr>
<tr><td>Password:</td><td><input type="password" name="passwordfield" /></td></label></td></tr>
<tr><td>Confirm Password:</td><td><input type="password" name="confirmpasswordfield" /></td></label></td></tr>
<tr><td>Email:</td><td><input type="text" name="emailfield" /></td></label></td></tr>
<tr><td>Phone:</td><td><input type="text" name="phonefield" /></td></label></td></tr>
<tr><td><input type="submit" value="Register" /></br></td><td></td></td></tr>
</table>
<H2>Already Registered?<a href="login.php">Login here</a></H2>
</form>
</body>
<?php
//Validate if all the i/p fields values are provided to the variables
if(isset($_POST['namefield'])&&isset($_POST['passwordfield'])&&isset($_POST['confirmpasswordfield'])&&isset($_POST['emailfield'])&&isset($_POST['phonefield']))
{
	
	$name=trim($_POST['namefield']);
	$password=trim($_POST['passwordfield']);
	$confirm_password=trim($_POST['confirmpasswordfield']);
	$email=trim($_POST['emailfield']);
	$phone=trim($_POST['phonefield']);

if(empty($name)||empty($password)||empty($confirm_password)||empty($email)||empty($phone))
	{
		echo"Please provide inputs to all the fields";
		exit();
	}
	else
	{
		$fquery=mysqli_query($con,"Select * from customer where Email='$email' LIMIT 0,1") or die(mysqli_error());
		$num_rows = mysqli_num_rows($fquery);
		
		if($num_rows==0)
		{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {	
			if($password===$confirm_password)
		{
	$query=mysqli_query($con,"INSERT INTO `customer`(`Customer_Name`, `Password`, `Email`, `Phone`) VALUES ('$name','$password','$email','$phone')") or die(mysqli_error());
		echo "Account Created Successfully!";
		
		}
		else 
		{
			echo "Password Not Match!";
		}
		}
		else 
		{
			echo "Enter Correct Email ID!";
		}
		}
		else 
		{
			echo "Email Id Already used!";
		}
	
	}

	

}
	?>
	
</html>