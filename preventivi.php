<?php 
include_once("include/config.php"); 
include_once("include/auth.lib.php"); 

list($status, $user) = auth_get_status(); 

if ($status != AUTH_LOGGED) { 
    echo '<script languaguage="javascript">  
<!--  
window.location = "logon.php?page=preventivi.php";   
//-->  
</script>'; 
} 
$query = "SELECT * FROM preventivi WHERE offer = '" . $user['username'] . "' OR finder = '" . $user['username'] . "' ORDER BY data DESC"; 
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);  
if (!$result) {  
    die("Impossibile reperire preventivi utente: ".mysqli_error()); 
}  
?> 
<html> 
    <head> 
        <title>Preventivi</title> 
        <?php include("style/head.php");?>
    </head> 
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
             <div class="container">  
            <b><table border="2"> 
                    <font size="2"> 
                    <?php 
                    if (mysqli_num_rows($result) > 0) { 
                        while ($row = mysqli_fetch_assoc($result)) : 
                            if ($row['attiv'] == 0) { 
                                $sfondo = "ORANGERED"; 
                                if ($row['offer'] == $user['username']) { 
                                    if ($row['turn']==$user['username'])    {
                                        $attivo = "Devi modificare il preventivo di ".$row['prezzo']."€"; 
                                    }else{
                                        $attivo = "Il preventivo di ".$row['prezzo']."€"." deve ancora essere accettato";
                                    }
                                    $testo = "Devi andare a lavorare da " . $row['finder']; 
                                } else { 
                                    if ($row['turn']==$user['username'])    {
                                        $attivo = "Accetta o chiedi di modificare il preventivo di ".$row['prezzo']."€";
                                    }else{
                                        $attivo = "Il lavoratore deve accettare la tua richiesta di preventivo";
                                    }
                                    $testo = $row['offer'] . " verrà a lavorare da te"; 
                                } 
                            } else { 
                                $sfondo = "SPRINGGREEN"; 
                                if ($row['offer'] == $user['username']) { 
                                    $testo = "Dovrai eseguire il lavoro da" . $row['finder']; 
                                    $attivo = "Preventivo accettato per ".$row['prezzo']."€"; 
                                } else { 
                                    $testo = $row['offer'] . " verrà a lavorare da te"; 
                                    $attivo = "Hai accettato il preventivo per ".$row['prezzo']."€"; 
                                } 
                            } 
                            ?> 
                            <tr bgcolor="<?= $sfondo ?>"> 
                                <td> 
                                    <?= $testo ?> 
                                    <br>Tipo di lavoro: <?= $row['lav'] ?> 
                                    <br><?= $attivo ?>
                                    <br><a href="prev.php?pid=<?= $row['pid']?>"><input type="submit" value="Visualizza preventivo" ></a>
                                </td> 
                            </tr> 
                            <?php 
                                endwhile; 
                            } else { 
                                echo '<tr><td>Non hai preventivi attivi</td></tr>'; 
                            } 
                            ?> 
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