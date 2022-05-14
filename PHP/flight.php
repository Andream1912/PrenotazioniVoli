<?php
require_once "parametri.php";
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
    $date = strtotime($_GET['startDate']);
    $day=date('d',$date);
    $month=date('m',$date);
    $year=date('Y',$date);
}else{
    $date = "";
    header("Location:../PHP/homepage.php");
}

$sql = "SELECT * FROM volo where data_volo=$1 and città_partenza = $2 and città_arrivo = $3";
$prep = pg_prepare($db,"searchFlight",$sql);
$ret = pg_execute($db,"searchFlight",array($date,$from,$to));
if(!$ret){
    echo "Errore Query";
    return false;
}else{
    if($row = pg_fetch_array($ret)){
        $città_partenza = $row['città_partenza'];
        $città_arrivo = $row['città_arrivo'];
    }
}
?>
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
                <p class="inizio"><?php echo $day?> Luglio</p> <span onclick="">&gt</span>
            </div>
            <div class="date"><span>&lt</span>
                <p>12 Luglio</p> <span>&gt</span>
            </div>
        </div>
    </form>
    <div class="body">
        <div class="left-page">
            <h1>Ciao</h1>
        </div>
        <div class="mid-page">
            <hr class="hr">
            <div class="wild-card">
                <div class="single-flight">
                    <div class="departure">
                        <p class="time">18:00 </p>
                        <p class="city"> <?php echo $_GET['departure'] ?></p>
                    </div>
                    <div class="info-flight">
                        <p>12h40m</p>
                        <img src="../immagini/aereo.png" alt="">
                        <p style="color:lightgreen;margin-top:0;">Diretto</p>
                    </div>
                    <div class="landing">
                        <p class="time">20:00 </p>
                        <p class="city"> <?php echo $_GET['landing'] ?></p>
                    </div>
                </div>
                <?php
                if (!empty($user)) { ?>
                    <div class="flight-price">
                        <p>12,00€</p>
                    </div>
                <?php
                } else { ?>
                    <div class="flight-price">
                        <p>Vuoi conoscere il prezzo?</p>
                        <button value="REGISTRATI">registrati </button>
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