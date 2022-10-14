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
<html lang="es" dir="ltr">

<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta charset="utf-8">

    <style>
    h2{
      
      text-align: center;
    }
    input{
        background-color: red;
        min-width: 100px;
        min-height: 40px;
        border-radius: 10%;
        float: right;
        margin-right: 700px;
    }
    table {
  width: 60%;
  margin-left: 20%;
  margin-right: 20%;
  margin-top: 40px;
  border: 1px solid blue;
  overflow-x: hidden;
  table-layout: auto;
  border: 1px solid black;
  

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
    </style>
</head>

<body>
<?php
$tid=$_POST['tid'];
$pid=$_POST['pid'];
$teamid=$_POST['teamid'];
$sql4="SELECT captain FROM team WHERE teamid='".$teamid."'";
$data4=mysqli_query($conn,$sql4);
$row4=$data4->fetch_assoc();

?>

<form method="POST" action="addall.php">
<input type=hidden name="tid" value= "<?php echo $tid;?>" readonly><br>
<input type=hidden name="pid" value= "<?php echo $pid;?>" readonly><br>
<input type=hidden name="teamid" value= "<?php echo $teamid;?>" readonly><br>
<input type=hidden name="captainpid" value= "<?php echo $row4['captain'];?>" readonly><br>
<?php
if($pid!=$row4['captain']){
    echo "<script>alert('You are not the captain of the team!! Cannot Register for the tournament')</script>";
    ?>
    
    <script type="text/javascript">
    window.location = 'upcomingtour.php';
    </script>      
<?php
}
else{
?>

<div class="addall">
<h2>Review all the team members and Register for the tournament</h2>
<?php
    $sql5="SELECT * FROM participants WHERE teamid='".$teamid."'";
    $data5=mysqli_query($conn,$sql5);
    $n=mysqli_num_rows($data5);
    ?>
    <table>
                <tr>
                    <th>Name of the candidate</th>
                    <th>Age of the candidate</th>
                    <th>Email of the candidate</th>
                    <th>Bloodgroup of the candidate</th>
                </tr>
    <?php
    if($n>0){
        while($row5=$data5->fetch_assoc()){

            ?>
            <tr>
                <td><?php echo $row5['pname'];?></td>
                <td><?php echo $row5['age'];?></td>
                <td><?php echo $row5['email'];?></td>
                <td><?php echo $row5['bloodgroup'];?></td>
            </tr>
            <?php
            
        }
    }
    
?>
<?php
}
?>
</table>
<br><br>
<input type="submit" value="Register" name="register1">
</form>
</div>

</body>


</html>