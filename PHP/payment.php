<?php
require_once "parametri.php";
session_start();
if (empty($_SESSION['username'])) {
    header("Location:../PHP/homepage.php");
} else {
    $username = $_SESSION['username'];
}
if ((!isset($_POST['id']) || empty($_POST['id']))) {
    header("Location:../PHP/homepage.php");
} else {
    $id = $_POST['id'];
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
        pg_last_error($db);;
    } else {
        if ((isset($_POST['id_back'])) && (!empty($_POST['id_back']))) {
            $id_back = $_POST['id_back'];
            $price_back = $_POST['price_back'];
            $sql_back = "INSERT INTO prenotazioni(username,id_volo,numero_bagagli,prezzo) VALUES($1,$2,$3,$4)";
            $prep_back = pg_prepare($db, "insertSecondFlight", $sql_back);
            if (!$prep_back) {
                echo pg_last_error($db);
            } else {
                $ret_back = pg_execute($db, 'insertSecondFlight', array($username, $id_back, $number, $priceBack + $n_luggage));
                if (!$ret_back) {
                    pg_last_error($db);
                }
            }
        }
    }
    header("Location: ../PHP/private_page.php?card=prenotazioni&prenotazioni=correnti");
}
