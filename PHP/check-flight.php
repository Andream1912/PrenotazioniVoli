<?php
require_once "parametri.php";
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql_byId = "SELECT * FROM volo where id = $1";
    $prep = pg_prepare($db, 'selectById', $sql_byId);
    if (!$prep) {
        echo "ERRORE QUERY Update: " . pg_last_error($db);
        exit;
    } else {
        $ret_select = pg_execute($db, 'selectById', array($id));
        if (!$ret_select) {
            echo "ERRORE QUERY";
        } else {
            $flight = pg_fetch_array($ret_select);
            $città_partenza = $flight['città_partenza'];
            $città_arrivo = $flight['città_arrivo'];
            $ora_partenza = $flight['ora_partenza'];
            $ora_arrivo = $flight['ora_arrivo'];
            $prezzo = $flight['prezzo'];
            $data_volo = $flight['data_volo'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Prenotazione Biglietto</title>
</head>
<body>

</body>

</html>