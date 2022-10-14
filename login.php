<?php 
session_start();
$conn = new mysqli("localhost:3306", 'root','','tournament');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if(isset($_SESSION['userid'])){
    header("Location:info.php", TRUE, 301);
    exit();
  }
  else if(isset($_SESSION['user'])){
    header("Location: yourtour.php", TRUE, 301);
    exit();
  }
?>


<!DOCTYPE html>
<html>
<head>
<title>Login Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="regis.css">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>


</head>
<body>
<div>
<?php
if(isset($_POST['submit'])){
  $email=$_POST['email'];
  $pass=$_POST['password'];
  //$pass1=password_hash($pass,PASSWORD_DEFAULT);
  if($email=='admin@gmail.com' && $pass=='abcdefg'){
    //echo "<script>alert('Admin Logged in succesfully')</script>";
    $_SESSION['userid']=$email;
    echo '<script type="text/javascript">
    window.location = "info.php";
    </script>';

  }
  else{
    /*
    $pass=sha1($_POST['password']);
    $sql="SELECT * FROM participants WHERE email='".$email."' AND  password='".$pass."' limit 1";
    $data = mysqli_query($conn,$sql);
    $row=$data->fetch_assoc();
    if(mysqli_num_rows($data)==1){
      */
      $sql="SELECT * FROM participants WHERE email='".$email."'";
    $data = mysqli_query($conn,$sql);
    $row=$data->fetch_assoc();
    $n=mysqli_num_rows($data);
    if($n==0){
      echo "<script>alert('Email or password is incorrect')</script>";
    }
    else if(password_verify($pass,$row['password'])){
      //echo "<script>alert('Logged in succesfully')</script>";
      $sql="SELECT * FROM participants WHERE email='".$email."' ";
      $data = mysqli_query($conn,$sql);
      $res=$data -> fetch_row();
      $n=$res[0];
      $_SESSION['user']=$n;
      ?>
      <script type="text/javascript">
      window.location = 'yourtour.php';
      </script>      
        <?php
  }
  else{  
    echo "<script>alert('Email or password is wrong')</script>";
  }
}
}
?>
</div>
  <div class="main-w3layouts wrapper">
    <h1>Sports Tournament</h1>
    <h1>Login Form</h1>
    <div class="main-agileinfo">
      <div class="agileits-top">
        <form action="#" method="post">
          <input class="text email" type="email" name="email" placeholder="Email" required="">
          <input class="text" type="password" name="password" placeholder="Password" required="">
          
          <input type="submit" value="SIGNIN" name="submit">
        </form>
        <p>Don't have an account? <a href="registration.php" style="color:black;text-decoration:underline;font-style:italic;">Signup Here!</a>
        </p>
      </div>
    </div>
    
</body>
</html>