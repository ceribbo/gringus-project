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
$query = "DELETE FROM preventivi WHERE pid='". $_GET['pid'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile eliminare: " . mysqli_error());
}else{
    echo '<script languaguage="javascript">  
<!--  
window.location = "../preventivi.php";   
//-->  
</script>';
}
?>