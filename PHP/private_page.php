<?php
require_once "parametri.php";
include 'header.php';

//controllo se l'utente è loggato e controllo il suo ruolo
if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
    $user = $_SESSION['username'];
} else {
    $user = "";
}
if (empty($user)) { 
    header("Location:../PHP/homepage.php");
}
if (isset($_SESSION['ruolo']) || !empty($_SESSION['ruolo'])) {
    $ruolo = $_SESSION['ruolo'];
} else {
    $ruolo = "";
}
if ($ruolo != "visitatore") {
    header("Location:../PHP/admin.php");
}
//controllo la card
if (isset($_GET['card']) || !empty($_GET['card'])) {
    $card = $_GET['card'];
} else {
    $card = "";
}


//controllo se voglio essere in prenotazioni o voli passati
if (isset($_GET['prenotazioni']) || !empty($_GET['prenotazioni'])) {
    $prenotazioni = $_GET['prenotazioni'];
} else {
    $prenotazioni = "";
}

//blocco di codice che mi permette di eliminare il mio account
if (isset($_POST['elimina_account']) || !empty($_POST['elimina_account'])) {
    $elimina_account = $_POST['elimina_account'];
} else {
    $elimina_account = "";
}
if (!empty($elimina_account)) {
    //elimino l'username preso dal get dal db
    $sql_delete = "DELETE FROM utenti WHERE username=$1;";
    $prep_delete = pg_prepare($db, "EliminaUtente", $sql_delete);
    $ret_delete = pg_execute($db, 'EliminaUtente', array($elimina_account));
    if (!$ret_delete) {
        echo "ERRORE DELETE " . pg_last_error($db);
    }
    header("Location:../PHP/logout.php");
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <title>User</title>
    <link rel="stylesheet" href="../CSS/private_page.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <script type="text/javascript" src="../JS/private_page.js"></script>

</head>

<body>
    <!-- creo un div totale -->
    <div id=totale>
        <!-- creo il div di sinistra che si chiamerà menu -->
        <div id=menu>
            <!--Do il benvenuto all'utente loggato -->
            <?php echo "<p id=ciao> Ciao " . ucfirst($user) . "</p>";      ?>
            <!-- creo la card per le infromazioni personali-->
            <a href="private_page.php?card=informazioni_personali" class="carte" id="informazioni_personali" name="informazioni_personali">
                <!-- div per la gestione dell'immagine -->
                <div id="logo_carte">
                    <img src="../immagini/avatar.png">
                </div>
                <!-- div che mi permette di organizzare la descrizione della card-->
                <div id=descrizione_carte>
                    <h4>Informazioni personali</h4>
                    <p>Visualizza le tue informazioni personali,elimina il tuo account,oppure modofica i tui dati</p>
                </div>
            </a>
            <!-- lo stesso di sopra ma per la card prenotazioni-->
            <a href="private_page.php?card=prenotazioni&prenotazioni=correnti" class="carte" id="prenotazioni_btn" name="prenotazioni_btn">

                <div id="logo_carte">
                    <img src="../immagini/Prenotazione.png">
                </div>
                <div id=descrizione_carte>
                    <h4>Prenotazioni</h4>
                    <p>Visualizza tutte le tue prenotazioni presenti e passate</p>
                </div>
            </a>
            <!-- bottone di logout-->
            <a id=logout href="../PHP/logout.php">
                Logout
            </a>
            <!-- form con bottone che mi permette di eliminare il mio utente con l'onsubmit mi chiede la conferma-->
            <!-- e con il post passo la variabile user presa dalla session per eliminare l'account loggato-->
            <form action="../PHP/private_page.php" method="post" onsubmit="return confirm_elimina_account()">
                <button type="submit" id="btn_elimina_account" name="elimina_account" value="<?php echo $user; ?>">Elimina account</button>
            </form>
        </div>
        <!-- creo il div di destra,che con dei display:none; gestiti con js cambierà a seconda della card selezionata-->
        <div id=destra>
            <!-- div per i dati personali dell'utente-->
            <div id=personal_data name=personal_data>
                <?php
                //controllo se l'utente ha fatto per la prima volta l'account. Se non fosse cosi creo una tubla sul db
                //che avrà popolato solo l'username
                $sql_controlla_utente = "SELECT username FROM personaldata WHERE username=$1";
                $prep = pg_prepare($db, "Controlla_utente", $sql_controlla_utente);
                $ret = pg_execute($db, "Controlla_utente", array($user));
                if (!$ret) {
                    echo "ERRORE QUERY: " . pg_last_error($db);
                } else {
                    $row = pg_fetch_assoc($ret);
                    $username = $row['username'];
                }
                if (empty($username)) {
                    $sql_utente = "INSERT INTO personaldata (username) VALUES ($1);";
                    $prep = pg_prepare($db, "Insert_utente", $sql_utente);
                    $ret = pg_execute($db, "Insert_utente", array($user));
                    if (!$ret) {
                        echo "ERRORE QUERY: " . pg_last_error($db);
                    }
                }
                //prendo la data di oggi
                $data_oggi = date("Y-m-d");

                if (isset($_POST['nome'])) {
                    $nome = $_POST['nome'];
                } else {
                    $nome = "";
                }
                if (isset($_POST['cognome'])) {
                    $cognome = $_POST['cognome'];
                } else {
                    $cognome = "";
                }
                if (isset($_POST['indirizzo'])) {
                    $indirizzo = $_POST['indirizzo'];
                } else {
                    $indirizzo = "";
                }
                if (isset($_POST['cap'])) {
                    $strcap = strval($_POST['cap']);
                    $lunghezzacap = strlen($strcap);
                    if ($lunghezzacap < 6) {
                        $cap = $_POST['cap'];
                    } else {
                        $cap = "";
                    }
                } else {
                    $cap = "";
                }
                if (isset($_POST['sex'])) {
                    $sex = $_POST['sex'];
                } else {
                    $sex = "";
                }
                if (isset($_POST['nazionalita'])) {
                    $nazionalita = $_POST['nazionalita'];
                } else {
                    $nazionalita = "";
                }
                if (isset($_POST['luogo_nascita'])) {
                    $luogo_nascita = $_POST['luogo_nascita'];
                } else {
                    $luogo_nascita = "";
                }
                if (isset($_POST['data_nascita'])) {
                    if (($_POST['data_nascita'] < $data_oggi)) {
                        $data_nascita = $_POST['data_nascita'];
                    } else {
                        $data_nascita = "";
                    }
                } else {
                    $data_nascita = "";
                }
                if (isset($_POST['numerotel'])) {
                    $strnum = strval($_POST['numerotel']);
                    $lunghezzanum = strlen($strnum);
                    if ($lunghezzanum < 12) {
                        $numerotel = $_POST['numerotel'];
                    } else {
                        $numerotel = "";
                    }
                } else {
                    $numerotel = "";
                }
                if (isset($_POST['sex'])) {
                    $sesso = $_POST['sex'];
                } else {
                    $sesso = "";
                }




                if (!empty($nome || $cognome || $indirizzo || $cap || $sex || $nazionalita || $luogo_nascita || $data_nascita || $numerotel)) {
                    $sql_update = "UPDATE personaldata SET nome=$1,cognome=$2,indirizzo=$3,cap=$4,sesso=$5,nazionalita=$6,luogo_nascita=$7,data_nascita=$8,numerotel=$9 WHERE username=$10";
                    $prep = pg_prepare($db, "UpdateUtente", $sql_update);
                    if (!$prep) {
                        echo pg_last_error($db);
                    } else {
                        $ret_update = pg_execute($db, "UpdateUtente", array($nome, $cognome, $indirizzo, $cap, $sesso, $nazionalita, $luogo_nascita, $data_nascita, $numerotel, $user));
                        if (!$ret_update) {
                            echo "ERRORE AGGIORNAMETO. RICARICARE LA PAGINA E RIPROVARE - " . pg_last_error($db);
                        }
                    }
                }

                //Prendo tutti i dati dal db che mi servono per popolare il form
                $sql = "SELECT nome,cognome,indirizzo,cap,sesso,nazionalita,luogo_nascita,data_nascita,numerotel FROM personaldata WHERE username=$1;";
                $prep = pg_prepare($db, "personalData", $sql);
                $ret = pg_execute($db, "personalData", array($user));
                if (!$ret) {
                    echo "ERRORE QUERY: " . pg_last_error($db);
                    return false;
                } else {
                    $row = pg_fetch_assoc($ret);
                    $nome = $row['nome'];
                    $cognome = $row['cognome'];
                    $indirizzo = $row['indirizzo'];
                    $cap = $row['cap'];
                    $sesso = $row['sesso'];
                    $nazionalita = $row['nazionalita'];
                    $luogo_nascita = $row['luogo_nascita'];
                    $data_nascita = $row['data_nascita'];
                    $numerotel = $row['numerotel'];
                }

                ?>
                <div class="dettagli personali">
                    <h4>Informazioni Personali</h4>
                    <!-- bottone che se schiacciato mi permette di abilitare le modifiche al form-->
                    <button id="modifica_btn" onclick="abilita_modifica()">Modifica</button>
                </div>
                <!-- form che mi permette di modificare e visualizzare le informazioni personali dell'utente-->
                <form action="private_page.php?card=informazioni_personali" method="post" id="personal_data_form" onsubmit="return validateDatiPersonali()">
                    <p>
                        <label for="name"></label>
                        Nome: <input id="nome" name="nome" type="text" disabled value="<?php echo "$nome" ?>">
                    </p>
                    <p>
                        <label for="cognome"></label>
                        Cognome: <input id="cognome" name="cognome" type="text" disabled value="<?php echo "$cognome" ?>">
                    </p>
                    <p>
                        <label for="indirizzo"></label>
                        Indirizzo: <input id="indirizzo" name="indirizzo" type="text" disabled value="<?php echo "$indirizzo" ?>">
                    </p>
                    <p>
                        <label for="cap"></label>
                        CAP: <input id="cap" name="cap" type="number" disabled value="<?php echo "$cap" ?>">
                    </p>
                    <p id="radio_sex">
                        <label for="sesso">SESSO: <div id="sesso">
                                <input type="radio" name="sex" id="male" value="M" disabled>M
                                <input type="radio" name="sex" id="female" value="F" disabled>F
                            </div>
                        </label>
                    </p>
                    <p>
                        <label for="nazionalita"></label>
                        Nazionalit&agrave;: <input id="nazionalita" name="nazionalita" type="text" disabled value="<?php echo "$nazionalita" ?>">
                    </p>
                    <p>
                        <label for="luogo_nascita"></label>
                        Luogo di nascita: <input id="luogo_nascita" name="luogo_nascita" type="text" disabled value="<?php echo "$luogo_nascita" ?>">
                    </p>
                    <p>
                        <label for="data_nascita"></label>
                        Data di Nascita: <input id="data_nascita" name="data_nascita" type="date" disabled value="<?php echo "$data_nascita" ?>">
                    </p>
                    <p>
                        <label for="numerotel"></label>
                        Numero di Telefono: <input id="numerotel" name="numerotel" type="number" disabled value="<?php echo "$numerotel" ?>">
                    </p>
                    <p>
                        <button type="submit" id="update_data" name="update_data">Salva le modifiche </button>
                    </p>
                </form>
            </div>
            <!-- div che mi permette di mostrare tutte le persone dell'utente presenti e future -->
            <div id=prenotazione_personale name="prenotazione_personale">
                <!-- div per visualizzare i voli quelli futuri e quelli passati-->
                <div class="dettagli voli">
                    <a id="btn_prenotazioni" name="btn_prenotazioni" href="private_page.php?card=prenotazioni&prenotazioni=correnti">Prenotazioni</a>
                    <a id="btn_voliPassati" name="btn_voliPassati" href="private_page.php?card=prenotazioni&prenotazioni=volipassati">Voli Passati</a>
                </div>
                <!-- div per i voli futuri-->
                <div id=prenotazioni name="prenotazioni">
                    <?php
                    //prendo la data di oggi
                    $data = date("Y-m-d");
                    $sql_prenotazioni = "SELECT p.username,p.id_volo,p.numero_bagagli,p.prezzo,v.data_volo,v.citta_partenza,v.ora_partenza,v.citta_arrivo,v.ora_arrivo,pd.nome,pd.cognome FROM prenotazioni p  JOIN volo v ON (p.id_volo = v.id_volo) JOIN personaldata pd ON (p.username = pd.username) WHERE p.username=$1 AND data_volo>'$data' ORDER BY data_volo";
                    $prep = pg_prepare($db, "prenotazioni_voli", $sql_prenotazioni);
                    $ret = pg_execute($db, "prenotazioni_voli", array($user));
                    if (!$ret) {
                        echo "ERRORE QUERY: " . pg_last_error($db);
                        return false;
                    } else {
                        $noData = pg_result_seek($ret, 0);
                        //controllo se la query ha ritornato dei dati.
                        //se ha riportato dati allora entro nell'if e con il while stampo tutti voli futuri
                        if ($noData) {
                            while ($row = pg_fetch_assoc($ret)) {
                                $id_volo = $row['id_volo'];
                                $numero_bagagli = $row['numero_bagagli'];
                                $prezzo = $row['prezzo'];
                                $data_volo = $row['data_volo'];
                                $citta_partenza = $row['citta_partenza'];
                                $ora_partenza = $row['ora_partenza'];
                                $citta_arrivo = $row['citta_arrivo'];
                                $ora_arrivo = $row['ora_arrivo'];
                                $nome = $row['nome'];
                                $cognome = $row['cognome'];
                    ?>
                                <div id="voli_prenotati_tot">
                                    <b>Data del volo: <?php echo $data_volo ?></b>
                                    <div id="voli_prenotati">

                                        <div id="container_citta">
                                            <?php echo "<p>Da: " . ucfirst($citta_partenza) . "</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_partenza . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Partenza: " .  substr($ora_partenza,0,5) . "</p>" ?>
                                        </div>

                                        <?php echo '<img src="../immagini/aereo.png">' ?>

                                        <div id="container_citta">
                                            <?php echo "<p>A: " . ucfirst($citta_arrivo) . "</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_arrivo . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Arrivo: " . substr($ora_arrivo,0,5) . "</p>" ?>
                                        </div>
                                    </div>
                                    <div id="informazioni_prenotazione">
                                        <?php echo "<p><b>Passeggero: </b> $nome $cognome</p>" ?>
                                        <?php echo "<p><b>Id Volo: </b> $id_volo</p>" ?>
                                        <?php echo "<p><b>Num. bagagli: </b> $numero_bagagli</p>" ?>
                                    </div>
                                </div>
                    <?php

                            }
                            //se non entra nell'if($noData) arriverà qui e stamperà voli non trovati
                        } else {
                            echo "<p id=notFound>Voli non trovati</p>";
                        }
                    }

                    ?>
                </div>
                <!-- div per visualizzare tutti i voli passati -->
                <!-- funziona allo stesso identico modo del div prenotazioni ma stamap tutti i voli passati-->
                <div id=voli_passati name="voli_passati">
                    <?php
                    $sql_passati = "SELECT p.username,p.id_volo,p.numero_bagagli,p.prezzo,v.data_volo,v.citta_partenza,v.ora_partenza,v.citta_arrivo,v.ora_arrivo,pd.nome,pd.cognome FROM prenotazioni p  JOIN volo v ON (p.id_volo = v.id_volo) JOIN personaldata pd ON (p.username = pd.username) WHERE p.username=$1 AND data_volo<='$data' ORDER BY data_volo";
                    $prep = pg_prepare($db, "voli_passati", $sql_passati);
                    $ret = pg_execute($db, "voli_passati", array($user));
                    if (!$ret) {
                        echo "ERRORE QUERY: " . pg_last_error($db);
                        return false;
                    } else {
                        $noData = pg_result_seek($ret, 0);
                        if ($noData) {
                            while ($row = pg_fetch_assoc($ret)) {
                                $id_volo = $row['id_volo'];
                                $numero_bagagli = $row['numero_bagagli'];
                                $prezzo = $row['prezzo'];
                                $data_volo = $row['data_volo'];
                                $citta_partenza = $row['citta_partenza'];
                                $ora_partenza = $row['ora_partenza'];
                                $citta_arrivo = $row['citta_arrivo'];
                                $ora_arrivo = $row['ora_arrivo'];
                                $nome = $row['nome'];
                                $cognome = $row['cognome'];
                    ?>
                                <div id="voli_prenotati_tot">
                                    <b>Data del volo: <?php echo $data_volo ?></b>

                                    <div id="voli_prenotati">
                                        <div id="container_citta">
                                            <?php echo "<p>Da: " . ucfirst($citta_partenza) . "</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_partenza . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Partenza: " . substr($ora_partenza,0,5) . "</p>" ?>
                                        </div>

                                        <?php echo '<img src="../immagini/aereo.png">' ?>

                                        <div id="container_citta">
                                            <?php echo "<p>A: " . ucfirst($citta_arrivo) . "</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_arrivo . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Arrivo: " . substr($ora_arrivo,0,5) . "</p>" ?>
                                        </div>
                                    </div>
                                    <div id="informazioni_prenotazione">
                                        <?php echo "<p><b>Passeggero: </b> $nome $cognome</p>" ?>
                                        <?php echo "<p><b>Id Volo: </b> $id_volo</p>" ?>
                                        <?php echo "<p><b>Num. bagagli: </b> $numero_bagagli</p>" ?>
                                    </div>
                                </div>
                    <?php

                            }
                        } else {
                            echo "<p id=notFound>Non hai voli passati</p>";
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>


    </div>
    <!-- includo il footer-->
    <?php include '../html/footer.html'; ?>
</body>

</html>

<?php
//if che mi serve per attivare la proprietà checked del input radio
if ($sesso == "M") {
    echo '<script type="text/javascript">male();</script>';
}
if ($sesso == "F") {
    echo '<script type="text/javascript">female();</script>';
}
//questi 3 if mi servono per visualizzare le card di mio interesse richiamando le funzioni JS
if ($card == "informazioni_personali") {
    echo '<script type="text/javascript">informazioni_personali();</script>';
}

if ($card == "prenotazioni" && $prenotazioni == "correnti") {
    echo '<script type="text/javascript">prenotazioni_correnti();</script>';
}
if ($card == "prenotazioni" && $prenotazioni == "volipassati") {
    echo '<script type="text/javascript">prenotazioni_passate();</script>';
}
