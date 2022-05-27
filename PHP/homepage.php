<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="../CSS/homepage.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <title>HomePage</title>
</head>

<body class="body">
    <?php include './header.php' ?>
    <div class="mid-page">
        <video loop muted autoplay class="fullscreen">
            <source src="../video/sea.mp4" type="video/mp4">
        </video>
        <form action="flight.php" method="get" class="search-bar" onsubmit="return checkInput()">
            <div class="top-bar" style="display:flex;flex-direction:row">
                <div class="roundtrip"><input type="radio" name="roundtrip" value="ritorno" onclick="enableDate()"><label for="ritorno">Andata e Ritorno</label></div>
                <div class="gone"><input type="radio" name="roundtrip" value="andata" checked onclick="disableDate()"><label for="andata">Solo Andata</label></div>
            </div>
            <div class="bot-bar" style="display:flex;flex-direction:row">
                <div class="container-search-bar">
                    <label for="">Da</label>
                    <input type="text" placeholder="Paese,citt&agrave o aereoporto" name="departure" id="departure" />
                </div>
                <div class="container-search-bar">
                    <img src="../immagini/switch.png" class="switch" onclick="switchCity()">
                </div>
                <div class="container-search-bar">
                    <label for="">A</label>
                    <input type="text" placeholder="Paese,citt&agrave o aereoporto" name="landing" id="landing" />
                </div>
                <div class="container-search-bar">
                    <label for="">Partenza</label>
                    <input type="date" id="startDate" name="startDate" />
                </div>
                <div class="container-search-bar date">
                    <label for="">Ritorno</label>
                    <input type="date" id="endDate" name="endDate" />
                </div>
                <input type="hidden" name="filter" value="standard">
                <button>Cerca voli</button>
            </div>
        </form>
        <div class="cards">
            <div class="inspiration-card">
                <h1>Indeciso sul dove andare?</h1>
                <a href="../PHP/lasciati_ispirare.php">
                    <button>LASCIATI ISPIRARE</button>
                </a>
                <img src="../immagini/wide-angle-landscape-photography-tips-thumbnail.jpg">
            </div>
        </div>
        <div class="carta-container">
            <div class="first-card">
                <h1>Esplora il mondo,</h1>
                <h2 dir="rtl">!sentiti libero</h2>
                <a href="../PHP/lasciati_ispirare.php?montagna=montagna&avventura=avventura">
                    <button class="bottone-foto">SONO IO</button>
                </a>
                <img src="../immagini/uomocappello.jpg">
            </div>
            <div class="second-card">
                <h1 style="margin-left:-140px">Immergiti nella Natura,</h1>
                <h2 style="margin-left:100px">godititi la tua vacanza!</h2>
                <a href="../PHP/lasciati_ispirare.php?relax=relax">
                    <button class="bottone-foto2">SONO IO</button>
                </a>
                <img src="../immagini/nature.jpg">
            </div>
        </div>
        <br><br><br>
        <div class="third-card">
            <h1>Immergiti in un avventura <br> unica!</h1>
            <a href="../PHP/lasciati_ispirare.php?avventura=avventura&divertimento=divertimento">
                <button >SONO IO</button>
            </a>
            <img src="../immagini/quad.jpg">
        </div>
    </div>
    <?php include '../HTML/footer.html' ?>

    <script src="../JS/homepage.js"></script>
</body>

</html>