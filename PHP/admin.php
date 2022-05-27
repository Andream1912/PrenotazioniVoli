<?php
require_once "parametri.php";
include 'header.php';
//controllo se l'utente è loggato e il suo ruolo

if(isset($_SESSION['username'])||!empty($_SESSION['username'])){
    $user = $_SESSION['username'];
}
else{
    $user="";
}
if(isset($_SESSION['ruolo'])||!empty($_SESSION['ruolo'])){
    $ruolo = $_SESSION['ruolo'];
}
else{
    $ruolo="";
}
if (empty($user) || ($ruolo != "admin")) {
    header("Location:../PHP/homepage.php");
}
if(isset($_GET['card'])||!empty($_GET['card'])){
    $card=$_GET['card'];
}
else{
    $card="";
}
$count = 0;
//controllo in che card mi trovo per far vedere ciò che mi interessa

//se l'utente non è loggato oppure il ruolo non è admin torno alla homepage
//blocco di codice che serve per eliminare l'user selezionato col tasto cancella nella sezione elimina account
if(isset($_POST['elimina_account'])||!empty($_POST['elimina_account'])){
    $user_da_eliminare = $_POST['elimina_account'];
}
else{
    $user_da_eliminare="";
}
if (!empty($user_da_eliminare)) {
    //elimino l'username preso dal get dal db
    $sql_delete = "DELETE FROM utenti WHERE username=$1;";
    $prep_delete = pg_prepare($db, "EliminaUtente", $sql_delete);
    $ret_delete = pg_execute($db, 'EliminaUtente', array($user_da_eliminare));
    if (!$ret_delete) {
        echo "ERRORE DELETE " . pg_last_error($db);
    }
}
?>
<!DOCTYPE html>
<html lang="it">


<head>
    <title>Admin page</title>
    <link rel="stylesheet" href="../CSS/admin.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <script type="text/javascript" src="../JS/admin.js"></script>
</head>

