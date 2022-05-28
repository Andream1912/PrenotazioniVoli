//funzione per nascondere la tabella se non si sono voli
function nascondi_tabella() {
    document.getElementById("tabella_utenti").style.display = "none";
}
//funzione per mostare card elimina utente
function elimina_utenti() {
    document.getElementsByName("elimina_utenti")[0].style.border = "2px solid #3498db";
    document.getElementsByName("visualizza_utenti")[0].style.display = "flex";
}
//funzione per mostrare la card aggiungi voli
function aggiungi_voli() {
    document.getElementsByName("aggiungi_voli")[0].style.border = "2px solid #3498db";
    document.getElementsByName("btn_aggiungi_voli")[0].style.display = "flex";

}
//funzione per la validazione del form che permette di aggiungere i voli
function validateAggiungiVoli(){
    //prendo tutti gli input del form 
    let data_volo=document.getElementsByName("data_volo")[0];
    let citta_partenza=document.getElementsByName("citta_partenza")[0];
    let ora_partenza=document.getElementsByName("ora_partenza")[0];
    let citta_arrivo=document.getElementsByName("citta_arrivo")[0];
    let ora_arrivo=document.getElementsByName("ora_arrivo")[0];
    let prezzo=document.getElementsByName("prezzo")[0];
    let posti_disponibili=document.getElementsByName("posti_disponibili")[0];
    //prendo la data di oggi
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
    
    if(data_volo.value==""||citta_partenza.value==""||ora_partenza.value==""||citta_arrivo.value==""||ora_arrivo.value==""||prezzo.value==""||posti_disponibili==""){
        if(data_volo.value=="" || data_volo.value<data_oggi){
            data_volo.style.border="2px solid red";
        }
        else{
            data_volo.style.border="2px solid black";
        }
        if(citta_partenza.value==""){
            citta_partenza.style.border="2px solid red";
        }
        else{
            citta_partenza.style.border="2px solid black";
        }
        if(ora_partenza.value==""){
            ora_partenza.style.border="2px solid red";
        }
        else{
            ora_partenza.style.border="2px solid black";
        }
        if(citta_arrivo.value==""){
            citta_arrivo.style.border="2px solid red";
        }
        else{
            citta_arrivo.style.border="2px solid black";
        }
        if(ora_arrivo.value==""||ora_arrivo.value<=ora_partenza.value){
            ora_arrivo.style.border="2px solid red";
        }
        else{
            ora_arrivo.style.border="2px solid black";
        }
        if(prezzo.value==""||prezzo.value<0){
            prezzo.style.border="2px solid red";
        }
        else{
            prezzo.style.border="2px solid black";
        }
        if(posti_disponibili.value==""||posti_disponibili.value<0){
            posti_disponibili.style.border="2px solid red";
        }
        else{
            posti_disponibili.style.border="2px solid black";
        }
        return false;
    }
    if((data_volo.value<data_oggi)||prezzo.value<0||posti_disponibili.value<0||ora_arrivo.value<=ora_partenza.value){
        if(data_volo.value<data_oggi){
            data_volo.style.border="2px solid red";
        }
        else{
            data_volo.style.border="2px solid black";
        }
        if(prezzo.value<0){
            prezzo.style.border="2px solid red";
        }
        else{
            prezzo.style.border="2px solid black";
        }
        if(posti_disponibili.value<0){
            posti_disponibili.style.border="2px solid red";
        }
        else{
            posti_disponibili.style.border="2px solid black";
        }
        if(ora_arrivo.value<=ora_partenza.value){
            ora_arrivo.style.border="2px solid red";
        }
        else{
            ora_arrivo.style.border="2px solid black";
        }
        return false;
    }
    return true;
    
}
//funzione che mi permette di far partire un confirm nel caso in cui premo il bottone cancella nella sezione elimina utente
function confirm_elimina_account(){
    if (confirm("Sei sicuro di voler eliminare questo account ?") == true) {
        return true;
      } else {
        return false;
      }
}