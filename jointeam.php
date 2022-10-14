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
  $teamname=$_POST['team'];
  $sql4="SELECT teamid,captain FROM team WHERE teamname='".$_POST['team']."'";
  $data4=mysqli_query($conn,$sql4);
  $row4=$data4->fetch_assoc();
  //$teamid=$_POST['teamid'];
  $teamid=$row4['teamid'];
  $p=$_SESSION['user'];
  $sql5="UPDATE participants SET teamid = '".$teamid."' WHERE pid = '".$p."'";
  $data5=mysqli_query($conn,$sql5);
  if($data5){
    echo "<script>alert('Teamid and captain is added to participant succesfully')</script>";
  }
  
  $sql7="SELECT * FROM team WHERE teamid='".$teamid."'";
  $data7=mysqli_query($conn,$sql7);
  if($data7){
    $row7=$data7->fetch_assoc();
    $count=$row7['count'];
    $count=$count+1;
    $sql8="UPDATE team SET count = '".$count."' WHERE teamid = '".$teamid."'";
    $data8=mysqli_query($conn,$sql8);
    if($data8){
        echo "<script>alert('Team Count is updated successfully)</script>";
        ?>
      <script type="text/javascript">
      window.location = 'upcomingtour.php';
      </script>      
        <?php
    }
  }
?>

