<h2>Profili</h2>


<?php
$r=(isset($_POST['rediget']) AND isset($_POST['radio']));
$username="";
$password="";
$access="";
$id="";
    //====izdzēst lietotāju
  if(isset($_POST['yes']) && isset($_SESSION['radioid'])){
    $id = $_SESSION['radioid'];
      //izdzēš lietotāju
      $sql3 = "DELETE FROM lietotaji WHERE id='$id'";
      if (mysqli_query($conn, $sql3)) {
          echo "Tika izdzēsts profils ar Id: ".$id;
      } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
}
 ?>

<table><tr><td></td><td>ID</td><td>Lietotājvārds</td><td>Parole</td><td>Profila pakāpe</td><td>Profila aktivitāte</td></tr>
<?php
        //=========== Izprintē visus esošos profilus tabulā ==============//
    $sql = "SELECT * FROM lietotaji";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<form class="forma" action="" method="post">';

            // Uztaisām virsrakstu tabulai un izprintējam lapas tabulā
        while($row = $result->fetch_assoc()) {
            if($row['active'] == 1){
                $aktivitate = "Aktīvs";
            } else {
                $aktivitate = "neaktīvs";
            }
            echo "<tr><td><input type='radio' value=".$row['id']." name='radio'></td><td>" . $row['id'] . "</td><td>".$row['username']."</td><td>".$row['password']."</td><td>". $row['access'] . "</td><td>".$aktivitate."</td></tr>";
            }
    }
    ?>
  </table><br>
  <input class="poga" type="submit" value="Pievienot lietotājus" name="pievienot">
  <input class='poga' type='submit' value='Rediģēt' name='rediget'>
  <input class="poga" type="submit" value="Izdzēst lietotāju" name="izdzest">
  <input class='poga' type='submit' value='Atjaunot sarakstu' name='atjaunot'>
  </form>
  <div style="height:20px;"></div>
<?php
  //=========== Pārprasa vai izdzēst profilu ==============//
  if(isset($_POST['izdzest']) AND isset($_POST['radio'])){
    $_SESSION['radioid'] = $_POST['radio'];
    ?>
       <br>
        Vai patiešām izdzēst lietotāju ar ID: <?php echo $_SESSION['radioid']?>
      <form action='' method='post'>
      <input type='submit' name='yes' value=Jā>
      <input type='submit' name='no' value=Nē>
      </form>
    <?php
  }
  ?>

<?php
                    //=========Izprintē rediģēšanas forumu, ja ir nospiesta poga rediģēt==========//
    if($r){
        $_SESSION['userid'] =$_POST['radio'];
        $id = $_POST['radio'];
        $sql4 ="SELECT * FROM lietotaji WHERE id='$id'";
        $result4 = $conn->query($sql4);
        $row2 = $result4->fetch_assoc();
        $username=$row2['username'];
        $password=$row2['password'];
        ?>
        <form action="" method="post">
        Id: <br><input name="redid" value='<?php echo $id ?>' disabled><br>
        Lietotājvārds:   <br><input type="text" name="lietotajvards2" value='<?php echo $username ?>' required ><br>
        Parole:          <br><input type="text" name="parole" value='' required><br>
        Pieejas pakāpe lietotājam: 
        <br><select name="access2" >
            <option value="public">--</option>
            <option value="public">Public</option>
            <option value="admin">Admin</option>
        </select><br>
        Profila aktivitāte: 
        <br><select name="active2">
            <option value="">--</option>
            <option value="1">Aktīvs</option>
            <option value="0">Neaktīvs</option>
        </select><br><br>

    <input class="poga" type="submit" value="Veikt izmaiņas" name="rediget2">
    </form>
    
    <?php
}

//==========Aizsūta rediģētos datus uz datubāzi==========//

if(isset($_POST['rediget2'])){ 
    $id = $_SESSION['userid'];
    $username = $_POST['lietotajvards2'];
    $password = $_POST['parole'];
    $access = $_POST['access2'];
    $active = $_POST['active2'];
    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
    $sql5 = "UPDATE lietotaji SET username = '$username', password='$hashedpassword', access = '$access', active = '$active' WHERE id='$id'";
    $result5 = $conn->query($sql5);
    if (mysqli_query($conn, $sql5)){
        echo "Profils ir ticis izlabots!";
    } else {
         echo "Error: ". $sql . "<br>" . mysqli_error($conn);
    }
    
}
 ?>
<?php
    //==================Pievienot lietotājus==================
    if(isset($_POST['pievienot'])){      
?>
<div class="labais">
<h3> Pievienot lietotājus</h3>

<form action="" method="post" autocomplete="off">
        <input type="text" name="lietotajvards" autocomplete="false"  placeholder="Lietotājvārds" required ><br><br>
        <input type="password" name="parole" placeholder="Parole" required><br>
        Pieejas pakāpe lietotājam: <br>
         <select name="access" >
             <option value="public" readonly="readonly">--</option>
             <option value="public">Public</option>
             <option value="admin">Admin</option>
         </select><br><br>
     <input type="submit" name="iesniegt" value="Izveidot profilu">
     </form>
        <?php   
    }
    ?>
<?php
                        //=========== Uztaisa profilus ar izvēli kādu access pakāpi var izmantot ==============//
    if(isset($_POST['iesniegt'])){
        $lietotajvards = $_POST["lietotajvards"];
        $password = $_POST['parole'];
        $access = $_POST['access'];
    }
    if(isset($_POST['iesniegt'])){
        //Meklē vai ir jau šāds profils
        $sql2 = "SELECT * FROM lietotaji WHERE username = '$lietotajvards'";
        $result2 = $conn->query($sql2);
        //Ja navnav šāds profils, tad izveidojam ar šiem datiem
        if(strlen($password) > 5){
            if(($result2->num_rows == 0)){ 
                $sql = "INSERT INTO lietotaji (username, password, access, active) VALUES ('$lietotajvards', '$password', '$access', '1')";
                if (mysqli_query($conn, $sql)){
                    echo "<p>Profils ir ticis izveidots!</p>";
                } else {
                        echo "Error: ". $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "<p class='pazinojums'>Lūdzu, izvēlaties citu lietotājvārdu!<p>";
            }
        }else{
            echo "<p class='pazinojums'>Lūdzu, ievadiet paroli, kas garāka par pieciem(5) simboliem!</p>";
        }
    }