<?php 
include_once("include/config.php"); 
include_once("include/auth.lib.php"); 

list($status, $user) = auth_get_status(); 

if ($status != AUTH_LOGGED) { 
    echo '<script languaguage="javascript">  
<!--  
window.location = "logon.php?page=messaggi.php";   
//-->  
</script>'; 
} 
$query = "SELECT cid FROM conversazioni WHERE usr_to='" . $user['username'] . "' AND usr_from='" . $_GET['mess'] . "'" 
        . " OR usr_from='" . $user['username'] . "' AND usr_to='" . $_GET['mess'] . "'"; 

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query); 
$cid = mysqli_fetch_array($result,  MYSQLI_ASSOC); 
if (!$result) { 
    die("Impossibile reperire messaggi con " . $_GET['mess'] . ": " . mysql_error());
} 
?> 
<html> 
    <head> 
        <title>Messaggi con <?= $_GET['mess'] ?></title> 
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
                    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM messaggi WHERE conv= " . $cid['cid'] . " ORDER BY data") 
                            or die("Errore nella ricerca dei messaggi". mysql_error());
                            while ($row = mysqli_fetch_assoc($result)) { 
                        if ($row['usr_to'] == $user['username']) { 
                            ?> 
                            <tr> 
                                <td bgcolor="red"> 
                                    <?= $row['text'] ?> 
                                    <br><font size='1'><?= $row['data'] ?></font> 
                                </td><td> 
                                </td> 
                            </tr> 
                        <?php } else { ?> 
                            <tr> 
                                <td></td> 
                                <td bgcolor="green"> 
                                    <?= $row['text'] ?> 
                                    <br><font size='1'><?= $row['data'] ?></font> 
                                </td> 
                            </tr> 
                            <?php 
                        } 
                    } 
                    ?> 
                    <tr> 

                    <form action="include/send.php" method="POST"> 
                        <td colspan="2"> 
                            <input type="text" name="messaggio" size="100%"> 
                            <input type="hidden" name="cid" value="<?=$cid['cid']?>"> 
                            <input type="hidden" name="destinatario" value="<?= $_GET['mess'] ?>"> 
                            <input type="submit" value="Invia"> 
                        </td> 
                    </form> 
                    </tr> 
                    </font> 
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
