<button id="chatpoga" class="open-button" onclick="openForm()"><b>Čats</b></button>

<div class="chat-popup" id="myForm">
  <form action="index.php" class="form-container" method="post">
    <h1>Saziņa</h1>

    <label for="msg"><b>Ziņas</b></label>
    <textarea placeholder="Type message.." name="msg" required></textarea>
    <button type="submit" class="btn" name="nosutit"><b>Nosūtīt</b></button>
    <button type="button" class="btn cancel" onclick="closeForm()"><b>Aizvērt</b></button>
  </form>
</div>
<script>
function openForm() {
    document.getElementById("myForm").style.display = "block";
    document.getElementById("chatpoga").style.display = "none";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
    document.getElementById("chatpoga").style.display = "initial";
  }
</script>

<?php
    //Nosūtīt ziņu 
    if(isset($_POST["nosutit"]) && $_POST["msg"] !== "" && isset($_SESSION['lietotajs'])){
        $zina = $_POST["msg"];
        $lietotajs = $_SESSION['lietotajs'];
        $sql = "INSERT INTO cats (nosutitajs, zina)
        VALUES ('$lietotajs', '$zina')";
    
        if ($conn->query($sql) === TRUE) {
        echo  "<p>Ziņa tika ievietota veiksmīgi!</p><br>";
        } else {
        echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
        }
    }
   
?>