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
  <title>Tournament Info</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--Popup form-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--Popup Form-->

<!--card style css-->
<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

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
  background-color: #333465;
  border: none;
  outline: none;
  color: white;
  box-shadow:  0 4px 8px 0 rgba(0,0,0,0.2);
  margin-right: 10px;
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
    
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <img src="tour.png" width="150px" height="50px">
    </div>
    <ul class="nav navbar-nav">
    <li  class="active"><a href="info.php">All Tournaments</a></li>
      <li><a href="createtournament.php">Create Tournament</a></li>
    </ul>
    <input type="button" value="Logout" style="float:right;width: 100px;margin-top:10px;margin-bottom:10px;background-color:red;border-radius:5px;border:None;color:white;" onclick="window.location='logout2.php';"></h1>
  </div>
</nav>

<?php
$sql="SELECT * FROM tourevents";
// WHERE tourend_date<'2022-08-30' AND end_date>'2022-08-10'";

$data = mysqli_query($conn,$sql);
$n=mysqli_num_rows($data);
if($n>0){
  while($row=$data->fetch_assoc()){
    ?>
    <?php
      //Showing the status as inactive and the candidates cannot register or deregister
      //Making the status as inactive when time is completed
      date_default_timezone_set('Asia/Kolkata');
      $date = date('Y-m-d h:i:s');
      $k=$row['end_date'].$row['time'];
      $date1 = strtotime($k);
      $date1=date('Y-m-d h:i:s',$date1);
      if($date>$date1){
        $sql1="UPDATE tourevents SET status=0 WHERE tid='".$row['tid']."'";
        $data1=mysqli_query($conn,$sql1);
      }
      if($row['status']==0){
        $sta='InActive';
      }
      else if($row['status']==1){
        $sta='Active';
      }
      ?>
      
    <div class="card1" style="margin-left:30px;">
  <div class="card" style="width:400px;" id="myButton<?php echo $row['tid'];?>">
  

    <div class="card-body" >
    <script type="text/javascript">
    document.getElementById("myButton<?php echo $row['tid'];?>").onclick = function () {
      var tid = <?php echo $row['tid']; ?>;
        location.href ="details.php?s="+tid;
    };
</script>
      <h4 class="card-title">Name of the Tournament : <?php echo $row['tname'];?></h4>
      <p class="card-text">Type : <?php echo $row['type'];?></p>
      <p class="card-text">Start date : <?php echo $row['start_date'];?></p>
      <p class="card-text">End date : <?php echo $row['end_date'];?></p>
      <p class="card-text">Status : <?php echo $sta;?></p>
      <p class="card-text">MinTeams : <?php echo $row['minteams'];?></p>
      <p class="card-text">Participants per team : <?php echo $row['pperteam'];?></p>
      
      <!--Display Team ids-->
      <p class="card-text">Time : <?php echo $row['time'];?></p>
      <p class="card-text">Tounament end date : <?php echo $row['tourend_date'];?></p>

    </div>
  </div>
    <!--Popup form-->
            <div class="container-box" style="display:flex;align-items:baseline;">
                <button type="button" class="btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['tid'];?>">Edit Details</button>
                <button type="button" style="margin-bottom:20px;" class="cancel btn-lg" data-toggle="modal" data-target="#myModal<?php echo $row['tid'];?>cancel">Cancel Tournament</button>
            
            </div>
            <!-- Modal -->
            <div id="myModal<?php echo $row['tid'];?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="display:inline;">
                                Edit Details
                            </h4>
                        </div>
                        <div class="modal-body">
                        <form action="edittour.php" method="post">
                                Tournament ID:
                                <input type="text" value="<?php echo $row['tid'];?>" name="tid" readonly><br><br>
                                Tournament name:
                                <input type="text" name="tname" required class="smalltext" value='<?php echo $row['tname'];?>'>
                                Type:
                                <select name="type" required class="smalltext">
                                <option selected><?php echo $row['type'];?></option>   
                                
                                </select><br><br>
                                Minteams                                                                      
                                <input type="text" name="minteams" required class="bigtext" value= '<?php echo $row['minteams'];?>'><br><br>
                                Participants per team                                                                      
                                <input type="text" name="pperteam" required class="bigtext" value='<?php echo $row['pperteam'];?>'><br><br>
                                Status
                                <select name="status" required class="smalltext">
                                <option selected><?php echo $sta;?></option> 
                                <?php
                                if($row['status']==NULL){
                                ?>
                                <option>Active</option>  
                                <option>InActive</option>  
                                <?php
                                } 
                                else if($row['status']==1){
                                ?>
                                <option>InActive</option>  
                                <?php
                                } 
                                else{
                                ?>
                                <option>Active</option>
                                <?php
                                }
                                ?>
                                </select>
                                Start Date:  
                                <input type="date" name="startdate" required class="smalltext" value='<?php echo $row['start_date'];?>'>
                                End Date:  
                                <input type="date" name="enddate" required class="smalltext" value='<?php echo $row['end_date'];?>'><br><br>
                                Event Time:  
                                <input type="time" name="time" required class="smalltext" value='<?php echo $row['time'];?>'><br><br>
                                  
                                <input type="submit" value="Submit">
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>




            <div class="container-box" style="vertical-align: middle;">
                </div>
            <!-- Modal -->
            <div id="myModal<?php echo $row['tid'];?>cancel" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                                Cancel the Tournament
                            </h4>
                        </div>
                        <div class="modal-body">
                          <h3>Are you sure to cancel the tournament??</h3>
                        <form method="POST" action="removetour.php">
                                  <input type='submit' value='cancel' name="cancel">
                                  <input type=hidden name="tid" value= "<?php echo $row['tid'];?>" readonly>
                                  <input type=hidden name="type" value= "<?php echo $row['type'];?>" readonly>
                                </form>
                                
                          
                        </div>
                    </div>
                </div>
            </div>
  </div>
  
<!--Popup form-->
    <?php
  }
}

?>


</body>
</html>
