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
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Teams Info</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!--card style css-->
<style>
.card1 {
float: left;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 45%;
  padding: 0 40px;
  margin-top:100px;
  margin-right: 50px;
  margin-bottom: 50px;
  margin-left:20px;
  border:10px;
  min-height:250px;
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
/*header css start*/
.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header button {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 25px;
  border-radius: 4px;
  border:none;
}


.header button:hover {
  background-color: #ddd;
  color: black;
}

.header button.active {
  background-color: dodgerblue;
  color: white;
}
.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header h3 {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;
  }
}
/*header css end*/
/*table style start*/
table {
  width: 60%;
  margin-left: 20%;
  margin-right: 20%;
  margin-top: 40px;
  border: 1px solid blue;
  overflow-x: hidden;
  table-layout: auto;
  

  }
th, td {
  text-align:center;
  vertical-align: center;
  padding-bottom: 6px;
  padding-top: 6px;
  font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
  font-weight :900;
  text-transform: uppercase;
  letter-spacing: 1px;
  }
th{
  background-color: white;
  color: red;
}

tr:nth-child(2n){
  background-color: #7f53ac;
background-image: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);
}
tr:nth-child(2n+1){
  background-color: #045de9;
background-image: linear-gradient(315deg, #045de9 0%, #09c6f9 74%);
}
/*table style end*/
form {
    display: inline;
}
#disq
{
  color:white;
  background-color:red;
  border-radius:7%;
  outline:none;
  border:none;
  width:100px;
  height: 30px;
  line-height: 30px;
  letter-spacing: 1px;
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}
</style>
<!--card style css-->

</head>
<body>
  
<?php
$tid=$_GET['s'];
$sql="SELECT * FROM tourevents where tid='".$tid."'";
$data = mysqli_query($conn,$sql);
$n=mysqli_num_rows($data);
$row=$data->fetch_assoc();
$sql12="SELECT SUM(wins) as wins FROM tourall WHERE tid='".$tid."'";
$data12=mysqli_query($conn,$sql12);
$row12=$data12->fetch_assoc();
$sql13="SELECT COUNT(tid) as count FROM tourall WHERE tid='".$tid."'";
$data13=mysqli_query($conn,$sql13);
$row13=$data13->fetch_assoc();
$c=$row13['count'];
$c=$c*($c-1);

if($row['type']=='single'){
  ?>
  <div class="header">
  <a class="logo"><?php echo $row['tname'];?></a>
  <div class="header-right">
  <a class="active" href="info.php" >All tournaments</a>
  <form method="POST" action="generate.php">
    <?php
    $sql1="SELECT * FROM tourevents WHERE tid='".$tid."'";
    $data1=mysqli_query($conn,$sql1);
    $row1=$data1->fetch_assoc();
    if($row1['status']==0){
      $k2=1;
    }
    else{
      $k2=0;
    }
    ?>
  <input type=hidden name='gen' value=0 readonly>
    <input type=hidden name='close' value="<?php echo $k2;?>" readonly>
    <input type=hidden name='final' value=0 readonly>
    <?php
    
    if($row12['wins']==$c+1){
      ?>
      <input type=hidden name='finish' value=2>
      <?php
      $sql19="SELECT * from matches WHERE tid='$tid' ORDER BY match_id desc LIMIT 1";
      $data19=mysqli_query($conn,$sql19);
      $row19=$data19->fetch_assoc();
      ?>
      <input type=hidden name='mid' value=<?php echo $row19['match_id'];?> readonly>
      <input type=hidden name='pidwin' value=<?php echo $row19['winner_id'];?> readonly>
      <?php
    }
    else if($row12['wins']==$c){
      ?>
      <input type=hidden name='finish' value=1>
      <input type=hidden name='mid' value=0 readonly>
      <input type=hidden name='pidwin' value=0 readonly>
      <?php
    }
    else{
      ?>
      <input type=hidden name='finish' value=0>
      <input type=hidden name='mid' value=0 readonly>
      <input type=hidden name='pidwin' value=0 readonly>
      <?php
    }
    ?>
    
  <button type="submit" name="tid" value="<?php echo $tid;?>" style="background-color:dodgerblue;color:white;margin-left:60px">Generate Matches</button>
</form>

  <?php
  echo "<a class='active' href='disparti.php?tid=".$tid."' style='margin-left:60px;'>Disqualified People</a>";
  ?>
    <a class="active" href="logout2.php"style="margin-left:60px;">Logout</a>

  </div>
</div>
<?php
  //disqualify of single participants
    $sql2="SELECT * FROM tourall where tid='".$tid."' AND disqualify=0";
    $data2 = mysqli_query($conn,$sql2);
    $n=mysqli_num_rows($data2);
    if($n>0){
      ?>
        <div style="overflow-x:auto;">
         <table>
            <tr style="border-bottom:1pt solid blue;">
               <th>Participant Name</th>
               <th>Age</th>
               <th>Email</th>
               <th>Address</th>
               <th>Blood Group</th>
               <th>Disqualify</th>
            </tr>
      <?php
        while($row2=$data2->fetch_assoc()){
        $sql3="SELECT * FROM participants where pid='".$row2['id']."'";
        $data3 = mysqli_query($conn,$sql3);
        $row3=$data3->fetch_assoc();
      ?>
          <tr>
               <td><?php echo $row3['pname']?></td>
               <td><?php echo $row3['age']?></td>
               <td><?php echo $row3['email']?></td>
               <td><?php echo $row3['address']?></td>
               <td><?php echo $row3['bloodgroup']?></td>
               <form method="POST" action="#">
                <input type=hidden name="tid" value=<?php echo $tid;?>>
                <input type=hidden name="pid" value=<?php echo $row2['id'];?>>
               <td><input type="submit" name="partidis" id='disq' value="Disqualify"></td>
              </form>
               <td></td>
          </tr>
      <?php
      
    }
    if(isset($_POST['partidis'])){
      $sql5="UPDATE tourall SET disqualify=1 WHERE tid='".$_POST['tid']."' AND id='".$_POST['pid']."'";
      $data5=mysqli_query($conn,$sql5);
      if($data5){
        echo "<script>alert('Participant is disqualified succesfully')</script>";
        echo '<script type="text/javascript">window.location = "details.php?s='.$tid.'";</script> ';
      }
    }
    ?>
    </table>
    <?php
    }
    else{
      //Display that no participants are registered yet
      ?>
      <span class="noclick" ><h3 style="margin-top:300px;margin-left:500px">No Participants are Registered for this tournament yet</h3></span>
      <?php
    }
  }

//Disqualification of teams
else{
  ?>
  <div class="header">
  <a class="logo"><?php echo $row['tname'];?></a>
  <div class="header-right">
  <a class="active" href="info.php" >All tournaments</a>
  
  <form method="POST" action="generate.php">
    <?php
    $sql1="SELECT * FROM tourevents WHERE tid='".$tid."'";
    $data1=mysqli_query($conn,$sql1);
    $row1=$data1->fetch_assoc();
    if($row1['status']==0){
      $k2=1;
    }
    else{
      $k2=0;
    }
    ?>
  <input type=hidden name='gen' value=0 readonly>
    <input type=hidden name='close' value="<?php echo $k2;?>" readonly>
    <input type=hidden name='final' value=0 readonly>
    <?php
    if($row12['wins']==$c+1){
      ?>
      <input type=hidden name='finish' value=2>
      <?php
      $sql19="SELECT * from matches WHERE tid='$tid' ORDER BY match_id desc LIMIT 1";
      $data19=mysqli_query($conn,$sql19);
      $row19=$data19->fetch_assoc();
      ?>
      <input type=hidden name='mid' value=<?php echo $row19['match_id'];?> readonly>
      <input type=hidden name='pidwin' value=<?php echo $row19['winner_id'];?> readonly>
      <?php
    }
    else if($row12['wins']==$c){
      ?>
      <input type=hidden name='finish' value=1>
      <input type=hidden name='mid' value=0 readonly>
      <input type=hidden name='pidwin' value=0 readonly>
      <?php
    }
    else{
      ?>
      <input type=hidden name='finish' value=0>
      <input type=hidden name='mid' value=0 readonly>
      <input type=hidden name='pidwin' value=0 readonly>
      <?php
    }
    ?>
  <button type="submit" name="tid" value="<?php echo $tid;?>" style="background-color:dodgerblue;color:white;margin-left:60px">Generate Matches</button>
</form>
  <?php
  
  echo "<a class='active' href='disteams.php?tid=".$tid."' style='margin-left:60px;'>Disqualified Teams</a>";
  ?>
    <a class="active" href="logout2.php" style="margin-left:60px;">Logout</a>

  </div>
</div>
<?php
$sql2="SELECT * FROM tourall where tid='".$tid."' AND disqualify=0";
$data2 = mysqli_query($conn,$sql2);
$n=mysqli_num_rows($data2);
if($n>0){
  while($row2=$data2->fetch_assoc()){

    $sql3="SELECT * FROM team WHERE teamid='".$row2['id']."'";
    $data3=mysqli_query($conn,$sql3);
    $row3=$data3->fetch_assoc();
    $sql4="SELECT * FROM participants WHERE teamid='".$row2['id']."'";
    $data4=mysqli_query($conn,$sql4);
    $n1=mysqli_num_rows($data4);
    ?>
    <div class="card1 bg-warning">
      <div class="container1">
  <div class="card" style="width:400px;">
  
    <div class="card-body">
        <div style="display:inline-block;">
      <h3 class="card-title" >Name of the Team : <?php echo $row3['teamname'];?></h3>
      <form method="POST" action="#">
      <input type=hidden name="tid" value=<?php echo $tid;?>>
      <input type=hidden name="teamid" value=<?php echo $row3['teamid'];?>>
      <input type="submit" name="teamdis" style="color:white;background-color:red;border-radius:10%;" value="Disqualify">
      </form>
        </div><br><hr>
      <?php
        if($n1>0){
            $k=1;
            while($row4=$data4->fetch_assoc()){
                ?>
                <p class="card-text" style="display:inline-block;">Team Member <?php echo $k?> : <?php echo $row4['pname'];?>
                <?php
                if($row3['captain']==$row4['pid']){
                    ?>
                    <div style="float:right;"><!--<a style="padding-right:10px" href="#">✔️</a>--></div></p>
                    
                    <?php
                    $k=$k+1;
                }
                else{
                ?>
                <div style="float:right;"><!--<a style="padding-right:10px" href="#">✔️</a><a href="removepartiteam.php?s=<?php //echo $row4['pid']?>">❌</a>--></div></p>
                
                <?php
                $k=$k+1;
                }
            }
        }
        
        //disqualify team
        if(isset($_POST['teamdis'])){
          $sql6="UPDATE tourall SET disqualify=1 WHERE tid='".$_POST['tid']."' AND id='".$_POST['teamid']."'";
          $data6=mysqli_query($conn,$sql6);
          if($data6){
            echo "<script>alert('Team is disqualified succesfully')</script>";
            echo '<script type="text/javascript">window.location = "details.php?s='.$tid.'";</script> ';
          }
        }
      ?>
      
        </div>
      </div>
  </div>
</div>
    <?php
  }
}
else{
  //Display that no teams are registered yet
  ?>
  <span class="noclick" ><h3 style="margin-top:300px;margin-left:500px">No Teams are Registered for this tournament yet</h3></span>
  <?php
}
}

?>
</body>
</html> 