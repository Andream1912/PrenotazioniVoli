<?php
require_once "parametri.php";
session_start();

if (empty($_SESSION['username'])) {
    header("Location:../PHP/homepage.php");
} else {
    $username = $_SESSION['username'];
}
if ((!isset($_POST['id']) || empty($_POST['id']))) { //ID DEL VOLO
    header("Location:../PHP/homepage.php");
} else {
    $id = $_POST['id'];
}
if (isset($_POST['nome']) || !empty($_POST['nome'])) {
    $nome = $_POST['nome'];
} else {
    $nome = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['cognome']) || !empty($_POST['cognome'])) {
    $cognome = $_POST['cognome'];
} else {
    $cognome = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['indirizzo']) || !empty($_POST['indirizzo'])) {
    $indirizzo = $_POST['indirizzo'];
} else {
    $indirizzo = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['nazionalita']) || !empty($_POST['nazionalita'])) {
    $nazionalita = $_POST['nazionalita'];
} else {
    $nazionalita = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['cap']) || !empty($_POST['cap'])) {
    $cap = $_POST['cap'];
} else {
    $cap = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['sex']) || !empty($_POST['sex'])) {
    $sex = $_POST['sex'];
} else {
    $sex = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['datanascita']) || !empty($_POST['datanascita'])) {
    $datanascita = $_POST['datanascita'];
} else {
    $datanascita = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['numero']) || !empty($_POST['numero'])) {
    $numero = $_POST['numero'];
} else {
    $numero = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
if (isset($_POST['luogonascita']) || !empty($_POST['luogonascita'])) {
    $luogonascita = $_POST['luogonascita'];
} else {
    $luogonascita = "";
    header("Location:" . $_SERVER['HTTP_REFERER']);
}
$number = 0;
if (!empty($_POST['luggage'])) {
    $n_luggage = $_POST['luggage'];
    if ($n_luggage == "19,99") {
        $number = 1;
    } else if ($n_luggage == "32,99") {
        $number = 2;
    }
}
$sql = "INSERT INTO prenotazioni(username,id_volo,numero_bagagli,prezzo) VALUES($1,$2,$3,$4)";
$sql_places = "UPDATE volo set posti_disponibili = posti_disponibili - 1 WHERE id_volo = $id";
$prep = pg_prepare($db, "insertFlight", $sql);
if (!$prep) {
    echo pg_last_error($db);
} else {
    $ret = pg_execute($db, 'insertFlight', array($username, $id, $number, $_POST['price'] + $n_luggage));
    pg_query($db, $sql_places);
    if (!$ret) {
        header("Location:" . $_SERVER['HTTP_REFERER']);
    } else {
        if ((isset($_POST['id_back'])) && (!empty($_POST['id_back']))) {
            $id_back = $_POST['id_back'];
            $price_back = $_POST['price_back'];
            $sql_back = "INSERT INTO prenotazioni(username,id_volo,numero_bagagli,prezzo) VALUES($1,$2,$3,$4)";
            $prep_back = pg_prepare($db, "insertSecondFlight", $sql_back);
            if (!$prep_back) {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            } else {
                $ret_back = pg_execute($db, 'insertSecondFlight', array($username, $id_back, $number, $priceBack + $n_luggage));
                if (!$ret_back) {
                    header("Location:" . $_SERVER['HTTP_REFERER']);
                }
            }
        }
        $sql_personalData = "SELECT * from personaldata where username = $1"; // VERIFICO SE L'UTENTE GIA ESISTE IN PERSONAL DATA
        $prep_personalData = pg_prepare($db, "insertPersonalData", $sql_personalData);
        if (!$prep_personalData) {
            header("Location:" . $_SERVER['HTTP_REFERER']);
        } else {
            $ret_personalData = pg_execute($db, "insertPersonalData", array($username));
            if (!$ret_personalData) {
                header("Location:" . $_SERVER['HTTP_REFERER']);
            } else {
                if ($resultPersonalData = pg_result_seek($ret_personalData, 0)) {
                    $sql_updatePersonalData = "UPDATE personaldata SET nome=$1,cognome=$2,indirizzo=$3,cap=$4,sesso=$5,nazionalita=$6,luogo_nascita=$7,data_nascita=$8,numerotel=$9 WHERE username=$10";
                    $prep_updatePersonalData = pg_prepare($db, "UpdateUtente", $sql_updatePersonalData);
                    if (!$prep_updatePersonalData) {
                        header("Location:" . $_SERVER['HTTP_REFERER']);
                    } else {
                        $ret_updatePersonalData = pg_execute($db, "UpdateUtente", array($nome, $cognome, $indirizzo, $cap, $sex, $nazionalita, $luogonascita, $datanascita, $numero, $username));
                        header("Location: ../PHP/private_page.php?card=prenotazioni&prenotazioni=correnti");
                    }
                } else {
                    // utente non ha un personal data
                    $sql_add = "INSERT INTO personaldata VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10)";
                    $prep_add = pg_prepare($db, "newPersonalData", $sql_add);
                    if (!$prep_add) {
                        header("Location:" . $_SERVER['HTTP_REFERER']);
                    } else {
                        $ret_add = pg_execute($db, "newPersonalData", array($username, $nome, $cognome, $indirizzo, $cap, $sex, $nazionalita, $luogonascita, $datanascita, $numero));
                        if (!$ret_add) {
                            header("Location:" . $_SERVER['HTTP_REFERER']);
                        } else {
                            header("Location: ../PHP/private_page.php?card=prenotazioni&prenotazioni=correnti");
                        }
                    }
                }
            }
        }
    }
}
