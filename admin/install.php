<?php
include '../config.php';

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS lapas (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nosaukums VARCHAR(255) NOT NULL,
taka VARCHAR(255) NOT NULL,
saturs TEXT,
laiks TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  echo "<p>Tabula lapas veiksmīgi izveidota!</p>";
} else {
  echo  "<p>Kļūda veidojot tabulu 'lapas'</p>: " . $conn->error;
}

// izveidojam tabulu preces
$sql = "CREATE TABLE IF NOT EXISTS preces (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nosaukums VARCHAR(255) NOT NULL,
  cena VARCHAR(10) NOT NULL,
  foto VARCHAR(255),
  apraksts TEXT,
  kategorijas_id int(11)
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula preces veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu preces: " . $conn->error. "</p>";
  }

  // izveidojam tabulu kategorijas
$sql = "CREATE TABLE IF NOT EXISTS kategorijas (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nosaukums VARCHAR(255) NOT NULL
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula kategorijas veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu kategorijas: " . $conn->error. "</p>";
  }

    // izveidojam tabulu kategorijas
$sql = "CREATE TABLE IF NOT EXISTS kategorijas (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nosaukums VARCHAR(255) NOT NULL
  )";
  
  if ($conn->query($sql) === TRUE) {
    echo "<p>Tabula kategorijas veiksmīgi izveidota!</p>";
  } else {
    echo "<p>Kļūda veidojot tabulu kategorijas: " . $conn->error. "</p>";
  }

?>