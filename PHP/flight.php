<?php
require_once "parametri.php";
require_once "transform_date.php";
$user = $_SESSION['username'];
if ((isset($_GET['departure'])) && (!empty($_GET['departure']))) {
    $from = $_GET['departure'];
} else {
    $from = "";
    header("Location:../PHP/homepage.php");
}
if ((isset($_GET['landing'])) && (!empty($_GET['landing']))) {
    $to = $_GET['landing'];
} else {
    $to = "";
    header("Location:../PHP/homepage.php");
}
if ((isset($_GET['startDate'])) && (!empty($_GET['startDate']))) {
    $data = $_GET['startDate'];
    $date = strtotime($_GET['startDate']);
    $day = date('d', $date);
    $month = date('m', $date);
    $year = date('Y', $date);
} else {
    $date = "";
    header("Location:../PHP/homepage.php");
}
if (($_GET['roundtrip']) == 'andata') {
    $roundtrip = $_GET['roundtrip'];
    $sql = "SELECT * FROM volo where città_partenza = $1 and città_arrivo = $2 and data_volo = $3";
    $prep = pg_prepare($db, "searchFlight", $sql);
    $ret = pg_execute($db, "searchFlight", array($from, $to, $data));
    if (!$ret) {
        echo "Errore Query";
        return false;
    }
} else {
    $roundtrip = $_GET['roundtrip'];
    $sql = "SELECT * FROM volo where città_partenza = $1 and città_arrivo = $2 and data_volo = $3";
    $prep = pg_prepare($db, "searchFlight", $sql);
    $ret = pg_execute($db, "searchFlight", array($from, $to, $data));

    if (!$ret) {
        echo "Errore Query";
        return false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Voli</title>
    <link rel="stylesheet" href="../CSS/flight.css">
    <link rel="stylesheet" href="../CSS/ritorno.css">
</head>

<body>

    <?php include 'header.php' ?>
    <br><br><br><br><br><br>
    <form action="flight.php" method="get" class="search-bar">
        <div class="roundtrip-inside">
            <input type="radio" name="roundtrip" value="ritorno" onclick="enableDate()" <?php if ($roundtrip == 'ritorno') { ?>checked<?php } ?>><label for="ritorno">Andate e Ritorno</label>
            <input type="radio" name="roundtrip" value="andata" onclick="disableDate()" <?php if ($roundtrip == 'andata') { ?>checked<?php } ?>><label for="andata"> Solo Andata</label>
        </div>
        <div class="top-bar">
            <input type="text" value=<?php echo $_GET['departure'] ?> name="departure">
            <input type="text" value=<?php echo $_GET['landing'] ?> name="landing">
            <img src="../immagini/search.png" class="button-search" onclick="submit()">
        </div>
        <div class="bottom-bar">
            <div class="date">
                <span onclick="previousDay()">&lt</span><input type="date" value=<?php echo $_GET['startDate'] ?> id="startDate" name="startDate" class="start-date"><span onclick="nextDay()">&gt</span>
            </div>
            <div class="date">
                <span>&lt</span><input type="date" value=<?php echo $_GET['endDate'] ?> id="endDate" name="endDate"><span>&gt</span>
            </div>
        </div>
    </form>
    <div class="body">
        <div class="left-page">
            <h1>Prova</h1>
        </div>
        <div class="mid-page">
            <?php
            $noData = pg_result_seek($ret, 0);
            if ($noData) {
                if ($_GET['roundtrip'] == 'andata') {
                    while ($row = pg_fetch_array($ret)) {
                        $ora_partenza = substr($row['ora_partenza'], 0, 5);
                        $ora_arrivo = substr($row['ora_arrivo'], 0, 5);
                        $diff_h = substr($ora_arrivo, 0, 2) - substr($ora_partenza, 0, 2);
                        $diff_m = substr($ora_arrivo, 3, 5) - substr($ora_partenza, 3, 5);
                        $id = $row['id_volo'];
                        $città_partenza = $row['città_partenza'];
                        $città_arrivo = $row['città_arrivo'];
                        $prezzo = $row['prezzo']; ?>
                        <div class="wild-card">
                            <div class="single-flight">
                                <div class="departure">
                                    <p class="time"><?php echo $ora_partenza ?></p>
                                    <p class="city"> <?php echo $città_partenza ?></p>
                                </div>
                                <div class="info-flight">
                                    <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                                    <p>ID:<?php echo $id ?></p>
                                    <img src="../immagini/aereo.png">
                                    <p style="color:lightgreen;margin-top:0;">Diretto</p>
                                </div>
                                <div class="landing">
                                    <p class="time"><?php echo $ora_arrivo ?> </p>
                                    <p class="city"> <?php echo $città_arrivo ?></p>
                                </div>
                            </div>
                            <?php
                            if (!empty($user)) { ?>
                                <div class="flight-price">
                                    <p>€ <?php echo $prezzo; ?></p>
                                    <button class="buy">Seleziona</button>
                                </div>
                            <?php
                            } else { ?>
                                <div class="flight-price">
                                    <p>Vuoi conoscere il prezzo?</p>
                                    <button class="price-registration" onclick="openLogin()">Accedi </button>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php }
                } else {
                    $endDate = $_GET['endDate'];
                    $sql = "SELECT * FROM volo WHERE città_partenza = $1 AND città_arrivo = $2 AND data_volo = $3";
                    $prep_r = pg_prepare($db, "searchFlight", $sql);
                    $ret_r = pg_execute($db, "searchFlight", array($to, $from, $endDate));
                    if (!$ret_r) {
                        return false;
                        // QUERY ERRATA
                    } else {
                    ?>
                        <div class="completo">
                            <?php
                            while ($row = pg_fetch_array($ret)) {
                                $ora_partenza = substr($row['ora_partenza'], 0, 5);
                                $ora_arrivo = substr($row['ora_arrivo'], 0, 5);
                                $diff_h = substr($ora_arrivo, 0, 2) - substr($ora_partenza, 0, 2);
                                $diff_m = substr($ora_arrivo, 3, 5) - substr($ora_partenza, 3, 5);
                                $id = $row['id_volo'];
                                $città_partenza = $row['città_partenza'];
                                $città_arrivo = $row['città_arrivo'];
                                $prezzo = $row['prezzo'];
                                for ($i = 0; pg_result_seek($ret_r, $i); $i++) {
                                    $città_partenza_ritorno = pg_fetch_result($ret_r, $i, 'città_partenza');
                                    $città_arrivo_ritorno = pg_fetch_result($ret_r, $i, 'città_arrivo');
                                    $prezzo_ritorno = pg_fetch_result($ret_r, $i, 'prezzo');
                                    $id_ritorno = pg_fetch_result($ret_r, $i, 'id_volo');
                                    $ora_partenza_ritorno = substr(pg_fetch_result($ret_r, $i, 'ora_partenza'), 0, 5);
                                    $ora_arrivo_ritorno = substr(pg_fetch_result($ret_r, $i, 'ora_arrivo'), 0, 5);
                                    $diff_h_r = substr($ora_arrivo_ritorno, 0, 2) - substr($ora_partenza_ritorno, 0, 2);
                                    $diff_m_r = substr($ora_arrivo_ritorno, 3, 5) - substr($ora_partenza_ritorno, 3, 5);

                            ?>
                                    <div class="full-container">
                                        <div class="ticket">
                                            <div class="single-flight">
                                                <div class="departure">
                                                    <p class="time"><?php echo $ora_partenza ?></p>
                                                    <p class="city"><?php echo $città_partenza ?></p>
                                                </div>
                                                <div class="info-flight">
                                                    <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                                                    <p>ID:<?php echo $id ?> </p>
                                                    <img src="../immagini/aereo.png">
                                                    <p style="color:lightgreen;margin-top:0;">Diretto</p>
                                                </div>
                                                <div class="landing">
                                                    <p class="time"><?php echo $ora_arrivo ?></p>
                                                    <p class="city"><?php echo $città_arrivo ?></p>
                                                </div>
                                            </div>
                                            <div class="single-flight">
                                                <div class="departure">
                                                    <p class="time"><?php echo $ora_partenza_ritorno ?></p>
                                                    <p class="city"><?php echo $città_partenza_ritorno ?></p>
                                                </div>
                                                <div class="info-flight">
                                                    <p><?php echo $diff_h_r; ?>h <?php echo $diff_m_r ?>min</p>
                                                    <p>ID:<?php echo $id_ritorno ?></p>
                                                    <img src="../immagini/aereo.png">
                                                    <p style="color:lightgreen;margin-top:0;">Diretto</p>
                                                </div>
                                                <div class="landing">
                                                    <p class="time"><?php echo $ora_arrivo_ritorno ?> </p>
                                                    <p class="city"> <?php echo $città_arrivo_ritorno ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($user)) { ?>
                                            <div class="price-back">
                                                <p>Prezzo</p>
                                                <p>€<?php echo $prezzo + $prezzo_ritorno ?></p>
                                                <button class="buy">Seleziona</button>
                                            </div>
                                        <?php } else { ?>
                                            <div class="price-back">
                                                <p>Vuoi conoscere</p>
                                                <p>il prezzo?</p>
                                                <button class="price-login" onclick="openLogin()">Accedi</button>
                                            </div>
                                        <?php } ?>
                                    </div>

                        <?php }
                            }
                        } ?>
                        </div>

                    <?php
                }
            } else {
                 ?>
                    <div class="nodata">
                        <p>Voli non trovati</p>
                    </div>
                <?php } ?>
        </div>
    </div>
    <?php include 'footer.php' ?>
    <script>
        function disableDate() {
            document.getElementById("endDate").disabled = true;
            document.getElementById("endDate").value = "";
        }

        function enableDate() {
            document.getElementById("endDate").disabled = false;
        }
    </script>
</body>

</html>i