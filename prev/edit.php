<?php
include_once("../include/config.php"); 
include_once("../include/auth.lib.php"); 
list($status, $user) = auth_get_status(); 

$query = "SELECT * FROM preventivi WHERE pid = '" . $_GET['pid'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
$row = mysqli_fetch_array($result);
if (($status != AUTH_LOGGED) || ($row['offer']!=$user['username'])) {
    echo '<script languaguage="javascript">  
<!--  
window.location = "../logon.php?page=preventivi.php";   
//-->  
</script>';
}
$query = "UPDATE preventivi SET testo='".$_POST['testo']."', prezzo=".$_POST['prezzo']
        .", turn='".$row['finder']."' WHERE pid='". $_GET['pid'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile aggiornare preventivo: " . mysqli_error());
}else{
    echo '<script languaguage="javascript">  
<!--  
window.location = "../prev.php?pid='.$_GET['pid'].'";   
//-->  
</script>';
}
?>