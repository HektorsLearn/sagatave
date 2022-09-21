<?php 


if(isset($_GET['q'])){
    //Ja tiek padots atslēgvārds q
    include "config.php";
    
    $atslegvards = $_GET['q'];

    $sql="SELECT nosaukums,id FROM preces WHERE nosaukums LIKE  '$atslegvards%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo "<a style='text-decoration:none;color:black' href=prece.php?id=".$row['id']."><div style='border:solid 1px black;margin-bottom:2px;'>";
        echo $row['nosaukums']."<br>";
        echo "</div></a>";
    }
    }
}



if(isset($_GET['l'])){
    //Ja tiek padots atslēgvārds q
    include "config.php";
    
    $lietotajs = $_GET['l'];

    $sql="SELECT username FROM lietotaji WHERE username LIKE  '$lietotajs%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        //Iemet augšā linkā augšā 
        echo "<a href='./sazina.php?lietotajs=".$row['username']."'>".$row['username']."</a>";
    }
    }
}

if(isset($_GET['zinas'])){
    include "config.php";
    echo $sanemejs = $_GET['zinas'];
    $sql = "SELECT * FROM cats WHERE sanemejs = '$sanemejs'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        echo $row['zina']."<br>";
    }
    }
}

?>