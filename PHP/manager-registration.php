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
        echo "Le password non corrispondono!";
        $pass = "";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = "";
            exit("Email non valida");
        }
        if ((strlen($pass) < 6) && !(preg_match($regex, $pass))) {
            $pass = "";
            exit("Password incorrect!");
        }
        if ((check_username($user,$db))||(check_email($email,$db))){
            echo "<p> Username $user già esistente. Riprova</p>";
            echo "<p>Ritorna alla <a href=../HTML/registration.html>registrazione</p>";
        } else {
            if (add_new_user($user,$email,$pass,$db)) {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            } else {
                echo "<p> Errore nell'inserimento del nuovo utente</p>";
            }
        }
    }
/* ------------------ CONTROLLO DB ------------------------*/
function check_username($user,$db)
{
    $sql = "SELECT username FROM utenti WHERE username=$1";
    $prep = pg_prepare($db, "sqlUsername", $sql);
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
function check_email($email,$db)
{
    $sql = "SELECT username FROM utenti WHERE email=$1";
    $prep = pg_prepare($db, "sqlUsername", $sql);
    $ret = pg_execute($db, "sqlUsername", array($email));
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

function add_new_user($user,$email,$pass,$db)
{
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO utenti(username, email, password) VALUES($1, $2, $3)";
    $prep = pg_prepare($db, "insertUser", $sql);
    $ret = pg_execute($db, "insertUser", array($user, $email, $hash));
    if (!$ret) {
        return false;
    } else {
        return true;
    }
}
?>
