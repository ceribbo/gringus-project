<?php

include_once("config.php");
include_once("auth.lib.php");
list($status, $user) = auth_get_status();
if ($status != AUTH_LOGGED) {
    echo '<script languaguage="javascript">  
            <!--  
            window.location = "../logon.php";   
            //-->  
            </script>';
}

if ($_GET['code']!="") echo '<script languaguage="javascript">  
        <!--  
        window.location = "https://accounts.google.com/o/oauth2/token?' .
         'code='.$_GET['code'].
         '&client_id=737940042710-8e6uidepkeop672pc3615pgrni1nqgo1.apps.googleusercontent.com' .
         '&redirect_uri=http://www.gringus.tk/include/regGoogle.php' .
         '&response_type=token' .
         '&scope=https://www.googleapis.com/auth/plus.login">;
            //-->
            </script>';
/*
 * https://www.googleapis.com/plus/v1/people/me?fields=id&key={YOUR_API_KEY}

$query = "UPDATE utenti SET codeGoogle = '".$_GET['code']."' WHERE username = '".$user['username']."'";
echo $query;
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile reperire informazioni utente: " . mysqli_error());
}else{
   /* echo '<script languaguage = "javascript">
<!--
window.location = "../account.php";
//-->  
</script>'; 
}*/

