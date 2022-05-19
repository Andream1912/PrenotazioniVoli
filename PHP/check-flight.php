<?php
require_once "parametri.php";
session_start();
if (empty($_SESSION['username'])) {
    header("Location:../PHP/homepage.php");
} else {
    $username = $_SESSION['username'];
    $sql_byUsername = "SELECT * FROM personaldata where username = $1";
    $prep_user = pg_prepare($db, 'selectByUsername', $sql_byUsername);
    if (!$prep_user) {
        echo "ERRORE QUERY Update: " . pg_last_error($db);
        exit;
    } else {
        $ret_user = pg_execute($db, 'selectByUsername', array($username));
        if (!$ret_user) {
            echo "ERRORE QUERY";
        } else {
            $user = pg_fetch_array($ret_user);
            $nome = $user['nome'];
            $cognome = $user['cognome'];
            $indirizzo = $user['indirizzo'];
            $cap = $user['cap'];
            $sesso = $user['sesso'];
            $nazionalita = $user['nazionalita'];
            $luogo_nascita = $user['ldinascita'];
            $data_nascita = $user['ddinascita'];
            $numero = $user['numerotel'];
        }
    }
}
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql_byId = "SELECT * FROM volo where id_volo = $1";
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
            $diff_h = substr($ora_arrivo, 0, 2) - substr($ora_partenza, 0, 2);
            $diff_m = substr($ora_arrivo, 3, 5) - substr($ora_partenza, 3, 5);
        }
    }
} else {
    header("Location:../PHP/homepage.php");
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Prenotazione Biglietto</title>
    <link rel="stylesheet" href="../CSS/check-flight.css">
</head>

<body>
    <?php include 'header.php' ?>
    <br><br><br><br><br><br>
    <form action="" class="payment">
        <div class="ticket">
            <div class="ticketOne">
                <p><?php echo $città_partenza ?></p>
                <p><?php echo substr($ora_partenza, 0, 5) ?></p>
            </div>
            <div class="ticketOne">
                <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                <p>ID:<?php echo $id ?></p>
                <p>Diretto</p>
            </div>
            <div class="ticketOne">
                <p><?php echo $città_arrivo ?></p>
                <p><?php echo substr($ora_arrivo, 0, 5) ?></p>
            </div>
        </div>
        <?php
            if(!empty($_GET['id_ritorno'])){
                $id_back = $_GET['id_ritorno'];
                $sql_byId_r = "SELECT * FROM volo where id_volo = $1";
                $prep_r = pg_prepare($db, 'selectByIdRitorno', $sql_byId_r);
                if (!$prep_r) {
                    echo "ERRORE QUERY Update: " . pg_last_error($db);
                    exit;
                } else {
                    $ret_select_r = pg_execute($db, 'selectByIdRitorno', array($id_back));
                    if (!$ret_select_r) {
                        echo "ERRORE QUERY";
                    } else {
                        $flight_back = pg_fetch_array($ret_select_r);
                        $città_partenza_back = $flight_back['città_partenza'];
                        $città_arrivo_back = $flight_back['città_arrivo'];
                        $ora_partenza_back = $flight_back['ora_partenza'];
                        $ora_arrivo_back = $flight_back['ora_arrivo'];
                        $prezzo_back = $flight_back['prezzo'];
                        $data_volo_back = $flight_back['data_volo'];
                        $diff_h_r = substr($ora_arrivo_back, 0, 2) - substr($ora_partenza_back, 0, 2);
                        $diff_m_r = substr($ora_arrivo_back, 3, 5) - substr($ora_partenza_back, 3, 5);
                    }
            }?>
        <div class="ticket2">
            <div class="ticketTwo">
                <p><?php echo $città_partenza_back ?></p>
                <p><?php echo substr($ora_partenza_back, 0, 5) ?></p>
            </div>
            <div class="ticketTwo">
                <p><?php echo $diff_h_r; ?>h <?php echo $diff_m_r ?>min</p>
                <p>ID:<?php echo $id_back ?></p>
                <p>Diretto</p>
            </div>
            <div class="ticketTwo">
                <p><?php echo $città_arrivo_back ?></p>
                <p><?php echo substr($ora_arrivo_back, 0, 5) ?></p>
            </div>
        </div>
        <?php } ?>
        <div class="confirm">
            <fieldset>
                <legend>I Tuoi Dati</legend>
                <label for="nome"> Nome: <input type="text" name="nome" value="<?php echo $nome; ?>"></label>
                <label for="cognome"> Cognome: <input type="text" name="surname" value="<?php echo $cognome; ?>"></label>
                <label for="luogonascita">Luogo di Nascita: <input type="text" name="indirizzo" value="<?php echo $luogo_nascita; ?>"></label>
                <label for="indirizzo">Indirizzo: <input type="text" name="indirizzo" value="<?php echo $indirizzo; ?>"></label>
                <label for="cap">CAP: <input type="text" name="CAP" value="<?php echo $cap; ?>"></label>
                <label for="sesso">SESSO: <div class="sex"><input type="radio" name="sex" id="male" value="M" checked>M<input type="radio" name="sex" id="fale" value="F">F</div></label>
                <label for="nazionalita">Nazionalità: <input type="text" name="nazione" value="<?php echo $nazionalita; ?>"></label>
                <label for="datanascita">Data di Nascita: <input type="date" name="birthday" value="<?php echo $data_nascita; ?>"></label>
                <label for="numero"> Numero: <input type="tel" value="<?php echo $numero; ?>"></label>

            </fieldset>
            <div class="info-pay">
                <h1>Dettagli del prezzo</h1>
                <h3>Riepilogo</h3>
                <div class="price">
                    <p>Adulto</p>
                    <p><?php echo $prezzo ?> € x 1</p>
                </div>
                <?php if (!empty([$id_back])) {?>
                    <div class="price">
                    <p>Adulto(Ritorno)</p>
                    <p><?php echo $prezzo_back ?> € x 1</p>
                </div>
                    <?php
                }
                ?>
                <div class="price end" style="color:grey">
                    <p>Tasse(IVA 22%)</p>
                    <p><?php echo number_format((($prezzo+$prezzo_back) * 22) / 100, 2) ?> €</p>
                </div>
                <div class="price">
                    <h2>Totale</h2>
                    <h2 class="total"><?php echo number_format($prezzo+$prezzo_back + ($prezzo * 22) / 100, 2) ?> €</h2>
                </div>
                <input type="submit" class="submit-flight" value="Prenota">
            </div>
        </div>
    </form>
    <?php include 'footer.php' ?>
</body>

</html>