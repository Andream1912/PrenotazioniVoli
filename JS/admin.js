function nasconi_tabella() {
    document.getElementById("tabella_utenti").style.display = "none";
}

function elimina_utenti() {
    document.getElementsByName("elimina_utenti")[0].style.border = "2px solid #3498db";
    document.getElementsByName("visualizza_utenti")[0].style.display = "flex";

}

function aggiungi_voli() {
    document.getElementsByName("aggiungi_voli")[0].style.border = "2px solid #3498db";
    document.getElementsByName("btn_aggiungi_voli")[0].style.display = "flex";

}