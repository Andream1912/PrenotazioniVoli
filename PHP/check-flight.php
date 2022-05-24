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
            $luogo_nascita = $user['luogo_nascita'];
            $data_nascita = $user['data_nascita'];
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
    <link rel="stylesheet" href="../CSS/payment.css">
</head>

<body>
    <?php include 'header.php' ?>
    <br><br><br><br><br><br>
    <form action="payment.php" class="payment" method="post" onsubmit="return checkPersonalData()">
        <div class="ticket">
            <div class="ticketOne">
                <p name="citta"><?php echo $città_partenza ?></p>
                <p><?php echo substr($ora_partenza, 0, 5) ?></p>
            </div>
            <div class="ticketOne">
                <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                <p>ID:<?php echo $id ?></p>
                <img src="../immagini/aereo.png">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <p style="color:lightgreen">Diretto</p>
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
                    $città_partenza_back = $flight_back['città_partenza'];
                    $città_arrivo_back = $flight_back['città_arrivo'];
                    $ora_partenza_back = $flight_back['ora_partenza'];
                    $ora_arrivo_back = $flight_back['ora_arrivo'];
                    $prezzo_back = $flight_back['prezzo'];
                    $data_volo_back = $flight_back['data_volo'];
                    $diff_h_r = substr($ora_arrivo_back, 0, 2) - substr($ora_partenza_back, 0, 2);
                    $diff_m_r = substr($ora_arrivo_back, 3, 5) - substr($ora_partenza_back, 3, 5);
                }
            } ?>
            <div class="ticket2">
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
                    <label for="nome"> Nome: <input type="text" id="nome" value="<?php echo $nome; ?>"></label>
                    <label for="cognome"> Cognome: <input type="text" id="cognome" value="<?php echo $cognome; ?>"></label>
                    <label for="luogonascita">Luogo di Nascita: <input type="text" id="luogonascita" name="luogonascita" value="<?php echo $luogo_nascita; ?>"></label>
                    <label for="indirizzo">Indirizzo: <input type="text" id="indirizzo" value="<?php echo $indirizzo; ?>"></label>
                    <label for="cap">CAP: <input type="text" id="cap" value="<?php echo $cap; ?>"></label>
                    <label for="sesso">SESSO: <div class="sex"><input type="radio" name="sex" id="male" value="M" checked>M<input type="radio" name="sex" id="fale" value="F">F</div></label>
                    <label for="nazionalita">Nazionalità: <input type="text" id="nazionalita" name="nazionalita" value="<?php echo $nazionalita; ?>"></label>
                    <label for="datanascita">Data di Nascita: <input type="date" id="datanascita" name="birthday" value="<?php echo $data_nascita; ?>"></label>
                    <label for="numero"> Numero: <input type="tel" id="numero" name="numero" value="<?php echo $numero; ?>"></label>
                </fieldset>
                <div class="card-payment">
                    <h1>Pagamento</h1>
                    <label for="ccn">Numero Carta:</label>
                    <div class="typecard"><input id="ccn" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" class="ccn" placeholder="xxxx xxxx xxxx xxxx"><img src="../immagini//mastercard.png" id="mastercard" class="mastercard"><img src="../immagini/visa.png" id="visa" class="visa"></div>
                    <label for="scadenza">Data di Scadenza: <input class="month" type="numeric" placeholder="Mese" id="month"> / <input class="year" type="numeric" min="2022" id="year" placeholder="Anno"></label>
                    <label for="CVV">CVV: <input type="numeric" id="cvv" class="cvv" placeholder="CVV" maxlength="3"></label>
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
                        <input type="hidden" name="priceBack" value=<?php echo number_format($prezzo_back  + (($prezzo_back) * 22) / 100, 2) ?> id="totalPriceHidden">
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
    <script>
        var price = document.getElementById("totalPrice");
        const priceconst = parseFloat(price.textContent.slice(0, 6));

        function handleChange(src) {
            const two = document.getElementById("twoluggage");
            const one = document.getElementById("oneluggage")
            const zero = document.getElementById("noluggage")
            if (two.checked == false) {
                two.parentElement.parentElement.style.backgroundColor = "#f2f2f2";
                two.parentElement.parentElement.style.color = "black";

            }
            if (one.checked == false) {
                one.parentElement.parentElement.style.backgroundColor = "#f2f2f2";
                one.parentElement.parentElement.style.color = "black";
            }
            if (zero.checked == false) {
                zero.parentElement.parentElement.style.backgroundColor = "#f2f2f2";
                zero.parentElement.parentElement.style.color = "black";
            }
            const x = src.parentElement.parentElement;
            x.style.backgroundColor = "rgb(4, 39, 89)"
            x.style.color = "white"
            newPrice = priceconst + parseFloat(src.value);
            price.innerHTML = newPrice.toFixed(2) + " € ";
        }

        function checkPersonalData() {
            nome = document.getElementById("nome");
            cognome = document.getElementById("cognome");
            indirizzo = document.getElementById("indirizzo");
            numero = document.getElementById("numero");
            datanascita = document.getElementById("datanascita");
            cap = document.getElementById("cap");
            luogonascita = document.getElementById("luogonascita");
            nazionalita = document.getElementById("nazionalita");
            ccn = document.getElementById("ccn");
            month = document.getElementById("month");
            year = document.getElementById("year");
            cvv = document.getElementById("cvv");
            if (nome.value == "" || cognome.value == "" || datanascita.value == "" || numero.value == "" || indirizzo.value == "" || cap.value == "" || luogonascita.value == "" || ccn.value == "" || month.value == "" || year.value == "" || cvv.value == "" || year.value < '2022') {

                if (nome.value == "") {
                    nome.style.borderColor = "red";
                } else {
                    nome.style.borderColor = "#f0f0f0";
                }
                if (cognome.value == "") {
                    cognome.style.borderColor = "red";
                } else {
                    cognome.style.borderColor = "#f0f0f0";
                }
                if (indirizzo.value == "") {
                    indirizzo.style.borderColor = "red";
                } else {
                    indirizzo.style.borderColor = "f0f0f0";
                }
                if (datanascita.value == "") {
                    datanascita.style.borderColor = "red";
                } else {
                    datanascita.style.borderColor = "#f0f0f0";
                }
                if (cap.value == "") {
                    cap.style.borderColor = "red";
                } else {
                    cap.style.borderColor = "#f0f0f0";
                }
                if (luogonascita.value == "") {
                    luogonascita.style.borderColor = "red";
                } else {
                    luogonascita.style.borderColor = "#f0f0f0";
                }
                if (numero.value == "") {
                    numero.style.borderColor = "red";
                } else {
                    numero.style.borderColor = "#f0f0f0";
                }
                if (nazionalita.value == "") {
                    nazionalita.style.borderColor = "red";
                } else {
                    nazionalita.style.borderColor = "#f0f0f0";
                }
                if (ccn.value == "") {
                    ccn.style.borderColor = "red";
                } else {
                    ccn.style.borderColor = "#f0f0f0"
                }
                if (month.value == "") {
                    month.style.border = "2px solid";
                    month.style.borderColor = "red";
                } else {
                    month.style.border = "none";
                }
                if ((year.value == "") || (year.value < '2022')) {
                    year.style.border = "2px solid";
                    year.style.borderColor = "red";
                } else {
                    year.style.border = "none";
                }
                if (cvv.value == "") {
                    cvv.style.borderColor = "red";
                } else {
                    cvv.style.borderColor = "#f0f0f0"
                }
                return false;
            } else {
                return true;
            }
        }
        input = document.querySelector('.ccn');
        input.addEventListener('input', updateValue);

        function updateValue(e) {
            if ((e.target.value[0]) == 4) {
                console.log(e.target.value[0]);
                document.querySelector('.mastercard').style.visibility = 'visible';
            } else if (((e.target.value[0] == 2) || (e.target.value[0] == 5))) {
                document.querySelector('.visa').style.visibility = 'visible';
                console.log();
            } else {
                document.querySelector('.mastercard').style.visibility = 'hidden';
                document.querySelector('.visa').style.visibility = 'hidden';


            }
        }
    </script>
</body>

</html>