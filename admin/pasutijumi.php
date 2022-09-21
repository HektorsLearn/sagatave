
<div class="col">
    <h1>Pasūtījumi</h1>
<?php
    //=========== Pārprasa vai izdzēst pasūtījumu ==============// Strādā
    if(isset($_POST['izdzest']) AND isset($_POST['radio'])){
      $_SESSION['pasutijumsizdzest'] = $_POST['radio'];
      ?>
         <br>
          Vai patiešām izdzēst pasūtījumu ar ID: <?php echo $_SESSION['pasutijumsizdzest']?>
        <form action='' method='post'>
        <input type='submit' name='yes' value=Jā>
        <input type='submit' name='no' value=Nē>
        </form>
      <?php
    }

    //============Nomaina statusu pasūtījumam==============//
    if(isset($_POST['statuss'])){
       $pasutijuma_id= $_POST['id']; ;
       $statuss=$_POST['statuss'];
        $sql="UPDATE pasutijumi SET statuss='$statuss' WHERE id='$pasutijuma_id'";
        if ($conn->query($sql) === TRUE) {
          echo  "<p>Pasūtījuma dati tika izmainīti!</p><br>";
        } else {
          echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
        }
    }


    //======Rediģē pasūtījumus===========//
    if(isset($_POST['rediget']) && isset($_POST['radio'])){
      $id= $_POST['radio'];
      $sql = "SELECT * FROM pasutijumi WHERE id='$id'";
      $result = $conn->query($sql);
      //Iegūst visu pasūtījumu id
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $kopeja_cena=0;
              //array_push($pasutijumi, $row['id'], $row['statuss']);
              //print_r($pasutijumi);
              $pasutijuma_id = $row['id'];
              $pasutitajs = $row['lietotaja_id'];
              //dabū lietotaja vardu, nevis id
              $sql3= "SELECT username FROM lietotaji WHERE id='$pasutitajs'";
              $result3 = $conn->query($sql3);
              if ($result3->num_rows > 0) {
                while($row3 = $result3->fetch_assoc()) {
                   $pasutitajs = $row3['username'];
                }
              }
              $laiks = $row['laiks'];
              $statuss = $row['statuss'];
              $sql2="SELECT * FROM pasutijuma_preces WHERE pasutijuma_id = '$pasutijuma_id'";
              $result2 = $conn->query($sql2);


              ?>

              <form action="" method='post'>
                
              Pasutijuma id:
              <input class='disabledinput' type='text' value="<?php echo $id; ?>" name='id' readonly ><br><br>
             <p><b>Nomainīt pasūtījuma statusu:</b></p> 
            <select name='statuss'>
              <option value="<?php echo $row['statuss']; ?>"><?php echo $row['statuss']; ?></option>
              <option value="Apstrādē">Apstrādē</option>
              <option value="Pasūtīts">Pasūtīts</option>
              <option value="Noraidīts">Noraidīts</option>
        </select>
              <input class='dzestpoga' type='submit' value='Iesniegt'>
              </form>
              <div class='line' style="margin-bottom:20px"></div>
              <?php

              if ($result2->num_rows > 0) {
                  while($row2 = $result2->fetch_assoc()) {
                    $kopeja_cena = $kopeja_cena = $row2['daudzums']*$row2['cena'];
                        //dabū pasūtītās preces īsto nosaukumu
                        $preces_id = $row2['preces_id'];
                        $preceid=$row2['id'];
                        $daudzums = $row2['daudzums'];
                        $cena = $row2['cena'];
                        $sql4= "SELECT nosaukums FROM preces WHERE id='$preces_id'";
                        $result4 = $conn->query($sql4);
                        if ($result4->num_rows > 0) {
                          while($row4 = $result4->fetch_assoc()) {
                            $prece = $row4['nosaukums'];
                          }
                          ?>
                          <form class='forma' style='width:100%;' method='post'>
                          Preces id:
                         <input class='disabledinput' type='text' value="<?php echo $preceid; ?>" name='id' readonly ><br>
                          Preces nosaukums:<b><?php echo $prece; ?></b><br>
                          Pasūtītājs:<b> <?php echo $pasutitajs; ?></b><br>
                          Daudzums:<input type='number' value="<?php echo $daudzums; ?>" name='daudzums' min='0'><br>
                          Cena:<input type='number' value="<?php echo $cena; ?>" name='cena' min='0'><br>
                            
                        
                        <input class='dzestpoga' type='submit' value='Rediģēt' name='rediget2'>
                        
                          </form>
                          <div class='line' style="margin-bottom:20px"></div>
                         
                    
            <?php
                        }
                  }
              }


            }
          }
            }
      //=====Rediģē pasūtījumus=========
      
        if(isset($_POST['rediget2'])){
          $id=$_POST['id'];
          $cena=$_POST['cena'];
          $daudzums=$_POST['daudzums'];
          if($daudzums >= 0 AND $cena >=0){
            $sql="UPDATE pasutijuma_preces SET cena='$cena', daudzums='$daudzums' WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
              echo  "<p>Pasūtījuma dati tika izmainīti!</p><br>";
            } else {
              echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
            }
            }else{
              echo "<b><p style='color:red'>Lūdzu ievadiet pozitīvas vērtības!</p></b>";
            }
          }

        
     
  
    //======Apstiprināt pasūtījumu==
    if(isset($_POST['apstiprinat']) && isset($_POST['radio'])){
        $id=$_POST['radio'];
        $statuss = "Pasūtīts";
        $sql = "UPDATE pasutijumi SET statuss ='$statuss' WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
          echo  "<p>Pasūtījuma statuss tika izmainīts!</p><br>";
        } else {
          echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
        }
    }

    //========Izdzēst pasūtījumu========//
    if(isset($_POST['yes'])){

      $id=$_SESSION['pasutijumsizdzest'];
      $sql = "DELETE FROM pasutijumi WHERE id='$id'";
            if (mysqli_query($conn, $sql)) {
                echo "Tika izdzēstas pasūtījums ar Id: ".$id;
            } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }  
    }

