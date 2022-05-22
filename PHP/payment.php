<?php
require_once "parametri.php";
session_start();
if (empty($_SESSION['username'])) {
    header("Location:../PHP/homepage.php");
} else {
    $username = $_SESSION['username'];
}
if ((!isset($_GET['id']) || empty($_GET['id']))) {
    header("Location:../PHP/homepage.php");
} else {
    $id = $_GET['id'];
}

$sql = "INSERT INTO prenotazioni(username,id_volo) VALUES($1,$2)";
$prep = pg_prepare($db, "insertFlight", $sql);
if (!$prep) {
    echo pg_last_error($db);
} else {
    $ret = pg_execute($db, 'insertFlight', array($username, $id));
    if (!$ret) {
        pg_last_error($db);
    } else {
        if ((isset($_GET['id_back'])) && (!empty($_GET['id_back']))) {
            $sql_back = "INSERT INTO prenotazioni(username,id_volo) VALUES($1,$2)";
            $prep_back = pg_prepare($db, "insertSecondFlight", $sql_back);
            if (!$prep_back) {
                echo pg_last_error($db);
            }else{
                $ret_back = pg_execute($db, 'insertSecondFlight',array($username,$id_back));
                if(!$ret_back){
                    pg_last_error($db);
                }
            }
        }
        header("Location:../PHP/homepage.php");
    }
}
