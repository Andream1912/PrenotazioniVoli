<?php
require_once "parametri.php";
require_once "transform_date.php";
$user = $_SESSION['username'];
$type = $_GET['filter'];
if ($type == 'speed') {
    $order = "order by tempo,prezzo";
} else if ($type == 'economy') {
    $order = "order by prezzo";
}
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
    $sql = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where città_partenza = $1 and città_arrivo = $2 and data_volo = $3" . $order;
    $prep = pg_prepare($db, "searchFlight", $sql);
    $ret = pg_execute($db, "searchFlight", array($from, $to, $data));
    if (!$ret) {
        exit;
    }
} else {
    $roundtrip = $_GET['roundtrip'];
    $endDate = $_GET['endDate'];
    $sql = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where città_partenza = $1 and città_arrivo = $2 and data_volo = $3" . $order;
    $prep = pg_prepare($db, "searchFlight", $sql);
    $ret = pg_execute($db, "searchFlight", array($from, $to, $data));

    if (!$ret) {
        exit;
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
    <form action="flight.php" method="get">
        <div class="search-bar">
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
                    <input type="date" value=<?php echo $_GET['startDate'] ?> id="startDate" name="startDate" class="start-date">
                </div>
                <div class="date">
                    <input type="date" <?php if ((!empty($endDate) || (!isset($endDate)))) { ?>value=<?php echo $endDate;
                                                                                                    } ?> id="endDate" name="endDate">
                </div>
            </div>
        </div>
        <?php if ((isset($user)) && (!empty($user))) { ?>
            <div class="filter">
                <div class="singleFilter firstFilter">
                    <label>
                        <input type="radio" name="filter" id="filterOne" value="standard" style="display:none" onChange="this.form.submit()">
                        <?php
                        $sql_standard = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where città_partenza = $1 and città_arrivo = $2 and data_volo = $3";
                        $prep_standard = pg_prepare($db, "searchFlightStandard", $sql_standard);
                        $ret_standard = pg_execute($db, "searchFlightStandard", array($from, $to, $data));
                        if (!$ret_standard) {
                            exit;
                        }
                        $standard = pg_fetch_array($ret_standard);
                        if ($roundtrip == 'ritorno') {
                            $prep_standard_back = pg_prepare($db, "searchFlightStandard", $sql_standard);
                            $ret_standard_back = pg_execute($db, "searchFlightStandard", array($to, $from, $endDate));
                            if (!$ret_standard_back) {
                                exit;
                            }else{
                               $standard_back = pg_fetch_array($ret_standard_back); 
                            }
                        }
                        ?>
                        <p>Standard</p>
                        <p>€ <?php echo number_format($standard['prezzo'] + $standard_back['prezzo'],2) ?></p>
                        <p><?php echo substr($standard['tempo'], 0, 2) . "h " . substr($standard['tempo'], 3, 2) . "m (media)" ?></p>
                    </label>
                </div>
                <div class="singleFilter secondFilter">
                    <label>
                        <input type="radio" name="filter" id="filterTwo" value="speed" style="display:none" onChange="this.form.submit()">
                        <?php
                        $sql_speed = "SELECT prezzo,id_volo,(ora_arrivo-ora_partenza) AS best FROM volo WHERE città_partenza = $1 and città_arrivo=$2 and data_volo=$3 and (ora_arrivo-ora_partenza) = (SELECT min(ora_arrivo-ora_partenza) from volo where città_partenza=$1 and città_arrivo=$2 and data_volo=$3) order by prezzo";
                        $prep_speed = pg_prepare($db, "searchFlightSpeed", $sql_speed);
                        $ret_speed = pg_execute($db, "searchFlightSpeed", array($from, $to, $data));
                        if (!$ret_speed) {
                            exit;
                        } else {
                            $second_filter = pg_fetch_array($ret_speed);
                            $best = $second_filter['best'];
                            $price = $second_filter['prezzo'];
                        }
                        if (($roundtrip == 'ritorno') && (!empty($endDate))) {
                            $prep_speed_b = pg_prepare($db, "searchRoundTripSpeed", $sql_speed);
                            $ret_speed_b = pg_execute($db, "searchRoundTripSpeed", array($to, $from, $endDate));
                            if (!$ret_speed_b) {
                                echo "Errore Query";
                                exit;
                            } else {
                                $second_filter_back = pg_fetch_array($ret_speed_b);
                                $priceback = $second_filter_back['prezzo'];
                            }
                        } ?>
                        <p>Il pi&ugrave; veloce</p>
                        <p><?php echo "€ " . number_format($price + $priceback,2) ?> </p>
                        <p><?php echo substr($best, 0, 2) . "h " . substr($best, 3, 2) . "m" ?> </p>
                    </label>
                </div>

                <div class="singleFilter thirdFilter">
                    <label>
                        <input type="radio" name="filter" value="economy" id="filterThree" style="display:none" onChange="this.form.submit()">
                        <?php
                        $sql_economy = "SELECT min(prezzo) as price,(ora_arrivo-ora_partenza) AS interval from volo where città_partenza = $1 and città_arrivo = $2 and data_volo=$3 group by interval";
                        $prep_economy = pg_prepare($db, "searchFlightEconomy", $sql_economy);
                        $ret_economy = pg_execute($db, "searchFlightEconomy", array($from, $to, $data));
                        if (!$ret_economy) {
                            echo "Errore Query";
                            return false;
                        } else {
                            $third_filter = pg_fetch_array($ret_economy);
                            $interval = $third_filter['interval'];
                            $price = $third_filter['price'];
                        }
                        if (($roundtrip == 'ritorno') && (!empty($endDate))) {
                            $prep_speed_b = pg_prepare($db, "searchRoundTripSpeed", $sql_speed);
                            $ret_speed_b = pg_execute($db, "searchRoundTripSpeed", array($to, $from, $endDate));
                            if (!$ret_speed_b) {
                                echo "Errore Query";
                                exit;
                            } else {
                                $second_filter_back = pg_fetch_array($ret_speed_b);
                                $priceback = $second_filter_back['prezzo'];
                            }
                        } ?>
                        <p>Il pi&ugrave; economico</p>
                        <p> € <?php echo number_format($price + $priceback,2) ?></p>
                        <p><?php echo substr($interval, 0, 2) . "h " . substr($interval, 3, 2) . "m" ?></p>
                    </label>
                </div>
            </div>
        <?php } ?>
    </form>

    <div class="mid-page">
        <?php
        $noData = pg_result_seek($ret, 0);
        if ($noData) {
            if ($roundtrip == 'andata') {
                while ($row = pg_fetch_array($ret)) {
                    $ora_partenza = substr($row['ora_partenza'], 0, 5);
                    $ora_arrivo = substr($row['ora_arrivo'], 0, 5);
                    $tempo = substr($row['tempo'], 0, 5);
                    $diff_h = substr($tempo, 0, 2);
                    $diff_m = substr($tempo, 3, 5);
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
                                <?php echo '<a class="buy" href="check-flight.php?id=' . $id . '">Seleziona</a>' ?>
                            </div>
                        <?php
                        } else { ?>
                            <div class="flight-price">
                                <p>Vuoi conoscere il prezzo?</p>
                                <a class="price-registration" onclick="openLogin()">Accedi </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php }
            } else {
                $sql = "SELECT * FROM volo WHERE città_partenza = $1 AND città_arrivo = $2 AND data_volo = $3" . $order;
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
                                            <p>€<?php echo number_format($prezzo + $prezzo_ritorno,2) ?></p>
                                            <?php echo '<a class="buy" href="check-flight.php?id=' . $id . '&id_ritorno=' . $id_ritorno . '">Seleziona</a>' ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="price-back">
                                            <p>Vuoi conoscere</p>
                                            <p>il prezzo?</p>
                                            <a class="buy-login" onclick="openLogin()">Accedi</a>
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
        queryString = window.location.search;
        urlparams = new URLSearchParams(queryString);
        filter = urlparams.get("filter");
        if (filter == 'speed') {
            document.querySelector('.secondFilter').style.backgroundColor = "#042759";
            document.querySelector('.secondFilter').style.color = "white";
        }
        else if (filter == 'economy') {
            document.querySelector('.thirdFilter').style.backgroundColor = "#042759";
            document.querySelector('.thirdFilter').style.color = "white";
        }else{
            document.querySelector('.firstFilter').style.backgroundColor = "#042759";
            document.querySelector('.firstFilter').style.color = "white";
        }
        if (!(urlparams.has("endDate"))) {
            console.log(document.getElementsByName("endDate")[0].disabled);
            document.getElementsByName("endDate")[0].disabled = true;
        }


        function disableDate() {
            document.getElementsByName("endDate")[0].disabled = true;
            document.getElementsByName("endDate")[0].value = "";
        }

        function enableDate() {
            document.getElementsByName("endDate")[0].disabled = false;
        }
    </script>
</body>

</html>