<?php
require_once "parametri.php";

session_start();
$user = $_SESSION['username'];
if (empty($user)) { //if login in session is not set
    header("Location:../PHP/homepage.php");
}
$ruolo = $_SESSION['ruolo'];
if ($ruolo != "visitatore") {
    header("Location:../PHP/admin.php");
}

$card = $_GET['card'];
$prenotazioni = $_GET['prenotazioni'];

?>




<html>

<head>
    <title>User</title>
    <link rel="stylesheet" href="../CSS/private_page.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <script type="text/javascript" src="../JS/private_page.js"></script>

</head>

<body>

    <?php

    include './header.php'

    ?>

    <div id=totale>
        <div id=menu>
            <?php

            echo "<p id=ciao> Ciao $user</p>";
            ?>


            <a href="private_page.php?card=informazioni_personali" class="carte" id="informazioni_personali" name="informazioni_personali">

                <div id="logo_carte">
                    <img src="../immagini/avatar.png">
                </div>
                <div id=descrizione_carte>
                    <h4>Informazioni personali</h4>
                    <p>Visualizza le tue informazioni personali,elimina il tuo account,oppure modofica i tui dati</p>
                </div>
            </a>
            <a href="private_page.php?card=prenotazioni&prenotazioni=correnti" class="carte" id="prenotazioni_btn" name="prenotazioni_btn">

                <div id="logo_carte">
                    <img src="../immagini/Prenotazione.png">
                </div>
                <div id=descrizione_carte>
                    <h4>Prenotazioni</h4>
                    <p>Visualizza tutte le tue prenotazioni presenti e passate</p>
                </div>
            </a>
            <a id=logout href="../PHP/logout.php">
                Logout
            </a>

        </div>
        <div id=destra>
            <div id=personal_data name=personal_data>
                <?php


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
                if (!empty($_POST['nome'] || $_POST['cognome'] || $_POST['indirizzo'] || $_POST['cap'] || $_POST['sesso'] || $_POST['nazionalita'] || $_POST['luogo_nascita'] || $_POST['data_nascita'] || $_POST['numerotel'])) {
                    $nome = $_POST['nome'];
                    $cognome = $_POST['cognome'];
                    $indirizzo = $_POST['indirizzo'];
                    $cap = $_POST['cap'];
                    $sesso = $_POST['sesso'];
                    $nazionalita = $_POST['nazionalita'];
                    $luogo_nascita = $_POST['luogo_nascita'];
                    $data_nascita = $_POST['data_nascita'];
                    $numerotel = $_POST['numerotel'];
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
                    <h4>Dettagli Personali</h4>
                    <button onclick="abilita_modifica()">Modifica</button>
                </div>

                <form action="private_page.php?card=informazioni_personali" method="post" id="personal_data_form" >
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
                        CAP: <input id="cap" name="cap" type="numeric" disabled value="<?php echo "$cap" ?>">
                    </p>
                    <p>
                        <label for="sesso"></label>
                        Sesso: <input id="sesso" name="sesso" type="text" disabled value="<?php echo "$sesso" ?>">
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
                        Numero di Telefono: <input id="numerotel" name="numerotel" type="text" disabled value="<?php echo "$numerotel" ?>">
                    </p>
                    <p>
                        <button type="submit" id="update_data" name="update_data">Salva le modifiche </button>
                    </p>
                </form>
            </div>

            <div id=prenotazione_personale name="prenotazione_personale">

                <div class="dettagli voli">
                    <a href="private_page.php?card=prenotazioni&prenotazioni=correnti">Prenotazioni</a>
                    <a href="private_page.php?card=prenotazioni&prenotazioni=volipassati">Voli Passati</a>
                    
                </div>
                <div id=prenotazioni name="prenotazioni">
                    <?php
                    $data = date("Y/m/d");
                    $sql_prenotazioni = "SELECT p.username,p.id_volo,p.numero_bagagli,p.prezzo,v.data_volo,v.citta_partenza,v.ora_partenza,v.citta_arrivo,v.ora_arrivo,pd.nome,pd.cognome FROM prenotazioni p  JOIN volo v ON (p.id_volo = v.id_volo) JOIN personaldata pd ON (p.username = pd.username) WHERE p.username=$1 AND data_volo>'$data' ORDER BY data_volo";
                    $prep = pg_prepare($db, "prenotazioni_voli", $sql_prenotazioni);
                    $ret = pg_execute($db, "prenotazioni_voli", array($user));
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

                                    <div id="voli_prenotati">
                                        <div id="container_citta">
                                            <?php echo "<p>Da: $citta_partenza</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_partenza . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Partenza: $ora_partenza</p>" ?>
                                        </div>

                                        <?php echo '<img src="../immagini/aereo.png">' ?>

                                        <div id="container_citta">
                                            <?php echo "<p>A: $citta_arrivo</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_arrivo . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Arrivo: $ora_arrivo</p>" ?>
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
                            echo "voli non trovati";
                        }
                    }

                    ?>




                </div>
                <div id=voli_passati name="voli_passati">
                    <?php
                    //$date = date("Y/m/d");
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

                                    <div id="voli_prenotati">
                                        <div id="container_citta">
                                            <?php echo "<p>Da: $citta_partenza</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_partenza . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Partenza: $ora_partenza</p>" ?>
                                        </div>

                                        <?php echo '<img src="../immagini/aereo.png">' ?>

                                        <div id="container_citta">
                                            <?php echo "<p>A: $citta_arrivo</p>" ?>

                                            <?php echo '<div id=foto_citta>
                                                        <img src="../immagini/' . $citta_arrivo . '.jpg" >
                                                    </div>' ?>
                                            <?php echo "<p>Arrivo: $ora_arrivo</p>" ?>
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
                            echo "Non hai voli passati";
                        }
                    }

                    ?>




                </div>


            </div>
        </div>
    </div>


    </div>

    <?php include './footer.php' ?>
</body>

</html>

<?php

if ($card == "informazioni_personali") {
    echo '<script type="text/javascript">informazioni_personali();</script>';
}

if ($card == "prenotazioni" && $prenotazioni == "correnti") {
    echo '<script type="text/javascript">prenotazioni_correnti();</script>';
}
if ($card == "prenotazioni" && $prenotazioni == "volipassati") {
    echo '<script type="text/javascript">prenotazioni_passate();</script>';
}
