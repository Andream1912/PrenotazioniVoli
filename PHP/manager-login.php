<?php
require_once "parametri.php";

if ($_POST['email'] || $_POST['password']) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hash = get_pwd($email, $db);
    if (!$hash) { /* Se ritorna false l'utente non è stato trovato nel db, in caso in cui non è false l'utente è stato trovato*/
        if (str_contains($_SERVER['HTTP_REFERER'], '?')) {
            $location = explode("error", $_SERVER['HTTP_REFERER']);
            header("Location:" . $location[0] . "&error=login");
        } else {
            header("Location:" . $_SERVER['HTTP_REFERER'] . "?error=login");
        }
    } else {
        if (password_verify($pass, $hash)) {
            $ruolo = get_level($email, $db);
            $username = get_username($email, $db);
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['ruolo'] = $ruolo;
            if (str_contains($_SERVER['HTTP_REFERER'], 'error')) {
                $location = explode("error", $_SERVER['HTTP_REFERER']);
                header("Location:" . $location[0]);
            } else {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            }
        } else {
            if (str_contains($_SERVER['HTTP_REFERER'], '?')) {
                $location = explode("error", $_SERVER['HTTP_REFERER']);
                header("Location:" . $location[0] . "&error=login");
            } else {
                header("Location:" . $_SERVER['HTTP_REFERER'] . "?error=login");
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
function get_username($email, $db)
{
    $sql = "SELECT username from utenti where email=$1";
    $prep = pg_prepare($db, "sqlUsername", $sql);
    $ret = pg_execute($db, "sqlUsername", array($email));
    if (!$ret) {
        echo "ERRORE QUERY: " . pg_last_error($db);
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            $username = $row['username'];
            return $username;
        } else {
            return false;
        }
    }
}
function get_level($email, $db)
{
    $sql = "SELECT livello from utenti where email=$1";
    $prep = pg_prepare($db, "sqllivello", $sql);
    if (!$prep) {
        return false;
    } else {
        $ret = pg_execute($db, "sqllivello", array($email));
        if (!$ret) {
            echo "ERRORE QUERY: " . pg_last_error($db);
            return false;
        } else {
            $row = pg_fetch_assoc($ret);
            $ruolo = $row['livello'];
            return $ruolo;
        }
    }
}
