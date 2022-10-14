<?php
session_start();
$conn = new mysqli("localhost:3306", 'root','','tournament');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  if (!isset($_SESSION["userid"])) {
    header("Location: login.php", TRUE, 301);
    exit();
  }
?>
<?php
echo $_GET['s'];
$k=$_GET['s'];
$sql="SELECT teamid FROM participants WHERE pid='".$k."'";
$data=mysqli_query($conn,$sql);
$row=$data->fetch_assoc();
$teamid=$row['teamid'];
$sql1="UPDATE participants SET teamid=NULL WHERE pid='".$k."'";
$data1=mysqli_query($conn,$sql1);
if($data1){
    echo '<script>
    alert("Participant is removed successfully");
    </script>';
}
$sql2="SELECT count FROM team WHERE teamid='".$teamid."'";
$data2=mysqli_query($conn,$sql2);
$row2=$data2->fetch_assoc();
$count=$row2['count'];
$count=$count-1;
$sql3="UPDATE team SET count='".$count."' WHERE teamid='".$teamid."'";
$data3=mysqli_query($conn,$sql3);
if($data3){
    echo '<script>
    alert("Team count is decremented successfully");
    </script>';
    echo '<script type="text/javascript">
    window.location = "info.php";
    </script>';
}
?>