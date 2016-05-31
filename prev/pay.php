<?php
include_once("../include/config.php");
include_once("../include/auth.lib.php");
list($status, $user) = auth_get_status();

if ($status != AUTH_LOGGED) {
    echo '<script languaguage="javascript">  
<!--  
window.location = "../logon.php?page=preventivi.php";   
//-->  
</script>';
}
$query = "UPDATE preventivi SET paid = 1 WHERE pid='". $_GET['pid'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile pagare: " . mysqli_error());
}else{
    echo '<script languaguage="javascript">  
<!--  
window.location = "../prev.php?pid='.$_GET['pid'].'";   
//-->  
</script>';
}
?>