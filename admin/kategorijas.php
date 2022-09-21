<h3>Preču kategorijas</h3>


<?php
$r=(isset($_POST['rediget']) AND isset($_POST['radio']));
$red=(isset($_POST['rediget']));

if($r){
    $id=$_POST['radio'];
    $sql ="SELECT * FROM kategorijas WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $id= $row['id'];
    $nosaukums= $row['nosaukums'];
    $_SESSION['kategorijasId']=$id;
    
}


 //=========Izdzēst kategoriju============//
 if(isset($_POST['yes'])){
    $id = $_SESSION['kategorijasId'];
    //Pārbauda vai šāda kategorija vispār eksistē///
    $sql="SELECT * FROM kategorijas WHERE id ='$id'";
    $result = $conn->query($sql);   
    if($result->num_rows > 0){
        //izdzēš kategoriju
        $sql3 = "DELETE FROM kategorijas WHERE id='$id'";
        if (mysqli_query($conn, $sql3)) {
            echo "<br>Tika izdzēstas kategorija ar Id: ".$id;
        } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

    //===========Pievieno kategoriju============//
    if((isset($_POST['iesniegt'])) AND ($_POST['kategorija'] !== "")){
        $kategorija = $_POST['kategorija'];
        $sql="INSERT INTO kategorijas (nosaukums) VALUES ('$kategorija')";
        
        if ($conn->query($sql) === TRUE) {
            echo  "<p>Jauna kategorija tika izveidota!</p><br>";
            } else {
            echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
            }
    }
 
    //==Rediģēt kategoriju===========//
    if(isset($_POST["rediget2"])){
        $id=$_SESSION['kategorijasId'];
        $nosaukums = $_POST["kategorija"];
            $sql2 = "UPDATE kategorijas SET nosaukums = '$nosaukums' WHERE id='$id'";
            if ($conn->query($sql2) === TRUE) {
                echo  "<p>Kategorija tika rediģēta!</p><br>";
            } else {
                echo  "<p>Kļūda!</p> " . $sql2 . "<br>" . $conn->error;
            }
        }
        ?>

  



    <div class="row">
    <div class="col">
    <form class="forma" action="" method="post">
    <table>
        <tr><td></td><td>ID</td><td>Nosaukums</td></tr> 
    <?php
      //==============Izprintē visas preces==================//
    $sql = "SELECT * FROM kategorijas";
  	$result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
      echo "<tr><td><input type='radio' value=".$row['id']." name='radio'></td><td>" . $row['id'] . "</td><td>" . $row['nosaukums']."</td></tr>";
        }
    }
    ?>
    </table>
    <br>
    <input type='submit' value='Rediģēt' name='rediget'>
    <input type='submit' value='Izdzēst kategoriju' name='izdzest'>
    <input type="submit" value="Atjaunot kategoriju sarkastu" name="atjaunot">
    </form>
    <?php
    //parādās formas poga, lai apstiprinātu lapas dzēsānu//
    if(isset($_POST['izdzest']) AND isset($_POST['radio'])){    
        $_SESSION['kategorijasId']=$_POST['radio'];
      ?>
        <br>
        Vai patiešām izdzēst kategoriju ar Id: <?php echo $_SESSION['kategorijasId']?>?
      <form action='' method='post'>
      <input type='submit' name='yes' value=Jā>
      <input type='submit' name='no' value=Nē>
    </form>
    </div>
    </div>
    <?php
    }
?>


<h3>Pievienot jaunu kategoriju</h3>
<form action='' method='post'>
    <input type="text" name="id" placeholder="Id:auto" value="<?php if($r){echo $id;}?>" disabled><br><br>
    <input type='text' name='kategorija' value="<?php if($red){echo $nosaukums;} ?>" placeholder='Kategorija' <?php if($r){echo $nosaukums;}?>>
    <input type="submit" value="<?php if($r){echo "Rediģēt kategoriju";}else{echo "Pievienot kategoriju";}?>" name="<?php if($r){echo "rediget2";}else{echo "iesniegt";}?>">
</form>

