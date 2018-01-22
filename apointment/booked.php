<!DOCTYPE html>
<html lang="en">
<head>
<script src="code/jquery.min.js"></script>
<script src="code/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<script>
$(function() {
$(".cancelAppointment").click(function(){
	    var r = confirm("Do you want to cancel this appointment booking?");
	    if(r==true){
       	var id = $(this).attr("data-id");		
		var info = 'id=' + id;
		$.ajax({
		type: "POST",
		url: "ajax/cancelBooking.php",
		data: info,
		success: function(response){
		  $("#block-"+id).hide();
		  alert(response);
		}
		});
		}	
    });
});
</script>

</head>

<body>
	<h2>Bookings</h2>
<?php
include('session.php');
if($user_type=="appointee"){
$result=mysqli_query($con,"SELECT * FROM bookings WHERE apteeID='$user_id'");
$numrows=mysqli_num_rows($result);
if($numrows==0)echo "No Appointments Booked Yet!";
while($row=mysqli_fetch_array($result))
{
	$slotnumber=$row['slot_number'];
	$aptmentID=$row['aptmentID'];
	$bookID=$row['bookID'];
	$result2=mysqli_query($con,"SELECT * FROM appointments WHERE appointmentID='$aptmentID='");
	$row2=mysqli_fetch_array($result2);
	$apterID=$row2['apterID'];
	$date=$row2['date'];
	$nSlots=$row2['nSlots'];
	$slot_from=$row2['slot_from'];
	$result3=mysqli_query($con,"SELECT * FROM appointer WHERE appointerID='$apterID'");
	$row3=mysqli_fetch_array($result3);
	$name=$row3['name'];
	$phone=$row3['phone'];
	$email=$row3['email'];
	$profession=$row3['profession'];
	$description=$row3['description'];
	$appointmentTime=$slot_from+$nSlots*($slotnumber-1);
	echo "<div class='block' id='block-$bookID' style='width:600px;'><b> Appointment Date: $date<br>Appointment Time: $appointmentTime:00 hours</b><br>Appointer Name: $name<br>Profession: $profession<br>Description: $description<br>Phone: $phone<br>Email: $email<br>";
	echo "<div class='cancelAppointment' id='cancelAppointment-$bookID' data-id='$bookID'>Cancel Appointment</div></div>";
	

}
}
else{
	echo "Invalid Page!";
}
?>
</body>