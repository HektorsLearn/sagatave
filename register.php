<?php
session_start(); 
include "functions.php";
include "config.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Reģistrēties</title>
	
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
	<h1>Reģistrēties</h1>
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
          </div>
		 </div>
      </nav>
	 <div class="container-fluid pt-3">   
    <h3>Jauna lietotāja piereģistrēšanās</h3>
        <!--Reģistrēšanās forma -->
	<form action="register.php" method="post" autocomplete="off">
        <input type="text" name="lietotajvards" autocomplete="false" placeholder="Lietotājvārds" required ><br><br>
        <input type="password" name="parole" placeholder="Parole" required><br><br>
        <input type="password" name="parole2" placeholder="Atkārtot paroli" required><br><br>
        <input type="submit" name="iesniegt" value="Reģistrēties">
    </form>
		</div>
	<?php 
    if(isset($_POST['iesniegt'])){
        $lietotajvards = $_POST["lietotajvards"];
        $password = $_POST['parole'];
        $password2 = $_POST['parole2'];
    }

    if(isset($_POST['iesniegt'])){
      //======Paskatās vai ir jau šāds profils ar šādu lietotājvārdu ============//
        $sql2 = "SELECT * FROM lietotaji WHERE username = '$lietotajvards'";
        $result2 = $conn->query($sql2);
        //Ja paroles ir vienādas un nav šāds lietotājvārds, tad reģistrē profilu ar public pieeju
        if(($password == $password2 )&& ($result2->num_rows == 0)){ 
            //sahasho paroli
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO lietotaji (username, password, access) VALUES ('$lietotajvards', '$hashedpassword', 'public')";
            if (mysqli_query($conn, $sql)){
                echo "Jūs esat piereģistrējušies";
            } else {
                 echo "Error: ". $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            $password = "";
            $password2 = "";
            echo "Lūdzu, ievadiet vienādas paroles vai citu lietotājvārdu!";
        }
    }
	?>
    <!--Pārlādē lapu, lai notīrītu  -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


  </div>

</body>
</html>
