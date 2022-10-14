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
    <link rel="stylesheet" type="text/css" href="main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    if($_POST['teamid']==NULL){
            
        ?>
    <div class="main">
        <div class="container a-container" id="a-container">
            <form class="form" id="a-form" method="POST" action="registerteam.php">
                <h2 class="form_title title">Create Team</h2>
                <input class="form__input" type="text" placeholder="Team Name" name="teamname" required>
                <input class="form__input" type=hidden placeholder="count" name="count" required>
                <input type=hidden name="tid" value= "<?php echo $_POST['tid'];?>" readonly>
                <input type=hidden name="pid" value= "<?php echo $_POST['pid'];?>" readonly>
                <input type="submit" class="switch__button button " value="Create Team">
            </form>
        </div>



        <div class="container b-container" id="b-container">
            <form class="form" id="b-form" method="POST" action="jointeam.php">
                <h3 class="form_title title">Join in a existing team</h3>
                <?php
                $sql2="SELECT id from tourall WHERE tid='".$_POST['tid']."' AND disqualify=0";
                $data2=mysqli_query($conn,$sql2);
                $n2=mysqli_num_rows($data2);
                if($n2>0){
                    ?>
                    <h3>Select the team</h3> 
                    <select class="form__input" name="team" required class="smalltext">
                    <option value="">None</option>
                    <?php
                    while($row2=$data2->fetch_assoc()){
                        
                        $sql3="SELECT teamname from team WHERE teamid='".$row2['id']."'";
                        $data3=mysqli_query($conn,$sql3);
                        $row3=$data3->fetch_assoc();
                        ?>
                        <option value="<?php echo $row3['teamname'];?>"><?php echo $row3['teamname'];?></option>
                        <?php
                        
                    }
                    ?>
                    </select>

                    <input type="submit" class="switch__button button " value="Join T">
                    <?php
                }
                else{
                    echo "No Team is Presently registered to this tounament\n";
                    echo "Please Create a new team";
                }
                ?>
                
            </form>
        </div>



        <div class="switch" id="switch-cnt">
            <div class="switch__circle"></div>
            <div class="switch__circle switch__circle--t"></div>
            <div class="switch__container" id="switch-c1">
                <h2 class="switch__title title">Join Team</h2>
                <button class="switch__button button switch-btn">Join</button>
            </div>



            <div class="switch__container is-hidden" id="switch-c2">
                <h2 class="switch__title title">Create Team</h2>
                <button class="switch__button button switch-btn">Create</button>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
    <?php
    }
    else{
        
          
    }
    ?>


</body>


</html>