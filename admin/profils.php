<?php
session_start(); 
include "../functions.php";
include "../config.php";


?>

<!DOCTYPE html>
<html>

<head>
	<title>Mans profils</title>
  
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
    <meta charset="UTF-8"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1"/>	
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>	
    <script type="text/javascript" src="../script.js"></script>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="container">
    <?php 
    if($_SESSION["pieteicies"] == true){
    ?>

    <div id="subtitle" class="container-fluid p-5 md-primary text-black text-center">
	<h1>Mans profils</h1>
  <?php if(isset($_SESSION['lietotajs'])){echo "Sveiks, ".$_SESSION['lietotajs'];}?>
	</div>
  <div class="grozs">
    <a id="topfa" href="../grozs.php"><i class="fa">&#xf07a;</i>
    <span id="grozs">Grozs</span></a>
</div>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <div  class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div  class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="../index.php">Sākumlapa</a>
              </li>
            </ul>
        	<ul class="nav navbar-nav navbar-right"> 
          <?php if(isset($_SESSION['lietotajs']) && isset($_SESSION['pieteicies'])){ ?>
					<li><a id="admin" class="text-decoration-none" href="profils.php">Mans profils</a></li>
          <?php
						if($_SESSION['pieeja']=="admin"){ ?>
					<li><a id="admin" class="text-decoration-none" href="index.php">Administrācijas panelis</a></li>
						<?php } ?>
            
				<?php } ?>
			</ul><?php if($_SESSION['pieteicies'] == false){
				echo "<a id='login' class='text-decoration-none' href='../login.php'> Pierakstīties </a>";
			}else{
				echo "<a id='login' class='text-decoration-none' href='../logout.php'> Izrakstīties </a>";
			}?>
      </div>
		 </div>
      </nav>
      <div style="height:20px">
    </div>

<div class="d-inline p-2 bd-highlight" >  
<div   > 
  <div class="p-3 border bg-light">
    <?php
    //izdzēst bildi

    if(isset($_GET['dzestbildi'])){
    $id=$_GET['lietotajaid'];
    $sql2 = "UPDATE lietotaji SET foto = '/uploads/stock.jpg' WHERE id = $id";
    if ($conn->query($sql2) === TRUE) {
        echo  "<p>Bilde tika izdzēsta!</p><br>";
    } else {
        echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
    }
    }
      ///////////

    if(isset($_SESSION['lietotajs'])){
    $username = $_SESSION['lietotajs'];
    $sql="SELECT foto from lietotaji WHERE username='$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
      if($row['foto']!== ""){
        echo "<img class='profilabilde' src='..".$row['foto']."' alt='profilabilde'>";
      } else{
      echo "<img class='profilabilde' src='../uploads/stock.jpg' alt='stock'>";
      }
        echo "<h3>".$_SESSION['lietotajs']."</h3>";
    }
    
      ?>
    </div>
    </div>
<div >
  <div class="p-3 border bg-light">
  <p>Profila informacija</p>
  <?php
        //========Atjaunot profili============
        if(isset($_GET['nosutit'])){
          $vards=$_GET['vards'];
          $uzvards=$_GET['uzvards'];
          $lietotajs = $_SESSION['lietotajs'];
          $parole=$_GET['parole'];
          $parole2=$_GET['parole2'];
          //Aizsūta datus
          if($_SESSION['vards'] != $vards OR $_SESSION['uzvards'] != $uzvards){
            $sql = "UPDATE lietotaji SET vards='$vards', uzvards='$uzvards' WHERE username='$lietotajs'";
            if ($conn->query($sql) === TRUE) {
                echo  "<p style='color:green'>Profils tika atjaunots!</p><br>";
              } else {
                echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
              }
            }

          if(($parole !="") && $parole==$parole2){
            if(strlen($parole) > 6){
            $hashedpassword = password_hash($parole, PASSWORD_DEFAULT);
            $sql = "UPDATE lietotaji SET password='$hashedpassword' WHERE username='$lietotajs'";
            if ($conn->query($sql) === TRUE) {
                echo  "<p style='color:green'>Parole tika atjaunota!</p><br>";
              } else {
                echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
              }
          }else{
            echo "<p style='color:red'>Lūdzu izvēlēties paroli, kas ir garāka par 6 simboliem!</p><br>";
          }
        }

      }

      if(isset($_POST['profilabilde'])){
        if(!empty($_FILES["fileToUpload"]["name"])){
          $lietotajs = $_SESSION['lietotajs'];
          $imgdir =imgupload();
          echo $imgdir;
          $sql = "UPDATE lietotaji SET foto='$imgdir' WHERE username='$lietotajs'";
            if ($conn->query($sql) === TRUE) {
                echo  "<p style='color:green'>Profils tika atjaunots!</p><br>";
              } else {
                echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
              }
        }else{
          echo "<p style='color:red'>Nav izvēlēta profila bilde</p>";
        }
      }


        
  if(isset($_SESSION['lietotajs'])){
    $username=$_SESSION['lietotajs'];
    $sql="SELECT * FROM lietotaji WHERE username='$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION['vards']=$row['vards'];
    $_SESSION['uzvards']=$row['uzvards'];
    ?>
    <form action="" method="get">
    <input hidden type='number' name='lietotajaid' value='<?php echo $row['id'] ?>'>
    <span>Vārds</span><span class="colorWarn"> *</span><br>
    <input class="input" type="text" placeholder="Vārds" name="vards" value="<?php echo $row['vards']; ?>" required ><br>
    <span>Uzvārds</span><span class="colorWarn"> *</span><br>
    <input class="input" type="text" placeholder="Uzvārds" name="uzvards" value="<?php echo $row['uzvards'] ?>" required><br>
    Nomainīt paroli: <br>
    <input class="input" type="password" placeholder="Parole" name="parole"><br>
    Atkārtot paroli: <br>
    <input class="input" type="password" placeholder="Atkārtot paroli" name="parole2"><br><br>
    <?php

    echo "<a target='_blank' href='/sagatave".$row['foto']."'>".substr($row['foto'], 9)."</a><br>";
    ?>
    <input class='dzestpoga' value="Izdzēst profila bildi" type='submit' name='dzestbildi'><br>
    <?php
        
    
    ?>
    <input type="submit" value="Saglabāt izmaiņas" name='nosutit'>
    <input type="submit" value="Dzēst savu profilu" name='izdzest'>
  </form>
<br>
<br>
    <p>Augšupielādēt bildi</p>
  <form action="" method="post" enctype="multipart/form-data">
  <input  type='file' name="fileToUpload" id="fileToUpload" ><br>
  <input type='submit' name='profilabilde' value='Augšupielādēt profila bildi'>
  </form>

  <?php
  if(isset($_GET['izdzest'])){
    ?>
     <br>
        Vai patiešām vēlaties dzēst savu profilu?
      <form action='' method='post'>
      <input type='submit' name='izdzest' value=Jā>
      <input type='submit' name='no' value=Nē>
      </form>
<?php
  }
  if(isset($_POST['izdzest'])){
    $lietotajs=$_SESSION['lietotajs'];
    $sql = "UPDATE lietotaji SET active=0 WHERE username='$lietotajs'";
    $conn->query($sql) === TRUE;
    header("Location:../logout.php");
  }
  }

  //========Dzest ziņu=========
  if(isset($_POST['dzestierakstu'])){
   $id=$_POST['zinasid'];
   $sql = "DELETE FROM zinas WHERE id='$id'";
   if (mysqli_query($conn, $sql)) {
       echo "<br>Tika izdzēsts ieraksts ar id: ".$id;
   } else {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
   }
  }

?>
</div>

  <?php
    }else{
        //Ja lietotājs nav ielagojies, met ārā no administrācijas paneļa
        header("Location:../index.php");
			exit();
    }
    ?>
    <br>
    </div>
    <div style="height:20px;">
    </div>
  <div class="d-flex justify-content-center">
    
    <div class="p-3 border bg-light" style='width:50%;'>
    <h3>Ziņas</h3>
    <div class="border bg-light">
    <?php     
        $lietotajs=$_SESSION['lietotajs'];
        
        $sql = "SELECT * FROM zinas WHERE autors ='$lietotajs' ORDER BY laiks DESC" ;
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $autors=$row['autors'];
                $sql2 ="SELECT * FROM lietotaji WHERE username='$autors'";
                $result2 = $conn->query($sql2); 
                $row2 = $result2->fetch_assoc()
                ?>
                    <div class='zinas'>
                        <div class="zinastop">
                        <b><?php if(isset($row2['vards'])){
                            echo $row2['vards']." ";
                        }
                        if(isset($row2['uzvards'])){
                            echo $row2['uzvards']." ";
                        }                                
                        ?>
                        </b>
                        <?php
                            echo "@".$row['autors']." ";                  
                            $date1 = strtotime($row['laiks']);
                            $date2 = strtotime(date('Y-m-d H:i:s', strtotime('+1 hours')));
                            $diff = abs($date2 - $date1);
                            $years = floor($diff / (365*60*60*24));
                            $months = floor(($diff - $years * 365*60*60*24)/ (30*60*60*24));
                            $days = floor(($diff - $years * 365*60*60*24 -$months*30*60*60*24)/ (60*60*24));
                            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                            if($years > 0){
                                echo $years." y";
                            }elseif($months > 0){
                                echo $months." m";
                            }elseif($days > 0){
                                    echo $days." d";
                            }elseif($hours > 0){
                                echo $hours." h";
                            }elseif($minutes > 1){
                                echo $minutes." min";
                            }else{
                                echo "Now";
                            }
                        ?>
                        </div>
                        <div class='zina'><?php echo $row['saturs'];?></div>
                        <div class="zinasapaksa">
                          <form method='post' action=''>
                            <input type='number' name='zinasid' value='<?php echo $row['id']?>' hidden>
                            <input type='submit' class='comment' name='dzestierakstu' value='Dzēst ierakstu'>
                          </form>                       
                        </div>
                    </div>
                <?php
            }
        }else{
          echo "Šobrīd Jums nav ierakstu";
        }
    ?>
</div>
</div>
  </div>
  </div>
  <?php
        include "../apaksa.php";
        
      ?>

  </div>
  </div>
  </div>


</body>
</html>

