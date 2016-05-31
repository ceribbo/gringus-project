<?php
include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if ($status == AUTH_LOGGED & auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK) {
    $link = "?uid=" . $_GET['uid'];
} else
    $link = '';
?>
<html>
    <head>
        <?php include("style/head.php"); ?>
        <title>Home</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="include/funzioni.js"></script>
    </head>
    <body onload="javascript:mostraGringo();
            aggiornaLavoro();">
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container">  
                <table id="home">
                    <tr>
                        <th>Trova</th>
                        <th>Offri</th>
                    </tr>
                    <tr>
                        <td id="left">
                            <form action="trova.php" method="post" class="geocode" onsubmit="javascript:checkCoord();" name="form">
                                <table class="tabellahome">
                                    <tr>
                                        <td>Tipologia di Gringo</td>
                                        <td>
                                            <select name="gringo" id="gringo" onChange="aggiornaLavoro();">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tipologia di Lavoro</td>
                                        <td>
                                            <select name="lavoro" >
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dove hai bisogno del Gringo?</td>
                                        <td>
                                            Geolocalizzati <input type="radio" onclick="javascript:mostraGringo();
                                                    unolaltro();" name="opz" required="">
                                            <div id="aspegeoloc" style="display:none;font-size: 70%;"></div>

                                            <br>Inserisci la tua via  <input type="radio" onclick="javascript:unolaltro();" name="opz" id="coord">
                                            <div id="ind" style="display:none"><input type="text" name="via" id="via"/>
                                            </div>

                                            <input type="hidden" name="latitude" id="latitude" required="" value="">
                                            <input type="hidden" name="longitude" id="longitude" required="" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Specifica raggio di azione:</td>
                                        <td>
                                            <select name="raggio" >
                                                <option value="1000" selected="selected">Nessun Limite</option>
                                                <option value="100">100 Km</option>
                                                <option value="50">50 Km</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Specifica la tua richiesta:</td>
                                        <td>
                                            <textarea name="richiesta"  rows="4" required=""></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><input onclick="javascript:sloggato('<?= $status ?>')" type="submit"></td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                        <td id="right" onclick="javascript:sloggato('<?= $status ?>')">
                            <b><a href="offri.php">Sei nuovo?</a>
                                <br><br><br><br>
                                Aggiornalo!</b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php"); ?>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var geocoder = new google.maps.Geocoder();
                $('form.geocode').submit(function (e) {
                    if (document.getElementById('coord').checked) {
                        var that = this;
                        var address = document.getElementById('via').value + ", <?= $user['citta']; ?>";
                        e.preventDefault();
                        $(that).unbind('submit');
                        var onSuccess = function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                var latitudine = results[0].geometry.location.lat();
                                var longitudine = results[0].geometry.location.lng();
                                document.getElementById('latitude').value = latitudine;
                                document.getElementById('longitude').value = longitudine;
                            }
                            $(that).trigger('submit');
                        }
                        geocoder.geocode({'address': address}, onSuccess);
                    } else {
                        if (!document.getElementById('latitude').value || !document.getElementById('longitude').value)
                            return false;
                    }
                });
            });
        </script>
    </body>
</html>