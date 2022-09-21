<h3>Pievienot ziņas</h3>
<div class="vidus">
<div class = "pievienot">
<form action="" method="post">
    <textarea class="textarea" name="text" placeholder="Whats happening"></textarea>
    <input class="poga" type="submit" placeholder="tweet" name="pievienot" value="Pievienot">
</form>
</div>
<div class="linija"></div>

<?php
if(isset($_POST["pievienot"]) && isset($_SESSION['lietotajs'])&& ($_POST['text'] !== "")){
    //Ja forma par sadaļu pievienošanu tika aizpildīta, tad liekam atsūtītos datus datubāzē 
    $text = $_POST["text"];
    $lietotajs = $_SESSION['lietotajs'];
    //Pārbaudam vai ievadītais nosaukums jau neatbilst no datubāzes.
    //Ja nav šādu ierakstu, ievietojam datus datubāzē
    $sql = "INSERT INTO zinas (saturs, autors)
    VALUES ('$text', '$lietotajs')";

    if ($conn->query($sql) === TRUE) {
    echo  "<p>Ziņa tika ievietota veiksmīgi!</p><br>";
    } else {
    echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
    }
}
?>
<?php
    //=========Paziņojums lai pieslēdzās//
    if(isset($_POST["pievienot"]) && !isset($_SESSION['lietotajs'])){
        echo "<p style='color:red;'>Lai pievienotu ziņas, lūdzu pierakstieties!</p>";
    }
?>

<!-- Ziņu izdrukāšana vidus lapā -->
<div class="border bg-light">
    <?php
        $sql = "SELECT * FROM zinas ORDER BY laiks DESC" ;
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $autors=$row['autors'];
                $sql2 ="SELECT * FROM lietotaji WHERE username='$autors'";
                $result2 = $conn->query($sql2); 
                $row2 = $result2->fetch_assoc()
                ?>
                    <div class='zinas'>
                        <div class="zinastop">
                        <b><?php if(isset($row2['vards'])){
                            echo $row2['vards']." ";
                        }
                        if(isset($row2['uzvards'])){
                            echo $row2['uzvards']." ";
                        }                                
                        ?>
                        </b>
                        <?php
                            echo "@".$row['autors']." ";                  
                            $date1 = strtotime($row['laiks']);
                            $date2 = strtotime(date('Y-m-d H:i:s', strtotime('+1 hours')));
                            $diff = abs($date2 - $date1);
                            $years = floor($diff / (365*60*60*24));
                            $months = floor(($diff - $years * 365*60*60*24)/ (30*60*60*24));
                            $days = floor(($diff - $years * 365*60*60*24 -$months*30*60*60*24)/ (60*60*24));
                            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
                            if($years > 0){
                                echo $years." y";
                            }elseif($months > 0){
                                echo $months." m";
                            }elseif($days > 0){
                                    echo $days." d";
                            }elseif($hours > 0){
                                echo $hours." h";
                            }elseif($minutes > 1){
                                echo $minutes." min";
                            }else{
                                echo "Now";
                            }
                        ?>
                        </div>
                        <div class='zina'><?php echo $row['saturs'];?></div>
                        <div class="zinasapaksa">
                            
                            <input type="hidden" id="custId" name="komentet" value="<?php echo $row['id']?>">
                            <button class="comment" onclick="komentet()" name="komentet">Komentēt</button>
                            <button class="comment" onclick="komentet()" name="">Dalīties</button>
                       
                        </div>
                    </div>
                <?php
            }
        }
    ?>
</div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal">

    <div class="modal-content">
        <span class="close" onclick="aizvert()">&times;</span>
            <?php 
            if(isset($_GET['komentet']))
            echo "snagls";
            $sql = "SELECT * FROM zinas WHERE id =''";

            ?>

            <form>
                
            </form>
    </div>
</div>
<script>
// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
var btn = document.getElementById("myBtn");

 function komentet() {
  modal.style.display = "block";
}
function aizvert() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>


