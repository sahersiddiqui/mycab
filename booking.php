<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Booking page</title>
<link rel="stylesheet" type="text/css" href="cabsonline_style.css">
</head>

<body>
<H1>CabsOnline</H1>
<H2>Booking a Cab</H2>
<h3> Please fill the fields below to book a taxi</h3>
<form name="BookingForm" method="post" action="#">
<table>
<tr><td>Passenger name:</td><td><input type="text" name="pName" ></td></tr>
<tr><td>Contact number of Passenger:</td><td><input type="text" name="pPhone" ></td></tr>
<tr><td>Pick up address:</td><td>Unit number:<input type="text" name="UnitNo" ></td></tr>
<tr><td></td><td>Street number:<input type="text" name="streetNo" ></td></tr>
<tr><td></td><td>Street name:<input type="text" name="StreetName" ></td></tr>
<tr><td></td><td>Suburb:<input type="text" name="Suburb" ></td></tr>
<tr><td>Destination suburb:</td><td><input type="text" name="Dsuburb" ></td></tr>
<tr><td>Pickup date:</td><td><input type="text" name="pDate" >(dd/mm/yyyy)</td></tr>
<tr><td>Pickup time:</td><td><input type="text" name="pTime"(HH:MM) ></td></tr>
<tr><td><input type="submit" value="Book"/></td><td></td></tr>
</table>
<input type="hidden" name="Customer_Id" value="<?php echo trim($_GET['Customer_Id']);?>"/>
</form>

</body>
<?php
if(!(isset($_GET['Customer_Id']))|| empty($_GET['Customer_Id']))
{
	//redierct to login page if customer id is not available
	$host=$_SERVER['HTTP_HOST'];
	$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
	$query_string="login.php";
	header("Location:http://$host$uri/query_string");
}
else
{
	if(isset($_GET['pName'])&&(isset($_GET['pPhone'])&&(isset($_GET['UnitNo'])&&(isset($_GET['StreetNo'])&&(isset($_GET['StreetName'])&&(isset($_GET['Suburb'])&&(isset($_GET['Dsuburb'])&&(isset($_GET['pDate'])&&(isset($_GET['pTime']))
	
	
		//get the value of customer id from query string
		$Customer_ID=trim($_GET['Customer_id']);
	
		//get the passenger details from the form
		$Passenger_Name=trim($_GET['pName']);
		$Passenger_Phone=trim($_GET['pPhone']);
		$Unit_No=trim($_GET['UnitNo']);
		$Street_No=trim($_GET['StreetNo']);
		$Street_Name=trim($_GET['StreetName']);
		$Suburb=trim($_GET['Suburb']);
		$Destination_Suburn=trim($_GET['Dsuburb']);
		$Pickup_Date=trim($_GET['pDate']);
		$Pickup_Time=trim($_GET['pTime']);
	
		// Check if any input iz empty except for unit no
		if(empty($Passenger_Name)||empty($Passenger_Phone)||empty($Street_No)||empty($Street_Name)||empty($Suburb)||empty($Destination_Suburn)||empty($Pickup_Date)||empty($Pickup_Time))
		{
			echo"Please provide details for all the fields";
			exit();		
		}
	
		else
		{
			//call a function to validate the date and time inputs
			ValidateDateTime($Pickup_Date,$Pickup_Time);
			//call a function to validate the pickup time , shulkd be greater than 60mints from cuurnt teime
			if(ValidBookingTime($Pickup_Date,$Pickup_Time))
			{
				CreateBooking($Customer_ID,$Passenger_Name,$Passenger_Phone,$Unit_No,$Street_No,$Street_Name,$Suburb,$Destination_Suburn,$Pickup_Date,$Pickup_Time);
			}
			else
			{
				echo"Booking can be placed one hour after the current system time.";
				exit();
			}
		}
	}



//this fuction takes date and time provided by customer and checks if the booking timeis greater than the 60mints from currnt time or not .and returns true if valid else false
function ValidBookingTime($Date,$Time)
{
	//Concatenate the date and time provided
	$dt=$Date.":".$Time;
	//create a data format using
	$Date=date_create_from_format('j/n/Y:H:i',$dt);
	//compare the datetime provided with current time +60mins
	if(date_format($Date,'Y/m/j:H:i')<date('Y/m/j:H:i',strtotime('+60 minute')))
	{
		return false;
	}
	else
	{
		return true;
	}
}
//this func takes date and time as i/p parameters whch r entered by the customers, and validates if they are in correct format or not by checking aginast regular expression
function ValidateDateTime($Pickup_Date,$Pickup_Time)
{
	//Regular exprsn for validating the dtae as DD/MM/YYYY format eg. 25/12/2017
	$DatePattern="/^(0[1-9]|[12][0-9]|3[01]\/(0[1-9]|1[012])\/(20\d\d)$/";
	//regukar expr for valiudating the time as HH:MM formnat e.g. 18:00
	$TimePattern="/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
	
	$DateFlag=preg_match($DatePattern,$Pickup_Date);	
	$TimeFlag=preg_match($TimePattern,$Pickup_Time);
	if($DateFlag!=1)
	{
		echo" Please enter the valid date in dd/mm/yyyy format";
		exit();
	}
	else
	{
		if($TimeFlag!=1)
		{
			echo"Please enter the valid time in HH:MM format";
			exit();
		}
	}
}
// this fuction takes all the parameters required fopr creating the booking and creates the book record.
function CreateBooking($Customer_ID,$Passenger_Name,$Passenger_Phone,$Unit_No,$Street_No,$Street_Name,$Suburb,$Destination_Suburn,$Pickup_Date,$Pickup_Time)
{
	$dtnow=date('Y-m-j H:i:s');
	$status="unassigned";
	$Pickup_Date=date_create_form_format('j/n/Y',$Pickup_Date);
	$Pickup_Date=date_format($Pickup_Date,'Y-m-j');
	$DBConnect=@mysqli_connect("localhost","root","","db")
	or die ("<p> Unable to connect to the database server.</p>"."<p>Error code".
	mysqli_connect_errno().":".mysqli_connect_error())."</p>";
	
	$SQLstring="INSERT INTO Booking values(null,'".$Customer_ID."','".$Passenger_Name."','".$Passenger_Phone."','".$Unit_No."','".$Street_No."','".$Street_Name."','".$Suburb."','".$Destination_Suburn."','".$Pickup_Date."','".$Pickup_Time."','".$dtnow."','".$status."')";
	//echo "<p>".$SQLstring."</p>";
	    $queryResult=@mysqli_query($DBConnect,$SQLstring)
		or die("<p>Unable to query the Booking table.</p>"."<p>Error code".
		mysqli_errno($DBConnect).":".mysqli_error($DBConnect))."</p>";
		$SQLstring="SELECT MAX(Booking_Number)FROM Booking";
		$queryResult=@mysqli_query($DBConnect,$SQLstring)
		or die("<p>Unable to query the Booking table.</p>"."<p>Error code".
		mysqli_errno($DBConnect).":".mysqli_error($DBConnect))."</p>";
		$row = mysqli_fetch_row($queryResult);
		$Pickup_Date=date_create_from_format('Y-m-j',$Pickup_Date);
		$Pickup_Date=date_format($Pickup_Date,'j/m/Y');
		echo"<p> Thank you! Your bookinbg refernce no is".$row[0].".Youb will be picked up in front of your provided address at ".$Pickup_Time."on".$Pickup_Date.".</p>";
		echo"<br><br><a href=login.php>Sign out</a>";
		exit();
}
?>
</html>