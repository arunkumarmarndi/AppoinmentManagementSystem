<?php
include('database-connect.php');

if(!isset($_SESSION['loginUser_id'])&&!isset($_SESSION['loginUser_type']))session_start();// Start Session
// Storing Session
$user_id=$_SESSION['loginUser_id'];
$user_type=$_SESSION['loginUser_type'];

// SQL Query To Fetch Complete Information Of User
if(strcmp($user_type,"appointee")==0){
	$ses_sql=mysqli_query($con,"select * from appointee where appointeeID='$user_id'");
	$row = mysqli_fetch_assoc($ses_sql);
	$loggedin_id=$row['appointeeID'];
}
else{
	$ses_sql=mysqli_query($con,"select * from appointer where appointerID='$user_id'");
	$row = mysqli_fetch_assoc($ses_sql);
	$loggedin_id=$row['appointerID'];
	$loggedin_profession=$row['profession'];
	$loggedin_description=$row['description'];
}



$loggedin_name =$row['name'];
$loggedin_email =$row['email'];
$loggedin_phone=$row['phone'];
?>