//funzione che mi permette di abilitare la modifica del form alla pressione del bottone modifica
function abilita_modifica() {
    var f = document.forms['personal_data_form'].getElementsByTagName('input');
    for (var i = 0; i < f.length; i++) {
        f[i].disabled = false;
    }
    document.getElementById('update_data').style.display = "block";
}
// 3 funzioni permettono di settare i display dei div a seconda della card selezionata
function informazioni_personali() {
    document.getElementsByName("informazioni_personali")[0].style.border = "2px solid #3498db";
    document.getElementsByName("personal_data")[0].style.display = "flex";

}
function prenotazioni_correnti() {
    document.getElementsByName("btn_prenotazioni")[0].style.border="2px solid black";
    document.getElementsByName("prenotazioni_btn")[0].style.border = "2px solid #3498db";
    document.getElementsByName("prenotazione_personale")[0].style.display = "flex";
    document.getElementsByName("prenotazioni")[0].style.display = "block";
    document.getElementsByName("voli_passati")[0].style.display = "none";
}
function prenotazioni_passate() {
    document.getElementsByName("btn_voliPassati")[0].style.border="2px solid black";
    document.getElementsByName("prenotazioni_btn")[0].style.border = "2px solid #3498db";
    document.getElementsByName("prenotazione_personale")[0].style.display = "flex";
    document.getElementsByName("voli_passati")[0].style.display = "block";
}
//funzioni male e female per gestire la proprieta checked del imput radio
function male(){
    document.getElementById("male").checked = true;
}
function female(){
    document.getElementById("female").checked = true;
}
//dunzione per attivare il confirm alla pressione del tasto cancella
function confirm_elimina_account(){
    if (confirm("Sei sicuro di voler eliminare il tuo account??") == true) {
        return true;
      } else {
        return false;
      }
}
//funzione per la validazione del form
function validateDatiPersonali(){
    let data_nascita=document.getElementsByName("data_nascita")[0];
    let numerotel=document.getElementsByName("numerotel")[0];
    var today=new Date();
    var anno=today.getFullYear();
    var mese=(today.getMonth()+1);
    var giorno=today.getDate();
    if(mese<10){
        mese='0'+mese;
    }
    if(giorno<10){
        giorno='0'+giorno;
    }
    var data_oggi=anno+'-'+mese+"-"+giorno;
    
    if(data_nascita.value!=""||numerotel.value!=""||cap.value!=""){
        if(data_nascita.value>data_oggi||numerotel.value.toString().length>=12||cap.value.toString().length>=6){
            if(data_nascita.value>data_oggi){
            
                data_nascita.style.border="2px solid red";
            }else{
                data_nascita.style.border="2px solid black";
            }
            if(numerotel.value.toString().length>=12){
                
                numerotel.style.border="2px solid red";
            }
            else{
                
                numerotel.style.border="2px solid black";
            }
            if(cap.value.toString().length>=6){
                
                cap.style.border="2px solid red";
            }
            else{
                
                cap.style.border="2px solid black";
            }
            return false;
        }
    
    }
    return true;
}

