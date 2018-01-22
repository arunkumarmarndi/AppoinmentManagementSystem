<!DOCTYPE html>
<html lang="en">
<head>
<script src="code/jquery.min.js"></script>
<script src="code/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<script>
var sem=1;
$(function() {
$(".canbebooked").click(function(){
	    var r = confirm("Do you want to book this appointment");
	    if(r==true){
       	var id = $(this).attr("data-id");//appointment
       	var id2 = $(this).attr("data-id2");//slot number
		var info = 'id=' + id+"&id2="+id2;
		$.ajax({
		type: "POST",
		url: "ajax/book.php",
		data: info,
		success: function(response){
		 	//$("#canbebooked-"+id+"-"+id2).hide();
		 	if(response!="You have already booked an appointment!"){
		 		$("#canbebooked-"+id+"-"+id2).css('background-color', 'lightblue');
		 	}
		 	alert(response);
		}
		});
		}	
    });
 });
function bookings() {
    var myWindow = window.open("booked.php", "Bookings", "width=700, height=500");
}
</script>
</head>
<?php
	$output="";
	include('session.php');
	include('bookinglib.php');
	if (isset($_POST['custom-search'])) {
		if (empty($name=$_POST['search-name']) & empty($profession=$_POST['search-profession']) & empty($date=$_POST['search-date'])) {
			$output = "Enter Search Query";
		}
		else if(!empty($name)&&!empty($date)){
			$result = mysqli_query($con,"SELECT appointerID FROM appointer WHERE name='".$name."'");
     		while($row=mysqli_fetch_array($result)){
     			$appointerID=$row['appointerID'];
     			$result2 = mysqli_query($con,"SELECT * FROM appointments WHERE date='$date' AND apterID='$appointerID'");
				while($row2=mysqli_fetch_array($result2))
				{
					$appointmentID=$row2['appointmentID'];
					showAppointment($appointmentID);
				}
			}
		}
		else if(!empty($date)&&!empty($profession)){
			$result = mysqli_query($con,"SELECT appointerID FROM appointer WHERE profession='".$profession."'");
     		while($row=mysqli_fetch_array($result)){
     			$appointerID=$row['appointerID'];
     			$result2 = mysqli_query($con,"SELECT * FROM appointments WHERE date='$date' AND apterID='$appointerID'");
     			$rows = mysqli_num_rows($result2);
				while($row2=mysqli_fetch_array($result2))
				{
					$appointmentID=$row2['appointmentID'];
					showAppointment($appointmentID);
				}
			}
		}
	}elseif (isset($_POST['name-search'])) {
		if (!empty($name=$_POST['search-name']))
		{
			$result = mysqli_query($con,"SELECT appointerID FROM appointer WHERE name='".$name."'");
     		while($row=mysqli_fetch_array($result)){
     			$appointerID=$row['appointerID'];
     			$result2 = mysqli_query($con,"SELECT * FROM appointments WHERE apterID='$appointerID'");
				while($row2=mysqli_fetch_array($result2))
				{
					$appointmentID=$row2['appointmentID'];
					showAppointment($appointmentID);
				}
			}
		}else $output = "Enter Search Query";
	}elseif (isset($_POST['profession-search'])) {
		if (!empty($profession=$_POST['search-profession']))
		{
			$result = mysqli_query($con,"SELECT appointerID FROM appointer WHERE profession='".$profession."'");
     		while($row=mysqli_fetch_array($result)){
     			$appointerID=$row['appointerID'];
     			$result2 = mysqli_query($con,"SELECT * FROM appointments WHERE apterID='$appointerID'");
				while($row2=mysqli_fetch_array($result2))
				{
					$appointmentID=$row2['appointmentID'];
					showAppointment($appointmentID);
				}
			}
		}else $output = "Enter Search Query";
	}

?>

<table width="80%" style="position: absolute;top: 10px;">
<tr>
<td colspan='3'><h2 align="center">Search Appointments</h2></td>
</tr>
<tr>
<td align="right">
<form  name="search1" action="view.php" method="post" >
Name: <input type="text" name="search-name"></input><br>
Profession: <input type="text" name="search-profession"></input><br>
Date: <input type="date" name="search-date"></input><br>
<input type="submit" name="custom-search" value="Search"></input>
</form>
</td>
<td align="right">
<form  name="search2" action="" method="post" >
<input type="text" name="search-name"></input>
<input type="submit" name="name-search" value="Search By Name"></input>
</form>
<form  name="search3" action="" method="post" >
<input type="text" name="search-profession"></input>
<input type="submit" name="profession-search" value="Search By Profession"></input>
</form>
</td>
<td align="right">
<?php if($user_type=="appointee")echo "<a onclick='bookings()'>Bookings</a>"; ?>
<a href='logout.php'>Logout</a>
</td>
<span><?php echo $output;?></span>
</tr>
</table>

</html>