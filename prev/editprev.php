<?php

include_once("../include/config.php");
include_once("../include/auth.lib.php");

list($status, $user) = auth_get_status();
if ($status != AUTH_LOGGED) {
    echo '<script languaguage="javascript">  
        <!--  
        //window.location = "logon.php?page=preventivi.php";   
        //-->  
        </script>'."errore";
}
$query = "SELECT * FROM preventivi WHERE pid='" . $_GET['pid'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile selezionare preventivo: " . mysqli_error());
}
$row = mysqli_fetch_array($result);
if (!$row['offer'] == $user['username']) {
    echo '<script languaguage="javascript">  
        <!--  
        window.location = "../preventivi.php";   
        //-->  
        </script>';
}
?>

<html> 
    <head> 
        <title>Modifica Preventivo</title> 
    </head> 
    <body> 
        <div align="center"> 
            <?php include("../include/menu.php"); ?> 
            <form action="edit.php?pid=<?=$row['pid']?>" method="post">
                <table border="1">
                    <tr><td><input name="prezzo" value="<?=$row['prezzo'] ?>"></td></tr>
                    <tr><td><textarea name="testo" ><?=$row['testo']?></textarea></td></tr>
                    <tr><td><input type="submit" value="Invia Preventivo"></td></tr>
                </table>
            </form>
        </di</div>
    </body>
</html>