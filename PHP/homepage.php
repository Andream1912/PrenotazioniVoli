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
            <div class="top-bar" style="display:flex;flex-direction:row">
                <div class="roundtrip"><input type="radio" name="roundtrip" value="ritorno" checked onclick="enableDate()"><label for="ritorno">Andata e Ritorno</label></div>
                <div class="gone"><input type="radio" name="roundtrip" value="andata" onclick="disableDate()"><label for="andata">Solo Andata</label></div>
            </div>
            <div class="bot-bar" style="display:flex;flex-direction:row">
                <div class="container-search-bar">
                    <label for="">Da</label>
                    <input type="text" placeholder="Paese,citt&agrave o aereoporto" name="departure" id="departure" />
                </div>
                <img src="../immagini/switch.png" class="switch" onclick="switchCity()">
                <div class="container-search-bar">
                    <label for="">A</label>
                    <input type="text" placeholder="Paese,citt&agrave o aereoporto" name="landing" id="landing" />
                </div>
                <div class="container-search-bar">
                    <label for="">Partenza</label>
                    <input type="date" id="startDate" name="startDate" />
                </div>
                <div class="container-search-bar">
                    <label for="">Ritorno</label>
                    <input type="date" id="endDate" />
                </div>
                <button>Cerca voli</button>
            </div>
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
        function switchCity(){
            x = document.getElementById("landing").value;
            document.getElementById("landing").value = document.getElementById("departure").value;
            document.getElementById("departure").value = x;
        }
        Date.prototype.addDays = function(days) {
            this.setDate(this.getDate() + parseInt(days));
            return this;
        };

        function disableDate() {
            document.getElementById("endDate").disabled = true;
            document.getElementById("endDate").value = "";
        }

        function enableDate() {
            document.getElementById("endDate").disabled = false;
            document.getElementById("endDate").value = calculateDate(14);
        }

        function calculateDate(x) {
            var date = new Date();
            date.addDays(x)
            var month = date.getMonth();
            var day = date.getDate();
            if (month < 10) {
                month = "0" + date.getMonth();
            }
            if (day < 10) {
                day = "0" + date.getDate();
            }
            return date.getFullYear() + "-" + month + "-" + day;
        }
        document.getElementById("startDate").value = calculateDate(7);
        document.getElementById("endDate").value = calculateDate(14);
    </script>
</body>

</html>