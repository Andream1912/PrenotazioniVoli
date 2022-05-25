<?php
/*includo parametri.php*/
require_once "parametri.php";
/*avvio la sessione*/
session_start();
/*setto una variabile alla data corrente*/
$now = date('Y-m-d\TH:i:s.u');
/*effettuo i controlli per la session e il get del form*/
if(isset($_SESSION['username'])||!empty($_SESSION['username'])){
    $creatore = $_SESSION['username'];
}
else{
    $creatore ="";
}
if(isset($_GET['code'])||!empty($_GET['code'])){
    $id=$_GET['code'];
}
else{
    $id="";
}
if(isset($_GET['descriptionText'])||!empty($_GET['descriptionText'])){
    $descrizione=$_GET['descriptionText'];
}
else{
    $descrizione="";
}
/*richiamo e controllo che la funzione pr modificare la descrizione vada a buon fine*/
if(modifyDescription($descrizione, $now, $id, $db)){
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
else{
    echo "<p>Errore nell'aggiornamento della descrizione</p>";
}
/* Funzioni per la modifica */
/*tramite una query update aggiorna la data corrente*/
function modifyDescription($descrizione, $now, $id, $db){
    $sql="UPDATE discussioni SET descrizione = $1,data_modifica = $2 WHERE id=$3";
    $prep=pg_prepare($db, "updateDate", $sql);
    $ret=pg_execute($db, "updateDate", array($descrizione, $now, $id));
    if(!$ret){
        return false;
    }
    else{
        return true;
    }
}
?>