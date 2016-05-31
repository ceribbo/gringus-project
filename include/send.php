<?php

include_once("config.php");
include_once("auth.lib.php");
list($status, $user) = auth_get_status();
$query = "INSERT INTO messaggi (conv, usr_from, usr_to, data, text) "
        . "VALUES (".$_POST['cid'].", '".$user['username']."', '".$_POST['destinatario']."', now(), "
        . "'".$_POST['messaggio']."')";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

$query2 = "UPDATE conversazioni SET data = now() WHERE cid = ".$_POST['cid'];
$result2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2); 
if (!$result||!$result2) { 
    die("Errore nell'esecuzione dell'operazione: ".mysqli_error());
} else {
    header("Location: ../messaggi.php?mess=".$_POST['destinatario']);
}
?>
