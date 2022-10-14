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
  <title>See Your Tounaments</title>
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
        <link rel="stylesheet" href="form.css" >
        <script src="form.js"></script>
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
  .container{
    background-color: orange;
    min-width: 100vw;
    margin-left:50px

  }
.card1 {
float: left;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 30%;
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
  background-color:red;
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
.cancel{
  background-color: red;
}
</style>
<!--card style css-->

</head>
<body>
<header>


</header>
<div style="padding-top:20px;">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <img src="tour.png" width="150px" height="50px">
    </div>
    <ul class="nav navbar-nav">
      <li class="active" style="padding-left:20px;"><a href="yourtour.php">Home Page</a></li>
      <li><a href="upcomingtour.php">Upcoming Tournaments</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
    <input type="button" value="Logout" style="float:right;width: 100px;margin-top:10px;margin-bottom:10px;background-color:red;border-radius:5px;border:None;color:white;" onclick="window.location='logout3.php';"></h1>

  </div>
</nav>
</div>
<?php
$f=0;
  $sql="SELECT * FROM tourevents";
  $data = mysqli_query($conn,$sql);
  $n=mysqli_num_rows($data);
  $k=$_SESSION['user'];
  if($n>0){
    while($row=$data->fetch_assoc()){
      //Making the status as InActive for the tournaments for which registration time is completed
      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d h:i:s');
      $k4=$row['end_date'].$row['time'];
      $date1 = strtotime($k4);
      $date1=date('Y-m-d h:i:s',$date1);
      if($date>$date1){
        $sql1="UPDATE tourevents SET status=0 WHERE tid='".$row['tid']."'";
        $data1=mysqli_query($conn,$sql1);
      }
      //Display all the tournaments
      $sql3="SELECT tid from tourall WHERE tid='".$row['tid']."' AND id='".$k."'";
      $data3 = mysqli_query($conn,$sql3);
      $row3=$data3->fetch_assoc();
      $sql4="SELECT teamid from participants WHERE pid='".$k."'";
      $data4 = mysqli_query($conn,$sql4);
      $row4=$data4->fetch_assoc();
      $sql5="SELECT tid FROM tourall WHERE tid='".$row['tid']."' AND id='".$row4['teamid']."'";
      $data5 = mysqli_query($conn,$sql5);
      //Determining to which single type tournaments the participants is registered to
      if(mysqli_num_rows($data3)==1 && $row['type']=='single'){

      ////////////////////////Flag
      $f=1;
      if($row['status']==0){
        $sta="InActive";
      }
      else if($row['status']==1){
        $sta="Active";
      }
        ?>
      <div class="card1" >
      <div class="container1">
  <div class="card" style="width:400px;" id="myButton<?php echo $row['tid'];?>">

    <div class="card-body">
    <script type="text/javascript">
    document.getElementById("myButton<?php echo $row['tid'];?>").onclick = function () {
      var tid = <?php echo $row['tid']; ?>;
        location.href ="showmatches.php?s="+tid;
    };
</script>
    <h4 class="card-title">Name of the Tournament : <?php echo $row['tname'];?></h4>
      <p class="card-text">Type : <?php echo $row['type'];?></p>
      <p class="card-text">Start date : <?php echo $row['start_date'];?></p>
      <p class="card-text">End date : <?php echo $row['end_date'];?></p>
      <p class="card-text">Status : <?php echo $sta;?></p>
      <p class="card-text">MinTeams : <?php echo $row['minteams'];?></p>
      <p class="card-text">Participants per team : <?php echo $row['pperteam'];?></p>
      <p class="card-text">Time : <?php echo $row['time'];?></p>
    </div>
  </div>

    <!--Popup form-->
            <div class="container-box" >
              <?php
              $sql5="SELECT * FROM tourall WHERE tid='".$row['tid']."' AND id='".$_SESSION['user']."'";
              $data5 = mysqli_query($conn,$sql5);
              $row5=$data5->fetch_assoc();
              if($row5['disqualify']==1){
                ?>
                <button type="button" class="btn-lg" disabled>Disqualified</button><br>
                <?php
              }
              else if($row['status']==1)
              {
              ?>
                <button type="button" class="btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['tid'];?>">Deregister</button><br>
                <?php
              }
              else{
                ?>
                <button type="button" class="btn-lg" disabled>Deregister</button><br>
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
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                                Deregister
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            if($row['type']=='single'){
                                ?>
                                <form method="POST" action="deregistersingle.php"> 
                                    <h3>Are you sure want to deregister?</h3>
                                    <h3>This tournament is of single type. Deregistering will remove your chance to participate</h3>
                                    <input type="hidden" name="tid" value="<?php echo $row['tid']?>">
                                    <input type="hidden" name="pid" value="<?php echo $_SESSION['user']?>">
                                    <input type="submit" name="submit" value="Withdraw">
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
<!--Popup form-->

        <?php
      }
      if(mysqli_num_rows($data5)==1 && $row['type']=='team'){
        //Determining to which team type tournament the participant has registered
      ///////////////////////////Flag
      $f=1;
      if($row['status']==0){
        $sta="InActive";
      }
      else if($row['status']==1){
        $sta="Active";
      }
        ?>
    <div class="card1">
      <div class="container1">
  <div class="card" style="width:400px;" id="myButton<?php echo $row['tid'];?>">

    <div class="card-body">
    <script type="text/javascript">
    document.getElementById("myButton<?php echo $row['tid'];?>").onclick = function () {
      var tid = <?php echo $row['tid']; ?>;
        location.href ="showmatches.php?s="+tid;
    };
</script>
    <h4 class="card-title">Name of the Tournament : <?php echo $row['tname'];?></h4>
      <p class="card-text">Type : <?php echo $row['type'];?></p>
      <p class="card-text">Start date : <?php echo $row['start_date'];?></p>
      <p class="card-text">End date : <?php echo $row['end_date'];?></p>
      <p class="card-text">Status : <?php echo $sta;?></p>
      <p class="card-text">MinTeams : <?php echo $row['minteams'];?></p>
      <p class="card-text">Participants per team : <?php echo $row['pperteam'];?></p>
      <p class="card-text">Time : <?php echo $row['time'];?></p>
    </div>
  </div>

    <!--Popup form-->
            <div class="container-box">
              <?php
              $sql2="SELECT * FROM participants WHERE pid='".$_SESSION['user']."'";
              $data2 = mysqli_query($conn,$sql2);
              $row2=$data2->fetch_assoc();
              $sql5="SELECT * FROM tourall WHERE tid='".$row['tid']."' AND id='".$row2['teamid']."'";
              $data5 = mysqli_query($conn,$sql5);
              $row5=$data5->fetch_assoc();
              if($row5['disqualify']==1){
                ?>
                <button type="button" class="btn-lg" disabled>Disqualified</button><br>
                <?php
              }
              else if($row['status']==1){
              ?>
                <button type="button" class="btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['tid'];?>">Deregister</button><br>
                <?php
              }
              else{
              ?>
              <button type="button" class="btn-lg" disabled>Deregister</button><br>
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
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                                Deregister
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            
                              $sql3="SELECT participants.teamid,team.captain FROM participants INNER JOIN team ON participants.teamid=team.teamid WHERE pid='".$_SESSION['user']."'";
                              $data3=mysqli_query($conn,$sql3);
                              $row3=$data3->fetch_assoc();
                              if($_SESSION['user']==$row3['captain']){
                                echo "You are the captain of the team !! You can deregister the team from the tournament";
                                ?>
                                <form method="POST" action="#">
                                  <input type='submit' value='deregister' name="deregister">
                                  <input type=hidden name="tid" value="<?php echo $row['tid'];?>">
                                  <input type=hidden name="teamid" value="<?php echo $row3['teamid'];?>">
                                  
                          
                                </form>
                                <?php
                                  if (isset($_POST["deregister"])){
                                    //$sql4="DELETE FROM tourall WHERE tid='".$row['tid']."' AND id='".$row3['teamid']."' ";
                                    $sql4="DELETE FROM tourall WHERE tid='".$_POST['tid']."' AND id='".$_POST['teamid']."' ";
                                    $data4=mysqli_query($conn,$sql4);
                                    if($data4){
                                      echo "<script>alert('Deregistered');</script>";
                                      echo "<script type='text/javascript'>window.location = 'yourtour.php';</script> ";
                                    }
                                  }
                              }
                              else{
                                echo "You are not the captain of the team !! Cannot degister from the tournament";
                                
                              }

                            
                            ?>
                            <div id="success_message" style="width:100%; height:100%; display:none; "> <h3>Sent your message successfully!</h3> </div>
                            <div id="error_message" style="width:100%; height:100%; display:none; "> <h3>Error</h3> Sorry there was an error sending your form. </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
    <?php

      }
    }
  }
    //Display that there are no registered tournaments
    $sql6="SELECT * FROM participants WHERE pid='".$_SESSION['user']."'";
    $data6=mysqli_query($conn,$sql6);
    $row6=$data6->fetch_assoc();
    $n6=mysqli_num_rows($data6);
    $teamid=$row6['teamid'];
    $sql7="SELECT * FROM tourall WHERE id='".$row6['teamid']."'";
    $data7=mysqli_query($conn,$sql7);
    $n7=mysqli_num_rows($data7);
    
    if($f==0){
    ?>
    <span class="noclick" ><h3 style="margin-top:300px;margin-left:500px">You haven't registered for any Tournament yet</h3></span>
    <?php
    }
    ?>
    

</body>
</html>
