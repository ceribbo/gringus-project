<?php
include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if ($status != AUTH_LOGGED) {
    echo '<script languaguage="javascript">  
<!--  
window.location = "logon.php?page=account.php";   
//-->  
</script>';
}
$gringo = $_POST['grin'];
$lavoro = $_POST['lav'];
$utente = $_GET['uth'];
$lavori = array("1%", "_1%", "__1%", "___1%", "____1%");
$query = "SELECT * FROM utenti WHERE username = '" . $utente . "'";
$query2 = "SELECT * FROM offerte WHERE username = '" . $utente . "' AND lavoro LIKE '$lavori[$lavoro]' ";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
if (!$result || !$result2) {
    die("Impossibile determinare info utente: " . mysqli_error());
}
$row = mysqli_fetch_array($result);
$off = mysqli_fetch_array($result2);
if (!$row['img']) {
    $row['img'] = "content/profilo.jpg";
}
?> 
<html> 
    <head> 
        <title>Profilo di <?= $utente; ?></title>
        <?php include("style/head.php"); ?>
        <script src="include/funzioni.js"></script>
    </head> 
    <body onload="javascript:getGringo('<?=$gringo?>');getLavoro('<?=$gringo?>','<?=$lavoro?>');">
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container">    

                <font size="2"> 
                <br><img src="<?= $row['img'] ?>" height="100" width="100"> 
                <table cellspacing="2"> 
                    <tr><td>Username: </td><td><?= $row['username']; ?></td></tr> 
                    <tr><td>Nome: </td><td><?= $row['name']; ?></td></tr> 
                    <tr><td>Citta: </td><td><?= $row['citta']; ?></td></tr> 
                    <tr><td>Distanza: </td><td><?= $_POST['dist']; ?></td></tr> 
                </table> 
                </font> 
                <form action="prev/new.php" method="post">
                    <table border="2"> 
                        <tr> 
                            <td>Gringo: <div id="getGringo"></div> 
                                <br>Lavoro: <div id="getLavoro"></div>
                                <br>Tipo: <?= $off['tipo']?>
                                <br>Aspetti: <?= $off['aspetti']; ?> 
                                <?php
                                            if ($row['att'] == true) {
                                                echo '<br>Attestato: ' . $row['attestato'];
                                            }
                                            ?> 
                                <br>Voto: <?= $off['voto']; ?> 
                                <br>Lavora da: <?= $off['dat_num'] . " " . $off['dat_tipo']; ?> 
                                <br><textarea name="richiesta" rows="4" ><?= $_POST[richiesta] ?></textarea>
                                <br><input type="submit" value="Richiedi preventivo">
                            </td> 
                        </tr> 
                    </table>
                    <input type="hidden" name="offer" value="<?= $utente ?>"> 
                    <input type="hidden" name="finder" value="<?= $user['username'] ?>"> 
                    <input type="hidden" name="lav" value="<?= $_POST['lav'] ?>"> 
                    <input type="hidden" name="prezzo" value="<?= $off['prezzo'] ?>"> 
                </form> 
            </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php"); ?>
            </div>
        </div>

    </body>
</html>