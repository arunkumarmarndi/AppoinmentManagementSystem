

<?php
include('../session.php');
$aptmentID=mysqli_escape_string($con,$_POST['id']);
$slotnumber=mysqli_escape_string($con,$_POST['id2']);
$verify=mysqli_query($con,"SELECT * FROM bookings WHERE apteeId='$user_id' AND aptmentID='$aptmentID'");
$checkrows=mysqli_num_rows($verify);
if(!empty($aptmentID)&&!empty($slotnumber)&&$user_type=="appointee"&&$checkrows==0){
	$sql=mysqli_query($con,"INSERT INTO bookings(apteeID,aptmentId,slot_number) VALUES('$user_id','$aptmentID','$slotnumber')");
	echo "Successfuly Booked!";
}
else if($checkrows!=0){
	echo "You have already booked an appointment!";
}
else if($user_type!="appointee"){
	echo "Log in as appointee to book";
}
?>