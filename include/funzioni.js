var dati = {
    fotovoltaici: ['Produzione Energia Elettrica', 'Produzione Acqua Calda'],
    elettronica: ['Per la casa - Frigo, lavatrice, lavastoviglie', "Per l'illuminazione - LED, CFL, OLED"],
    consulenze: ['Consulenza Generale Casa', 'Isolamento termico'],
    ecoedilizia: ['Sostituzione Infissi con materiali ad alte prestazioni energetiche', 'Isolamento Termico Muri'],
    pompe: ['Aria-Aria','Aria-Acqua','Acqua-Acqua','Terreno-Acqua']
};
var gringo = {
    fotovoltaici:['Installazione Impianti Fotovoltaici'],
    manutenzione:['Manutenzione ed Assistenza Impianto Fotovoltaico'],
    elettronica:['Elettronica a basso consumo'],
    consulenze:['Consulenze e Risparmio Energetico'],
    ecoedilizia:['Ecoedilizia'],
    roofgarden:['Roof Garden'],
    pompe:['Pompe di Calore']
}
//////////////////////////////////////////////////////////////////////////////


function updateLocation(position) { //funzione che ricava i dati di localizzazione e li inserisce nell'html
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lon;
    document.getElementById("aspegeoloc").innerHTML = '<img src="/content/images/done.png" height="15px" width="15px">';
}
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.display = 'block';
        document.getElementById('attestato').required = 'true';

    }
    else {
        document.getElementById('ifYes').style.display = 'none';
        document.getElementById('attestato').removeAttribute('required');
    }
}
function unolaltro() {
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    if (document.getElementById('coord').checked) {
        //caso selezione via
        document.getElementById('ind').style.display = 'block';
        document.getElementById('via').required = 'true';
        document.getElementById('aspegeoloc').style.display = 'none';
        document.getElementById("aspegeoloc").innerHTML = '';

    } else {
        //caso geolocalizzazione
        document.getElementById("aspegeoloc").innerHTML = '<img src="/content/images/load.GIF" height="15px" width="15px">';
        document.getElementById('ind').style.display = 'none';
        document.getElementById('via').removeAttribute('required');
        document.getElementById('aspegeoloc').style.display = 'block';
        document.getElementById('aspegeoloc').style.display = 'inline';
        if (navigator.geolocation) { // verifica se la geolocalizzazione è supportata dall'hardware
            navigator.geolocation.getCurrentPosition(updateLocation);
        } else {
            document.getElementById("aspegeoloc").innerHTML = "Impossibile eseguire Geolocalizzazione";
            return;
        }
    }
}
function checkCoord() {
    if (!document.getElementById('coord').checked) {
        if (document.getElementById('latitude').value == "" ||
                document.getElementById('longitude').value == "") {
            alert("ATTENZIONE\n\errore nel tentativo di geolocalizzazione!\n\Attendere qualche secondo e poi riprovare!");
            return false;
        }
    }
}
function selezionaOpzioni(scelta) {
    /*Resetto le opzioni precedenti del campo*/
    var selectLavoro = document.form.lavoro;
    selectLavoro.options.length = 0;
    /*verifico la scelta e aggiungo i campi*/
    for (gri in gringo){
        if (scelta == gri) {
            for (var i=0;i<dati[gri].length;i++)    {
                selectLavoro.options[selectLavoro.options.length] = new Option(dati[gri][i],i);
            }
        }
    }
}
function mostraGringo(){
    var selectGringo = document.getElementById('gringo');
    for (gri in gringo){
        selectGringo.options[selectGringo.options.length] = new Option(gringo[gri][0],gri);
    }
}
function aggiornaLavoro() {
    var selezionato = document.getElementById('gringo').selectedIndex;
    var campo = document.getElementById('gringo').options;
    selezionaOpzioni(campo[selezionato].value);
}
function sloggato(loggato) {
    if (loggato != 99)
        window.location = "logon.php?page=index.php";
}
function getGringo(gringus) {
    document.getElementById('getGringo').innerHTML = ""+gringo[gringus];
}
function getLavoro(gringus,lavorus) {
    document.getElementById('getLavoro').innerHTML = ""+dati[gringus][lavorus];
}