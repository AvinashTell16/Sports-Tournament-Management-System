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
$tid=$_POST['tid'];
$type=$_POST['type'];
$sql="DELETE FROM tourevents where tid='".$tid."'";
$data=mysqli_query($conn,$sql);
//Deleting all the participants of that particular tournament of type single
if($data){
  if($type=='single'){
    $sql2="DELETE FROM tourall WHERE tid='".$tid."'";
    $data2=mysqli_query($conn,$sql2);
    if($data2){
      echo "<script>alert('Tournament is cancelled Successfully')</script>";
      echo "<script type='text/javascript'>window.location = 'info.php';</script> ";
    }
  }
  else{
    $sql2="DELETE FROM tourall WHERE tid='".$tid."'";
    $data2=mysqli_query($conn,$sql2);
    if($data2){
      echo "<script>alert('Tournament is cancelled Successfully!!')</script>";
      echo "<script type='text/javascript'>window.location = 'info.php';</script> ";
    }
  }
}
?>