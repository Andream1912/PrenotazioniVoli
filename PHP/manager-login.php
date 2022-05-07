<?php
require_once "parametri.php";

if ($_POST['email'] || $_POST['password']) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hash = get_pwd($email, $db);
    if (!$hash) { /* Se ritorna false l'utente non è stato trovato nel db, in caso in cui non è false l'utente è stato trovato*/
        echo "<p>Utente non registrato";
    } else {
        if (password_verify($pass, $hash)) {
            $level = get_role($email, $db);
            if ($level == False) {
                echo "Problemi con l'utente";
            } else {
                echo "<p>Login eseguito con successo!";
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['livello'] = $level;
            }
        }
    }
}

function get_pwd($email, $db)
{
    $sql = "SELECT password from utenti where email=$1";
    $prep = pg_prepare($db, "sqlPassword", $sql);
    $ret = pg_execute($db, "sqlPassword", array($email));
    if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            $pass = $row['password'];
            return $pass;
        } else {
            return false;
        }
    }
}
function get_role($email, $db)
{
    $sql = "SELECT livello from utenti where email=$1";
    $prep = pg_prepare($db, "sqllivello", $sql);
    $ret = pg_execute($db, "sqllivello", array($email));
    if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            $role = $row['livello'];
            return $role;
        } else {
            return false;
        }
    }
}
?>