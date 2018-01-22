<!DOCTYPE html>
<html lang="en">
<head>
<script src="code/jquery.min.js"></script>
<script src="code/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php

function showAppointment($aptmentID){
global $con;
global $user_type;
global $user_id;
$result = mysqli_query($con,"SELECT * FROM appointments WHERE appointmentID='".$aptmentID."'");
$row=mysqli_fetch_array($result);
$apterID=$row['apterID'];
$date=$row['date'];
$slot_from=$row['slot_from'];
$slot_to=$row['slot_to'];
$nSlots=$row['nSlots'];
$result = mysqli_query($con,"SELECT * FROM appointer WHERE appointerID='".$apterID."'");
$row=mysqli_fetch_array($result);
$name=$row['name'];
$description=$row['description'];
$profession=$row['profession'];
$phone=$row['phone'];
$email=$row['email'];
echo "<br><br><br><br><br><br><br><br><br><br><div class='block' id='block-$aptmentID'>";
echo "Appointment Date: ".$date."<br>";
echo "Visiting Time: ".$nSlots.":00 hours <br>";
echo "Appointer: ".$name."<br>";
echo "Profession: ".$profession."<br>";
echo "Description: ".$description."<br>";
echo "Phone: ".$phone."<br>";
echo "Email: ".$email."<br>";
$slotCount=0;
for($i=$slot_from;($i+$nSlots)<$slot_to;$i+=$nSlots)
{
	$slotCount++;
	$result = mysqli_query($con,"SELECT * FROM bookings WHERE aptmentID='$aptmentID' AND slot_number='$slotCount'");
	$numrows = mysqli_num_rows($result);
	if($numrows>0)
		echo "<div class='booked'>$i:00</div>";
	else{
		if($user_type=="appointee")
		{
			echo "<div class='canbebooked' id='canbebooked-$aptmentID-$slotCount' data-id='$aptmentID' data-id2='$slotCount'>$i:00</div>";
		}else{
			echo "<div class='unbooked'>$i:00</div>";
		}
	}
}
echo "</div>";
}
?>