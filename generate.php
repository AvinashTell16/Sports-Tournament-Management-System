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

/* Add media queries for responsiveness - when the screen is 500px wide or less, stack the links on top of each other */
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

$tid=$_POST['tid'];
//echo $tid;
$close=$_POST['close'];
//echo $close;
//Close the registrations

if($close==1){
  $sql4="UPDATE tourevents set status=0 WHERE tid='".$_POST['tid']."'";
  $data4=mysqli_query($conn,$sql4);

}
if($close==2){
  $sql4="UPDATE tourevents set status=1 WHERE tid='".$_POST['tid']."'";
  $data4=mysqli_query($conn,$sql4);

}
if($close==1 && $_POST['gen']==1 && $_POST['finish']!=2){
  $sql1="DELETE FROM matches WHERE tid='".$tid."'";
  $data1=mysqli_query($conn,$sql1);
}

if($_POST['mid']!=0){
  //Updating the winner
  $sql1="UPDATE matches SET winner_id='".$_POST['pidwin']."' WHERE match_id='".$_POST['mid']."'";
  $data1=mysqli_query($conn,$sql1);
  if($_POST['finish']!=2){
  $sql1="UPDATE tourall SET wins=wins+1 WHERE tid='".$tid."' AND id='".$_POST['pidwin']."'";
  $data1=mysqli_query($conn,$sql1);
  }
}
if($_POST['final']==2){
  $sql1="UPDATE tourall SET wins=wins+1 WHERE tid='".$tid."' AND id='".$_POST['pidwin']."'";
  $data1=mysqli_query($conn,$sql1);

}

$sql="SELECT * FROM tourevents where tid='".$tid."'";
$data = mysqli_query($conn,$sql);
$n=mysqli_num_rows($data);
$row=$data->fetch_assoc();

//Count the no of winners until now
$sql12="SELECT SUM(wins) as wins FROM tourall WHERE tid='".$tid."'";
$data12=mysqli_query($conn,$sql12);
$row12=$data12->fetch_assoc();
$sql13="SELECT COUNT(tid) as count FROM tourall WHERE tid='".$tid."' AND disqualify=0";
$data13=mysqli_query($conn,$sql13);
$row13=$data13->fetch_assoc();
$c=$row13['count'];
$c=$c*($c-1);

?>

  <div class="header">
  <a class="logo"><?php echo $row['tname'];?></a>
  <div class="header-right">
  <a class="active" href="info.php" >All tournaments</a>
  <?php
  $sql11="SELECT * FROM matches WHERE tid='".$tid."'";
  $data11=mysqli_query($conn,$sql11);
  $n3=mysqli_num_rows($data11);
  if($n3>0){
    $_POST['gen']=1;
  }
  else if($close==1 && $n3==0){
    echo "<form method='POST' action='generate.php'>
    <input type=hidden name='gen' value=1 readonly>
    <input type=hidden name='close' value=1 readonly>
    <input type=hidden name='tid' value='".$tid."' readonly>
    <input type=hidden name='mid' value=0 readonly>
    <input type=hidden name='pidwin' value=0 readonly>";
    //Proceed to generate the final match
    if($row12['wins']==$c){
      echo "<input type=hidden name='final' value=1 readonly>";
    }
    else{
    echo "<input type=hidden name='final' value=0 readonly>";
    }
    if($row12['wins']==$c+1){
      echo "<input type=hidden name='finish' value=1 readonly>";
    }
    else{
    echo "<input type=hidden name='finish' value=0 readonly>";
    }
    echo "
      <button type='submit' name='gen1' style='background-color:dodgerblue;color:white;margin-left:60px'>Generate All Matches</button>
      </form>";
  }
  ?>
    <a class="active" href="logout2.php"style="margin-left:60px;">Logout</a>

  </div>
</div>
<?php
  

