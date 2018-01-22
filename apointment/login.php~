<!DOCTYPE html>
<html lang="en">
<head>
<script src="code/jquery.min.js"></script>
<script src="code/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
include('database-connect.php');
$error="";$error2="";$error3="";
session_start();
if(isset($_SESSION['loginUser_type'])&&$_SESSION['loginUser_type']=="appointee")header("location: view.php"); else if(isset($_SESSION['loginUser_type'])&&$_SESSION['loginUser_type']=="appointer") header("location: appointments.php");
if (isset($_POST['login-submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is empty";
}
else{
$uid=0;
$userType=$_POST['userType'];


if($userType=="appointee")
  $result = mysqli_query($con,"SELECT * FROM appointee WHERE email='".mysqli_real_escape_string($con,$_POST['username'])."' AND pwd='".mysqli_real_escape_string($con,$_POST['password'])."'");
else
  $result = mysqli_query($con,"SELECT * FROM appointer WHERE email='".mysqli_real_escape_string($con,$_POST['username'])."' AND pwd='".mysqli_real_escape_string($con,$_POST['password'])."'");

$rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

  if($rows== 1){//authentication validated
  if($userType=="appointee")$uid=$row['appointeeID']; else $uid=$row['appointerID'];
  //setcookie("userId",$uid,'/');
  $_SESSION['loginUser_id']=$uid;
  $_SESSION['loginUser_type']=$userType;
  if($userType=="appointee")header("location: view.php"); else header("location: appointments.php");
  }
  else
  {
    $error="Username or Password is invalid";
  }
mysqli_close($con);
}//end of else
}//end of if (isset($_POST['submit']))
else if(isset($_POST['appointee-submit']))
{
  if (empty($name=$_POST['name']) || empty($age=$_POST['age'])||empty($sex=$_POST['sex']) || empty($phone=$_POST['phone'])||empty($email=$_POST['email']) || empty($pwd=$_POST['password'])|| empty($_POST['password2'])) {
    $error2 = "Some Fields are empty";
  }
  else if(strcmp($_POST['password'],$_POST['password2'])!=0)
  {
     $error2 = "Password do not match";
  }
  else{
     $result = mysqli_query($con,"SELECT * FROM appointee WHERE email='".$email."'");
     $rows = mysqli_num_rows($result);
     if($rows>0)
     {
        $error2 = "Account Exists Already!";
     }
     else {
      mysqli_query($con,"INSERT INTO appointee(name,sex,age,phone,email,pwd) VALUES('$name','$sex','$age','$phone','$email','$pwd')");
      $error2 = "Account Created. Log in to Continue";
    }
  }
}
else if(isset($_POST['appointer-submit']))
{
  if (empty($name=$_POST['name']) || empty($profession=$_POST['profession'])||empty($description=$_POST['description']) || empty($phone=$_POST['phone'])||empty($email=$_POST['email']) || empty($pwd=$_POST['password'])|| empty($_POST['password2'])) {
    $error3 = "Some Fields are empty";
  }
  else if(strcmp($_POST['password'],$_POST['password2'])!=0)
  {
     $error3 = "Password do not match";
  }
  else{
     $result = mysqli_query($con,"SELECT * FROM appointer WHERE email='".$email."'");
     $rows = mysqli_num_rows($result);
     if($rows>0)
     {
        $error3 = "Account Exists Already!";
     }
     else {
      mysqli_query($con,"INSERT INTO appointer(name,profession,description,phone,email,pwd) VALUES('$name','$profession','$description','$phone','$email','$pwd')");
      $error3 = "Account Created. Log in to Continue";
    }
  }
}

?>

<body>
<h1 align="center" style="margin-top:-6px;margin-bottom:0px;">Appointment Management Systems</h1>
<table style="width:85%">
<tr>
<td align="center" colspan="2">
<h2 style="margin-bottom:-2px;">Login</h2>
<form  name="login" action="" method="post" >
<input type="text" name="username"></input><br>
<input type="password" name="password"></input><br>
 <input type="radio" name="userType" value="appointee" checked> Appointee<br>
 <input type="radio" name="userType" value="appointer"> Appointer<br>
 <span><?php echo $error; ?></span>
<input type="submit" name="login-submit" value="login"></input>

</form>
</td>
</tr>
<tr>
<td align="right">
<h2 style="margin-bottom:-2px;">Appointee SignUp</h2>
<form name="appointee-signUp" action="" method="post" >
Name: <input type="text" name="name"></input><br>
Age: <input type="text" name="age"></input><br>
Gender: <input type="text" name="sex"></input><br>
Phone: <input type="text" name="phone"></input><br>
Email: <input type="text" name="email"></input><br>
Password: <input type="password" name="password"></input><br>
Confirm Password: <input type="password" name="password2"></input><br>
<span><?php echo $error2; ?></span>
<input type="submit" name="appointee-submit" value="signup"></input>
</form>
</td>
<td align="right">
<h2 style="margin-bottom:-2px;">Appointer SignUp</h2>
<form name="appointee-signUp" action="" method="post" >
Name: <input type="text" name="name"></input><br>
Profession: <input type="text" name="profession"></input><br>
Description: <input type="text" name="description"></input><br>
Phone: <input type="text" name="phone"></input><br>
Email: <input type="text" name="email"></input><br>
Password: <input type="password" name="password"></input><br>
Confirm Password: <input type="password" name="password2"></input><br>
<span><?php echo $error3; ?></span>
<input type="submit" name="appointer-submit" value="signup"></input>
</form>
</td>
</tr>
</table>
<div class='block' style='width:99%;margin-left:-6px;font-size: 18px;'>All Copy rights Reservered. Software Engineering Lab. 2016. </div>
</body>
