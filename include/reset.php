<?php 

include_once("config.php"); 
include_once("auth.lib.php"); 
list($status, $user) = auth_get_status(); 
$res = mysqli_query($GLOBALS["___mysqli_ston"], " 
    SELECT password 
    FROM " . $_CONFIG['table_utenti'] . " 
    WHERE username='" . $user['username'] . "'"); 
$row = mysqli_fetch_array($res,  MYSQLI_BOTH); 
if (md5($_POST[old_psw]) != $row['password']) { 
    header("Refresh: 3;URL=../modifica.php"); 
    echo 'La password che hai inserito non è corretta: riprova'; 
} else if ($_POST[new_psw1] != $_POST[new_psw2]) { 
    header("Refresh: 3;URL=../modifica.php"); 
    echo 'Le nuove password che hai inserito non coincidono: riprova'; 
} else { 
    $query = "UPDATE utenti SET password=MD5('" . $_POST[new_psw1] . "') 
            WHERE username='" . $user['username'] . "'"; 
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query); 
    if (!$result) { 
        die("Errore nell'esecuzione dell'operazione: " . mysqli_error());
    } else { 
        header("Location: ../modifica.php"); 
    } 
} 
?> 