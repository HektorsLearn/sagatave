
<h2>Lapas</h2>

<?php

$r=(isset($_POST['rediget']) AND isset($_POST['radio']));
$nosaukums ="";
$taka ="";
$saturs ="";
$id="";
$npk="";
?>
    <div class="row">
      <div class="col">
    <form class="forma" action="" method="post">
    <table><tr><td></td><td>ID</td><td>Nosaukums</td><td>Taka</td><td>Saturs</td><td>Datums</td><td>Lapas npk.</td></tr> 
<?php
    //==============Izprintē visas lapas==================//
    $sql2 = "SELECT * FROM lapas ORDER BY npk";
  	$result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
      echo "<tr><td><input type='radio' value=".$row['id']." name='radio'></td><td>" . $row['id'] . "</td><td>" . $row['nosaukums'] . "</td><td>". $row['taka'] . "</td><td>". $row['saturs'] . "</td><td>". $row['laiks'] . "</td><td>". $row['npk'] .".lapa</td></tr>";
    }
    }
    ?>
    </table><br>
    <input type='submit' value='Rediģēt' name='rediget'>
    <input type='submit' value='Izdzēst lapu' name='izdzest'>
    <input type="submit" value="Atjaunot sarakstu" name="atjaunot">
    <?php
    //parādās formas poga, lai apstiprinātu lapas dzēsānu//
    if(isset($_POST['izdzest']) AND isset($_POST['radio'])){     
      ?>
        <br>
        Vai patiešām izdzēst lapu ar Id: <?php echo $_SESSION['id']?>?
      <form action='' method='post'>
      <input type='submit' name='yes' value=Jā>
      <input type='submit' name='no' value=Nē>

      </form>
    </div>
    </div>
    <?php
    }
    ?>

    <!--Forma kas mainās atkarībā vai ir nospiesta rediģēšanas poga -->
   
    </form><br>
    <h3><?php if(!$r){echo "Pievienot ";}else{echo "Rediģēt ";}?>lapu</h3>
    <?php 
    if(isset($_POST['radio'])){
    $id = $_POST['radio'];
    $sql2 = "SELECT * FROM lapas WHERE id ='$id'";
  	$result2 = $conn->query($sql2);
    $row = $result2->fetch_assoc();
    $saturs= $row["saturs"];
    $taka= $row["taka"];
    $nosaukums= $row["nosaukums"];
    $id=$row["id"];
    $npk =$row['npk'];
    //Session dzēšamais id, ko iegūstam no formas
    $_SESSION['id']=$row["id"];
    }
    ?>

    <form action="" method="post">
    <input type="text" name="id" placeholder="Id:auto" value="<?php if($r){echo $id;}?>" disabled><br><br>
    <input type="text" name="nosaukums" placeholder="Lapas nosaukums" value="<?php if($r){echo $nosaukums;}?>" required><br><br>
    <input type="text" name="taka" placeholder="Lapas taka(īsceļš)" value="<?php if($r){echo $taka;}?>" required><br><br>
    <?php 
    if(isset($r) AND isset($npk)){echo "Numurs pēc kārtas <br>";
     echo "<input type='number' name='npk'  value=".$npk." required><br><br>";
    }
    ?>
    <textarea name="saturs" rows="5" cols="40" placeholder="Lapas saturs"><?php if($r){echo $saturs;}?></textarea ><br>
    <input type="submit" value="<?php if($r){echo "Rediģēt";}else{echo"Pievienot lapu";}?>" name="<?php if($r){echo "rediget2";}else{echo "pievienot";}?>">
    
  <br><br>
</form>
    

<?php 
                                    //====Pievienot lapu===========//
    if(isset($_POST["pievienot"])){
        //Ja forma par sadaļu pievienošanu tika aizpildīta, tad liekam atsūtītos datus datubāzē 
        $nosaukums = $_POST["nosaukums"];
        $taka = $_POST["taka"];
        $saturs = $_POST["saturs"];
        //Pārbaudam vai ievadītais nosaukums jau neatbilst no datubāzes.
        $sql4 = "SELECT * FROM lapas WHERE nosaukums = '$nosaukums' OR taka = '$taka'";
        $result3 = $conn->query($sql4);   
        if($result3->num_rows == 0){
          //Ja nav šādu ierakstu, ievietojam datus datubāzē
          $sql = "INSERT INTO lapas (nosaukums, taka, saturs)
          VALUES ('$nosaukums', '$taka', '$saturs')";

          if ($conn->query($sql) === TRUE) {
            echo  "<p>Lapa tika ievietota veiksmīgi!</p><br>";
          } else {
            echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
          }
          //Ja  šādi dati eksistē, tad izmetam ierakstu, ka šāda lapa jau pastāv.
        }else {
          echo "Šāds lapas nosaukums vai taka jau eksistē, mēģinām izvēlēties citu nosaukumu/taku!";
        }
    }
                               

                      //===========Rediģēt lapas============//

    if(isset($_POST["rediget2"])){
        $id=$_SESSION['id'];
        $nosaukums = $_POST["nosaukums"];
        $taka = $_POST["taka"];
        $saturs = $_POST["saturs"];
        $npk=$_POST['npk'];
        //Jāuztaisa loģika, kur salīdzina ar pārēiem nosaukumiem un takām izņemto šo ID
 
        //Ja nav šādu ierakstu, ievietojam datus datubāzē
        $sql = "UPDATE lapas SET nosaukums = '$nosaukums', taka='$taka', saturs='$saturs', npk='$npk' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
          echo  "<p>Lapa tika rediģēta!</p><br>";
        } else {
          echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
        }

  }
    
                  

                          //=========Izdzēst lapu============//
        if(isset($_POST['yes'])){
          $id = $_SESSION['id'];
          //Pārbauda vai šāda lapa vispār eksistē///
          $sql="SELECT * FROM lapas WHERE id ='$id'";
          $result = $conn->query($sql);   
          if($result->num_rows > 0){
            //izdzēš lapu
            $sql3 = "DELETE FROM lapas WHERE id='$id'";
            if (mysqli_query($conn, $sql3)) {
                echo "Tika izdzēstas lapa ar Id: ".$id;
            } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          }
        }
?>  
  <!-- =====Sākumlapas izvēle=======-->
    
          <h3>Izvēlēties sākumlapu</h3>
            <php ?>
            <form action="" method="post">
                <select id="sakums" name="sakums">
                      <!-- Atjauno drop options ar Database nosaukumiem-->
                    <?php 
                      //nolasa ražotājus no database, kas neatkārtojas
                    $sql = "SELECT DISTINCT nosaukums FROM lapas";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0 ){
                        while($row = $result->fetch_assoc()){
                        echo "<option value='".$row["nosaukums"]."'>".$row['nosaukums']."</option>";
            }
        }
        ?>
                </select>
                <input type='submit' name='sakumlapa' value='Iesniegt'>
            </form>
     


        <?php 
          if(isset($_POST['sakumlapa'])){
            //Iedod visām lapām nulles npk un pēc tam iedod izveletajai lapai nummerāciju 1
              $nosaukums= $_POST['sakums'];
              $sql = "UPDATE lapas SET npk=2 WHERE npk=1";
              $result = $conn->query($sql);
              $sql= "UPDATE lapas SET npk=1 WHERE nosaukums='$nosaukums'";
              $result = $conn->query($sql);
          }
        ?>
