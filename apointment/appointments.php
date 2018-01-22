<!DOCTYPE html>
<html lang="en">
<head>
<script src="code/jquery.min.js"></script>
<script src="code/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<script>
var sem=1;
$(function() {
$(".slots").hide();
$(".slotsToggle").click(function(){
	var noteid=$(this).attr("data-id");
	
	$("#appointments-"+noteid).fadeToggle();
});
$(".rejectAppointee").click(function(){
	    var r = confirm("Do you want to reject this appointee?");
	    if(r==true){
       	var id = $(this).attr("data-id");//appointee
       	var superid = $(this).attr("data-superid");//appointment		
		var info = 'id=' + id+"&superid="+superid;
		$.ajax({
		type: "POST",
		url: "ajax/rejectAppointee.php",
		data: info,
		success: function(response){
		 $("#innerblock-"+id+"-"+superid).hide();

		}
		});
		}	
    });
$(".cancelAppointment").click(function(){
	    var r = confirm("Do you want to cancel this appointment? Note: Cancelling Appointment will automatically reject all Appointees");
	    if(r==true){
       	var id = $(this).attr("data-id");		
		var info = 'id=' + id;
		$.ajax({
		type: "POST",
		url: "ajax/cancelAppointment.php",
		data: info,
		success: function(response){
		 $("#appointments-"+id).hide();
		 $("#block-"+id).hide();
		}
		});
		}	
    });
});
</script>
<body>
<title>Appointers Login</title>
<h1 align='center' style='margin-top:-6px;margin-bottom:-2px;'>Appointments</h1><br>
<?php

include('session.php');
$msg="";
if(strcmp($user_type,"appointer")!=0)header("location: 550.php"); 
echo "<h2 align='center'  style='margin-top:-2px;margin-bottom:-2px;' >Welcome ".$loggedin_name."</h2>";
echo "<div style='text-align: right'><a href='logout.php' '>Logout</a></div>";
if (isset($_POST['create-appointment'])) {
	if (empty($from=$_POST['from']) || empty($to=$_POST['to']) || empty($slots=$_POST['slots'])||empty($date=$_POST['date'])) {
		$msg = "Fill up all the fields";
	}
	else if($to<$from||($to-$from)/$slots<0)
	{
		$msg = "Invalid appointment time";
	}
	else{
		$msg="Appointment is created";
		mysqli_query($con,"INSERT INTO appointments(apterID,date,slot_from,slot_to,nSlots) VALUES($loggedin_id,'$date','$from','$to','$slots')");
	}
}

?>
<body>

<h3>Create an Appointment</h3>
<div class="block" style="width:30%;">
<form name="appointments" align="right" action="" method="post" >
Date<input type="date" name="date"></input><br>
From (hours)<input type="number" min="0" max="23" name="from"></input><br>
To (hours)<input type="number" min="0" max="23" name="to"></input><br>
Number Of Slots: <input type="number" min="1" name="slots"></input><br>
<input type="submit" name="create-appointment" value="Create Appointment" ></input>
<span><?php echo $msg; ?></span>
</form>
</div>
<div class="block" style="width:50%;">
<?php
	echo "Email: ".$loggedin_email."<br>";
	echo "Phone: ".$loggedin_phone."<br>";
	echo "Profession: ".$loggedin_profession."<br>";
	echo "Description: ".$loggedin_description."<br>";
?>
<a href='view.php'>Search Other Appointments</a></div>
<div class="heading">
<h3>Your Appointments</h3>
</div>
<?php
$result = mysqli_query($con,"SELECT * FROM appointments WHERE apterID='".$loggedin_id."' ORDER BY date DESC");
while($row=mysqli_fetch_array($result))
{
	$appointmentID=$row['appointmentID'];
	echo "<div class='block' id='block-$appointmentID'>";
	echo "<b>Appointment Date: ".$row['date']."</b><br>";
	echo "Appointment starts from: ".$from=$row['slot_from'].":00 hours <br>";
	echo "Appointment ends at: ".$row['slot_to'].":00 hours <br>";
	echo "Appointment slot time: ".$row['nSlots'].":00 hours <br>";
	echo "Total Slots: ".(int)(($row['slot_to']-$row['slot_from'])/$row['nSlots'])."<br>";	
	$booking_sql=mysqli_query($con,"SELECT * FROM bookings WHERE aptmentID='".$appointmentID."' ORDER BY slot_number");
	$rows = mysqli_num_rows($booking_sql);
	echo "Number of Slots Booked: ".$rows."<br>";	
	echo "<div class='cancelAppointment' id='cancelAppointment-$appointmentID' data-id='$appointmentID' >Cancel Appointment</div>";
	echo "<div class='slotsToggle' data-id='$appointmentID'>Show/Hide</div>";
	echo "</div>";
	echo "<div class='slots' id='appointments-$appointmentID' style='display: block;' >";
	while($row2=mysqli_fetch_array($booking_sql))
	{
			$id=$row2['apteeID'];
			$slot_num=$row2['slot_number'];
			$appointmentTime=$from+$row['nSlots']*$slot_num;
			$appointee_sql=mysqli_query($con,"SELECT * FROM appointee WHERE appointeeID='".$id."'");
			$row3=mysqli_fetch_array($appointee_sql);
			echo "<div class='innerblock' id='innerblock-$id-$appointmentID'>";
			echo "<b>Visiting Time: ".$appointmentTime.":00 hours</b><br>";
			echo "Name :".$row3['name']."<br>";
			echo "Age :".$row3['age']."<br>";
			echo "Gender :".$row3['sex']."<br>";
			echo "Phone :".$row3['phone']."<br>";
			echo "Email :".$row3['email']."<br>";
			echo "<div class='rejectAppointee' id='rejectAppointee-$id-$appointmentID' data-id='$id' data-superid='$appointmentID' >Reject Appointee</div>";
			echo "</div>";
	}
	echo "</div>";
}
?>

</body>