<body>
    <!-- includo tutto in un div totale -->
    <div id=totale>
        <!-- creo il div di sinistra chiamato menu-->
        <div id=menu>
            <?php
            //stampo il benvenuto all'admin
            echo "<p id=ciao> Ciao $user</p>";
            ?>
            <!-- creo la card per eliminare gli utenti -->
            <a href="admin.php?card=eliminautenti" class="carte" id="elimina_utenti" name="elimina_utenti">
                <!-- div per gestire l'immagine della card-->
                <div id="logo_carte">
                    <img src="../immagini/avatar.png">
                </div>
                <!-- div per la descrizione della card -->
                <div id=descrizione_carte>
                    <h4>Elimina Utenti</h4>
                    <p>Visualizza tutti gli utenti con la possibilita&grave; di eliminarli</p>
                </div>
            </a>
            <!-- creo la card per aggiungere i voli -->
            <a href="admin.php?card=aggiungivoli" class="carte" id="aggiungi_voli" name="aggiungi_voli">
                <!-- div per gestire l'immagine della card-->
                <div id="logo_carte">
                    <img src="../immagini/Prenotazione.png">
                </div>
                <!-- div per la descrizione della card -->
                <div id=descrizione_carte>
                    <h4>Aggiungi Voli</h4>
                    <p>Aggiungi voli futuri</p>
                </div>
            </a>
            <!-- bottone di logout -->
            <a id=logout href="../PHP/logout.php">
                Logout
            </a>


        </div>
        <!-- creo il div di destra,che con dei display:none; gestiti con js cambierà a seconda della card selezionata-->
        <div id=destra>
            <!-- div per visualizzare tutti gli utenti ed eliminarli-->
            <div id=visualizza_utenti name="visualizza_utenti">
                <!-- form con un input per cercare gli utenti-->
                <form action="admin.php?card=eliminautenti" method="post">
                    <input type="text" name="cerca" placeholder="Username da cercare" value="<?php if (isset($_POST['cerca'])) {
                                                                                                    echo $_POST['cerca'];
                                                                                                }  ?>">
                    <!-- bottone che effettua la ricerca-->
                    <button type="submit" id="cerca_button">Cerca</button>
                </form>
                <?php
                //acqusisco i dati dell'input per la ricerca
                if(isset($_POST['cerca'])||!empty($_POST['cerca'])){
                    $cerca_utenti = $_POST['cerca'];
                }
                else{
                    $cerca_utenti="";
                }
                //seleziono tutti gli utenti tranne l'admin in modo tale che non lo posso eliminare per errore
                $sql_visualizza_tutti_utenti = "SELECT username,email FROM utenti EXCEPT(SELECT username,email FROM utenti WHERE username='admin') ORDER BY username;";
                $ret = pg_query($db, $sql_visualizza_tutti_utenti);
                if (!$ret) {
                    echo "ERRORE QUERY: " . pg_last_error($db);
                } ?>
                <!-- creo la tabella per la visualizzazione degli utenti-->
                <table id=tabella_utenti name="tabella_utenti">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Elimina</th>
                    </tr>

                    <?php
                    // se l'imput di ricerca è vuoto visualizzo tutti gli utenti con il while
                    if (empty($cerca_utenti)) {
                        $Data = pg_result_seek($ret, 0);
                        //se la query non mi torna niente allora stampo Non esiste nessun utente
                        //se invece ci sono dati allora stamperò con il while tutti gli utenti
                        if ($Data) {
                            while ($row = pg_fetch_assoc($ret)) {
                                $username = $row['username'];
                                $email = $row['email'];
                                echo "<tr>";
                                echo "<td>$username</td>";
                                echo "<td>$email</td>";
                                //form che mi permette di passare tramite il post l'username da eliminare dal db
                                //ed uso l'onsubmit per far uscire il cofirm JS
                    ?><td>
                                    <form action="../PHP/admin.php?card=eliminautenti" method="post" onsubmit="return confirm_elimina_account()">
                                        <button type="submit" class="btn_elimina_account" name="elimina_account" value="<?php echo $username; ?>">Cancella</button>
                                    </form>
                                </td>
                            <?php
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {

                            echo '<script type="text/javascript">nascondi_tabella();</script>';
                            echo "<b>Non esiste nessun utente</b>";
                        }
                        //se sono qui allora vuol dire che l'input è pieno quindi cerco solo gli utenti che mi interessano
                    } else {
                        
                        while ($row = pg_fetch_assoc($ret)) {
                            //stampo nella tabella solo le cose che mi interessano a seconda dell'input
                            if (strstr($row['username'], $cerca_utenti)) {
                                $count += 1;
                                $username = $row['username'];
                                $email = $row['email'];

                                echo "<tr>";
                                echo "<td>$username</td>";
                                echo "<td>$email</td>";
                            ?><td>
                                    <form action="../PHP/admin.php?card=eliminautenti" method="post" onsubmit="return confirm_elimina_account()">
                                        <button type="submit" id="btn_elimina_account" name="elimina_account" value="<?php echo $username; ?>">Cancella</button>
                                    </form>
                                </td>
                        <?php
                                echo "</tr>";
                            }
                        }
                        echo "</table>";

                        ?>

                    <?php   }
                    //se il count è 0 allora nessuna corrispondenza dell'input
                    if ($count == 0 && !empty($cerca_utenti)) {
                        echo '<script type="text/javascript">nascondi_tabella();</script>';
                        echo "<b>Nessun utente trovato con $cerca_utenti</b>";
                    }

                    ?>
                </table>
            </div>
            <!-- div per aggiungere nuovi voli-->
            <div id=btn_aggiungi_voli name="btn_aggiungi_voli">
                <div id="controllo_form" name="controllo_form">
                    <?php
                    //prendo la data di oggi
                    $data_oggi = date("Y-m-d");
                    //controllo che il volo non sia inferiore alla data di oggi
                    if ((isset($_POST['data_volo'])) && (!empty($_POST['data_volo'])) && ($_POST['data_volo'] > $data_oggi)) {
                        $data_volo = $_POST['data_volo'];
                    } else {
                        $data_volo = "";
                    }
                    if ((isset($_POST['citta_partenza'])) && (!empty($_POST['citta_partenza']))) {
                        $citta_partenza = strtolower($_POST['citta_partenza']);
                        //controllo se la città di partenza è all'interno del db se non lo è l'inserimento non va a buon fine
                        $sql_paese = "SELECT nome FROM paese WHERE nome=$1";
                        $prep_paese = pg_prepare($db, 'controllaPaesePart', $sql_paese);
                        $ret_paese = pg_execute($db, 'controllaPaesePart', array($citta_partenza));
                        if (!($row = pg_fetch_array($ret_paese))) {
                            $citta_partenza = "";
                            $insertFlight = "Volo non inserito, CITTA PARTENZA ERRATA!";
                        }
                    } else {
                        $citta_partenza = "";
                    }
                    //controllo che l'ora di partenza sia inizializzata
                    if ((isset($_POST['ora_partenza'])) && (!empty($_POST['ora_partenza']))) {
                        $ora_partenza = $_POST['ora_partenza'] . ":00";
                    } else {
                        $ora_partenza = "";
                    }
                    //faccio la stessa cosa che ho fatto per la città di partenza
                    if ((isset($_POST['citta_arrivo'])) && (!empty($_POST['citta_arrivo']))) {
                        $citta_arrivo = strtolower($_POST['citta_arrivo']);
                        $sql_paese = "SELECT nome FROM paese WHERE nome=$1";
                        $prep_paese = pg_prepare($db, 'controllaPaeseArrivo', $sql_paese);
                        $ret_paese = pg_execute($db, 'controllaPaeseArrivo', array($citta_arrivo));
                        if (!($row = pg_fetch_array($ret_paese))) {
                            $citta_arrivo = "";
                            $insertFlight = $insertFlight . "CITTA ARRIVO ERRATA";
                        }
                    } else {
                        $citta_arrivo = "";
                    }
                    //controllo che l'orario di arrivo sia inizializzata
                    if ((isset($_POST['ora_arrivo'])) && (!empty($_POST['ora_arrivo']))) {
                        $ora_arrivo = $_POST['ora_arrivo'] . ":00";
                    } else {
                        $ora_arrivo = "";
                    }
                    //controllo che il prezzo non sia inferiore a 0
                    if ((isset($_POST['prezzo'])) && (!empty($_POST['prezzo']) && ($_POST['prezzo'] > 0))) {
                        $prezzo = $_POST['prezzo'];
                    } else {
                        $prezzo = "";
                    }
                    //controllo che i posti disponibili non siano inferiori a 0
                    if ((isset($_POST['posti_disponibili'])) && (!empty($_POST['posti_disponibili']) && ($_POST['posti_disponibili'] > 0))) {
                        $posti_disponibili = intval($_POST['posti_disponibili']);
                    } else {
                        $posti_disponibili = "";
                    }
                    // controllo che tutti i campi sono pieni nel caso non lo fossero non posso fare l'inserimento nel db
                    if (!empty($data_volo) && !empty($citta_partenza) && !empty($ora_partenza) && !empty($citta_arrivo) && !empty($ora_arrivo) && !empty($prezzo) && !empty($posti_disponibili)) {
                        $sql_insert_volo = "INSERT INTO volo(data_volo,citta_partenza,ora_partenza,citta_arrivo,ora_arrivo,prezzo,posti_disponibili) values ($1,$2,$3,$4,$5,$6,$7);";
                        $prep_insert_volo = pg_prepare($db, "insertVolo", $sql_insert_volo);
                        $ret_insert_volo = pg_execute($db, "insertVolo", array($data_volo, $citta_partenza, $ora_partenza, $citta_arrivo, $ora_arrivo, $prezzo, $posti_disponibili));
                        if (!$ret_insert_volo) {
                            echo "ERRORE INSERIMENTO VOLO " . pg_last_error($db);
                        } else {
                            $insertFlight = "Volo Inserito";
                        }
                    } else {
                    } ?>
                </div>
                <p><?php echo $insertFlight; ?></p>
                <h2>Aggiungi un Volo</h2>
                <!-- form che mi permette di inserire tutti i dati necessari per l'inserimento del volo -->
                <form action="admin.php?card=aggiungivoli" method="post" id="aggiungi_voli_form" onsubmit="return validateAggiungiVoli()">
                    <p>
                        <label for="data_volo"></label>
                        Data volo: <input name="data_volo" type="date" required>
                    </p>
                    <p>
                        <label for="citta_partenza"></label>
                        Citta di partenza: <input name="citta_partenza" type="text" required>
                    </p>
                    <p>
                        <label for="ora_partenza"></label>
                        Ora di partenza: <input name="ora_partenza" type="time" required>
                    </p>
                    <p>
                        <label for="citta_arrivo"></label>
                        Citta di arrivo: <input name="citta_arrivo" type="text" required>
                    </p>
                    <p>
                        <label for="ora_arrivo"></label>
                        Ora di arrivo: <input name="ora_arrivo" type="time" required>
                    </p>
                    <p>
                        <label for="prezzo"></label>
                        Prezzo: <input name="prezzo" type="numeric" required>
                    </p>
                    <p>
                        <label for="posti_disponibili"></label>
                        Posti disponibili: <input name="posti_disponibili" type="integer" required>
                    </p>
                    <p>
                        <button type="submit" id="submit_volo" name="submit_volo">Aggiungi il volo </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <!-- includo il footer -->
    <?php include '../html/footer.html'; ?>
</body>

</html>

<?php
//controllo se mi trovo nella card per eliminare gli utenti oppure in quella per aggiungere i voli
//a seconda di dove mi trovo vengono chiamate le funzioni JS per mostrare le cose di interesse
if ($card == "eliminautenti") {
    echo '<script type="text/javascript">elimina_utenti();</script>';
}
if ($card == "aggiungivoli") {
    echo '<script type="text/javascript">aggiungi_voli();</script>';
}
