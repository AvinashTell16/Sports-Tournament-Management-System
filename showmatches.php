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
  <title>Matches schedule</title>
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
</style>
<!--card style css-->

</head>
<body>

<?php
$tid=$_GET['s'];
?>
<div class="header">
  <a class="logo"><?php 
  $sql="SELECT * FROM tourevents WHERE tid='".$tid."'";
  $data=mysqli_query($conn,$sql);
  $row=$data->fetch_assoc();
  echo $row['tname'];?></a>
  <div class="header-right">
  <a class="active" href="yourtour.php" >All tournaments</a>
    <a class="active" href="logout3.php"style="margin-left:60px;">Logout</a>

  </div>
</div>
<?php


$sql="SELECT * FROM tourevents WHERE tid='".$tid."'";
$data=mysqli_query($conn,$sql);
$row=$data->fetch_assoc();
$sql1="SELECT * FROM matches WHERE tid='".$tid."'";
$data1=mysqli_query($conn,$sql1);
$n1=mysqli_num_rows($data1);
$row1=$data1->fetch_assoc();
$sql3="SELECT * FROM participants WHERE pid='".$_SESSION['user']."'";
$data3=mysqli_query($conn,$sql3);
$row3=$data3->fetch_assoc();
if($n1>0){
    if($row['type']=='team'){
        echo "<h2>Upcoming matches are</h2>";
        $sql2="SELECT * FROM matches WHERE tid='".$tid."' AND (pid1='".$row3['teamid']."' OR pid2='".$row3['teamid']."') AND winner_id=0";
        $data2=mysqli_query($conn,$sql2);
        $n2=mysqli_num_rows($data2);
        if($n2>0){
            echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>
                  </thead>
                  <tbody>";
            if($n2>0){
                while($row2=$data2->fetch_assoc()){
                    $sql4="SELECT * FROM team WHERE teamid='".$row2['pid1']."'";
                    $data4=mysqli_query($conn,$sql4);
                    $row4=$data4->fetch_assoc();
                    $sql5="SELECT * FROM team WHERE teamid='".$row2['pid2']."'";
                    $data5=mysqli_query($conn,$sql5);
                    $row5=$data5->fetch_assoc();

                    echo "<tr><td>".$row4['teamname']."</td><td>".$row5['teamname']."</td></tr>";

                }
                echo "</tbody></table>";
            }
        }
        else{
            //No upcoming matches
            echo "<span class='noclick' ><h3>All the matches are completed for this tournament</h3></span>";

        }
        
    }
    else{
        //For single tournaments
        echo "<h2>Upcoming matches are</h2>";
        $sql2="SELECT * FROM matches WHERE tid='".$tid."' AND (pid1='".$row3['pid']."' OR pid2='".$row3['pid']."') AND winner_id=0";
        $data2=mysqli_query($conn,$sql2);
        $n2=mysqli_num_rows($data2);
        if($n2>0){
            echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>
                  
                  </thead>
                  <tbody>";
            if($n2>0){
                while($row2=$data2->fetch_assoc()){
                    $sql4="SELECT * FROM participants WHERE pid='".$row2['pid1']."'";
                    $data4=mysqli_query($conn,$sql4);
                    $row4=$data4->fetch_assoc();
                    $sql5="SELECT * FROM participants WHERE pid='".$row2['pid2']."'";
                    $data5=mysqli_query($conn,$sql5);
                    $row5=$data5->fetch_assoc();

                    echo "<tr><td>".$row4['pname']."</td><td>".$row5['pname']."</td></tr>";

                }
                echo "</tbody></table>";
            }
        }
        else{
            //No upcoming matches
            echo "<span class='noclick' ><h3>All the matches are completed for this tournament</h3></span>";

        }

    }
    //Completed matches of teams and singles
    if($row['type']=='team'){
        echo "<h2>Completed matches are</h2>";
        $sql2="SELECT * FROM matches WHERE tid='".$tid."' AND (pid1='".$row3['teamid']."' OR pid2='".$row3['teamid']."') AND winner_id!=0";
        $data2=mysqli_query($conn,$sql2);
        $n2=mysqli_num_rows($data2);
        if($n2>0){
            echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>
                  <th>Winner</th>
                  </thead>
                  <tbody>";
            if($n2>0){
                while($row2=$data2->fetch_assoc()){
                    $sql4="SELECT * FROM team WHERE teamid='".$row2['pid1']."'";
                    $data4=mysqli_query($conn,$sql4);
                    $row4=$data4->fetch_assoc();
                    $sql5="SELECT * FROM team WHERE teamid='".$row2['pid2']."'";
                    $data5=mysqli_query($conn,$sql5);
                    $row5=$data5->fetch_assoc();
                    $sql6="SELECT * FROM team WHERE teamid='".$row2['winner_id']."'";
                    $data6=mysqli_query($conn,$sql6);
                    $row6=$data6->fetch_assoc();

                    echo "<tr><td>".$row4['teamname']."</td><td>".$row5['teamname']."</td><td>".$row6['teamname']."</td></tr>";

                }
                echo "</tbody></table>";
            }
        }
        else{
            //No upcoming matches
            echo "<span class='noclick' ><h3>No matches are completed for this tournament</h3></span>";

        }
        
    }
    else{
        //For single tournaments
        echo "<h2>Completed matches are</h2>";
        $sql2="SELECT * FROM matches WHERE tid='".$tid."' AND (pid1='".$row3['pid']."' OR pid2='".$row3['pid']."') AND winner_id!=0";
        $data2=mysqli_query($conn,$sql2);
        $n2=mysqli_num_rows($data2);
        if($n2>0){
            echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>
                  <th>Winner</th>
                  </thead>
                  <tbody>";
            if($n2>0){
                while($row2=$data2->fetch_assoc()){
                    $sql4="SELECT * FROM participants WHERE pid='".$row2['pid1']."'";
                    $data4=mysqli_query($conn,$sql4);
                    $row4=$data4->fetch_assoc();
                    $sql5="SELECT * FROM participants WHERE pid='".$row2['pid2']."'";
                    $data5=mysqli_query($conn,$sql5);
                    $row5=$data5->fetch_assoc();
                    $sql6="SELECT * FROM participants WHERE pid='".$row2['winner_id']."'";
                    $data6=mysqli_query($conn,$sql6);
                    $row6=$data6->fetch_assoc();

                    echo "<tr><td>".$row4['pname']."</td><td>".$row5['pname']."</td><td>".$row6['pname']."</td></tr>";

                }
                echo "</tbody></table>";
            }
        }
        else{
            //No upcoming matches
            echo "<span class='noclick' ><h3>No matches are completed for this tournament</h3></span>";

        }

    }
    ////Showing the winner
    $sql12="SELECT SUM(wins) as wins FROM tourall WHERE tid='".$tid."'";
    $data12=mysqli_query($conn,$sql12);
    $row12=$data12->fetch_assoc();
    $sql13="SELECT COUNT(tid) as count FROM tourall WHERE tid='".$tid."' AND disqualify=0";
    $data13=mysqli_query($conn,$sql13);
    $row13=$data13->fetch_assoc();
    $c=$row13['count'];
    $c=$c*($c-1);
    if($row12['wins']==$c+1){
        $sql21="SELECT * FROM matches WHERE tid='$tid' ORDER BY match_id DESC LIMIT 1";
        $data21=mysqli_query($conn,$sql21);
        $row21=$data21->fetch_assoc();
        if($row['type']=='single'){
            //Display single type tournament winner
            $sql20="SELECT * FROM participants WHERE pid='".$row21['winner_id']."'";
            $data20=mysqli_query($conn,$sql20);
            $row20=$data20->fetch_assoc();
            echo "<br><br><marquee behavior='scroll' direction='left' scrollamount='12' style='font-size: xx-large;'>"
            .$row20['pname']." is the Winner of the ".$row['tname']." Tournament</marquee>";
        }
        else{
            //Display team type tournament winner
            $sql20="SELECT * FROM team WHERE teamid='".$row21['winner_id']."'";
            $data20=mysqli_query($conn,$sql20);
            $row20=$data20->fetch_assoc();
            echo "<br><br><marquee behavior='scroll' direction='left' scrollamount='12' style='font-size: xx-large;'>"
            .$row20['teamname']." is the Winner of the ".$row['tname']." Tournament</marquee>";

        }
    }

    
}
else{
    //The matches are not yet generated 
    echo "<span class='noclick' ><h1 style='margin-top:300px;margin-left:400px'>The matches are not generated for this Tournament yet</h1></span>";
}
?>

</body>
</html>