?>
                        <!-- Meklētājs -->
<div>
  Kārtot pēc:
</div>
<div id='meklet'>
    <div style='col-2'>
      Pasūtītājs:
      <form action='' method='get'>
      <?php
        if(isset($_GET['statuss'])){
          echo '<input type="hidden" name="statuss" value="'.$_GET['statuss'].'" />';
        }
        ?>
        <select name='pasutitajs'>
          <option value=''>--</option >
       <?php
          $sql="SELECT username FROM lietotaji"; 
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
?>
            <option value='<?php echo $row['username'];?>'><?php echo $row['username'];?></option>
<?php
            }
          }else{
            echo "--";
          }
         ?>
     </select>
     <input type="hidden" name="atvert" value="pasutijumi" />
     <input type='submit' value='Meklēt' name='meklet'>
      </form>

    </div>

    <div style='col-2'>
    Statuss
    <form action='' method='get'>
    <?php
        if(isset($_GET['pasutitajs'])){
          echo '<input type="hidden" name="pasutitajs" value="'.$_GET['pasutitajs'].'" />';
        }
        ?>
        <select name='statuss'>
          <option value=''>--</option >
       <?php
          $sql="SELECT DISTINCT statuss FROM pasutijumi"; 
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
?>
            <option value='<?php echo $row['statuss'];?>'><?php echo $row['statuss'];?></option>
<?php
            }
          }else{
            echo "--";
          }
         ?>
     </select>
     <input type="hidden" name="atvert" value="pasutijumi" />
     <input type='submit' value='Meklēt' name='mekletstatuss'>
      </form>
    </div>

</div>

<?php


    //==============Izprintē visus pasūtījumus==================//
    

    $sql = "SELECT * FROM pasutijumi";
    
    if(isset($_GET['pasutitajs'])){
      $meklet = $_GET['pasutitajs'];
      $sql5= "SELECT id FROM lietotaji WHERE username='$meklet'";
      $result5 = $conn->query($sql5);
      if ($result5->num_rows > 0) {
        $row = $result5->fetch_assoc();
        $id=$row['id'];
      $sql.=" WHERE lietotaja_id='$id'";

      }
    }
    if(isset($_GET['statuss']) && isset($_GET['pasutitajs'])){
      $statuss = $_GET['statuss'];
      $sql.=" AND statuss='$statuss'";
    }elseif(isset($_GET['statuss'])){
      $statuss = $_GET['statuss'];
      $sql.=" WHERE statuss='$statuss'";
    }

    $datums="";
   
    echo $sql;

  	$result = $conn->query($sql);
    $kopeja_cena=0;
    //$pasutijumi = array();
    //Iegūst visu pasūtījumu id
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $kopeja_cena=0;
          echo "<div ><form class='forma' style='width:100%;' method='post'>";
            //array_push($pasutijumi, $row['id'], $row['statuss']);
            //print_r($pasutijumi);
            $pasutijuma_id = $row['id'];
            $pasutitajs = $row['lietotaja_id'];
            //dabū lietotaja vardu, nevis id
            $sql3= "SELECT username FROM lietotaji WHERE id='$pasutitajs'";
            $result3 = $conn->query($sql3);
            if ($result3->num_rows > 0) {
              while($row3 = $result3->fetch_assoc()) {
                 $pasutitajs = $row3['username'];
              }
            }
            $laiks = $row['laiks'];
            $statuss = $row['statuss'];
            $sql2="SELECT * FROM pasutijuma_preces WHERE pasutijuma_id = '$pasutijuma_id'";
            $result2 = $conn->query($sql2);
            echo "<table style='width:100%;'><tr><td><input type='radio' value=".$pasutijuma_id." name='radio'></td><td>Pasūtījuma Id</td><td >Pasūtītājs</td><td style='width:100%;'>Pasūtītās preces</td><td>Daudzums</td><td>Cena</td><td>Statuss</td></tr>";
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                  $kopeja_cena = $kopeja_cena + (int)$row2['daudzums']*(int)$row2['cena'];
                      //dabū pasūtītās preces īsto nosaukumu
                      $preces_id = $row2['preces_id'];
                      $sql4= "SELECT nosaukums FROM preces WHERE id='$preces_id'";
                      $result4 = $conn->query($sql4);
                      if ($result4->num_rows > 0) {
                        while($row4 = $result4->fetch_assoc()) {
                          $prece = $row4['nosaukums'];
                        }
                      }
        
                    ?>
                    <tr><td></td><td><?php echo $pasutijuma_id ?></td><td><?php echo $pasutitajs ?></td><td><?php echo $prece; ?></td><td><?php echo $row2['daudzums'] ?></td><td><?php echo $row2['cena'] ?></td><td><?php echo $statuss ?></td></tr>
                    <?php
                }
            }
            echo "</table>";
            ?>

            <input class='dzestpoga' type='submit' value='Rediģēt' name='rediget'>
            <input class='dzestpoga' type='submit' value='Izdzēst passūtījumu' name='izdzest'>
            <input class='dzestpoga' type='submit' value='Apstiprināt pasūtījumu' name='apstiprinat'>
              </form>
              <?php
            echo "<span>Kopā: ".$kopeja_cena." Eiro</span><br><br></div>";
        }
    }

//  }



    ?>

    </div>
    </div>
