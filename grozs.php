<?php
session_start();
include "functions.php";
include "config.php";
pieteicies();
$prece=0;


?>

<!DOCTYPE html>
<html>

<head>
	<title>Publiskā daļa</title>
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
	<meta charset="UTF-8"/> 
	<meta name="viewport" content="width=device-width, initial-scale=1"/>	
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
		<!-- Manējais style sheet and js -->
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="script.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
	
<div class="container"  >
	<div class="row">
<?php 
		if(!isset($_SESSION["pieteicies"])){
			$_SESSION["pieteicies"] = false;
		};
	?>
<div id="subtitle" class="container-fluid p-5 md-primary text-black text-center">
	<h1>Mājaslapas sagatave (publiskā daļa)</h1>
	<?php if(isset($_SESSION['lietotajs'])){echo "Sveiks, ".$_SESSION['lietotajs'];}?>
</div>
<div class="grozs">
    <a id="topfa" href="./grozs.php"><i class="fa">&#xf07a;</i>
    <span id="grozs">Grozs</span></a>
</div>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div  class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div  class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Sākumlapa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="veikals.php">Veikals</a>
              </li>
			  <?php 
				$sql = "SELECT id, nosaukums, saturs FROM lapas ORDER BY npk";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
				  // output data of each row
				  while($row = $result->fetch_assoc()) {
					$id=$row["id"];
					$nosaukums=$row["nosaukums"];
					echo '<li class="nav-item">
					<a class="nav-link" href="?id='.$id.'">'.$nosaukums.'</a>
				  </li>';

				  }
				}
				?>
            </ul>
        	<ul class="nav navbar-nav navbar-right"> 
				<?php if(isset($_SESSION['lietotajs']) && isset($_SESSION['pieteicies'])){ ?>
					<li><a id="admin" class="text-decoration-none" href="admin/profils.php">Mans profils</a></li>
					<?php
						if($_SESSION['pieeja']=="admin"){ ?>
					<li><a id="admin" class="text-decoration-none" href="admin/index.php">Administrācijas panelis</a></li>
						<?php } ?>
				<?php } ?>
				
				<li>

			<?php if($_SESSION['pieteicies'] == false){
				echo "<a id='login' class='text-decoration-none' href='login.php'> Pierakstīties </a>";
			}else{
				echo "<a id='login' class='text-decoration-none' href='logout.php'> Izrakstīties </a>";
			}?>
			</li>
			</ul>
          </div>
		 </div>
      </nav>
      </div>
      </div>
   

    <div class='container'>

	<div>
		<h3>Groza saturs</h3>
	</div>
	<div id="grozainfo" class='row'>
		<div id="precesinfo" class='col-8'>
			<span>Preces</span>
		</div>
		<div id="precesskaits" class='col'>
			<span>Skaits</span>
		</div>
		<div id="precescena" class='col'>
			<span>Cena</span>
		</div>
	</div>



