function abilita_modifica() {
    var f = document.forms['personal_data_form'].getElementsByTagName('input');
    for (var i = 0; i < f.length; i++) {
        f[i].disabled = false;
    }
    document.getElementById('update_data').style.display = "block";


}

function informazioni_personali() {
    document.getElementsByName("informazioni_personali")[0].style.border = "2px solid #3498db";
    document.getElementsByName("personal_data")[0].style.display = "flex";

}

function prenotazioni_correnti() {
    document.getElementsByName("prenotazioni_btn")[0].style.border = "2px solid #3498db";
    document.getElementsByName("prenotazione_personale")[0].style.display = "flex";
    document.getElementsByName("prenotazioni")[0].style.display = "block";
    document.getElementsByName("voli_passati")[0].style.display = "none";
}

function prenotazioni_passate() {
    document.getElementsByName("prenotazioni_btn")[0].style.border = "2px solid #3498db";
    document.getElementsByName("prenotazione_personale")[0].style.display = "flex";
    document.getElementsByName("voli_passati")[0].style.display = "block";
}