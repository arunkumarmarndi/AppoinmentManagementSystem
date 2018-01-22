<?php
include('../session.php');
$id=mysqli_escape_string($con,$_POST['id']);
$superid=mysqli_escape_string($con,$_POST['superid']);
if(!empty($_POST['id'])){
	$sql=mysqli_query($con,"DELETE FROM bookings WHERE apteeID='$id' AND aptmentID='$superid'");
	echo "Successfuly Rejected!";
}
else{
	echo "Error!";
}
?>