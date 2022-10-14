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
$pid=$_POST['pid'];
$sql="DELETE FROM tourall WHERE tid='".$tid."' AND id='".$pid."' ";
$data=mysqli_query($conn,$sql);
if($data){
    ?>
    <script type="text/javascript">
      alert("Deregistered Successfully");  
      window.location = 'upcomingtour.php';
      </script>
    <?php
}
?>