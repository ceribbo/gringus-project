<?php
include_once("include/config.php");
include_once("include/auth.lib.php");
list($status, $user) = auth_get_status();
if ($status != AUTH_LOGGED) {
    echo '<script languaguage="javascript">  
<!--  
window.location = "logon.php?page=index.php";   
//-->  
</script>';
}
//echo "latitudine: " . $_POST[latitude] . " --- longitudine: " . $_POST[longitude];  
$latitudine = $_POST[latitude];
$longitudine = $_POST[longitude];
$gringo = $_POST[gringo];
$lavoro = $_POST[lavoro];
$raggio = $_POST[raggio];
$richiesta = $_POST[richiesta];
$lavori = array("1%", "_1%", "__1%", "___1%", "____1%");


$query = "SELECT *
FROM offerte o, (SELECT oid, (6371 * ACOS( COS( RADIANS( $latitudine ) ) * COS( RADIANS( latitude ) ) *  
				 COS( RADIANS( longitude ) - RADIANS( $longitudine ) ) + SIN( RADIANS( $latitudine ) ) *  
						SIN( RADIANS( latitude ) ) ) ) AS distance
				 FROM offerte ) d
	
WHERE o.gringo='$gringo' 
		AND d.distance < ( $raggio )
		AND o.lavoro LIKE '$lavori[$lavoro]'  
		AND o.oid = d.oid
		ORDER BY d.distance
        LIMIT 30";
/* $query = "SELECT *, ( 6371 * ACOS( COS( RADIANS(" . $latitudine . ") ) * COS( RADIANS( latitude ) ) *  
  COS( RADIANS( longitude ) - RADIANS(" . $longitudine . ") ) + SIN( RADIANS(" . $latitudine . ") ) *
  SIN( RADIANS( latitude ) ) ) ) AS distance ".
  "FROM offerte ".
  "WHERE gringo='" . $gringo . "' ".
  "AND ( 6371 * ACOS( COS( RADIANS(" . $latitudine . ") ) * COS( RADIANS( latitude ) ) *
  COS( RADIANS( longitude ) - RADIANS(" . $longitudine . ") ) + SIN( RADIANS(" . $latitudine . ") ) *
  SIN( RADIANS( latitude ) ) ) ) < (" . $raggio . "+0.5) ".
  "AND lavoro LIKE '".$lavori[$lavoro]."' ".
  "ORDER BY distance".
  "LIMIT 30";
 */
//STORT PROCEDURE

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    die("Impossibile eseguire ricerca: " . mysqli_error());
}
?> 
<html> 
    <head> 
        <title>Trova</title> 
        <?php include("style/head.php"); ?>
        <script src="include/funzioni.js"></script>
    </head> 
    <body onload="javascript:getGringo('<?=$gringo?>');getLavoro('<?=$gringo?>','<?=$lavoro?>');">
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container"> 
                <table width="50%" border="1px"> 
                    <tr><th>Gringo: <div id="getGringo"></div>
                    <br>Lavoro: <div id="getLavoro"></div></th></tr>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) :
                            if ($row['distance'] >= 3) {
                                $distanza = number_format($row['distance'], 2) . " Km";
                            } else {
                                $distanza = number_format($row['distance'] * 1000, 0, '', '') . " Metri";
                            }
                            ?>
                            <tr><td>
                                    <table width="100%" cellspacing="0px" align="left">
                                        <form action="user.php?uth=<?= $row['username'] ?>" method="post" name="<?= $row['username'] ?>">
                                            <tr><td width="50%">Username:</td><td width="50%"><?= $row['username'] ?></td></tr>
                                            <tr><td width="50%">Tipologia:</td><td width="50%"><?= $row['tipo'] ?></td></tr>
                                            <?php
                                            if ($row['att'] == true) {
                                                echo '<tr><td width="50%">Attestato:</td><td width="50%">' . $row['attestato'] . "</td></tr>";
                                            }
                                            ?> 
                                            <tr><td width="50%">Lavora da:</td><td width="50%"><?=$row['dat_num']." ".$row['dat_tipo']?></td></tr>
                                            <tr><td width="50%">Distanza:</td><td width="50%"><?= $distanza ?></td></tr>
                                            <input type="hidden" name="dist" value="<?= $distanza ?>"> 
                                            <input type="hidden" name="lav" value="<?= $lavoro ?>">
                                            <input type="hidden" name="grin" value="<?= $gringo ?>">
                                            <input type="hidden" name="offer" value="<?= $utente ?>"> 
                                            <textarea name="richiesta" hidden="" ><?= $richiesta ?></textarea>
                                            <tr bgcolor="orange"><td><input type="submit" value="Contatta <?= $row['username'] ?>"></td><td></td></tr> 
                                        </form>
                                    </table>
                                </td></tr> 
                            <?php
                        endwhile;
                    } else {
                        echo '<tr><td>Non ci sono risultati riprova con altri parametri</td></tr>';
                    }
                    ?> 
                </table> 
            </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php"); ?>
            </div>
        </div>
    </body>
</html>
