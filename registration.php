
<?php
session_start();
$conn = new mysqli("localhost:3306", 'root','','tournament');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
if(isset($_SESSION['user'])){
  header("Location: yourtour.php", TRUE, 301);
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
<title>Participants SignUp Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="regis.css">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<style>
span{
			font-size: 13px;
			color: #FFFF00;
			padding-top: 0px;
			margin-bottom: 0px;
		}  
</style>
<script type=text/javascript>
  function validate(){
  var username=document.getElementById("name").value;
  var password=document.getElementById("password").value;
  var cpassword=document.getElementById("cpassword").value;
  var email=document.getElementById('email').value;
  var f=email.indexOf("@");
  var l=email.lastIndexOf(".");
  var age=document.getElementById('age').value;
  var age1 = parseInt(age);
  var bloodgroup=document.getElementById('bloodgroup').value;
  var address=document.getElementById('address').value;
  var flag=1;
  if(username.length<6){
    document.getElementById("name1").innerHTML="Username must contain atleast 6 characters";
		flag=0;
    
  }
  if(password.length<6){
    document.getElementById("password1").innerHTML="Password should be greater than 6 characters";
		flag=0;
  }
  if(password!=cpassword){
    document.getElementById("password1").innerHTML="Passwords do not match";
        document.getElementById("password2").innerHTML="Passwords do not match";
				flag=0;
  }
  if(age1>60 && age1<10){
    document.getElementById("age1").innerHTML="Enter valid age";
    flag=0;
  }
  if(bloodgroup!="O+" && bloodgroup!="O-" && bloodgroup!="A+" && bloodgroup!="A-" && bloodgroup!="B+" && bloodgroup!="B-" && bloodgroup!="AB+" && bloodgroup!="AB-"){
    document.getElementById("bgrp1").innerHTML="Invalid Blood Group";
    flag=0;
  }
  if(address.length==0){
    document.getElementById("add1").innerHTML="Please Enter Address";
    flag=0;
  }
  if(f==-1 || l==-1 || f>l){
		document.getElementById("email1").innerHTML="Standard mail pattern is (abc@domain.com)";
		flag=0;
	}

	if(flag==0){
		return false
	}
	if(flag==1){
		return true;
	}
}
</script>
</head>
<body>
<div>
<?php
if(isset($_POST['submit'])){
  $pname=$_POST['name'];
  //$pass=sha1($_POST['password']);
  $pass=$_POST['password'];
  $age=$_POST['age'];
  $email=$_POST['email'];
  $address=$_POST['address'];
  $bgrp=$_POST['bloodgroup'];
  $f1=0;
  $f2=0;
  //password hashing
 // $pass1=password_hash($pass,PASSWORD_DEFAULT);
 $hash = password_hash($pass,PASSWORD_BCRYPT);
 $sql1="SELECT email FROM participants WHERE email='".$email."'";
 $data1=mysqli_query($conn,$sql1);
 if(mysqli_num_rows($data1)==1){
  $f1=1;
  echo "<script>alert('User with same mail already exists')</script>";
 }
 $sql2="SELECT pname FROM participants WHERE pname='".$pname."'";
 $data2=mysqli_query($conn,$sql2);
 if(mysqli_num_rows($data2)==1){
  $f2=1;
  echo "<script>alert('User with same name already exists')</script>";
 }
 if($f1==0 && $f2==0){
 
  $sql="INSERT INTO participants (pname,age,email,password,address,bloodgroup) values('$pname','$age','$email','$hash','$address','$bgrp')";
  $data = mysqli_query($conn,$sql);
  if($data){
      echo "<script>alert('User registered succesfully')</script>";
    ?>
	<script type="text/javascript">
	window.location = 'login.php';
	</script>      
    <?php
}
else{
    
    echo "<script>alert('record insertion failed')</script>";
}
}
}
?>
</div>
  <div class="main-w3layouts wrapper">
    <h1>Sports Tournament</h1>
    <h1>Participants SignUp Form</h1>
    <div class="main-agileinfo">
      <div class="agileits-top">
      <form method="post">
          
          <input class="text" type="text" name="name" placeholder="Username" required="" id="name">
          <span id="name1"></span>
          <input class="text email" type="email" name="email" placeholder="Email" required="" id="email">
          <span id="email1"></span>
          <input class="text" type="password" name="password" placeholder="Password" required="" id="password">
          <span id="password1"></span>
          <input class="text w3lpass" type="password" name="password" placeholder="Confirm Password" required="" id="cpassword">
          <span id="password2"></span>
          <input class="text" type="text" name="age" placeholder="Age" required="" id="age"><br>
          <span id="age1"></span>
          <input class="text" type="text" name="bloodgroup" placeholder="bloodgroup" required="" id="bloodgroup"><br>
          <span id="bgrp1"></span>
          <input class="text" type="text" name="address" placeholder="address" required="" id="address">
          <span id="add1"></span>
          <div class="wthree-text">
            <label class="anim">
              <input type="checkbox" required="">
              <span>I Agree To The Terms & Conditions</span>
            </label>
            <div class="clear"> </div>
          </div>
          <input type="submit" value="SIGNUP" name="submit" onClick="return validate()"> 
        </form>
        <p>Already have an account? <a href="login.php" style="color:black;text-decoration:underline;font-style:italic;"> Login Here!</a>
        </p>
      </div>
    </div>
    
</body>
</html>
