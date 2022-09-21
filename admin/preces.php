
<h1>Preces</h1>

<?php


$r=(isset($_POST['rediget']) AND isset($_POST['radio']));

        //=========Izdzēst preci============//
        if(isset($_POST['yes'])){
            $id = $_SESSION['precesId'];
            //Pārbauda vai šāda lapa vispār eksistē///
            $sql="SELECT * FROM preces WHERE id ='$id'";
            $result = $conn->query($sql);   
            if($result->num_rows > 0){
                //izdzēš lapu
                $sql3 = "DELETE FROM preces WHERE id='$id'";
                if (mysqli_query($conn, $sql3)) {
                    echo "<br>Tika izdzēstas prece ar Id: ".$id;
                } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }

        //izdzēst bildi

        if(isset($_POST['dzestbildi'])){
            $id=$_SESSION['dzestbildi'];
            $sql2 = "UPDATE preces SET foto = '/uploads/mcalfa.png' WHERE id = $id";
            if ($conn->query($sql2) === TRUE) {
                echo  "<p>Bilde tika izdzēsta!</p><br>";
            } else {
                echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
            }
        }

        //====Pievienot preci===========//
        if(isset($_POST["pievienot"])){
        //Priekš foto ielādes
        $imgdir ="";
        if(!empty($_FILES["fileToUpload"]["name"])){
            $imgdir =imgupload();
        }else{
            //defoult bilde
            $imgdir = "/uploads/mcalfa.png";
        }
        //Beidzas attēla augšupielāde
        //Pārbauda ievadītās kategorijas nosaukumu, ja nu gadījumā caur HTML tiek faktiski izmainīts 
        $kategorija = $_POST["kategorija"];
        echo $kategorija;
        //Pārbaudam vai ievadītais nosaukums jau neatbilst no datubāzes.
        $sql = "SELECT * FROM kategorijas WHERE id = '$kategorija'";
        $result = $conn->query($sql);   
        if($result->num_rows > 0){
           
            //Ja ir, tad atļauj nosūtīt tālāk datus. Piešķiram izvēlētajai kategorijai id
            $row = $result->fetch_assoc();
            $kategorijas_id = $row['id'];
            //Ja forma par sadaļu pievienošanu tika aizpildīta, tad liekam atsūtītos datus datubāzē 
            $nosaukums = $_POST["nosaukums"];
            $cena = $_POST["cena"];
            $apraksts = $_POST["apraksts"];
            
            //Pārbaudam vai ievadītais nosaukums jau neatbilst no datubāzes.
            $sql4 = "SELECT * FROM preces WHERE nosaukums = '$nosaukums'";
            $result3 = $conn->query($sql4);   
            if($result3->num_rows == 0){
                //Ja nav šādu ierakstu, ievietojam datus datubāzē
                $sql = "INSERT INTO preces (nosaukums, cena, foto, apraksts, kategorijas_id)
                VALUES ('$nosaukums', '$cena', '$imgdir', '$apraksts', '$kategorijas_id')";
                if ($conn->query($sql) === TRUE) {
                echo  "<p>Prece tika ievietota veiksmīgi!</p><br>";
                } else {
                echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
                }
                //Ja  šādi dati eksistē, tad izmetam ierakstu, ka šāda lapa jau pastāv.
            }else {
                echo "Prece ar šādu nosaukumu jau eksistē!";
            }
        }else{
            echo "<br>Šāda kategorija neeksistē!";
        }
    }

        //===========Rediģēt preces============//

        if(isset($_POST["rediget2"])){
        $id=$_SESSION['precesId'];
        $nosaukums = $_POST["nosaukums"];
        $cena = $_POST["cena"];
        $apraksts = $_POST["apraksts"];
        $imgdir ="";
        if(!empty($_FILES["fileToUpload"]["name"])){
            $imgdir =imgupload();
        }
        //Pārbaudam vai ievadītais kategrijas nosaukums jau neatbilst no datubāzes.
        $kategorija = $_POST["kategorija"];
        if($kategorija !== ""){
        $sql = "SELECT * FROM kategorijas WHERE nosaukums = '$kategorija'";
        $result = $conn->query($sql);   
        if($result->num_rows == 0){
        //Ja nav šādu ierakstu, ievietojam datus datubāzē
            $sql2 = "UPDATE preces SET nosaukums = '$nosaukums', cena='$cena',";
            if(!empty($_FILES["fileToUpload"]["name"])){
                $sql2.="foto='$imgdir',";
            }
            $sql2 .="apraksts='$apraksts', kategorijas_id='$kategorija' WHERE id='$id'";
            if ($conn->query($sql2) === TRUE) {
                echo  "<p>Prece tika rediģēta!</p><br>";
            } else {
                echo  "<p>Kļūda!</p> " . $sql2 . "<br>" . $conn->error;
            }
        }
        }else{
            echo "<p style='color:red'>Lūdzu norādiet prece kategoriju!</p>";
        }
    }
    


        $nosaukums ="";
        $taka ="";
        $saturs ="";
        $id="";
        $kategorija="";
        ?>
    <div class="row">
      <div class="col">
    <form class="forma" action="" method="post">
    <table><tr><td></td><td>ID</td><td>Nosaukums</td><td>Cena</td><td>foto</td><td>Apraksts</td><td>Kategorijas Id</td><td>Foto</td></tr> 
<?php
    //==============Izprintē visas preces==================//
    $sql = "SELECT * FROM preces";
  	$result = $conn->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sql2 = "SELECT nosaukums FROM kategorijas WHERE id=".$row['kategorijas_id']."";
        $result2 = $conn->query($sql2);
        if($result2->num_rows == 1){
            $row2 = $result2->fetch_assoc();
            $kategorija = $row2['nosaukums'];
        }else{
            $kategorija = "Nav kategorijas";
        }

      echo "<tr><td><input type='radio' value=".$row['id']." name='radio'></td><td>" . $row['id'] . "</td><td>" . $row['nosaukums'] . "</td><td>". $row['cena'] . "</td><td>". $row['foto'] . "</td><td>". $row['apraksts'] . "</td><td>". $kategorija ."</td><td><img src='..".$row['foto']."' style='width:100px'></td></tr>";
    }
    }
    ?>
    </table><br>
    <input type='submit' value='Rediģēt' name='rediget'>
    <input type='submit' value='Izdzēst preci' name='izdzest'>
    <input type="submit" value="Atjaunot preču sarkastu" name="atjaunot">
    <?php
    //parādās formas poga, lai apstiprinātu lapas dzēsānu//
    if(isset($_POST['izdzest']) AND isset($_POST['radio'])){    
        $_SESSION['precesId']=$_POST['radio'];
      ?>
        <br>
        Vai patiešām izdzēst preci ar Id: <?php echo $_SESSION['precesId']?>?
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
    <h3><?php if(!$r){echo "Pievienot ";}else{echo "Rediģēt ";}?>preci</h3>
    <?php 
    if(isset($_POST['radio'])){
    $id = $_POST['radio'];
    $_SESSION['dzestbildi']= $id;
    $sql2 = "SELECT * FROM preces WHERE id ='$id'";
  	$result2 = $conn->query($sql2);
    $row = $result2->fetch_assoc();
    $id=$row["id"];
    $nosaukums= $row["nosaukums"];
    $cena= $row["cena"];
    $foto= $row["foto"];
    $apraksts =$row['apraksts'];
    $kategorija =$row['kategorijas_id'];
    //Session dzēšamais id, ko iegūstam no formas
    $_SESSION['precesId']=$row["id"];
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="id" placeholder="Id:auto" value="<?php if($r){echo $id;}?>" disabled><br><br>
    <input type="text" name="nosaukums" placeholder="Preces nosaukums" value="<?php if($r){echo $nosaukums;}?>" required><br><br>
    <input type="number" name="cena" placeholder="Preces cena" step=".01" value="<?php if($r){echo $cena;}?>" required><br><br>
    <input type='file' name="fileToUpload" id="fileToUpload" ><br><br>
    <?php
    //Parada zem bildes jau esošo bildi, kuru var apskatīties
    if($r){
        if($foto !== ""){
            echo "<a target='_blank' href='/sagatave".$foto."'>".substr($foto, 9)."</a><br>";
            ?>
                <input class='dzestpoga' value="Izdzēst bildi" type='submit' name='dzestbildi'><br>
            <?php
        }
    }


    ?>
    <textarea name="apraksts" rows="5" cols="40"><?php if($r){echo $apraksts;}?></textarea ><br>
    <select name='kategorija'>
        <option value="">--</option>
        <!-- Atjauno drop options ar Database pieejamajim ražotājiem-->
        <?php 
        //nolasa ražotājus no database, kas neatkārtojas
        $sql = "SELECT DISTINCT * FROM kategorijas ORDER BY nosaukums";
        $result = $conn->query($sql);
        if(isset($result) && $result->num_rows > 0 ){
            //dabū preču kategorijas nosaukumus 
            while($row = $result->fetch_assoc()){
            echo "<option value='".$row["id"]."'>".$row['nosaukums']."</option>";
            }
        }
        ?>
    </select>
    <input type="submit" value="<?php if($r){echo "Rediģēt preci";}else{echo "Pievienot preci";}?>" name="<?php if($r){echo "rediget2";}else{echo "pievienot";}?>">
  <br><br>
</form>
    

    
