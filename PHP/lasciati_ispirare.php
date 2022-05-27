<?php
require_once "parametri.php";
if (isset($_GET['mare'])) {
    $mare = 'mare';
} else {
    $mare = 'pre_mare';
}

if (isset($_GET['montagna'])) {
    $montagna = 'montagna';
} else {
    $montagna = 'pre_montagna';
}
if (isset($_GET['citta'])) {
    $citta = 'citta';
} else {
    $citta = 'pre_citta';
}
if (isset($_GET['economico'])) {
    $economico = 'economico';
} else {
    $economico = 'pre_economico';
}
if (isset($_GET['tendenza'])) {
    $tendenza = 'tendenza';
} else {
    $tendenza = 'pre_tendenza';
}
if (isset($_GET['cultura'])) {
    $cultura = 'cultura';
} else {
    $cultura = 'pre_cultura';
}
if (isset($_GET['famiglia'])) {
    $famiglia = 'famiglia';
} else {
    $famiglia = 'pre_famiglia';
}
if (isset($_GET['cibo'])) {
    $cibo = 'cibo';
} else {
    $cibo = 'pre_cibo';
}
if (isset($_GET['avventura'])) {
    $avventura = 'avventura';
} else {
    $avventura = 'pre_avventura';
}
if (isset($_GET['romanticismo'])) {
    $romanticismo = 'romanticismo';
} else {
    $romanticismo = 'pre_romanticismo';
}
if (isset($_GET['neve'])) {
    $neve = 'neve';
} else {
    $neve = 'pre_neve';
}
if (isset($_GET['divertimento'])) {
    $divertimento = 'divertimento';
} else {
    $divertimento = 'pre_divertimento';
}
if (isset($_GET['relax'])) {
    $relax = 'relax';
} else {
    $relax = 'pre_relax';
}

$sql = "SELECT nome FROM paese WHERE (paese.tipo=$1 or paese.tipo=$2 or paese.tipo=$3) or (paese.categoria=$4 or paese.categoria=$5 or paese.categoria=$6 or paese.categoria=$7 or paese.categoria=$8 or paese.categoria=$9 or paese.categoria=$10 or paese.categoria=$11)";
$prep = pg_prepare($db, "paesi", $sql);
$ret = pg_execute($db, "paesi", array($mare, $montagna, $citta, $cultura, $famiglia, $cibo, $avventura, $romanticismo, $neve, $divertimento, $relax));
if (!$ret) {
    echo "Errore Query";
    return false;
}

$sql_empty = "SELECT nome FROM paese";
$prep_empty = pg_prepare($db, 'paesi_empty', $sql_empty);
$ret_empty = pg_execute($db, 'paesi_empty', array());
if (!$ret_empty) {
    echo "Errore Query";
    return false;
}

$sql_tendenza = "SELECT citta_arrivo,count(*) as tendenza from volo where (data_volo+ora_partenza)>=(CURRENT_DATE+LOCALTIME(0)) group by citta_arrivo order by tendenza desc";
$prep_tendenza = pg_prepare($db, 'tendenza', $sql_tendenza);
$ret_tendenza = pg_execute($db, 'tendenza', array());
if (!$ret_tendenza) {
    echo "Errore Query";
    return false;
}

$sql_economico = "SELECT distinct(citta_arrivo),(select min(prezzo) from volo v where volo.citta_arrivo = v.citta_arrivo) as prezzo from volo where (data_volo+ora_partenza)>=(CURRENT_DATE+LOCALTIME(0)) order by prezzo";
$prep_economico = pg_prepare($db, 'economico', $sql_economico);
$ret_economico = pg_execute($db, 'economico', array());
if (!$ret_economico) {
    echo "Errore Query";
    return false;
}

