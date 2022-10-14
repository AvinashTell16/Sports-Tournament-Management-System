<?php 
session_start();
$conn = new mysqli("localhost:3306", 'root','','tournament');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if (!isset($_SESSION["user"])) {
    header("Location: login.php", TRUE, 301);
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Player Info</title>
  <h3 class="liketext">Push Yourselves to compete with others</h3>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
  .gradient-custom {
    background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));
    }
    
  </style>
</head>
<body>

<?php
$s=$_SESSION['user'];
$sql="SELECT * FROM participants WHERE pid='".$s."' ";
$data = mysqli_query($conn,$sql);
$res=$data -> fetch_row();
$name=$res[1];
$age=$res[2];
$email=$res[3];
$address=$res[5];
$bloodgrp=$res[6];
?>

<div style="padding-top:20px;">
<nav class="navbar navbar-default" >
  <div class="container-fluid">
    <div class="navbar-header">
    <img src="tour.png" width="150px" height="50px">
    </div>
    <ul class="nav navbar-nav">
      <li style="padding-left:20px;"><a href="yourtour.php">Home Page</a></li>
      <li><a href="upcomingtour.php">Upcoming Tournaments</a></li>
      <li class="active"><a href="profile.php">Profile</a></li>
    </ul>
    <input type="button" value="Logout" style="float:right;width: 100px;margin-top:10px;margin-bottom:10px;background-color:red;border-radius:5px;border:None;color:white;" onclick="window.location='logout3.php';"></h1>
  </div>
</nav>
</div>




  <section class="vh-100" style="background-color: #f4f5f7;width:300px;margin-left:200px;margin-top:100px;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-6 mb-4 mb-lg-0">
        <div class="card mb-3" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white"
              style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <img src="user.png"
                alt="Avatar" class="img-fluid my-5" style="width: 100px;height:134px;margin-top:10px" />
              <h4><?php echo $name;?></h4>
              <p>Participant</p>
              <i class="far fa-edit mb-5"></i>
            </div>
            <div class="col-md-8 gradient-custom text-white" style="height:214px;border-top-right-radius: .5rem;border-bottom-right-radius:.5rem;">
              <div class="card-body p-4">
                <h3>Personal Information</h3>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                <div class="col-6 mb-3" style="padding-left:10px;">
                    <h5 style="display:inline">Age : </h5>
                    <p class="text-muted" style="display:inline"><?php echo $age;?></p><br>
                    <h5 style="display:inline">Email : </h5>
                    <p class="text-muted" style="display:inline"><?php echo $email;?></p><br>
                    <h5 style="display:inline">Address : </h5>
                    <p class="text-muted" style="display:inline"><?php echo $address;?></p><br>
                    <h5 style="display:inline">Blood Group : </h5>
                    <p class="text-muted" style="display:inline"><?php echo $bloodgrp;?></p><br>
                  </div>
                </div>
                
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


</body>
</html>
