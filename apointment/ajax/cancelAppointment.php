<?php
include('../session.php');
$id=mysqli_escape_string($con,$_POST['id']);
if(!empty($_POST['id'])){
	$sql=mysqli_query($con,"DELETE FROM bookings WHERE aptmentID='$id'");
	$sql=mysqli_query($con,"DELETE FROM appointments WHERE appointmentID='$id'");
	echo "Successfuly Cancelled!";
}
else{
	echo "Error!";
}
?>