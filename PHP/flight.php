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
    $day=date('d',$date);
    $month=date('m',$date);
    $year=date('Y',$date);
}else{
    $date = "";
    header("Location:../PHP/homepage.php");
}

$sql = "SELECT * FROM volo where città_partenza = $1 and città_arrivo = $2 and data_volo = $3";
$prep = pg_prepare($db,"searchFlight",$sql);
$ret = pg_execute($db,"searchFlight",array($from,$to,$data));
if(!$ret){
    echo "Errore Query";
    return false;
}else{
    if($row = pg_fetch_array($ret)){
        $ora_partenza = substr($row['ora_partenza'],0,5);
        $ora_arrivo = substr($row['ora_arrivo'],0,5);
        $diff_h = substr($ora_arrivo,0,2) - substr($ora_partenza,0,2);
        $diff_m = substr($ora_arrivo,3,5) - substr($ora_partenza,3,5);
        $id = $row['id_volo'];
        $città_partenza = $row['città_partenza'];
        $città_arrivo = $row['città_arrivo'];
        $prezzo = $row['prezzo'];
    }
}
?>
<script>console.log(<?php $object_date1?>)</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Voli</title>
    <link rel="stylesheet" href="../CSS/flight.css">
</head>

<body>

    <?php include 'header.php' ?>
    <br><br><br><br><br><br>
    <form action="" class="search-bar">
        <div class="top-bar">
            <input type="text" placeholder=<?php echo $_GET['departure'] ?>>
            <input type="text" placeholder=<?php echo $_GET['landing'] ?>>
            <img src="../immagini/search.png" class="button-search" onclick="">
        </div>
        <div class="bottom-bar">
            <div class="date"><span onclick="nextDay()">&lt</span>
                <p class="inizio"><?php echo $day?> <?php echo number_to_month($month)?></p> <span onclick="">&gt</span>
            </div>
            <div class="date"><span>&lt</span>
                <p>12 Luglio</p> <span>&gt</span>
            </div>
        </div>
    </form>
    <div class="body">
        <div class="left-page">
            <h1>Dio cane</h1>
        </div>
        <div class="mid-page">
            <hr class="hr">
            <div class="wild-card">
                <div class="single-flight">
                    <div class="departure">
                        <p class="time"><?php echo $ora_partenza?></p>
                        <p class="city"> <?php echo $città_partenza ?></p>
                    </div>
                    <div class="info-flight">
                        <p><?php echo $diff_h;?>h <?php echo $diff_m?>min</p>
                        <p>ID:<?php echo $id?></p>
                        <img src="../immagini/aereo.png" alt="">
                        <p style="color:lightgreen;margin-top:0;">Diretto</p>
                    </div>
                    <div class="landing">
                        <p class="time"><?php echo $ora_arrivo?> </p>
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
                        <button class="price-registration">registrati </button>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
</body>

</html>