<?php

				//=====Palielina preces skaitu====//
	if(isset($_POST['plus'])){
		$prece = (int)$_POST['precesid'];
		//echo $_SESSION["visaspreces"][$prece] = $_SESSION["visaspreces"][$prece] + 1;
		array_push($_SESSION['grozs'], $prece );
	}

				//==========Samazina preces=========//
	if(isset($_POST['minus'])){
		$prece = (int)$_POST['precesid'];
		foreach (array_keys($_SESSION['grozs'], $prece, true) as $key){
				unset($_SESSION['grozs'][$key]);
				break;	
		}
		
	}

				//======Izdzēst preci=====// Strādā
		if(isset($_POST['izdzest'])){
			//priekš int skaitļa
			$dzesamaisId=(int)$_POST['precesid'];
			foreach (array_keys($_SESSION['grozs'], $dzesamaisId, true) as $key) {
				$key."<br>";
				unset($_SESSION['grozs'][$key]);
				
			}
			//priekš string skaitļa
			$dzesamaisId=$_POST['precesid'];
			foreach (array_keys($_SESSION['grozs'], $dzesamaisId, true) as $key) {
				$key."<br>";
				unset($_SESSION['grozs'][$key]);
				//unset($_SESSION['visaspreces'][$dzesamaisId]);
			}
			
		}	

			//===========Pasūtīt preces=====// Strādā
	if(isset($_POST['pasutit']) && !empty($_SESSION['grozs'])){
		//izveido jaunu pasutijumu
		$lietotaja_id = $_SESSION['lietotaja_id'];
		$sql = "INSERT INTO pasutijumi (lietotaja_id, statuss)
          VALUES ('$lietotaja_id', 'Apstrādē')";
          if ($conn->query($sql) === TRUE) {
            echo  "<p>Prece tika pasūtīta!</p><br>";
			//Ja ir izveidots jauns pasūtījums, aizsūta datus pasūtījuma_preces
			$last_id = $conn->insert_id;
			$visaspreces = 	array_count_values($_SESSION['grozs'],);
			for($i=0;$i<sizeof($visaspreces);$i++){
				$keys= array_keys($visaspreces)[$i];
				$daudzums = $visaspreces[$keys];
				$sql = "INSERT INTO pasutijuma_preces (pasutijuma_id, preces_id, daudzums, cena) 
				VALUES ('$last_id','$keys', '$daudzums', (SELECT cena from preces WHERE id='$keys'))";
				$conn->query($sql);
			}
			unset($_SESSION['grozs']);
          } else {
            echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
          }
	}


				//========Izprintē visas preces============// Strādā
		
	if(!empty($_SESSION['grozs'])){
		$visaspreces = 	array_count_values($_SESSION['grozs'],);	
		for($i=0;$i<sizeof($visaspreces);$i++){
			$keys = array_keys($visaspreces)[$i];
			$values=array_values($visaspreces)[$i];
			$sql="SELECT * FROM preces WHERE id='$keys'";
			$result = $conn->query($sql);
			if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			}
?>
	<div id="grozainfo" class='row'>
		<div id="precesinfo" style="border-top:none" class='col-8'>
			<div >
				<img class="precesbilde" src=".<?php echo $row['foto'] ?>">
				<?php 
				//izprintē katras preces key
				?>
			</div>
			<div class="precesapraksts">
				<a href="./prece.php?id=<?php echo $row['id'] ?>" ><?php echo $row['nosaukums'];?></a>
				<p><?php echo $row['apraksts'];?></p>
			</div>
		</div>
		<div id="precesskaits" style="border-top:none" class='col'>
			<div class='skaits'>
				<form action="" method="post">
				<input class="paslept" type='number' name='precesid' value='<?php echo $keys?>'>
				<?php
				if($values > 1){
				?>
				<input type='submit' name='minus' value="-">
				<?php
				}else{
				?>
				<input type='submit' name='minus' value="-" disabled>
				<?php
				}
				?>
				<input type="number" name="skaits" value='<?php echo $values?>' style="width:75px;" disabled>
				<input type='submit' name='plus' value='+'>	
				<div class='izdzestdiv'>
					<input type='submit' name='izdzest' value='Izdzēst preci'>	
				</form>
				<!-- 
				<a style="color:black" data-confirm="Vai tiešām vēlaties džest preci?" href="./grozs.php?dzest=<?php echo $row['id'] ?>"><i class="fa fa-close"></i>izdzēst</a>
			-->	
			</div>
					
<?php				
					
?>

	</div>
		<p class="text-center">gab.</p>
	</div>
	<div id="precescena"  style="border-top:none"class='col'>
	<?php
	echo $row['cena'];
	?>
	</div>
	</div>
<?php

	}
}

					//=========Beidzas preču printēšana============
?>
	
	<div class="grozaapaksa">
<?php
		//aprēķina kopējo summu//Strādā
		if(!isset($kopejasumma)){
			$kopejasumma=0;
		}
		if(isset($_SESSION['grozs'])){
		$visaspreces = 	array_count_values($_SESSION['grozs'],);
		for($i=0;$i<sizeof($visaspreces);$i++){
			$keys= array_keys($visaspreces)[$i];
			$sql="SELECT cena FROM preces WHERE id='$keys'";
			$result = $conn->query($sql);
				if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				}
			$values=array_values($visaspreces)[$i];
			$kopejasumma = 	$kopejasumma +$row['cena']*$values;
		}
	}
?>
	<span class="precesCena">Kopā apmaksai: <?php echo $kopejasumma;?> Eiro</span>	
	<?php
	//Poga pasūtīšanai
	if(isset($_SESSION['grozs'])){
		?>
			<div class="pasutit">
				<form action="" method="post">
					<input type="submit" value="Pasūtīt" name="pasutit">
				</form>
			</div>
		<?php
		}
		?>
		</div>
				

		</div>
	</div>

<?php
	include "apaksa.php";
	echo "<---sesijas visas preces";
	echo "<br>";
	print_r($_SESSION['grozs']);
?>

</div>
</div>
</body>
</html>
