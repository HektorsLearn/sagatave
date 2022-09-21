<?php
if(isset($_SESSION['lietotajs'])){
?>

<div class="apaksa">
<div class="chatdiv">
<div class='chatpoga'onclick="atvertcatu('chatkaste')">
    <p>Čats</p>
</div>

<div class='chatbox' id="chatkaste">
    <div class='chataugsa' onclick="aizvertcatu('chatkaste')">
        <div class="ierobezojums">
            <div class="indikators"></div>
        </div>
        <div>
        <p>Čats</p>
        </div>
    </div>
    <div>
    <?php
        $lietotajs = $_SESSION['lietotajs'];
        $sql="SELECT * FROM lietotaji WHERE username <> '$lietotajs'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $chatter = $row["username"];
                ?>
                <div class='chatlietotaji' onclick='atvertcatu("<?php echo $chatter ?>poga")'><?php 
                if($row['vards']== "" AND $row['uzvards'] ==""){
                    echo "@".$chatter;
                } else{
                   echo $row['vards']." ".$row['uzvards'];
                }?> 
                </div>
                <?php
            }
        }
    ?>
    </div>

    <div class="chatmeklet">
            <input class="chatinput" maxlength="30" placeholder="Meklēt lietotāju">
    </div>
</div>
</div>



    <?php
    //  Izprintē visus čatus ar lietotājiem
        $lietotajs = $_SESSION['lietotajs'];
        $sql="SELECT * FROM lietotaji WHERE username <> '$lietotajs'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $chatter = $row["username"];
                ?>
                <div>
                <!-- Poga ar lietotaju-->
                <div class="chatdiv" id="<?php echo $chatter;?>poga" style="display:none">
                    <div class='chatpoga2' >
                        <div class="chatname" onclick="atvertcatu('<?php echo $chatter;?>')">
                        <?php echo $chatter;?>
                        </div>
                        <div class="chatclose" onclick="aizvertcatu('<?php echo $chatter ?>poga')">&#10005</div>
                    </div>
                <!-- Čats ar lietotaju-->
                    <div class='chatbox2' style="display:none" id="<?php echo $chatter;?>">
                        <div class='chataugsa' onclick="aizvertcatu('<?php echo $chatter;?>')">
                                <div class="ierobezojums">
                                    <div class="indikators"></div>
                                </div>
                                <div class="chatname"><?php echo $chatter; ?></div>
                                <div class="chatclose" onclick="aizvertcatu('<?php echo $chatter ?>poga')">&#10005</div>
                        </div>
<?php 
    $sql2 = "SELECT * FROM cats WHERE nosutitajs='$chatter' OR sanemejs = '$chatter'";
    $result2 = $conn->query($sql2);
        while($row2 = $result2->fetch_assoc()) {
            echo "<div>".$row2['nosutitajs'].": ".$row2['zina']."</div>";
        }
?>

                        <div class="chatnosutit">
                                <form action="" method="post">
                                    <input class="chatinput" placeholder="Nosūtīt ziņu" name="catot" value="">
                                    <input type="submit" name="nosutit">
                                </form>
        
<?php
        

        // Nosūta ziņu 
    if(isset($_POST['nosutit']) && ($_POST['catot']) != ""){
        $text = $_POST['catot'];
        $sql = "INSERT INTO cats (nosutitajs, sanemejs, zina)
        VALUES ('$lietotajs', '$chatter', '$text')";
        if ($conn->query($sql) === TRUE) {
            echo  "<p>Ziņa tika nosūtīta!</p><br>";
          } else {
            echo  "<p>Kļūda!</p> " . $sql . "<br>" . $conn->error;
          }
    }

    $text = "";
    echo $chatter;
    echo $lietotajs;

?>
                                
                        </div>
                </div>
                </div>
        </div>
                
            <?php
            }
        }
    ?>
</div>

<script>

    function atvertcatu(id) {
    document.getElementById(id).style.display = "block";
  }
  function aizvertcatu(id) {
    document.getElementById(id).style.display = "none";
  }

</script>


<?php
}
?>