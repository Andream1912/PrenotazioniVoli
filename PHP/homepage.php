<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="../CSS/homepage.css">
    <title>HomePage</title>
</head>

<body class="body">
    <?php include './header.php' ?>
    <div class="mid-page">
        <video loop muted autoplay class="fullscreen">
                <source src="../video/sea.mp4" type="video/mp4">  
        </video>
        <form action="flight.php" method="get" class="search-bar">
            <div class="container-search-bar">
                <label for="">Da</label>
                <input type="text" placeholder="Paese,citt&agrave o aereoporto" name="departure" id="departure"/>
            </div>
            <div class="container-search-bar">
                <label for="">A</label>
                <input type="text" placeholder="Paese,citt&agrave o aereoporto" name="landing" id="landing"/>
            </div>
            <div class="container-search-bar">
                <label for="">Partenza</label>
                <input type="date" id="startDate" name="startDate"/>
            </div>
            <div class="container-search-bar">
                <label for="">Ritorno</label>
                <input type="date" id="endDate" />
            </div>
            <button>Cerca voli</button>
        </form>
    </div>
    <div class="cards">
        <div class="carta-container">
            <div class="first-card">
                <h1>Esplora il mondo,</h1>
                <h2 dir="rtl">sentiti libero</h2>
                <button class="bottone-foto">sono io</button>
                <img src="../immagini/uomocappello.jpg">
            </div>
            <div class="second-card">
                <h1>Cultura, bellezza,</h1>
                <h2 dir="rtl">felicità</h2>
                <button class="bottone-foto">pietro</button>
                <img src="../immagini/nature.jpg">
            </div>
        </div>
        <br><br><br>
        <div class="third-card">
            <h1>Immergiti in un avventura unica</h1>
            <button>Esperienze</button>
            <img src="../immagini/quad.jpg" alt="">
        </div>
    </div>
    <?php include 'footer.php' ?>
    <script>
        var data = new Date();
        var month = data.getMonth();
        var day = data.getDate();
        if (data.getMonth() < 10) {
            month = "0" + data.getMonth();
        }
        if (data.getDate() < 10) {
            day = "0" + data.getDate()
        }
        var string = data.getFullYear() + "-" + month + "-" + day;
        document.getElementById("startDate").value = string;
    </script>
</body>

</html>