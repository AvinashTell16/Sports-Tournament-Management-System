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
if(isset($_POST['submit'])){
  $tour_name=$_POST['tname'];
  $type=$_POST['type'];
  $minteams=$_POST['minteams'];
  $start_date=$_POST['startdate'];
  $end_date=$_POST['enddate'];
  $pperteam=$_POST['pperteam'];
  $time=$_POST['time'];
  $k=$_POST['duration'];
  $tourenddate=date('Y-m-d', strtotime($end_date. ' + '.$k.' days'));
  
  $kk=0;
  //Whether there is a tournament with same name or not
  $sql2="SELECT tname FROM tourevents WHERE tname='".$tour_name."' ";
  $data2=  mysqli_query($conn,$sql2);
  if(mysqli_num_rows($data2)==1){
      echo '<script type="text/javascript">'; 
      echo 'alert("Event already exits");'; 
      echo 'window.location.href = "createtournament.php";';
      echo '</script>'; 
      $kk=1;
  }
  //Is another tournament being conducted in the same time
  date_default_timezone_set('Asia/Kolkata');
  $date = date('Y-m-d H:i:s',strtotime($_POST['enddate'].$_POST['time']));
  $k=$_POST['duration'];
  $date1=date('Y-m-d H:i:s', strtotime($date. ' + '.$k.' days'));
  $sql1="SELECT * FROM tourevents";
  $data1=mysqli_query($conn,$sql1);
  $k1=0;
  $k2=0;
  $nk=mysqli_num_rows($data1);
  while($row1=$data1->fetch_assoc()){
    $cur=$row1['end_date'].$row1['time'];
    $cur1 = date('Y-m-d H:i:s',strtotime($cur));
    $cur12=$row1['tourend_date'].$row1['time'];
    $cur2 = date('Y-m-d H:i:s',strtotime($cur12));
    if(($date<$cur1 && $date1<$cur1) || ($date>$cur2 && $date1>$cur2)){
        $k1=$k1+1;
    }
  }
  if($nk-$k1 !=0){
    echo '<script type="text/javascript">'; 
    echo 'alert("Another Tournament is conducted during the same time!!");'; 
    echo 'window.location.href = "createtournament.php";';
    echo '</script>'; 
    $kk=1;
    }
    

  if($kk==0){
    $sql = "INSERT INTO tourevents(tname,type,start_date,end_date,status,minteams,pperteam,time,tourend_date)
    VALUES ('$tour_name','$type','$start_date','$end_date',1,'$minteams','$pperteam','$time','$tourenddate')";
    $data = mysqli_query($conn,$sql);
    if ($data) {	
      echo '<script type="text/javascript">'; 
      echo 'alert("Event Added Sucessfully");'; 
      echo 'window.location.href = "info.php";';
      echo '</script>';  
    }
    else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Tournament</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-97824898-1', 'auto');
ga('send', 'pageview');
</script>

</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <img src="tour.png" width="150px" height="50px">
    </div>
    <ul class="nav navbar-nav">
      <li><a href="info.php">All Tournaments</a></li>
	    <li  class="active"><a href="createtournament.php">Create Tournament</a></li>
    </ul>
    <input type="button" value="Logout" style="float:right;width: 100px;margin-top:10px;margin-bottom:10px;background-color:red;border-radius:5px;border:None;color:white;" onclick="window.location='logout2.php';"></h1>
  </div>
</nav>
<div style="padding:20px;">     
  <div class="col-12">
    <div style="padding-left:2%;width:100%;border-style:solid; border-radius:10px;border-color:#0000ff">
      <center><h1>Add New Tournament</h1></center>                          
      <form method="post" style="padding:20px;">
        Tournament name:
        <input type="text" name="tname" required class="smalltext">
        Type: <select name="type" required class="smalltext">
        <option value="single">single</option>
        <option value="team">team</option>
        </select><br><br>
        Minteams                                                                      
        <input type="text" name="minteams" required class="bigtext"><br><br>
        Participants per team                                                                      
        <input type="text" name="pperteam" required class="bigtext"><br><br>
        Start Date:  
        <input type="date" name="startdate" required class="smalltext">
        End Date:  
        <input type="date" name="enddate" required class="smalltext"><br><br>
        Event Start Time:  
        <input type="time" name="time" required class="smalltext"><br><br>
        Event Duration:
        <input type="int" name="duration" required class="smalltext" placeholder="(in days)"><br><br>
        <input type="submit" value="Submit" name="submit">
      </form>
    </div>
  </div>
</div>
</div>

</body>
</html>