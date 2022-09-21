<?php
session_start();
include "functions.php";
include "config.php";
pieteicies();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="script.js"></script>

	
	
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
       
    <?php
    //Nolasa datus ivēlētajai precei ar id no url
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql = "SELECT * FROM preces WHERE id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
      


          //=====Pievieno Session grozam ====
      if(isset($_POST['pievienot'])){
        $id=$_POST['pievienot'];
        array_push($_SESSION['grozs'], $_POST['pievienot'] );
      echo "Prece tika pievienota";


    }
    ?>

<div class="precescontainer">
    <div class="precesimg">
        <img src=".<?php echo $row['foto']?>">
    </div>

    <div class="aprakstacontainer">
    <div class="precesNos">
        <h1 class="text-center"><?php echo $row['nosaukums'] ?></h1>
    </div>
    <div >
        <p class="precesapr"><?php echo $row['apraksts'];?></p>
    </div>

    <div class="pasutitPreci">
        <div>

        <form action="" method="post">
            <button value="<?php echo $id;?>" name="pievienot" type='submit' class='addCart'> Pievienot grozam<i class="fa fa-shopping-cart"></i></button>
        </form>
        </div>
        <div > 
            <span class="precesCena"><?php echo $row['cena']; ?> EIRO </span>
        </div>
    </div>
    </div>

</div>

<?php
        
        }
    }


    ?>
    <!--Beidzas item container -->
        



<?php
        include "apaksa.php";
?>

</div>
</div>
</body>
</html>
