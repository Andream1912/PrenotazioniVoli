<?php
$regex = "/^(?=.*?[0-9])(?=.*[A-Z]).{6,12}$/";
require_once "parametri.php";


if (isset($_POST['username']))
    $user = $_POST['username'];
else
    $user = "";
if (isset($_POST['email-register']))
    $email = $_POST['email-register'];
else
    $email = "";
if (isset($_POST['password-register']))
    $pass = $_POST['password-register'];
else
    $pass = "";
if (isset($_POST['verify-password']))
    $verify_password = $_POST['verify-password'];
else
    $verify_password = "";
if (!empty($pass))
    if ($pass != $verify_password) {
        $pass = "";
        header("Location:" . $_SERVER['HTTP_REFERER']);
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = "";
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
        if ((strlen($pass) < 6) && !(preg_match($regex, $pass))) {
            $pass = "";
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
        if ((check_username($user, $db))) {
            if (str_contains($_SERVER['HTTP_REFERER'], '?')) {
                header("Location:" . $_SERVER['HTTP_REFERER'] . "&error=username");
            } else {
                header("Location:" . $_SERVER['HTTP_REFERER'] . "?error=username");
            }
        } else if (check_email($email, $db)) {
            if (str_contains($_SERVER['HTTP_REFERER'], '?')) {
                header("Location:" . $_SERVER['HTTP_REFERER'] . "&error=email");
            } else {
                header("Location:" . $_SERVER['HTTP_REFERER'] . "?error=email");
            }
        } else {
            if (add_new_user($user, $email, $pass, $db)) {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            } else {
                echo "<p> Errore nell'inserimento del nuovo utente</p>";
            }
        }
    }
/* ------------------ CONTROLLO DB ------------------------*/
function check_username($user, $db)
{
    $sql = "SELECT username FROM utenti WHERE username=$1";
    $prep = pg_prepare($db, "sqlUsername", $sql);
    if (!$prep) {
        return false;
    }
    $ret = pg_execute($db, "sqlUsername", array($user));
    if (!$ret) {
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            return true;
        } else {
            return false;
        }
    }
}
function check_email($email, $db)
{
    $sql_email = "SELECT * FROM utenti WHERE email=$1";
    $prep_email = pg_prepare($db, "sqlEmail", $sql_email);
    if (!$prep_email) {
        return false;
    }
    $ret_email = pg_execute($db, "sqlEmail", array($email));
    if (!$ret_email) {
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret_email)) {
            return true;
        } else {
            return false;
        }
    }
}

function add_new_user($user, $email, $pass, $db)
{
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO utenti(username, email, password) VALUES($1, $2, $3)";
    $prep = pg_prepare($db, "insertUser", $sql);
    if(!$prep){
        return false;
    }
    $ret = pg_execute($db, "insertUser", array($user, $email, $hash));
    if (!$ret) {
        return false;
    } else {
        return true;
    }
}
