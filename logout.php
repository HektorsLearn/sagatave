<?php
session_start(); 
include "functions.php";
?>

<!DOCTYPE html>
<html>

<body>

<?php
session_unset();

//Nodzēš cookies, ja izlagojas

//Pāradresācija uz sākumlapu
header("Location:index.php");

if(isset($_COOKIE["lietotajs"])){
    unset($_COOKIE["lietotajs"]);
    unset($_COOKIE["pieteicies"]);
    unset($_COOKIE["pieeja"]);
    setcookie("lietotajs", "", time() - 3600);
    setcookie("pieteicies", "", time() - 3600);
}
if(isset($_SESSION["pieteicies"])){
    $_SESSION["pieteicies"] = false;
}
exit();
?>
</body>
</html>
