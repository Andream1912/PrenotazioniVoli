<?php
/*includo parametri.php*/
require_once "parametri.php";
/*inizo la sessione*/
session_start();
/*setto una variabile alla data attuale*/
$now = date('Y-m-d\TH:i:s.u');
/*setto una variabile con il numero di righe della tabella + 1*/
$codice = count_rows($db)+1;
/*effettuo i controlli sulla session e il get del form*/
if(isset($_SESSION['username'])||!empty($_SESSION['username'])){
    $partecipante = $_SESSION['username'];
}
else{
    $partecipante ="";
}
if(isset($_GET['code'])||!empty($_GET['code'])){
    $id=$_GET['code'];
}
else{
    $id="";
}
if(isset($_GET['responseText'])||!empty($_GET['responseText'])){
    $testo=$_GET['responseText'];
}
else{
    $testo="";
}
/*richiamo la funzione per aggiungere la risposta al db verificando che l'inserimento sia andato a buon fine*/
if(add_response($codice, $id, $partecipante, $testo, $now, $db)){
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
else{
    echo "<p>Errore nell'inserimento della risposta</p>";
}
/*aggiorno la data dell'ultima modifica effettuata alla discussione*/
if(update_date($id, $now, $db)){
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
else{
    echo "<p>Errore nell'aggiornamento della data</p>";
}

/*Funzioni per risposte*/ 
/*fuznione per contare le righe della tabella*/
function count_rows($db){
    $sql = "SELECT * FROM risposte";
    $result = pg_query($db, $sql);
    $rows = pg_num_rows($result);
    return $rows;
}
/*funzione per aggiungere la risposta al db con insert into*/
function add_response($codice, $id, $partecipante, $testo, $now, $db){
    $sql = "INSERT INTO risposte(codice, id_discussione, partecipante, testo, data_risposta) 
    VALUES($1, $2, $3, $4, $5)";
    $prep=pg_prepare($db, "createResponse", $sql);
    $ret=pg_execute($db, "createResponse", array($codice, $id, $partecipante, $testo, $now));
    if(!$ret){
        return false;
    }
    else{
        return true;
    }
}
/*funzione per aggiornare la data di ultima modifica tramite la variabile $now*/
function update_date($id, $now, $db){
    $sql="UPDATE discussioni SET data_modifica = $2 WHERE id=$1";
    $prep=pg_prepare($db, "updateDate", $sql);
    $ret=pg_execute($db, "updateDate", array($id, $now));
    if(!$ret){
        return false;
    }
    else{
        return true;
    }
}
?>