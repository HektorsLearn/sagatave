<?php
session_start(); 
include "../functions.php";
include "../config.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Administrācijas panelis</title>
  
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
    if($_SESSION["pieteicies"] == true && $_SESSION['pieeja']=='admin'){
    ?>
    <div id="subtitle" class="container-fluid p-5 md-primary text-black text-center">
	<h1>Administrācijas panelis</h1>
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
              <li class="nav-item">
                <a class="nav-link" href="?atvert=lapas">Lapas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?atvert=profili">Profili</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?atvert=preces">Preces</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?atvert=kategorijas">Kategorijas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?atvert=pasutijumi">Pasūtījumi</a>
              </li>
            </ul>
        	<ul class="nav navbar-nav navbar-right"> 
          <?php if(isset($_SESSION['lietotajs']) && isset($_SESSION['pieteicies'])){ ?>
					<li><a id="admin" class="text-decoration-none" href="profils.php">Mans profils</a></li>
					<li><a id="admin" class="text-decoration-none" href="index.php">Administrācijas panelis</a></li>
        
				<?php } ?>
				
			</ul><?php if($_SESSION['pieteicies'] == false){
				echo "<a id='login' class='text-decoration-none' href='../login.php'> Pierakstīties </a>";
			}else{
				echo "<a id='login' class='text-decoration-none' href='../logout.php'> Izrakstīties </a>";
			}?>
          </div>
		 </div>
      </nav>
	 <div class="container-fluid pt-3">   <!--Pieteikšanās forma -->
	
  <?php
   if(isset($_GET["atvert"])){
        if($_GET['atvert']=="lapas"){
        include 'lapas.php';
        } elseif($_GET['atvert'] == "profili"){
        include 'profili.php';
        } elseif($_GET['atvert'] == "preces"){
        include 'preces.php';
        }elseif($_GET['atvert'] == "kategorijas"){
        include 'kategorijas.php';
        }elseif($_GET['atvert'] == "pasutijumi"){
          include 'pasutijumi.php';
        }


   ?>
  
    <?php
   }
    }else{
        //Ja lietotājs nav ielagojies, met ārā no administrācijas paneļa
        header("Location:../index.php");
			exit();
    }

    ?>



  </div>
  <?php 	include "../cats2.php"; ?>

<?php
    include "../apaksa.php";
  ?>

</body>
</html>