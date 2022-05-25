<?php
require_once "parametri.php";
session_start();
$user = $_SESSION['username'];
$ruolo = $_SESSION['ruolo'];
$card = $_GET['card'];
if (empty($user) || ($ruolo != "admin")) {
    header("Location:../PHP/homepage.php");
}
$user_da_eliminare = $_GET['id'];
if (!empty($user_da_eliminare)) {
    $sql_delete = "DELETE FROM utenti WHERE username=$1;";
    $prep_delete = pg_prepare($db, "deleteById", $sql_delete);
    $ret_delete = pg_execute($db, 'deleteById', array($user_da_eliminare));
    if (!$ret_delete) {
        echo "ERRORE DELETE " . pg_last_error($db);
    }
}
?>
<html>

<head>
    <title>Admin page</title>
    <link rel="stylesheet" href="../CSS/admin.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <script type="text/javascript" src="../JS/admin.js"></script>
</head>

<body>

    <?php

    include './header.php';

    ?>

    <div id=totale>
        <div id=menu>
            <?php

            echo "<p id=ciao> Ciao $user</p>";

            ?>


            <a href="admin.php?card=eliminautenti" class="carte" id="elimina_utenti" name="elimina_utenti">

                <div id="logo_carte">
                    <img src="../immagini/avatar.png">
                </div>
                <div id=descrizione_carte>
                    <h4>Elimina Utenti</h4>
                    <p>Visualizza tutti gli utenti con la possibilita&grave; di eliminarli</p>
                </div>
            </a>
            <a href="admin.php?card=aggiungivoli" class="carte" id="aggiungi_voli" name="aggiungi_voli">

                <div id="logo_carte">
                    <img src="../immagini/Prenotazione.png">
                </div>
                <div id=descrizione_carte>
                    <h4>Aggiungi Voli</h4>
                    <p>Aggiungi voli futuri</p>
                </div>
            </a>
            <a id=logout href="../PHP/logout.php">
                Logout
            </a>

        </div>
        <div id=destra>
            <div id=visualizza_utenti name="visualizza_utenti">
                <form action="admin.php?card=eliminautenti" method="post">
                    <input type="text" name="cerca" placeholder="Inserisci username" value="<?php if (isset($_POST['cerca'])) {
                                                                                                echo $_POST['cerca'];
                                                                                            }  ?>">
                    <button type="submit">Cerca</button>
                </form>
                <?php
                $cerca_utenti = $_POST['cerca'];


                $sql_visualizza_tutti_utenti = "SELECT username,email FROM utenti EXCEPT(SELECT username,email FROM utenti WHERE username='admin');";
                $ret = pg_query($db, $sql_visualizza_tutti_utenti);
                if (!$ret) {
                    echo "ERRORE QUERY: " . pg_last_error($db);
                } ?>
                <table id=tabella_utenti name="tabella_utenti" border="true">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Elimina</th>
                    </tr>

                    <?php

                    if (empty($cerca_utenti)) {
                        $noData = pg_result_seek($ret, 0);
                        if ($noData) {
                            while ($row = pg_fetch_assoc($ret)) {
                                $username = $row['username'];
                                $email = $row['email'];
                                echo "<tr>";
                                echo "<td>$username</td>";
                                echo "<td>$email</td>";
                                echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?card=eliminautenti&id=' . $username . '">Cancella</a></td>';
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo '<script type="text/javascript">nasconi_tabella();</script>';
                            echo "<p>Non esiste nessun utente</p>";
                        }
                    } else {
                        $count = 0;
                        while ($row = pg_fetch_assoc($ret)) {

                            if (strstr($row['username'], $cerca_utenti)) {
                                $count += 1;
                                $username = $row['username'];
                                $email = $row['email'];

                                echo "<tr>";
                                echo "<td>$username</td>";
                                echo "<td>$email</td>";
                                echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?card=eliminautenti&id=' . $username . '">Cancella</a></td>';
                                echo "</tr>";
                            }
                        }
                        echo "</table>";

                    ?>

                    <?php   }
                    if ($count == 0 && !empty($cerca_utenti)) {
                        echo '<script type="text/javascript">nasconi_tabella();</script>';
                        echo "nessun utente trovato con $cerca_utenti";
                    }

                    ?>
                </table>
            </div>
            <div id=btn_aggiungi_voli name="btn_aggiungi_voli">

                <?php
                $data_oggi = date("Y-m-d");

                if ((isset($_POST['data_volo'])) && (!empty($_POST['data_volo'])) && ($_POST['data_volo'] > $data_oggi)) {
                    $data_volo = $_POST['data_volo'];
                } else {
                    $data_volo = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }
                if ((isset($_POST['citta_partenza'])) && (!empty($_POST['citta_partenza']))) {
                    $citta_partenza = strtolower($_POST['citta_partenza']);
                    $sql_paese = "SELECT nome FROM paese WHERE nome=$1";
                    $prep_paese = pg_prepare($db, 'controllaPaese', $sql_paese);
                    $ret_paese = pg_execute($db, 'controllaPaese', array($citta_partenza));
                    if (!($row = pg_fetch_array($ret_paese))) {
                        $citta_partenza = "";
                        header("Location:../PHP/admin.php?card=aggiungivoli");
                    }
                } else {
                    $citta_partenza = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }

                if ((isset($_POST['ora_partenza'])) && (!empty($_POST['ora_partenza']))) {
                    $ora_partenza = $_POST['ora_partenza'] . ":00";
                } else {
                    $ora_partenza = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }
                if ((isset($_POST['citta_arrivo'])) && (!empty($_POST['citta_arrivo']))) {
                    $citta_arrivo = strtolower($_POST['citta_arrivo']);
                    $sql_paese = "SELECT nome FROM paese WHERE nome=$1";
                    $prep_paese = pg_prepare($db, 'controllaPaese', $sql_paese);
                    $ret_paese = pg_execute($db, 'controllaPaese', array($citta_arrivo));
                    if (!($row = pg_fetch_array($ret_paese))) {
                        $citta_arrivo = "";
                        header("Location:../PHP/admin.php?card=aggiungivoli");
                    }
                } else {
                    $citta_arrivo = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }
                if ((isset($_POST['ora_arrivo'])) && (!empty($_POST['ora_arrivo']))) {
                    $ora_arrivo = $_POST['ora_arrivo'] . ":00";
                } else {
                    $ora_arrivo = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }
                if ((isset($_POST['prezzo'])) && (!empty($_POST['prezzo']) && ($_POST['prezzo'] > 0))) {
                    $prezzo = $_POST['prezzo'];
                } else {
                    $prezzo = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }
                if ((isset($_POST['posti_disponibili'])) && (!empty($_POST['posti_disponibili']) && ($_POST['posti_disponibili'] > 0))) {
                    $posti_disponibili = intval($_POST['posti_disponibili']);
                } else {
                    $posti_disponibili = "";
                    header("Location:../PHP/admin.php?card=aggiungivoli");
                }
                if (!empty($data_volo) && !empty($citta_partenza) && !empty($ora_partenza) && !empty($citta_arrivo) && !empty($ora_arrivo) && !empty($prezzo) && !empty($posti_disponibili)) {
                    $sql_insert_volo = "INSERT INTO volo(data_volo,citta_partenza,ora_partenza,citta_arrivo,ora_arrivo,prezzo,posti_disponibili) values ($1,$2,$3,$4,$5,$6,$7);";
                    $prep_insert_volo = pg_prepare($db, "insertVolo", $sql_insert_volo);
                    $ret_insert_volo = pg_execute($db, "insertVolo", array($data_volo, $citta_partenza, $ora_partenza, $citta_arrivo, $ora_arrivo, $prezzo, $posti_disponibili));
                    if (!$ret_insert_volo) {
                        echo "ERRORE INSERIMENTO VOLO " . pg_last_error($db);
                    }
                    echo "Il volo è stato inserito ";
                }









                ?>
                <h2>Aggiungi un Volo</h2>
                <form action="admin.php?card=aggiungivoli" method="post" id="aggiungi_voli_form">
                    <p>
                        <label for="data_volo"></label>
                        Data volo: <input name="data_volo" type="date">
                    </p>
                    <p>
                        <label for="citta_partenza"></label>
                        Citta di partenza: <input name="citta_partenza" type="text">
                    </p>
                    <p>
                        <label for="ora_partenza"></label>
                        Ora di partenza: <input name="ora_partenza" type="time">
                    </p>
                    <p>
                        <label for="citta_arrivo"></label>
                        Citta di arrivo: <input name="citta_arrivo" type="text">
                    </p>
                    <p>
                        <label for="ora_arrivo"></label>
                        Ora di arrivo: <input name="ora_arrivo" type="time">
                    </p>
                    <p>
                        <label for="prezzo"></label>
                        Prezzo: <input name="prezzo" type="numeric">
                    </p>
                    <p>
                        <label for="posti_disponibili"></label>
                        Posti disponibili <input name="posti_disponibili" type="integer">
                    </p>
                    <p>
                        <button type="submit" id="submit_volo" name="submit_volo">Aggiungi il volo </button>
                    </p>
                </form>



            </div>

        </div>
    </div>



    </div>


    <?php include './footer.php'; ?>

</body>

</html>

<?php
if ($card == "eliminautenti") {
    echo '<script type="text/javascript">elimina_utenti();</script>';
}
if ($card == "aggiungivoli") {
    echo '<script type="text/javascript">aggiungi_voli();</script>';
}
