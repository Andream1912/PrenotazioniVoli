<?php 
    /*importo parametri.php*/
    require_once "parametri.php";
    /*inizio la sessione*/
    session_start();
    /*effettuo controlli sulle variabili di sessione e passate tramite form*/
    if(isset($_SESSION['username'])||!empty($_SESSION['username'])){
        $creatore = $_SESSION['username'];
    }
    else 
        $creatore = "";
    if(isset($_GET['discussionTitle'])||!empty($_GET['discussionTitle'])){
        $discussion_title = $_GET['discussionTitle'];
    }
    else
        $discussion_title = "";
    if(isset($_GET['discussionText'])||!empty($_GET['discussionText'])){
        $discussion_text = $_GET['discussionText'];
    }
    else
        $discussion_text = "";
    /*aggiungo la discussione al db verificando se va a buon fine*/
    if(add_discussion($creatore, $discussion_title, $discussion_text, $db)){
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
    else{
        echo "<p>Errore durante la creazione della discussione</p>";
    }
    /*Funzioni per discussioni*/

    /*funzione che conta le righe del db*/
    function count_rows($db){
        $sql = "SELECT * FROM discussioni";
        $result = pg_query($db, $sql);
        $rows = pg_num_rows($result);
        return $rows;
    }

    /*funzione che aggiunge una discussione*/
    function add_discussion($creatore, $discussion_title, $discussion_text, $db){
        $now = date('Y-m-d\TH:i:s.u');
        $id = count_rows($db)+1;
        $sql = "INSERT INTO discussioni(creatore, id, titolo, descrizione, data_creazione) 
        VALUES($1, $2, $3, $4, $5)";
        $prep = pg_prepare($db, "createDiscussion", $sql);
        $ret = pg_execute($db, "createDiscussion", array($creatore, $id, $discussion_title, $discussion_text, $now));
        if (!$ret) {
            return false;
        } 
        else {
            return true;
        }
    }
?>