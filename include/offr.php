<?php
include_once("config.php");
include_once("auth.lib.php");
list($status, $user) = auth_get_status();
$stri = "";
foreach ($_POST["lavori"] as $key => $value) { 
      $stri = $stri.$value;
   } 
$query = "INSERT INTO offerte (username, latitude, longitude, gringo, lavoro, tipo, att, attestato, voto, dat_num, dat_tipo, migliorare, aspetti, piva)"
        . " VALUES ('".$user['username']."', '$_POST[latitude]', '$_POST[longitude]', '$_POST[gringo]', "
        . "'$stri', '$_POST[tipo]','$_POST[att]', '$_POST[attestato]', '$_POST[voto]', "
        . "'$_POST[dat_num]', '$_POST[dat_tipo]', '$_POST[migliorare]', '$_POST[aspetti]', '$_POST[piva]')";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query); 
if (!$result) { 
    die("Errore nell'esecuzione dell'operazione: ".mysqli_error());
} 
else {
    header("Location: ../account.php");
}
?>
