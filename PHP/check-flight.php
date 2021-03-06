<?php
require_once "parametri.php";
include 'header.php';
if (isset($_SESSION['username']) || !empty($_SESSION['username'])){
    $username = $_SESSION['username'];
    $sql_byUsername = "SELECT * FROM personaldata where username = $1";
    $prep_user = pg_prepare($db, 'selectByUsername', $sql_byUsername);
    if (!$prep_user) {
        echo "ERRORE QUERY Update: " . pg_last_error($db);
        exit;
    } 
    else {
        $ret_user = pg_execute($db, 'selectByUsername', array($username));
        if (!$ret_user) {
            echo "ERRORE QUERY";
        } else {
            if (pg_result_seek($ret_user, 0)) {
                $user = pg_fetch_array($ret_user);
                $nome = $user['nome'];
                $cognome = $user['cognome'];
                $indirizzo = $user['indirizzo'];
                $cap = $user['cap'];
                $sesso = $user['sesso'];
                $nazionalita = $user['nazionalita'];
                $luogo_nascita = $user['luogo_nascita'];
                $data_nascita = $user['data_nascita'];
                $numero = $user['numerotel'];
            }else{
                $nome = "";
                $cognome = "";
                $indirizzo = "";
                $cap = "";
                $sesso = "";
                $nazionalita = "";
                $luogo_nascita = "";
                $data_nascita = "";
                $numero = "";
            }
        }
        }
} 
else {
    header("Location:../PHP/homepage.php");
    
}
$diff_h=0;
$diff_m=0;
$id_back=0;
$prezzo_back=0;
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
            $città_partenza = ucfirst($flight['citta_partenza']);
            $città_arrivo = ucfirst($flight['citta_arrivo']);
            $ora_partenza = $flight['ora_partenza'];
            $ora_arrivo = $flight['ora_arrivo'];
            $prezzo = $flight['prezzo'];
            $data_volo = $flight['data_volo'];
            $diff_h = (int)(substr($ora_arrivo, 0, 2) - substr($ora_partenza, 0, 2));
            $diff_m = (int)substr($ora_arrivo, 3, 5) - substr($ora_partenza, 3, 5);
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
    <link rel="stylesheet" href="../CSS/payment.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <br><br><br><br><br><br>
    <form action="payment.php" class="payment" method="post" onsubmit="return checkPersonalData()">
        <div class="ticket">
            <div class="ticketOne">
                <p name="citta"><?php echo $città_partenza; ?></p>
                <p><?php echo substr($ora_partenza, 0, 5) ?></p>
            </div>
            <div class="ticketOne">
                <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                <p>ID:<?php echo $id ?></p>
                <img src="../immagini/aereo.png">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <p style="color:lightgreen">Diretto</p>
                <p><?php echo $data_volo ?></p>
            </div>
            <div class="ticketOne">
                <p><?php echo $città_arrivo ?></p>
                <p><?php echo substr($ora_arrivo, 0, 5) ?></p>
            </div>
        </div>
        <?php
        if (!empty($_GET['id_ritorno'])) {
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
                    $città_partenza_back = ucfirst($flight_back['citta_partenza']);
                    $città_arrivo_back = ucfirst($flight_back['citta_arrivo']);
                    $ora_partenza_back = $flight_back['ora_partenza'];
                    $ora_arrivo_back = $flight_back['ora_arrivo'];
                    $prezzo_back = $flight_back['prezzo'];
                    $data_volo_back = $flight_back['data_volo'];
                    $diff_h_r = (int)substr($ora_arrivo_back, 0, 2) - (int)substr($ora_partenza_back, 0, 2);
                    $diff_m_r = (int)substr($ora_arrivo_back, 3, 5) - (int)substr($ora_partenza_back, 3, 5);
                }
            } ?>
            <div class="ticket2" id="ticket2">
                <div class="ticketTwo">
                    <p><?php echo $città_partenza_back ?></p>
                    <p><?php echo substr($ora_partenza_back, 0, 5) ?></p>
                </div>
                <div class="ticketTwo">
                    <p><?php echo $diff_h_r; ?>h <?php echo $diff_m_r ?>min</p>
                    <p>ID:<?php echo $id_back ?></p>
                    <img src="../immagini/aereo.png">
                    <input type="hidden" name="id_back" value="<?php echo $id_back ?>">
                    <p style="color:lightgreen">Diretto</p>
                    <p><?php echo $data_volo_back ?></p>
                </div>
                <div class="ticketTwo">
                    <p><?php echo $città_arrivo_back ?></p>
                    <p><?php echo substr($ora_arrivo_back, 0, 5) ?></p>
                </div>
            </div>
        <?php } ?>
        <div class="confirm">
            <div class="left-page">
                <fieldset>
                    <legend>I Tuoi Dati</legend>
                    <label for="nome"> Nome: <p dir="rtl"></p><input name="nome" type="text" id="nome" value="<?php echo $nome; ?>"></label>
                    <label for="cognome"> Cognome: <p dir="rtl"></p><input type="text" name="cognome" id="cognome" value="<?php echo $cognome; ?>"></label>
                    <label for="luogonascita">Luogo di Nascita: <p dir="rtl"></p><input type="text" id="luogonascita" name="luogonascita" value="<?php echo $luogo_nascita; ?>"></label>
                    <label for="indirizzo">Indirizzo: <p dir="rtl"></p><input type="text" id="indirizzo" name="indirizzo" value="<?php echo $indirizzo; ?>"></label>
                    <label for="cap">CAP: <p dir="rtl"></p><input name="cap" type="number" min="10000" max="99999" value="<?php echo $cap; ?>"id="cap" value="<?php echo $cap; ?>"></label>
                    <label for="sesso">SESSO: <div class="sex"><input type="radio" name="sex" id="male" value="M" checked>M<input type="radio" name="sex" id="fale" value="F">F</div></label>
                    <label for="nazionalita">Nazionalità: <p dir="rtl"></p><input type="text" id="nazionalita" name="nazionalita" value="<?php echo $nazionalita; ?>"></label>
                    <label for="datanascita">Data di Nascita: <input type="date" id="datanascita" name="datanascita" value="<?php echo $data_nascita; ?>"></label>
                    <label for="numero"> Numero: <p dir="rtl"></p><input type="number" id="numero" name="numero" minlenght="6" maxlength="15" value="<?php echo $numero; ?>"></label>
                </fieldset>
                <div class="card-payment">
                    <h1>Pagamento</h1>
                    <label for="ccn">Numero Carta:</label>
                    <div class="typecard"><p style="color:red"></p><input id="ccn" type="tel" inputmode="number"  autocomplete="cc-number" maxlength="19" class="ccn" placeholder="xxxx xxxx xxxx xxxx"><img src="../immagini//mastercard.png" id="mastercard" class="mastercard"><img src="../immagini/visa.png" id="visa" class="visa"></div>
                    <label for="scadenza">Data di Scadenza: <input class="month" type="number" placeholder="Mese" id="month"> / <input class="year" type="numeric" min="2022" id="year" placeholder="Anno"></label>
                    <label for="CVV">CVV: <input type="number" min="99" max="999" id="cvv" class="cvv" placeholder="CVV" maxlength="3"></label>
                </div>
            </div>
            <div class="right">
                <div class="info-pay">
                    <h1>Dettagli del prezzo</h1>
                    <h3>Riepilogo</h3>
                    <div class="price">
                        <p>Adulto</p>
                        <p><?php echo $prezzo ?> € x 1</p>
                    </div>
                    <?php if ((!empty([$id_back])) && ($id_back != null)) { ?>
                        <div class="price">
                            <p>Adulto(Ritorno)</p>
                            <p><?php echo $prezzo_back ?> € x 1</p>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="price end" style="color:grey">
                        <p>Tasse(IVA 22%)</p>
                        <p><?php echo number_format((($prezzo + $prezzo_back) * 22) / 100, 2) ?> €</p>
                    </div>
                    <div class="price">
                        <h2>Totale</h2>
                        <h2 class="total" id="totalPrice"><?php echo number_format($prezzo + $prezzo_back + (($prezzo + $prezzo_back) * 22) / 100, 2) ?> €</h2>
                        <input type="hidden" name="price" value=<?php echo number_format($prezzo  + (($prezzo) * 22) / 100, 2) ?> id="totalPriceHidden">
                        <input type="hidden" name="priceBack" value=<?php echo number_format($prezzo_back  + (($prezzo_back) * 22) / 100, 2) ?> id="totalPriceHiddenBack">
                    </div>
                    <input type="submit" class="submit-flight" value="Prenota">
                </div>
                <div class="luggage">
                    <div class="noluggage">
                        <label>
                            <input checked type="radio" name="luggage" id="noluggage" value="0" onchange=handleChange(this)>
                            <img src="../immagini/backpack.png">
                            <p>Senza bagaglio</p>
                            <p>Gratis</p>
                        </label>
                    </div>
                    <div class="oneluggage">
                        <label>
                            <input type="radio" name="luggage" id="oneluggage" value="19,99" onchange=handleChange(this)>
                            <img src="../immagini/luggage1.png">
                            <p>1 bagaglio(10kg)</p>
                            <p>€ 12,99</p>
                        </label>
                    </div>
                    <div class="twoluggage">
                        <label>
                            <input type="radio" name="luggage" id="twoluggage" value="32,99" onchange=handleChange(this)>
                            <img src="../immagini/luggage2.png">
                            <p>2 bagagli(10kg x 2)</p>
                            <p>€ 32,99</p>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php include '../HTML/footer.html' ?>
    <script src='../JS/check-flight.js' defer></script>
</body>

</html>