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
  <?php
  $tid=$_POST['tid'];
  $p=$_POST['pid'];
  $t=$_POST['teamname'];
  $c=$_POST['count'];
  $sql1="SELECT teamname FROM team WHERE teamname='".$t."'";
  $data1=mysqli_query($conn,$sql1);
  if(mysqli_num_rows($data1)==1){
    echo "<script>alert('Team Already Exists')</script>";
    echo "<script type='text/javascript'>window.location = 'upcomingtour.php';</script>";
  }

  else{
    $c=1;
    $sql="INSERT INTO team (teamname,count,captain) VALUES('".$t."','".$c."','".$p."')";
    $data=mysqli_query($conn,$sql);
    if($data){
      echo "<script>alert('Team is Created Successfully!')</script>";
      $sql2="SELECT teamid FROM team WHERE teamname='".$t."'";
      $data2=mysqli_query($conn,$sql2);
      $row2=$data2->fetch_assoc();
      $teamid=$row2['teamid'];
      $sql3="INSERT INTO tourall (tid,id,disqualify) VALUES('".$tid."','".$teamid."',0)";
      $data3=mysqli_query($conn,$sql3);
      $sql5="UPDATE participants SET teamid = '".$teamid."' WHERE pid = '".$p."'";
      $data5=mysqli_query($conn,$sql5);
      if($data3 && $data5){
        echo "<script>alert('Registered to Tournament Successfully!')</script>";
      }
    ?>
    <script type="text/javascript">
      window.location = 'upcomingtour.php';
      </script>    
      <?php
    }
  }
  ?>