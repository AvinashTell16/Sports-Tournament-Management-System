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

.header button.logo {
  font-size: 25px;
  font-weight: bold;
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
  width: 100%;
  border: 1px solid blue;
  }
th, td {
  text-align: left;
  padding: 8px;
  }
/*table style end*/
</style>
<!--card style css-->

</head>
<body>
  <?php //Show disqualified teams
  $tid=$_GET['tid'];
  $sql="SELECT * FROM tourevents WHERE tid='".$tid."'";
  $data=mysqli_query($conn,$sql);
  $row=$data->fetch_assoc();
  ?>
  <div class="header">
  <a class="logo"><?php echo $row['tname'];?> Disqualified Teams</a>
  <div class="header-right">
  <a class="active" href="info.php" >All tournaments</a>
  <?php
    echo "<a class='active' href='details.php?s=".$tid."' style='margin-left:60px;'>All Teams</a>";
    ?>
    <a class="active" href="logout2.php" style="margin-left:60px;">Logout</a>

  </div>
</div>
<?php
$sql2="SELECT * FROM tourall where tid='".$tid."' AND disqualify=1";
$data2 = mysqli_query($conn,$sql2);
$n=mysqli_num_rows($data2);
if($n>0){
  while($row2=$data2->fetch_assoc()){
    $sql5="SELECT * FROM tourevents WHERE tid='".$row['tid']."'";
    $data5=mysqli_query($conn,$sql5);
    $row5=$data5->fetch_assoc();
    if($row5['type']=='team'){
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
      <input type="submit" name="teamqualify" style="color:white;background-color:green;border-radius:10%;" value="Qualify">
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
        
        //qualify team
        if(isset($_POST['teamqualify'])){
          $sql6="UPDATE tourall SET disqualify=0 WHERE tid='".$_POST['tid']."' AND id='".$row3['teamid']."'";
          $data6=mysqli_query($conn,$sql6);
          if($data6){
            echo "<script>alert('Team is Qualified succesfully')</script>";
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
}
else{
  //Display that no disqualified teams are yet
  ?>
  <span class="noclick" ><h3 style="margin-top:300px;margin-left:500px">No Teams are Disqualified for this tournament yet</h3></span>
  <?php
}

?>


</body>
</html> 