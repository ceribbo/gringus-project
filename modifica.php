<?php
include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if ($status != AUTH_LOGGED) {
    header("Refresh: 0;URL=logon.php?page=modifica.php");
    echo 'Devi eseguire il login, attendi di essere reindirizzato';
}
$query = "SELECT * FROM utenti WHERE username='" . $user['username'] . "'";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile reperire informazioni utente: " . mysqli_error());
}

$row = mysqli_fetch_array($result);
?> 
<html> 
    <head> 
        <title>Modifica Profilo</title> 
        <?php include("style/head.php");?>
    </head> 
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container"><b><font size="2"> 
                    <form action="include/modify.php" method="post" enctype="multipart/form-data"> 
                        <table cellspacing="2"> 
                            <tr><td>Immagine: </td><td><input type="file" name="miofile"></td></tr> 
                            <tr><td>Mail: </td> 
                                <td><input type="text" value="<?= $row['mail']; ?>" name="mail" size="30"></td> 
                            </tr> 
                            <tr><td>Telefono: </td> 
                                <td><input type="text" value="<?= $row['telefono']; ?>" name="telefono" size="30"></td></tr> 
                            <tr><td>Indirizzo: </td> 
                                <td><input type="text" value="<?= $row['indirizzo']; ?>" name="indirizzo" size="30"></td></tr> 
                            <tr><td>Città: </td> 
                                <td><input type="text" value="<?= $row['citta']; ?>" name="citta" size="30"></td></tr> 
                            <tr><td>Cap: </td> 
                                <td><input type="text" value="<?= $row['cap']; ?>" name="cap" size="30"></td></tr> 

                            <tr></tr><tr><td></td><td colspan="2"><input type="submit" name="action" value="Aggiorna"></td></tr> 
                        </table></form> 
                    <form action="include/reset.php" method="post"> 
                        <table cellspacing="2"> 
                            <tr><td>Vecchia Password: <input type="password" name="old_psw" size="20"></td></tr> 
                            <tr><td>Nuova Password: <input type="password" name="new_psw1" size="20"></td></tr> 
                            <tr><td>Nuova Password: <input type="password" name="new_psw2" size="20"></td></tr> 
                            <tr><td colspan="2"><input type="submit" name="action" value="Modifica password"></td></tr> 
                        </table></form> 

                    </font></b>
            </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php");?>
            </div>
        </div>

    </body>
</html>
