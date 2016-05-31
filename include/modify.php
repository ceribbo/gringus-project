<?php 
include_once("config.php"); 
include_once("auth.lib.php"); 
list($status, $user) = auth_get_status(); 
if ($status != AUTH_LOGGED) { 
    echo '<script languaguage="javascript">  
<!--  
window.location = "logon.php?page=modifica.php";   
//-->  
</script>'; 
} 
     
    if(!trim($_FILES["miofile"]["name"]) == '')  { 
        if(!is_uploaded_file($_FILES["miofile"]["tmp_name"]) or $_FILES["miofile"]["error"]>0){   
            echo 'Si sono verificati problemi nella procedura di upload!';   
        } 
         
        $tipi_consentiti = array("gif","png","jpeg","jpg");   
        $max_byte = 200000;   
         
        $stringa =__DIR__."/../content/pp/".$user['username']."/"; 
        if(!is_dir($stringa)) { 
            mkdir($stringa, 0700); 
        } 
        if(!move_uploaded_file($_FILES["miofile"]["tmp_name"], $stringa.$_FILES["miofile"]["name"]))  {
                echo "Immagine non inserita"; 
        }else{
            //$query = "SELECT "
        }
        $query = "UPDATE utenti SET mail='$_POST[mail]', telefono='$_POST[telefono]', 
        indirizzo='$_POST[indirizzo]',citta='$_POST[citta]',cap='$_POST[cap]',img='/content/pp/".$user['username']."/".$_FILES["miofile"]["name"]."' 
            WHERE username='".$user['username']."'"; 
    }else{ 
        $query = "UPDATE utenti SET mail='$_POST[mail]', telefono='$_POST[telefono]', 
        indirizzo='$_POST[indirizzo]',citta='$_POST[citta]',cap='$_POST[cap]' 
            WHERE username='".$user['username']."'"; 
    } 


$result = mysqli_query($GLOBALS["___mysqli_ston"], $query); 
if (!$result) { 
    die("Impossibile reperire informazioni utente: ".mysqli_error());
} 
else { 
    header("Location: ../account.php"); 
} 
?> 