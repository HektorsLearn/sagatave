<?php
session_start(); 
include "functions.php";
include "config.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Pieteikties</title>
	
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
	
	<meta charset="UTF-8"/> 
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
		
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	
</head>
<body>
	<div class="container">
	<div id="subtitle" class="container-fluid p-5 md-primary text-black text-center">
	<h1>Pieslēgties</h1>
	</div>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <div  class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div  class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Sākumlapa</a>
              </li>
            </ul>
        	<ul class="nav navbar-nav navbar-right"> 
			</ul><?php if($_SESSION['pieteicies'] == false){
				echo "<a id='login' class='text-decoration-none' href='login.php'> Pierakstīties </a>";
			}else{
				echo "<a id='login' class='text-decoration-none' href='logout.php'> Izrakstīties </a>";
			}?>
          </div>
		 </div>
      </nav>
	 <div class="container-fluid pt-3">   <!--Pieteikšanās forma -->
	<form id="forma" action="" method="post">
        <input type="text" name="username" placeholder="Ievadiet lietotājvārdu" required><br><br>
        <input type="password" name="password" placeholder="Ievadiet paroli" required><br><br>
		Atcerēties mani<input type="checkbox" name="atcereties"><br>
		<input type="submit" name="iesniegt" value="Pieteikties"><br>
		<a href='register.php'>Reģistrēties</a>
    </form>
		</div>
	<?php 

	//Pārbaudam vai forma tika iesniegta

	if(isset($_POST["iesniegt"])){
		
		//Ierakstam mainīgajos lietotājvārdu/paroli
		$username = $_POST['username'];
		$password = $_POST['password'];
		//Paņem no database username un tās paroli
		$sql = "SELECT * FROM lietotaji WHERE username='$username'";
		$result = $conn->query($sql);
		//Pārbauda vai eksistē vispār šāds lietotājs ar šādu lietotājvārdu
		if($result->num_rows == 0){
			echo "Šāds lietotājs neeksistē!";
		}
		//Pārbauda vai eksistē šāds lietotājs un pābrauda paroli
		if($result->num_rows > 0){
		$row = $result->fetch_assoc();
			if($row['active'] == 1){
				if (password_verify($password, $row['password'])){
					//ja pareizs piešķir sesijas un cookie aktīvo profilu
					$pieteicies = true;
					$_SESSION["pieteicies"] = true;
					$_SESSION["lietotajs"] = $row['username'];
					$_SESSION['pieeja'] = $row['access'];
					$_SESSION['lietotaja_id']=$row['id'];

					//Saglabā cookies iekšā lietotājvārdu un vai ir pieteicies 30dienas, ja ir atzīmēt formā atcerēties
					if(isset($_POST['atcereties'])){
						setcookie("lietotajs", $username, time() + (86400 * 30));
						setcookie('pieteicies', true, time() + (86400 * 30));
					}
					header("Location:index.php");
					exit();
				}elseif(password_verify($password, $row['password']) == FALSE){
					echo "Nav ievadīta pareiza parole!<br>";
				}
			}else{
				echo "Šis konts ir neaktīvs. Lūdzu sazināties ar administrātoru, lai aktivizētu kontu!";
			}
		}
	
	}
	
	?>

<br><br>
<p>Pieslēgšanās parametri priekš pārbaudes:<br>
	Lietotājvārds: henrijs024<br>
	Parole: Zakis123
</p>
<?php
        include "apaksa.php";
		
      ?>
</div>
</body>
</html>
