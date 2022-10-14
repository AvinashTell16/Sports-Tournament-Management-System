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
    $sql7="INSERT INTO tourall (tid,id,disqualify) VALUES('".$_POST['tid']."' ,'".$_POST['pid']."',0)";
    $data7= mysqli_query($conn,$sql7);
    if($data7){
      echo '<script type="text/javascript">'; 
      echo 'alert("Participant is registered Successfully");'; 
      echo 'window.location.href = "upcomingtour.php";';
      echo '</script>'; 
      }
    ?>