$sql_consigliati = "SELECT distinct data_volo,citta_arrivo,(select min(prezzo) from volo v where volo.citta_arrivo = v.citta_arrivo) as prezzo from volo where posti_disponibili > 0 and (data_volo+ora_partenza)>=(CURRENT_DATE+LOCALTIME(0)) and (data_volo+ora_partenza) < ((CURRENT_DATE +'1 DAY'::interval)+LOCALTIME(0)) order by  prezzo";
$prep_consigliati = pg_prepare($db, "consigliati", $sql_consigliati);
$ret_consigliati = pg_execute($db, "consigliati", array());
if (!$ret_consigliati) {
    echo "Errore Query";
    return false;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/inspiration.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <title>Lasciati ispirare</title>
</head>

<body class="body">

    <?php include './header.php' ?>
    <div class="mid-page">
        <div class="head_midpage">
            <img src="../immagini/joshua-earle-ICE__bo2Vws-unsplash.jpg">
        </div>
        <div class="mid_midpage">
            <form class="selection_midpage" action="lasciati_ispirare.php" method="get">
                <h1>scegli le tue preferenze</h1>
                <h4 class="label_midpage">Dacci qualche indicazione e al resto ci pensiamo noi!</h4>
                <h3>
                    <hr class="hr1">Che tipo di viaggio ti piacerebbe intraprendere?
                </h3>
                <div class="label_location">
                    <div class="selection">
                        <input id="checkbox_mare" onChange="this.form.submit()" name="mare" type="checkbox" value="mare">
                        <label for="checkbox_mare"><img onclick="selectionFilter('mare')" id="mare" class="mare" src="../immagini/pre_mare.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>MARE</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_montagna" onChange="this.form.submit()" name="montagna" type="checkbox" value="montagna">
                        <label for="checkbox_montagna"><img onclick="selectionFilter('montagna')" id="montagna" class="montagna" src="../immagini/pre_montagna.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>MONTAGNA</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_citta" onChange="this.form.submit()" name="citta" type="checkbox" value="citta">
                        <label for="checkbox_citta"><img onclick="selectionFilter('citta')" id="citta" class="citta" src="../immagini/pre_citta.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>CITTA</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_economico" onChange="this.form.submit()" name="economico" type="checkbox" value="economico">
                        <label for="checkbox_economico"><img onclick="selectionFilter('economico')" id="economico" class="economico" src="../immagini/pre_economico.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>ECONOMICO</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_tendenza" onChange="this.form.submit()" name="tendenza" type="checkbox" value="tendenza">
                        <label for="checkbox_tendenza"><img onclick="selectionFilter('tendenza')" id="tendenza" class="tendenza" src="../immagini/pre_tendenza.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>TENDENZA</h2>
                        </input>
                    </div>
                </div>
                <h3><br>
                    <hr class="hr2">Cosa ti piacerebbe fare durante il tuo viaggio?
                </h3>
                <div class="label_location">
                    <div class="selection">
                        <input id="checkbox_cultura" onChange="this.form.submit()" name="cultura" type="checkbox" value="cultura">
                        <label for="checkbox_cultura"><img onclick="selectionFilter('cultura')" id="cultura" class="cultura" src="../immagini/pre_cultura.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>CULTURA</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_famiglia" onChange="this.form.submit()" name="famiglia" type="checkbox" value="famiglia">
                        <label for="checkbox_famiglia"><img onclick="selectionFilter('famiglia')" id="famiglia" class="famiglia" src="../immagini/pre_famiglia.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>FAMIGLIA</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_cibo" onChange="this.form.submit()" name="cibo" type="checkbox" value="cibo">
                        <label for="checkbox_cibo"><img onclick="selectionFilter('cibo')" id="cibo" class="cibo" src="../immagini/pre_cibo.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>CIBO</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_avventura" onChange="this.form.submit()" name="avventura" type="checkbox" value="avventura">
                        <label for="checkbox_avventura"><img onclick="selectionFilter('avventura')" id="avventura" class="avventura" src="../immagini/pre_avventura.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>AVVENTURA</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_romanticismo" onChange="this.form.submit()" name="romanticismo" type="checkbox" value="romanticismo">
                        <label for="checkbox_romanticismo"><img onclick="selectionFilter('romanticismo')" id="romanticismo" class="romanticismo" src="../immagini/pre_romanticismo.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>ROMANTICISMO</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_neve" onChange="this.form.submit()" name="neve" type="checkbox" value="neve">
                        <label for="checkbox_neve"><img onclick="selectionFilter('neve')" id="neve" class="neve" src="../immagini/pre_neve.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>NEVE</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_divertimento" onChange="this.form.submit()" name="divertimento" type="checkbox" value="divertimento">
                        <label for="checkbox_divertimento"><img onclick="selectionFilter('divertimento')" id="divertimento" class="divertimento" src="../immagini/pre_divertimento.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>DIVERTIMENTO</h2>
                        </input>
                    </div>
                    <div class="selection">
                        <input id="checkbox_relax" onChange="this.form.submit()" name="relax" type="checkbox" value="relax">
                        <label for="checkbox_relax"><img onclick="selectionFilter('relax')" id="relax" class="relax" src="../immagini/pre_relax.jpg" style="position: relative; width: 70px; height: 70px;"></label>
                        <h2>RELAX</h2>
                        </input>
                    </div>
                </div>
            </form>
            <aside class="aside">
                <h1>Consigliati di oggi</h1>

                <?php
                $i = 0;
                while (($row = pg_fetch_array($ret_consigliati)) && ($i<3)) {
                    $paese_consigliati = $row['citta_arrivo'];
                    $data_consigliata = $row['data_volo'];
                    $i++;
                ?>
                    <div class="asideContent">
                        <?php echo  '<a href="../PHP/flight.php?roundtrip=andata&departure=ovunque&landing=' . $paese_consigliati . '&startDate=' . $data_consigliata . '&filter=economy">' ?>
                        <?php echo '<img src="../immagini/' . $paese_consigliati . '.jpg" style="position:relative; height:110px;border-radius:0.5rem">' ?>
                        </a>
                        <h2 style="margin:0;"><?php echo $paese_consigliati ?></h2>
                    </div>
                <?php } ?>

            </aside>
        </div>

        <div class="footer_midpage">
            <?php
            if (!$_GET || (!empty($_GET['error']))) {
                while ($row = pg_fetch_array($ret_empty)) {
                    $paese_empty = $row['nome'];
            ?>
                    <div>
                        <?php echo  '<a href="../PHP/flight.php?roundtrip=andata&departure=ovunque&landing=' . $paese_empty . '&startDate=qualsiasi&filter=standard">' ?>
                        <?php echo '<img src="../immagini/' . $paese_empty . '.jpg">' ?>
                        </a>
                        <h1><?php echo $paese_empty ?></h1>
                    </div>
            <?php }
            } ?>

            <?php
            if ($tendenza == 'tendenza') {
                for ($i = 0; $i < 9; $i++) {
                    $row = pg_fetch_array($ret_tendenza);
                    $paese_tendenza = $row['citta_arrivo'];
            ?>
                    <div>
                        <?php echo  '<a href="../PHP/flight.php?roundtrip=andata&departure=ovunque&landing=' . $paese_tendenza . '&startDate=qualsiasi&filter=standard">' ?>
                        <?php echo '<img src="../immagini/' . $paese_tendenza . '.jpg">' ?>
                        </a>
                        <h1><?php echo $paese_tendenza ?></h1>
                    </div>
            <?php }
            } ?>

            <?php
            if ($economico == 'economico') {
                for ($i = 0; $i < 9; $i++) {
                    $row = pg_fetch_array($ret_economico);
                    $paese_economico = $row['citta_arrivo'];
            ?>
                    <div>
                        <?php echo  '<a href="../PHP/flight.php?roundtrip=andata&departure=ovunque&landing=' . $paese_economico . '&startDate=qualsiasi&filter=standard">' ?>
                        <?php echo '<img src="../immagini/' . $paese_economico . '.jpg">' ?>
                        </a>
                        <h1><?php echo $paese_economico ?></h1>
                    </div>
            <?php }
            } ?>

            <?php
            while ($row = pg_fetch_array($ret)) {
                $paese = $row['nome'];
            ?>
                <div>
                    <?php echo  '<a href="../PHP/flight.php?roundtrip=andata&departure=ovunque&landing=' . $paese . '&startDate=qualsiasi&filter=standard">' ?>
                    <?php echo '<img src="../immagini/' . $paese . '.jpg">' ?>
                    </a>
                    <h1><?php echo $paese ?></h1>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php include '../HTML/footer.html' ?>
    <script src="../JS/inspire.js"></script>
</body>

</html>