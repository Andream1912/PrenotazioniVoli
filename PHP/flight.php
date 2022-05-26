<?php
require_once "parametri.php";
require_once "transform_date.php";
$user = $_SESSION['username'];
$type = $_GET['filter']; //Gestisco il tipo in cui saranno ordinati i voli, all'inizio sarà di tipo "standard";
$roundtrip = $_GET['roundtrip'];
if ($type == 'speed') {
    $order = "order by tempo,prezzo";
} else if ($type == 'economy') {
    $order = "order by prezzo";
}
if ((isset($_GET['departure'])) && (!empty($_GET['departure']))) { //CITTA' DI PARTENZA
    $from = strtolower($_GET['departure']);
} else {
    $from = "";
    header("Location:../PHP/homepage.php");
}
if ((isset($_GET['landing'])) && (!empty($_GET['landing']))) { //CITTA' DI ARRIVO
    $to = strtolower($_GET['landing']);
} else {
    $to = "";
    header("Location:../PHP/homepage.php");
}
if ((isset($_GET['startDate']))) {
    if (empty($_GET['startDate'])) {
        $data = 'qualsiasi';
    } //DATA DI PARTENZA
    else if ($_GET['startDate'] == 'qualsiasi') {
        $data = $_GET['startDate'];
    } else {
        $data = $_GET['startDate'];
        $date = strtotime($_GET['startDate']);
        $reverseDate = date("d-m-Y", $date);
        $day = date('d', $date);
        $month = date('m', $date);
        $year = date('Y', $date);
    }
} //SELEZIONATO SOLO ANDATA
if (($data == 'qualsiasi') && ($from == 'ovunque')) {
    $sql = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_arrivo = $1" . $order;
    $prep = pg_prepare($db, "searchFlightEveryWhere", $sql);
    if (!$prep) {
        exit;
        header("Location:../PHP/homepage.php");
    } else {
        $ret = pg_execute($db, "searchFlightEveryWhere", array($to));
        if (!$ret) {
            exit();
            header("Location:../PHP/homepage.php");
        }
    }
} else if ($from == 'ovunque') {
    $sql = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_arrivo = $1 and data_volo = $2" . $order;
    $prep = pg_prepare($db, "searchFlight", $sql);
    if (!$prep) {
        exit;
        header("Location:../PHP/homepage.php");
    } else {
        $ret = pg_execute($db, "searchFlight", array($to, $data));
        if (!$ret) {
            exit();
            header("Location:../PHP/homepage.php");
        }
    }
} else if ($data == 'qualsiasi') { //GESTIONE PER VOLI CONSIGLIATI 
    $sql = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_partenza = $1 and citta_arrivo = $2 order by data_volo";
    $prep = pg_prepare($db, "searchFlight", $sql);
    if (!$prep) {
        exit();
        header("Location:../PHP/homepage.php");
    } else {
        $ret = pg_execute($db, "searchFlight", array($from, $to));
        if (!$ret) {
            exit();
            header("Location:../PHP/homepage.php");
        }
    }
} else {
    $sql = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_partenza = $1 and citta_arrivo = $2 and data_volo = $3 and posti_disponibili > 0" . $order;
    $prep = pg_prepare($db, "searchFlight", $sql);
    if (!$prep) {
        exit;
        header("Location:../PHP/homepage.php");
    } else {
        $ret = pg_execute($db, "searchFlight", array($from, $to, $data));
        if (!$ret) {
            exit();
            header("Location:../PHP/homepage.php");
        }
    }
}
if ($roundtrip == 'ritorno') {
    $endDate = $_GET['endDate'];
    if (($endDate == "qualsiasi") || (empty($endDate))) {
        $sql_r = "SELECT * FROM volo WHERE citta_partenza = $1 AND citta_arrivo = $2 AND data_volo > '$data'";
        $prep_r = pg_prepare($db, "searchFlightBack", $sql_r);
        if (!$prep_r) {
            exit();
            header("Location:../PHP/homepage.php");
        } else {
            $ret_r = pg_execute($db, "searchFlightBack", array($to, $from));
            if (!$ret_r) {
                exit();
                header("Location:../PHP/homepage.php");
            }
        }
    } else {
        $sql_r = "SELECT * FROM volo WHERE citta_partenza = $1 AND citta_arrivo = $2 AND data_volo = $3";
        $prep_r = pg_prepare($db, "searchFlightBackOneDate", $sql_r);
        if (!$prep_r) {
            exit();
            header("Location:../PHP/homepage.php");
        } else {
            $ret_r = pg_execute($db, "searchFlightBackOneDate", array($to, $from, $endDate));
            if (!$ret_r) {
                exit();
                header("Location:../PHP/homepage.php");
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Voli</title>
    <link rel="stylesheet" href="../CSS/flight.css">
    <link rel="stylesheet" href="../CSS/ritorno.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
</head>

<body class="body">
    <?php include 'header.php' ?>
    <br><br><br><br><br><br>
    <div class="mid-page">
        <form action="flight.php" method="get">
            <div class="search-bar">
                <div class="roundtrip-inside">
                    <input type="radio" name="roundtrip" value="ritorno" onclick="enableDate()" <?php if ($roundtrip == 'ritorno') { ?>checked<?php } ?>><label for="ritorno">Andate e Ritorno</label>
                    <input type="radio" name="roundtrip" value="andata" onclick="disableDate()" <?php if ($roundtrip == 'andata') { ?>checked<?php } ?>><label for="andata"> Solo Andata</label>
                </div>
                <div class="top-bar">
                    <input type="text" value=<?php echo ucfirst($from) ?> name="departure">
                    <input type="text" value=<?php echo ucfirst($to) ?> name="landing">
                    <img src="../immagini/search.png" class="button-search" onclick="submit()">
                </div>
                <div class="bottom-bar">
                    <div class="date">
                        <input type="date" value=<?php echo $data ?> id="startDate" name="startDate" class="start-date">
                    </div>
                    <div class="date">
                        <input type="date" <?php if ((!empty($endDate) || (!isset($endDate)))) { ?>value=<?php echo $endDate;
                                                                                                        } ?> id="endDate" name="endDate">
                    </div>
                </div>
            </div>

            <?php
            $noData = pg_result_seek($ret, 0);
            if ($noData) {
                if (((isset($user)) && (!empty($user)) && ($endDate != "qualsiasi"))) { ?>
                    <div class="filter">
                        <div class="singleFilter firstFilter">
                            <label>
                                <input type="radio" name="filter" id="filterOne" value="standard" style="display:none" onChange="this.form.submit()">
                                <?php
                                if ($from == 'ovunque') {
                                    $sql_standard = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_arrivo = $1 and data_volo = $2";
                                    $prep_standard = pg_prepare($db, "searchFlightStandard", $sql_standard);
                                    $ret_standard = pg_execute($db, "searchFlightStandard", array($to, $data));
                                    if (!$ret_standard) {
                                        exit;
                                    }
                                } else {
                                    $sql_standard = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_partenza = $1 and citta_arrivo = $2 and data_volo = $3";
                                    $prep_standard = pg_prepare($db, "searchFlightStandard", $sql_standard);
                                    $ret_standard = pg_execute($db, "searchFlightStandard", array($from, $to, $data));
                                    if (!$ret_standard) {
                                        exit;
                                    }
                                }
                                $standard = pg_fetch_array($ret_standard);
                                if (($roundtrip == 'ritorno')) {
                                    if ($endDate == "") {
                                        $prep_standard_back = pg_prepare($db, "searchFlightStandardBack", $sql_r);
                                        $ret_standard_back = pg_execute($db, "searchFlightStandardBack", array($to, $from));
                                        if (!$ret_standard_back) {
                                            exit;
                                        } else {
                                            $standard_back = pg_fetch_array($ret_standard_back);
                                        }
                                    } else {
                                        $prep_standard_back = pg_prepare($db, "searchFlightStandardBack", $sql_r);
                                        $ret_standard_back = pg_execute($db, "searchFlightStandardBack", array($to, $from, $endDate));
                                        if (!$ret_standard_back) {
                                            exit;
                                        } else {
                                            $standard_back = pg_fetch_array($ret_standard_back);
                                        }
                                    }
                                }
                                ?>
                                <p>Standard</p>
                                <p>€ <?php echo number_format($standard['prezzo'] + $standard_back['prezzo'], 2) ?></p>
                                <p><?php echo substr($standard['tempo'], 0, 2) . "h " . substr($standard['tempo'], 3, 2) . "m (media)" ?></p>
                            </label>
                        </div>
                        <div class="singleFilter secondFilter">
                            <label>
                                <input type="radio" name="filter" id="filterTwo" value="speed" style="display:none" onChange="this.form.submit()">
                                <?php
                                if ($from == 'ovunque') {
                                    $sql_speed = "SELECT prezzo,id_volo,(ora_arrivo-ora_partenza) AS best FROM volo WHERE citta_arrivo=$1 and data_volo=$2 and (ora_arrivo-ora_partenza) = (SELECT min(ora_arrivo-ora_partenza) from volo where citta_arrivo=$1 and data_volo=$2) order by prezzo";
                                    $prep_speed = pg_prepare($db, "searchFlightSpeed", $sql_speed);
                                    $ret_speed = pg_execute($db, "searchFlightSpeed", array($to, $data));
                                    if (!$ret_speed) {
                                        exit;
                                    } else {
                                        $second_filter = pg_fetch_array($ret_speed);
                                        $best = $second_filter['best'];
                                        $price = $second_filter['prezzo'];
                                    }
                                } else {
                                    $sql_speed = "SELECT prezzo,id_volo,(ora_arrivo-ora_partenza) AS best FROM volo WHERE citta_partenza = $1 and citta_arrivo=$2 and data_volo=$3 and (ora_arrivo-ora_partenza) = (SELECT min(ora_arrivo-ora_partenza) from volo where citta_partenza=$1 and citta_arrivo=$2 and data_volo=$3) order by prezzo";
                                    $prep_speed = pg_prepare($db, "searchFlightSpeed", $sql_speed);
                                    $ret_speed = pg_execute($db, "searchFlightSpeed", array($from, $to, $data));
                                    if (!$ret_speed) {
                                        exit;
                                    } else {
                                        $second_filter = pg_fetch_array($ret_speed);
                                        $best = $second_filter['best'];
                                        $price = $second_filter['prezzo'];
                                    }
                                }
                                if (($roundtrip == 'ritorno')) {
                                    if ($endDate == "") {
                                        $sql_r_speed = "SELECT *,(ora_arrivo - ora_partenza) as interval FROM volo WHERE citta_partenza = $1 AND citta_arrivo = $2 AND data_volo > '$data' order by prezzo,interval";
                                        $prep_speed_b = pg_prepare($db, "searchRoundTripSpeed", $sql_r_speed);
                                        $ret_speed_b = pg_execute($db, "searchRoundTripSpeed", array($to, $from));
                                        if (!$ret_speed_b) {
                                            exit;
                                        } else {
                                            $second_filter_back = pg_fetch_array($ret_speed_b);
                                            $priceback = $second_filter_back['prezzo'];
                                        }
                                    } else {
                                        $prep_speed_b = pg_prepare($db, "searchRoundTripSpeed", $sql_speed);
                                        $ret_speed_b = pg_execute($db, "searchRoundTripSpeed", array($to, $from, $endDate));
                                        if (!$ret_speed_b) {
                                            echo "Errore Query";
                                            exit;
                                        } else {
                                            $second_filter_back = pg_fetch_array($ret_speed_b);
                                            $priceback = $second_filter_back['prezzo'];
                                            $bestBack = $second_filter_back['best'];
                                        }
                                    }
                                }
                                ?>
                                <p>Il pi&ugrave; veloce</p>
                                <p><?php echo "€ " . number_format($price + $priceback, 2) ?> </p>
                                <p><?php echo substr($best, 0, 2) . "h " . substr($best, 3, 2) . "m(media)" ?> </p>
                            </label>
                        </div>

                        <div class="singleFilter thirdFilter">
                            <label>
                                <input type="radio" name="filter" value="economy" id="filterThree" style="display:none" onChange="this.form.submit()">
                                <?php
                                if ($from == 'ovunque') {
                                    $sql_economy = "SELECT min(prezzo) as price,(ora_arrivo-ora_partenza) AS interval from volo where citta_arrivo = $1 and data_volo=$2 group by interval";
                                    $prep_economy = pg_prepare($db, "searchFlightEconomy", $sql_economy);
                                    $ret_economy = pg_execute($db, "searchFlightEconomy", array($to, $data));
                                    if (!$ret_economy) {
                                        echo "Errore Query";
                                        return false;
                                    } else {
                                        $third_filter = pg_fetch_array($ret_economy);
                                        $price = $third_filter['price'];
                                    }
                                } else {
                                    $sql_economy = "SELECT *,-(ora_partenza-ora_arrivo) as tempo FROM volo where citta_partenza = $1 and citta_arrivo = $2 and data_volo = $3 order by prezzo";
                                    $prep_economy = pg_prepare($db, "searchFlightEconomy", $sql_economy);
                                    $ret_economy = pg_execute($db, "searchFlightEconomy", array($from, $to, $data));
                                    if (!$ret_economy) {
                                        echo "Errore Query";
                                        return false;
                                    } else {
                                        $third_filter = pg_fetch_array($ret_economy);
                                        $interval = $third_filter['tempo'];
                                        $price = $third_filter['prezzo'];
                                    }
                                }
                                if (($roundtrip == 'ritorno')) {
                                    if ($endDate == "") {
                                        $sql_r_economy = "SELECT min(prezzo),(ora_arrivo-ora_partenza) AS interval from volo where citta_partenza = $1 and citta_arrivo = $2 and data_volo = '2022-06-10' group by interval";
                                        $prep_economy_b = pg_prepare($db, "searchRoundTripEconomy", $sql_r_economy);
                                        if (!$pre_economy_b) {
                                        } else {
                                            $ret_economy_b = pg_execute($db, "searchRoundTripEconomy", array($to, $from));
                                            if (!$ret_economy_b) {
                                                exit;
                                            } else {
                                                $third_filter_back = pg_fetch_array($ret_economy_b);
                                                $priceback = $third_filter_back['min'];
                                            }
                                        }
                                    } else {
                                        $prep_economy_b = pg_prepare($db, "searchRoundTripEconomy", $sql_economy);
                                        $ret_economy_b = pg_execute($db, "searchRoundTripEconomy", array($to, $from, $endDate));
                                        if (!$ret_speed_b) {
                                            echo "Errore Query";
                                            exit;
                                        } else {
                                            $second_filter_back = pg_fetch_array($ret_economy_b);
                                            $priceback = $second_filter_back['min'];
                                        }
                                    }
                                } ?>
                                <p>Il pi&ugrave; economico</p>
                                <p> € <?php echo number_format($price + $priceback, 2) ?></p>
                                <p><?php echo substr($interval, 0, 2) . "h " . substr($interval, 3, 2) . "m" ?></p>
                            </label>
                        </div>
                    </div>
                <?php } ?>
        </form>

        <div class="midpage">
            <?php
                if ($roundtrip == 'andata') {
                    while ($row = pg_fetch_array($ret)) {
                        $ora_partenza = substr($row['ora_partenza'], 0, 5);
                        $ora_arrivo = substr($row['ora_arrivo'], 0, 5);
                        $tempo = substr($row['tempo'], 0, 5);
                        $data_singola = $row['data_volo'];
                        $reverse_data_singola = date("d-m-Y", strtotime($data_singola));
                        $diff_h = substr($tempo, 0, 2);
                        $diff_m = substr($tempo, 3, 5);
                        $id = $row['id_volo'];
                        $citta_partenza = $row['citta_partenza'];
                        $citta_arrivo = $row['citta_arrivo'];
                        $prezzo = $row['prezzo']; ?>
                    <div class="wild-card">
                        <div class="single-flight">
                            <div class="departure">
                                <p class="time"><?php echo $ora_partenza ?></p>
                                <p class="city"> <?php echo ucfirst($citta_partenza) ?></p>
                            </div>
                            <div class="info-flight">
                                <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                                <p>ID:<?php echo $id ?></p>
                                <img src="../immagini/aereo.png">
                                <p style="color:lightgreen;margin-top:0;">Diretto</p>
                                <p><?php echo $reverse_data_singola ?></p>
                            </div>
                            <div class="landing">
                                <p class="time"><?php echo $ora_arrivo ?> </p>
                                <p class="city"> <?php echo ucfirst($citta_arrivo) ?></p>
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
                    $noData = pg_result_seek($ret, 0);
                    $noDataBack = pg_result_seek($ret_r, 0);
                    if ($noData || $noDataBack || $from != 'ovunque') {
                ?>
                    <div class="completo">
                        <?php
                        while ($row = pg_fetch_array($ret)) {
                            $ora_partenza = substr($row['ora_partenza'], 0, 5);
                            $ora_arrivo = substr($row['ora_arrivo'], 0, 5);
                            $diff_h = substr($ora_arrivo, 0, 2) - substr($ora_partenza, 0, 2);
                            $diff_m = substr($ora_arrivo, 3, 5) - substr($ora_partenza, 3, 5);
                            $id = $row['id_volo'];
                            $data_andata = $row['data_volo'];
                            $reverse_data_andata = date("d-m-Y", strtotime($data_andata));
                            $citta_partenza = $row['citta_partenza'];
                            $citta_arrivo = $row['citta_arrivo'];
                            $prezzo = $row['prezzo'];
                            for ($i = 0; pg_result_seek($ret_r, $i); $i++) {
                                $citta_partenza_ritorno = pg_fetch_result($ret_r, $i, 'citta_partenza');
                                $citta_arrivo_ritorno = pg_fetch_result($ret_r, $i, 'citta_arrivo');
                                $data_ritorno = pg_fetch_result($ret_r, $i, 'data_volo');
                                $reverse_data_ritorno = date("d-m-Y", strtotime($data_ritorno));
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
                                                <p class="city"><?php echo ucfirst($citta_partenza) ?></p>
                                            </div>
                                            <div class="info-flight">
                                                <p><?php echo $diff_h; ?>h <?php echo $diff_m ?>min</p>
                                                <p>ID:<?php echo $id ?> </p>
                                                <img src="../immagini/aereo.png">
                                                <p style="color:lightgreen;margin-top:0;">Diretto</p>
                                                <p><?php echo $reverse_data_andata ?></p>
                                            </div>
                                            <div class="landing">
                                                <p class="time"><?php echo $ora_arrivo ?></p>
                                                <p class="city"><?php echo ucfirst($citta_arrivo) ?></p>
                                            </div>
                                        </div>
                                        <div class="single-flight">
                                            <div class="departure">
                                                <p class="time"><?php echo $ora_partenza_ritorno ?></p>
                                                <p class="city"><?php echo ucfirst($citta_partenza_ritorno) ?></p>
                                            </div>
                                            <div class="info-flight">
                                                <p><?php echo $diff_h_r; ?>h <?php echo $diff_m_r ?>min</p>
                                                <p>ID:<?php echo $id_ritorno ?></p>
                                                <img src="../immagini/aereo.png">
                                                <p style="color:lightgreen;margin-top:0;">Diretto</p>
                                                <p><?php echo $reverse_data_ritorno ?></p>
                                            </div>
                                            <div class="landing">
                                                <p class="time"><?php echo $ora_arrivo_ritorno ?> </p>
                                                <p class="city"> <?php echo ucfirst($citta_arrivo_ritorno) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($user)) { ?>
                                        <div class="price-back">
                                            <p>Prezzo</p>
                                            <p>€<?php echo number_format($prezzo + $prezzo_ritorno, 2) ?></p>
                                            <?php echo '<a class="buy" href="check-flight.php?id=' . $id . '&id_ritorno=' . $id_ritorno . '">Seleziona</a>' ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="price-back" style="height:280px;">
                                            <p>Vuoi conoscere</p>
                                            <p>il prezzo?</p>
                                            <a class="buy-login" onclick="openLogin()">Accedi</a>
                                        </div>
                                    <?php } ?>
                                </div>

                    <?php

                            }
                        }
                    } ?>
                    </div>

                <?php
                }
            } else {
                ?>
                <div class="nodata">
                    <img src="../immagini/nodata.png" alt="">
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include '../HTML/footer.html' ?>

    <script src='../JS/flight.js' defer>

    </script>
</body>

</html>