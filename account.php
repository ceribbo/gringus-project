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
$query = "SELECT * FROM utenti WHERE username='" . $user['username'] . "'";
$query2 = "SELECT * FROM offerte WHERE username = '" . $user['username'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
if (!$result || !$result2) {
    die("Impossibile reperire informazioni utente: " . mysqli_error());
}
$row = mysqli_fetch_array($result);
$off = mysqli_fetch_array($result2);
if (!$row['img']) {
    $img = "content/profilo.jpg";
} else {
    $img = $row['img'];
}
?> 
<html> 
    <head> 
        <title>Profilo</title> 
        <?php include("style/head.php"); ?>
    </head> 
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container">  
                <b> 

                    <font size="2"> 
                    <br><img src="<?= $img ?>" height="100" width="100"> 
                    <table cellspacing="2"> 
                        <tr><td>Username: </td><td><?= $user['username']; ?></td></tr> 
                        <tr><td>Nome: </td><td><?= $user['name']; ?></td></tr> 
                        <tr><td>Cognome: </td><td><?= $user['surname']; ?></td></tr> 
                        <tr><td>Data di Nascita: </td><td><?= $row['giorno']; ?>-<?= $row['mese']; ?>-<?= $row['anno']; ?></td></tr> 
                        <tr><td>Mail: </td><td><?= $row['mail']; ?></td></tr> 
                        <tr><td>Telefono: </td><td><?= $row['telefono']; ?></td></tr> 
                        <tr><td>Indirizzo: </td><td><?= $row['indirizzo']; ?></td></tr> 
                        <tr><td>Citta: </td><td><?= $row['citta']; ?></td></tr> 
                        <tr><td>Cap: </td><td><?= $row['cap']; ?></td></tr> 
                        <tr><td>
                                <a href="https://accounts.google.com/o/oauth2/auth?client_id=737940042710-8e6uidepkeop672pc3615pgrni1nqgo1.apps.googleusercontent.com&redirect_uri=http://www.gringus.tk/include/regGoogle.php&response_type=code&scope=https://www.googleapis.com/auth/plus.login">
                                    <img height="50" width="250" src="content/social/goole.png">
                                </a>
                            </td></tr>
                    </table> 
                    </font> 
                </b> 
                <div align="left"><a href="modifica.php">Modifica dati</a> 
                </div>
                Le tue offerte attive 
                <table border="2"> 
                    <?php
                    if (mysqli_num_rows($result2) > 0) {
                        do {
                            echo "<tr><td>Lavoro: " . $off['lavoro'];
                            echo "<br>Prezzo: " . $off['prezzo'] . "€";
                            echo "<br>Aspetti: " . $off['aspetti'];
                            $att = "Nessun attestato";
                            if ($off['att'] == true)
                                $att = $off['attestato'];
                            echo "<br>Attestato: " . $att;
                            echo "<br>Voto: " . $off['voto'];
                            echo "<br>Lavora da: " . $off['dat_num'] . " " . $off['dat_tipo'];
                            echo "<br>Mezzo: " . $off['mezzo'] . "</td></tr>";
                        }while ($off = mysqli_fetch_assoc($result2));
                    }else {
                        echo 'Attualmente non offri alcun lavoro';
                    }
                    ?> 

                </table> 
            </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php"); ?>
            </div>
        </div>

    </body>
</html>