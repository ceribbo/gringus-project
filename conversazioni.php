<?php 
include_once("include/config.php"); 
include_once("include/auth.lib.php"); 

list($status, $user) = auth_get_status(); 

if ($status != AUTH_LOGGED) { 
    echo '<script languaguage="javascript">  
<!--  
window.location = "logon.php?page=conversazioni.php";   
//-->  
</script>'; 
} 
$query = "SELECT * FROM conversazioni WHERE usr_to='" . $user['username'] . "' " 
        . "OR usr_from='" . $user['username'] . "' ORDER BY data DESC"; 

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query); 
if (!$result) { 
    die("Impossibile reperire informazioni utente: ".mysqli_error());
} 
?> 
<html> 
    <head> 
        <title>Conversazioni</title> 
        <?php include("style/head.php");?>
    </head> 
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
             <div class="container">  
            <b><table border='2'> 
                    <font size="2"> 
                    <?php 
                    if (mysqli_num_rows($result) > 0) { 
                        while ($cid = mysqli_fetch_assoc($result)) { 
                            if ($cid['usr_from'] == $user['username']) 
                                $destinatario = $cid['usr_to']; 
                            else 
                                $destinatario = $cid['usr_from']; 
                            ?> 
                    <tr><td><a href="messaggi.php?mess=<?= $destinatario ?>"><?= $destinatario ?></a></td></tr> 
                            <?php 
                        } 
                    } else { 
                        echo '<tr><td>Non ci sono conversazioni presenti</td></tr>'; 
                    } 
                    ?> 
                </table> 
            </b> 
         </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php");?>
            </div>
        </div>

    </body>
</html>