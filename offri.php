<?php
include_once("include/config.php");
include_once("include/auth.lib.php");

list($status, $user) = auth_get_status();

if ($status != AUTH_LOGGED) {
    echo '<script languaguage="javascript"> 
<!-- 
window.location = "logon.php?page=offert.php";  
//--> 
</script>';
}
?>
<html>
    <head>
        <title>Offri</title>
        <?php include("style/head.php"); ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="include/funzioni.js"></script>
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>

    </head>
    <body onload="javascript:mostraGringo();">
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container">


                <form class="geocode" action="include/offr.php" method="post"> 
                    <table class="tabellaoffri">
                        <tr>
                            <td>Di quale lavoro "Eco" di occupi?</td>
                            <td>
                                <select name="gringo" id="gringo">
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Specifica su cosa sei più portato (settore):</td>
                            <td>
                                <div class="checkboxes">
                                    <input type="hidden" name="lavori[0]" value="0">
                                    <input type="checkbox" name="lavori[0]" value="1">Produzione Energia Elettrica
                                    <br>
                                    <input type="hidden" name="lavori[1]" value="0">
                                    <input type="checkbox" name="lavori[1]" value="1">Produzione Acqua Calda
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Sei una Società o Libero Professionista:</td>
                            <td>
                                <select name="tipo">
                                    <option value="societa" selected="selected">Società</option>
                                    <option value="libero">Libero Professionista</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Indica preferenza per la tua zona lavorativa:</td>
                            <td>
                                Geolocalizzati <input type="radio" onclick="javascript:unolaltro();" name="opz" required="">
                                <div id="aspegeoloc" style="display:none;font-size: 70%;"></div>
                                <br>Inserisci la tua via  <input type="radio" onclick="javascript:unolaltro();" name="opz" id="coord">
                                <div id="ind" style="display:none"><input type="text" name="via" id="via"/>
                                </div>

                                <input type="hidden" name="latitude" id="latitude" required="" value="">
                                <input type="hidden" name="longitude" id="longitude" required="" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>Attestato:</td>
                            <td>Si <input type="radio" onclick="javascript:yesnoCheck();" name="att" value="1" id="yesCheck" required="">
                                No <input type="radio" onclick="javascript
                                        :yesnoCheck();" name="att" value="0" id="noCheck"><br>
                                <div id="ifYes" style="display:none" >
                                    Che tipo di attestato: <input type='text' name='attestato' id="attestato">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Da un voto alle tue capacità:</td>
                            <td>
                                <select name="voto" >
                                    <option value="1" selected="selected">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Da quanto tempo sei pratico?</td>
                            <td>
                                <select name="dat_num" required="">
                                    <option value="1" selected="selected">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">10+</option>
                                </select>
                                <select name="dat_tipo" >
                                    <option value="mese/i" selected="selected">Mese/i</option>
                                    <option value="anno/i">Anno/i</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Cosa aspiri a migliorare dal punto di vista ecosostenibile</td>
                            <td>
                                <textarea type="text" name="migliorare" rows="5" width="100%" required=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Qualche aspetto "Green" su di te:</td>
                            <td>
                                <textarea type="text" name="aspetti" rows="5" width="100%" required=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Partita IVA</td>
                            <td>
                                <input type="text" name="piva" required="">
                            </td>
                        </tr>
                        <tr>
                            <td>Ricerca a filtri</td>
                            <td>
                                <input type="text" name="tag" required="" onmouseover="javascript:conta();">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="invia" ></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div id="foot">
            <div class="footer">
                <?php include("style/footer.php"); ?>
            </div>
        </div>
        <script>
            //funzione per la geolocalizzazione
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
            //funzione per la modifica dei checkbox
            // quando la scelta cambia esegui una funzione
            $(document.getElementById('gringo')).on('change', function mostraCheckbox(e) {
                // previene comportamenti default, per sicurezza lo specifico sempre quando ci sono input/form
                e.preventDefault();

                // pulisci i valori precendeti che si erano creati
                $('.checkboxes').empty();
                var i = 0;
                // controlla che sia stato scelto un valore nel select (not empty)
                if ($(this).val()) {
                    // seleziona l'array che corrisponde all'opzione scelta e fai un ciclo su tutti gli elementi
                    dati[$(this).val()].forEach(function (element) {
                        //crea l'input checkbox con il value e testo
                        var checkbox = '<input type="hidden" name="lavori[' + i + ']" value="0">';
                        // aggiungi questo input alla lista dei checkbox
                        $('.checkboxes').append(checkbox);
                        checkbox = '<input type="checkbox" name="lavori[' + i + ']" value="1">' + element + '<br>';
                        // aggiungi questo input alla lista dei checkbox
                        $('.checkboxes').append(checkbox);
                        i++;
                    });
                }
            });

        </script>
    </body>
</html>
