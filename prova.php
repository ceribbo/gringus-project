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
    <body>
        <div id="header">
            <?php include("include/header.php") ?>
        </div>
        <div id="page">
            <div class="container">


                <form class="geocode" action="include/offr.php" method="post"> 
                    <table cellspacing="2">
                        <tr>
                            <td>Di quale lavoro "Eco" di occupi?</td>
                            <td>
                                <select name="gringo" id="gringo">
                                    <option value="fotovoltaico">Impianto Fotovoltaico</option>
                                    <option value="ecoedilizia">Ecoedilizia</option>
                                    <option value="pompe">Pompe di calore</option>
                                </select>
                            </td>
                            <td></td>
                        <tr><td
                                <div class="checkboxes"></div>
                            </td></tr>
                        <tr>
                            <td>Sei una Società o Libero Professionista:</td>
                            <td>
                                <select name="tipo" >
                                    <option value="societa" selected="selected">Società</option>
                                    <option value="libero">Libero Professionista</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Dove Lavori:</td>
                            <td>
                                Geolocalizzati <input type="radio" onclick="javascript:geoloc();
                                        caricaLocalizzazione();" name="opz" required="">
                                <br>Inserisci la tua via  <input type="radio" onclick="javascript:geoloc();"name="opz" id="coord">
                                <div id="ind" style="display:none"><input type="text" name="via" id="via"/>
                                </div>

                                <input type="text" name="latitude" id="latitude" hidden="" required="">
                                <input type="text" name="longitude" id="longitude" hidden="" required="">
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
                                <textarea type="text" name="migliorare" rows="5" cols="28" required=""></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Qualche aspetto "Green" su di te:</td>
                            <td>
                                <textarea type="text" name="aspetti" rows="5" cols="28" required=""></textarea>
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
                                <input type="text" name="tag" required="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="invia">

                            </td>
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
        <script id="jsbin-javascript">
// salva qui la tua lista di checkbox, e per comodita' io lascerei un oggetto con keys i nomi dei value del select
            var dati = {
                fotovoltaico: ['pinguino', 'anatra'],
                ecoedilizia: ['mario', 'luigi', 'andrea'],
                pompe: ['milano', 'torino']
            };

// quando la scelta cambia esegui una funzione
            $('#gringo').on('change', function mostraCheckbox(e) {
                // previene comportamenti default, per sicurezza lo specifico sempre quando ci sono input/form
                e.preventDefault();

                // pulisci i valori precendeti che si erano creati
                $('.checkboxes').empty();

                // controlla che sia stato scelto un valore nel select (not empty)
                if ($(this).val()) {
                    // seleziona l'array che corrisponde all'opzione scelta e fai un ciclo su tutti gli elementi
                    dati[$(this).val()].forEach(function (element) {
                        //crea l'input checkbox con il value e testo
                        var checkbox = '<input type="checkbox" name="checkbox" value="' + element + '">' + element + '<br>';
                        // aggiungi questo input alla lista dei checkbox
                        $('.checkboxes').append(checkbox);
                    });
                }

            });
        </script>
    </body>
</html>