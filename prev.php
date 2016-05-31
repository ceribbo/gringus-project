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
$query = "SELECT * FROM preventivi WHERE pid = '" . $_GET['pid'] . "'";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile determinare info utente: " . mysqli_error());
}
$row = mysqli_fetch_array($result);
if (!($row['offer']==$user['username']||$row['finder']==$user['username'])) {
    echo '<script languaguage="javascript">  
<!--  
window.location = "preventivi.php";   
//-->  
</script>';
}
if ($row['attiv']==0)   {
    if ($row['turn']==$user['username'])    {
        if ($row['offer']==$user['username'])   {
            $azione = '<a href="prev/editprev.php?pid='.$row['pid'].'"><button>Modifica Preventivo</button></a>';
            $redit = $row['redit'];
        }else{
            $azione = '<a href="prev/accept.php?pid='.$row['pid'].'"><button>Accetta Preventivo</button></a>'
                    . '<a href="prev/redit.php?pid='.$row['pid'].'"><button>Richiedi Modifica Preventivo</button></a>';
        }
    }else{
        if ($row['offer']==$user['username'])   {
            $azione = "In attesa che il preventivo sia accettato";
        }else{
            $azione = "In attesa del Preventivo";
        }
    }
}else{
    if ($row['paid']==true)   {
        $azione = "Pagamento effettuato";
    }else{
        if ($row['offer']==$user['username'])   {
            $azione = "In attesa del pagamento";
        }else{
            $azione = '<a href="prev/pay.php?pid='.$row['pid'].'"><button>Effettua Pagamento</button></a>';
        }
    }
}
?> 
<html> 
    <head> 
        <title>Preventivo</title> 
        <?php include("style/head.php");?>
    </head> 
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
             <div class="container"> 
            <b> 
                <table cellspacing="2" border="1"> 
                    <tr><td>Richiedente: </td><td><?= $row['finder']; ?></td></tr> 
                    <tr><td>Offerente: </td><td><?= $row['offer']; ?></td></tr> 
                    <tr><td>Oggetto del Preventivo: </td><td><?= $row['lav']; ?></td></tr> 
                    <tr><td>Prezzo: </td><td><?php
                            if ($row['prezzo'] == NULL)
                                echo "In attesa di risposta";
                            else
                                echo $row['prezzo']."€";
                            ?></td></tr> 
                    <tr><td>Richiesta del preventivo: </td><td><?= $row['richiesta']; ?></td></tr>
                    <tr><td>Preventivo: </td><td><?= $row['testo']; ?></td></tr>
                    <tr><td><?= $azione ?></td>
                        <td>
                            <?php if (!$row['attiv']) echo '<a href="prev/delete.php?pid='.$row['pid'].
                                    '"><button>Elimina Preventivo</button></a>';?></td></tr>
                    <?php if ($redit!=null) echo "<tr><td>Motivo Richiesta Modifica</td><td>".$redit."</tr></td>";?>
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