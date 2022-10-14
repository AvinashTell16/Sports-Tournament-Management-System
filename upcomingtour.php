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
  <title>Upcoming Tournaments</title>
  
<h3 class="liketext">Push Yourselves to compete with others</h3>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!--Popup form-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--Popup Form-->

<!--card style css-->
<style>
  *{
      box-sizing: border-box;
      margin: 0px;
      padding:0px;
     
      
  }
  body
  {
    background-color: #F7F7F7;
    letter-spacing: 1.2px;
  }
.card1 {
float: left;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  padding-left:15px;
  margin-right: 20px;
  margin-bottom: 50px;
  background-color: #E1EBEE;
  border-radius:10px;
}

.card1:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container1 {
  padding: 2px 16px;
}
.modal-body{
  background: linear-gradient(45deg, red, orange, yellow, green, blue, indigo, violet, red);
}
.btn-lg{
  background-color:#333465;
  border: none;
  outline: none;
  color: white;
  box-shadow:  0 4px 8px 0 rgba(0,0,0,0.2);
  margin-right: 10px;
  margin-bottom: 10px;
  min-width: 200px;
  max-width: 250px;
  text-align: center;
}
</style>
<!--card style css-->


<div style="padding-top:20px;">
<nav class="navbar navbar-default" >
  <div class="container-fluid">
    <div class="navbar-header">
    <img src="tour.png" width="150px" height="50px">
    </div>
    <ul class="nav navbar-nav">
      <li style="padding-left:20px;"><a href="yourtour.php">Home Page</a></li>
      <li class="active"><a href="upcomingtour.php">Upcoming Tournaments</a></li>
      <li><a href="profile.php">Profile</a></li>
     
    </ul>
    <input type="button" value="Logout" style="float:right;width: 100px;margin-top:10px;margin-bottom:10px;background-color:red;border-radius:5px;border:None;color:white;" onclick="window.location='logout3.php';"></h1>
  </div>
</nav>
</div>
</head>


<body>

<?php
$sql="SELECT * FROM tourevents";

$data = mysqli_query($conn,$sql);
$n=mysqli_num_rows($data);
$k=$_SESSION['user'];
if($n>0){
  while($row=$data->fetch_assoc()){
    
    $sql3="SELECT tid from tourall WHERE tid='".$row['tid']."' AND id='".$k."'";
    $data3 = mysqli_query($conn,$sql3);
    $row3=$data3->fetch_assoc();
    $sql4="SELECT teamid from participants WHERE pid='".$k."'";
    $data4 = mysqli_query($conn,$sql4);
    $row4=$data4->fetch_assoc();
    $sql5="SELECT tid FROM tourall WHERE tid='".$row['tid']."' AND id='".$row4['teamid']."'";
    $data5 = mysqli_query($conn,$sql5);

    if(mysqli_num_rows($data3)==1 && $row['type']=='single'){
      continue;
    }
    if(mysqli_num_rows($data5)==1 && $row['type']=='team'){
      continue;
    }
    else{
      //Display only active tournaments
      if($row['status']==0){
        $sta="InActive";
      }
      else if($row['status']==1){
        $sta="Active";
      }
    ?>
    <div class="card1">
  <div class="card" style="width:400px;">

    <div class="card-body">
      <h4 class="card-title">Name of the Tournament : <?php echo $row['tname'];?></h4>
      <p class="card-text">Type : <?php echo $row['type'];?></p>
      <p class="card-text">Start date : <?php echo $row['start_date'];?></p>
      <p class="card-text">End date : <?php echo $row['end_date'];?></p>
      <p class="card-text">Status : <?php echo $sta;?></p>
      <p class="card-text">Participants per team : <?php echo $row['pperteam'];?></p>
      <p class="card-text">Time : <?php echo $row['time'];?></p>
    </div>
  </div>
  
    <!--Popup form-->
            <div class="container-box">
              <?php
              if($row['status']!=1){
                ?>
                <button type="button" class="btn-lg" disabled>Register</button>
                <?php
              }
              else{
              ?>
                <button type="button" class="btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['tid'];?>" >Register</button>
                <?php
              }
              ?>
            </div>
            <!-- Modal -->
            <div id="myModal<?php echo $row['tid'];?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" name="register">&times;</button>
                            <h4 class="modal-title">
                                Register
                            </h4>
                        </div>
                        <div class="modal-body">
                        <?php 
                        //Type=single
                        if($row['type']=='single'){
                          $p=0;
                          echo "Finally Confirm to register for the tournament";
                          ?>
                          <form method="POST" action="registertour.php">
                          <input type=hidden name="tid" value= "<?php echo $row['tid'];?>" readonly>
                          <input type=hidden name="pid" value= "<?php echo $k;?>" readonly>
                          
                          <input type='submit' name='register' action="registertour.php">
                        </form>
                          <?php
                                                      
                        }

                        else{
                          //type=team
                          $sql2="SELECT teamid FROM participants WHERE pid='".$k."'";
                          $data2=mysqli_query($conn,$sql2);
                          $row2=$data2->fetch_assoc();
                          $k2=$row2['teamid'];
                          ?>
                         <?php
                         if($k2==NULL)
                         {
                         ?>
                          <form method="POST" action="teams.php">
                        <?php
                         }
                         else{
                          ?>
                          <form method="POST" action="teamdetails.php">
                          <?php
                         }
                         ?>
                            <!--Create a new team or select an existing team-->
                          <h4>This tournament should be registered as a team</h4>
                          <input type=hidden name="tid" value= "<?php echo $row['tid'];?>" readonly>
                          <input type=hidden name="pid" value= "<?php echo $k;?>" readonly>
                          <input type=hidden name="teamid" value= "<?php echo $k2;?>" readonly>
                        
                          <input type='submit' name='register' value="Register">
                          </form>
                          <?php
                        }
                        
                        ?>
                        
                          </div>
                    </div>
                </div>
            </div>
    </div>
    <!--Popup form-->
    <?php
      //End of only display active tournaments
    }
  }
}

?>

</body>
</html>
