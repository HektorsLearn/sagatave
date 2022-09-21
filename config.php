<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sagatave';



//izveidojam savienojumu
$conn = new mysqli($servername, $username, $password, $dbname);
//Pārbaudam savienojumu

if($conn->connect_error){
    die("Pieslēgums datubāzei neizdevās:".$conn->connect_error);
}

function restartet(){
    echo "<meta http-equiv='refresh' content='0'>";
}
?>