if($row['status']==1){
 // echo "The registrations are still active cannot generate matches<br>";
  //echo "To generate matches close the registrations<br>";
  echo "<form method='POST' action='generate.php'>
  <input type=hidden name='gen' value=0 readonly>
  <input type=hidden name='tid' value='".$tid."' readonly>
  <input type=hidden name='mid' value=0 readonly>
  <input type=hidden name='pidwin' value=0 readonly>
  <input type=hidden name='close' value=1 readonly>";
  //Proceed to generate the final match
  if($row12['wins']==$c){
    echo "<input type=hidden name='final' value=1 readonly>";
  }
  else{
  echo "<input type=hidden name='final' value=0 readonly>";
  }
  if($row12['wins']==$c+1){
    echo "<input type=hidden name='finish' value=1 readonly>";
  }
  else{
  echo "<input type=hidden name='finish' value=0 readonly>";
  }
  $sql22="SELECT DISTINCT * FROM tourall WHERE tid='".$tid."' AND disqualify!=1";
  $data22=mysqli_query($conn,$sql22);
  $n22=mysqli_num_rows($data22);
  if($n22<$row['minteams']){
    echo "<h3>Minimum required Teams are not registered for this tournament</h3>
    <h3>Cannot Close the Registrations yet</h3>
  <input style='float:right;margin-right:100px;min-height:50px;border-radius:10%;background-color:red;color:white;' type='submit' name='close1' value='Close Registrations' disabled>";
  }
  else{
    echo "<h3>The Number of required Teams are registered for this tournament</h3>
    <h3>Close registrations to start the matches</h3>
  <input style='float:right;margin-right:100px;min-height:50px;border-radius:10%;background-color:red;color:white;' type='submit' name='close1' value='Close Registrations'>";
  }
  echo "</form>";
}
else{
  echo "<h3>The registrations are closed</h3>";
  echo "<h3>The required number of teams are ready for the tournament</h3>";
  echo "<form method='POST' action='generate.php'>
  <input type=hidden name='gen' value=0 readonly>
  <input type=hidden name='tid' value='".$tid."' readonly>
  <input type=hidden name='mid' value=0 readonly>
  <input type=hidden name='pidwin' value=0 readonly>
  <input type=hidden name='close' value=2 readonly>";
  //Proceed to generate the final match
  if($row12['wins']==$c){
    echo "<input type=hidden name='final' value=1 readonly>";
  }
  else{
  echo "<input type=hidden name='final' value=0 readonly>";
  }
  if($row12['wins']==$c+1){
    echo "<input type=hidden name='finish' value=1 readonly>";
  }
  else{
  echo "<input type=hidden name='finish' value=0 readonly>";
  }
  
  echo "
  <input style='float:right;margin-right:100px;min-height:50px;border-radius:10%;background-color:red;color:white;' type='submit' name='close1' value='Open Registrations'>
  
  </form>";
  


  $sql5="SELECT * FROM matches WHERE tid='".$tid."'";
  $data5=mysqli_query($conn,$sql);
  if($_POST['gen']==1){
    //Status is inactive
    //Matches are already Generated
      $sql5="SELECT * FROM matches WHERE tid='".$tid."'";
      $data5=mysqli_query($conn,$sql5);
      $n1=mysqli_num_rows($data5);
      
      if($n1>0){
          //If matches are already generated for this tournament
          echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
          <th>Participant 1</th>  
          <th>Participant 2</th>   
          <th>Winner</th> 
          </thead>
          <tbody>";
          while($row5=$data5->fetch_assoc()){
            
            if($row['type']=='team'){
              //Generated matches for team tournaments
              $sql3="SELECT * FROM team WHERE teamid='".$row5['pid1']."'";
              $data3=mysqli_query($conn,$sql3);
              $row3=$data3->fetch_assoc();
              $sql9="SELECT * FROM team WHERE teamid='".$row5['pid2']."'";
              $data9=mysqli_query($conn,$sql9);
              $row9=$data9->fetch_assoc();
              if($row5['winner_id']==0){
                //If match winner is not yet decided
                echo "<tr><td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=1 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row5['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row5['pid1']."' readonly>";
                //Proceed to generate the final match
                if($row12['wins']==$c-1){
                  echo "<input type=hidden name='final' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='final' value=0 readonly>";
                }
                if($row12['wins']==$c+1){
                  echo "<input type=hidden name='finish' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='finish' value=0 readonly>";
                }
                echo "<button>".$row3['teamname']."</button></form></td>

                <td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=1 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row5['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row5['pid2']."' readonly>";
                //Proceed to generate the final match
                if($row12['wins']==$c-1){
                  echo "<input type=hidden name='final' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='final' value=0 readonly>";
                }
                if($row12['wins']==$c+1){
                  echo "<input type=hidden name='finish' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='finish' value=0 readonly>";
                }
                echo "<button>".$row9['teamname']."</button></td></form>";
              }
              else{
              echo "<tr><td>".$row3['teamname']."</td><td>".$row9['teamname']."</td>";
              }
              if($row5['winner_id']==0){
                //If match winner is not yet decided
                echo "<td></td></tr>";
              }
              else{
                $sql10="SELECT * FROM team WHERE teamid='".$row5['winner_id']."'";
                $data10=mysqli_query($conn,$sql10);
                $row10=$data10->fetch_assoc();
              echo "<td>".$row10['teamname']."</td></tr>";
              }
            }



            else{
              //for single type tournaments
              //Generated matches for single tournaments
              $sql3="SELECT * FROM participants WHERE pid='".$row5['pid1']."'";
              $data3=mysqli_query($conn,$sql3);
              $row3=$data3->fetch_assoc();
              $sql9="SELECT * FROM participants WHERE pid='".$row5['pid2']."'";
              $data9=mysqli_query($conn,$sql9);
              $row9=$data9->fetch_assoc();
              if($row5['winner_id']==0){
                //If match winner is not yet decided
                echo "<tr><td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=1 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row5['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row5['pid1']."' readonly>";
                //Proceed to generate the final match
                if($row12['wins']==$c-1){
                  echo "<input type=hidden name='final' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='final' value=0 readonly>";
                }
                if($row12['wins']==$c+1){
                  echo "<input type=hidden name='finish' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='finish' value=0 readonly>";
                }
                echo "<button>".$row3['pname']."</button></form></td>

                <td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=1 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row5['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row5['pid2']."' readonly>";
                //Proceed to generate the final match
                if($row12['wins']==$c-1){
                  echo "<input type=hidden name='final' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='final' value=0 readonly>";
                }
                if($row12['wins']==($c-1)){
                  echo "<input type=hidden name='finish' value=1 readonly>";
                }
                else if($row12['wins']==$c+1){
                  echo "<input type=hidden name='finish' value=1 readonly>";
                }
                else{
                echo "<input type=hidden name='finish' value=0 readonly>";
                }
                echo "<button>".$row9['pname']."</button></td></form>";
              }
              else{
              echo "<tr><td>".$row3['pname']."</td><td>".$row9['pname']."</td>";
              }
              if($row5['winner_id']==0){
                //If match winner is not yet decided
                echo "<td></td></tr>";
              }
              else{
                $sql10="SELECT * FROM participants WHERE pid='".$row5['winner_id']."'";
                $data10=mysqli_query($conn,$sql10);
                $row10=$data10->fetch_assoc();
              echo "<td>".$row10['pname']."</td></tr>";
              }
              //echo "<tr><td>".$row3['pname']."</td><td>".$row9['pname']."</td></tr>";

            }

          }
          echo "</tbody></table>";
          //echo $c;
          // echo $_POST['gen'];
          //echo $row12['wins'];
          //echo $c;
          // echo $_POST['final'];
          // echo $_POST['finish'];
          if($_POST['gen']==1 && $row12['wins']==$c && ($_POST['finish']==1 || $_POST['final']==1)){
            $a1=[];
            echo "<br><br>The final Winner is <br>";
            $sql14="SELECT * FROM tourall WHERE tid='".$tid."' ORDER BY wins desc limit 2";
            $data14=mysqli_query($conn,$sql14);
            $n14=mysqli_num_rows($data14);
            if($n14==2){
              while($row14=$data14->fetch_assoc()){
                array_push($a1,$row14['id']);
                
              }
            }

            //Final match for teams
            if($row['type']=='team'){
              //echo $row14['id'];
              echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>   
                  <th>Winner</th> 
                  </thead>
                  <tbody>";
            $sql17="SELECT * FROM team WHERE teamid='".$a1[0]."'";
            $data17=mysqli_query($conn,$sql17);
            $row17=$data17->fetch_assoc();
            $sql18="SELECT * FROM team WHERE teamid='".$a1[1]."'";
            $data18=mysqli_query($conn,$sql18);
            $row18=$data18->fetch_assoc();
            $sql19="SELECT match_id from matches ORDER BY match_id desc limit 1;";
            $data19=mysqli_query($conn,$sql19);
            $row19=$data19->fetch_assoc();
            $m1=$row19['match_id']+1;
            $sql20="INSERT INTO matches (match_id,tid,pid1,pid2) VALUES ($m1,$tid,$a1[0],$a1[1])";
            $data20=mysqli_query($conn,$sql20);
            $sql21="SELECT * FROM matches WHERE tid='$tid' ORDER BY match_id DESC LIMIT 1";
            $data21=mysqli_query($conn,$sql21);
            $row21=$data21->fetch_assoc();
            echo "<tr><td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=2 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row21['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row21['pid1']."' readonly>
                <input type=hidden name='final' value=2 readonly> 
                <input type=hidden name='finish' value=2 readonly> ";

            echo "<button>".$row17['teamname']."</button></form></td>";
            echo "<td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=2 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row21['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row21['pid2']."' readonly>
                <input type=hidden name='final' value=2 readonly> 
                <input type=hidden name='finish' value=2 readonly>";
            echo "<button>".$row18['teamname']."</button></form></td><td></td></tr></tbody></table>";
              
            }
            else{
              //Final match for single tournaments
              //echo $row14['id'];
              
              echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>   
                  <th>Winner</th> 
                  </thead>
                  <tbody>";
            $sql17="SELECT * FROM participants WHERE pid='".$a1[0]."'";
            $data17=mysqli_query($conn,$sql17);
            $row17=$data17->fetch_assoc();
            $sql18="SELECT * FROM participants WHERE pid='".$a1[1]."'";
            $data18=mysqli_query($conn,$sql18);
            $row18=$data18->fetch_assoc();
            $sql19="SELECT match_id from matches ORDER BY match_id desc limit 1;";
            $data19=mysqli_query($conn,$sql19);
            $row19=$data19->fetch_assoc();
            $m1=$row19['match_id']+1;
            $sql20="INSERT INTO matches (match_id,tid,pid1,pid2) VALUES ($m1,$tid,$a1[0],$a1[1])";
            $data20=mysqli_query($conn,$sql20);
            $sql21="SELECT * FROM matches WHERE tid='$tid' ORDER BY match_id DESC LIMIT 1";
            $data21=mysqli_query($conn,$sql21);
            $row21=$data21->fetch_assoc();
            echo "<tr><td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=2 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row21['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row21['pid1']."' readonly>
                <input type=hidden name='final' value=2 readonly> 
                <input type=hidden name='finish' value=2 readonly> ";

            echo "<button>".$row17['pname']."</button></form></td>";
            echo "<td><form method='POST' action='generate.php'>
                <input type=hidden name='gen' value=2 readonly>
                <input type=hidden name='tid' value='".$tid."' readonly>
                <input type=hidden name='close' value=0 readonly> 
                <input type=hidden name='mid' value='".$row21['match_id']."' readonly>
                <input type=hidden name='pidwin' value='".$row21['pid2']."' readonly>
                <input type=hidden name='final' value=2 readonly> 
                <input type=hidden name='finish' value=2 readonly>";
            echo "<button>".$row18['pname']."</button></form></td><td></td></tr></tbody></table>";
            }
          }
        }
      
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      else{
        //Status is inactive
        //Matches are need to be generated
        //If matches are not generated for this tournament
        $a=[];
        $pnames=[];
        $sql2="SELECT id FROM tourall WHERE tid='".$tid."' AND disqualify!=1";
        $data2=mysqli_query($conn,$sql2);
        $n=mysqli_num_rows($data2);
        if($n>0){
          while($row2=$data2->fetch_assoc()){
            array_push($a,$row2['id']);
            if($row['type']=='team'){
              //for team type tournaments
            $sql3="SELECT * FROM team WHERE teamid='".$row2['id']."'";
            $data3=mysqli_query($conn,$sql3);
            $row3=$data3->fetch_assoc();
            array_push($pnames,$row3['teamname']);
            }
            else{
              //for single type tournaments
              $sql3="SELECT * FROM participants WHERE pid='".$row2['id']."'";
              $data3=mysqli_query($conn,$sql3);
              $row3=$data3->fetch_assoc();
              array_push($pnames,$row3['pname']);
            }
          }
        }
        //shuffle($pnames);
          $sql6="SELECT match_id from matches ORDER BY match_id desc limit 0,1;";
          $data6=mysqli_query($conn,$sql6);
          $n2=mysqli_num_rows($data6);
          if($n2==0){
            $m=1;
          }
          else{
            $row6=$data6->fetch_assoc();
            $m=$row6['match_id']+1;
          }
          echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
          <th>Participant 1</th>  
          <th>Participant 2</th>   
          <th>Winner</th> 
          </thead>
          <tbody>";
        for($i=0;$i<$n;$i++){
          for($j=0;$j<$n;$j++){
            if($i==$j){
              continue;
            }
            else{
              echo "<tr><td>".$pnames[$i]."</td><td>".$pnames[$j]."</td><td></td></tr>";
              $sql7="INSERT INTO matches (match_id,tid,pid1,pid2) VALUES($m,$tid,$a[$i],$a[$j])";
              $data7=mysqli_query($conn,$sql7);
              $m=$m+1;
            }
          }
        }
        echo "</table><br><br>
        <form method='POST' action='generate.php'>
        Click OK to fix this tournament
        <input type=hidden name='gen' value=1 readonly>
        <input type=hidden name='tid' value='".$tid."' readonly>
        <input type=hidden name='close' value=0 readonly> 
        <input type=hidden name='mid' value=0 readonly>
        <input type=hidden name='pidwin' value=0 readonly>
        <input type=hidden name='final' value=0 readonly>
        <input type='submit' name='ok' value='create'>
        </form>";
      }
  }
  //From details page 1,3,3,2,0
  //From final page 1,3,3,2,9,2
  //  echo $_POST['gen'];
  //  echo $row12['wins'];
  //  echo $c+1;
  //  echo $_POST['finish'];
  //  echo $_POST['mid'];
  //  echo $_POST['pidwin'];
  if($_POST['gen']==1 && $row12['wins']==$c+1 && ($_POST['finish']==2)){
            
    $sql19="UPDATE matches SET winner_id='".$_POST['pidwin']."' WHERE match_id='".$_POST['mid']."'";
    $data19=mysqli_query($conn,$sql19);
    
    $sql19="SELECT * from matches WHERE match_id='".$_POST['mid']."'";
    $data19=mysqli_query($conn,$sql19);
    $row19=$data19->fetch_assoc();
    if($row['type']=='single'){
    $sql17="SELECT * FROM participants WHERE pid='".$row19['pid1']."'";
    $data17=mysqli_query($conn,$sql17);
    $row17=$data17->fetch_assoc();
    //echo $row17['pname'];
    $sql18="SELECT * FROM participants WHERE pid='".$row19['pid2']."'";
    $data18=mysqli_query($conn,$sql18);
    $row18=$data18->fetch_assoc();
    //echo $row18['pname'];
    $sql20="SELECT * FROM participants WHERE pid='".$row19['winner_id']."'";
    $data20=mysqli_query($conn,$sql20);
    $row20=$data20->fetch_assoc();
    echo "<br><br><marquee behavior='scroll' direction='left' scrollamount='12' style='font-size: xx-large;'>"
            .$row20['pname']." is the Winner of the ".$row['tname']." Tournament</marquee>";
    }
    else{
      $sql17="SELECT * FROM team WHERE teamid='".$row19['pid1']."'";
    $data17=mysqli_query($conn,$sql17);
    $row17=$data17->fetch_assoc();
    //echo $row17['pname'];
    $sql18="SELECT * FROM team WHERE teamid='".$row19['pid2']."'";
    $data18=mysqli_query($conn,$sql18);
    $row18=$data18->fetch_assoc();
    //echo $row18['pname'];
    $sql20="SELECT * FROM team WHERE teamid='".$row19['winner_id']."'";
    $data20=mysqli_query($conn,$sql20);
    $row20=$data20->fetch_assoc();
    echo "<br><br><marquee behavior='scroll' direction='left' scrollamount='12' style='font-size: xx-large;'>The team "
            .$row20['teamname']." is the Winner of the ".$row['tname']." Tournament</marquee>";
    }
    /*echo "<br><br><table style='width:80%;border:1px solid blue;margin-left:50px;'><thead style='border:1px solid blue;background-color:grey;'>
                  <th>Participant 1</th>  
                  <th>Participant 2</th>   
                  <th>Winner</th> 
                  </thead>
                  <tbody>";
            echo "<tr><td>".$row17['pname']."</td><td>".$row18['pname']."</td><td>".$row20['pname']."</td></tr></tbody></table>";
            */
    

}
else if($row12['wins']==$c+1){
  $sql19="SELECT * from matches ORDER BY match_id DESC LIMIT 1";
    $data19=mysqli_query($conn,$sql19);
    $row19=$data19->fetch_assoc();
    if($row['type']=='single'){
    $sql17="SELECT * FROM participants WHERE pid='".$row19['pid1']."'";
    $data17=mysqli_query($conn,$sql17);
    $row17=$data17->fetch_assoc();
    //echo $row17['pname'];
    $sql18="SELECT * FROM participants WHERE pid='".$row19['pid2']."'";
    $data18=mysqli_query($conn,$sql18);
    $row18=$data18->fetch_assoc();
    //echo $row18['pname'];
    $sql20="SELECT * FROM participants WHERE pid='".$row19['winner_id']."'";
    $data20=mysqli_query($conn,$sql20);
    $row20=$data20->fetch_assoc();
    echo "<br><br><marquee behavior='scroll' direction='left' scrollamount='12' style='font-size: xx-large;'>"
            .$row20['pname']." is the Winner of the ".$row['tname']." Tournament</marquee>";
    }
    else{
      $sql17="SELECT * FROM team WHERE teamid='".$row19['pid1']."'";
    $data17=mysqli_query($conn,$sql17);
    $row17=$data17->fetch_assoc();
    //echo $row17['pname'];
    $sql18="SELECT * FROM team WHERE teamid='".$row19['pid2']."'";
    $data18=mysqli_query($conn,$sql18);
    $row18=$data18->fetch_assoc();
    //echo $row18['pname'];
    $sql20="SELECT * FROM team WHERE teamid='".$row19['winner_id']."'";
    $data20=mysqli_query($conn,$sql20);
    $row20=$data20->fetch_assoc();
    echo "<br><br><marquee behavior='scroll' direction='left' scrollamount='12' style='font-size: xx-large;'>The team "
            .$row20['teamname']." is the Winner of the ".$row['tname']." Tournament</marquee>";
    }
}
}

?>
</body>
</html>