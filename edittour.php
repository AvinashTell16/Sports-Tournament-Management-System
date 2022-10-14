
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


$sql2="SELECT tname FROM tourevents WHERE tname='".$_POST['tname']."' AND tid!='".$_POST['tid']."'";
$data2=  mysqli_query($conn,$sql2);
if(mysqli_num_rows($data2)==1){
    echo '<script type="text/javascript">'; 
    echo 'alert("Event already exits");'; 
    echo 'window.location.href = "info.php";';
    echo '</script>'; 
}
else{
  if($_POST['status']=='Active'){
    $sta=1;
  }
  else if($_POST['status']=='InActive'){
    $sta=0;
  }
  $sql="UPDATE tourevents SET tname='".$_POST['tname']."',type='".$_POST['type']."',start_date='".$_POST['startdate']."',end_date='".$_POST['enddate']."',status='".$sta."',minteams='".$_POST['minteams']."',pperteam='".$_POST['pperteam']."',time='".$_POST['time']."'  WHERE tid='".$_POST['tid']."' ";
  $data=  mysqli_query($conn,$sql);
    if($data){
      echo '<script type="text/javascript">'; 
      echo 'alert("Event Updated Successfully");'; 
      echo 'window.location.href = "info.php";';
      echo '</script>'; 
    }
}

?>
