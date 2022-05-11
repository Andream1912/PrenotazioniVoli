<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="../CSS/homepage.css">
    <title>HomePage</title>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="mid-page">
        <video loop muted autoplay class="fullscreen">
                <source src="../video/sea.mp4" type="video/mp4">  
        </video>
        <form action="" class="search-bar">
            <div class="container-search-bar">
                <label for="">Da</label>
                <input type="text" placeholder="Paese,citt&agrave o aereoporto" />
            </div>
            <div class="container-search-bar">
                <label for="">A</label>
                <input type="text" placeholder="Paese,citt&agrave o aereoporto" />
            </div>
            <div class="container-search-bar">
                <label for="">Partenza</label>
                <input type="date" id="startDate" />
            </div>
            <div class="container-search-bar">
                <label for="">Ritorno</label>
                <input type="date" id="endDate" />
            </div>
            <button>Cerca voli</button>
        </form>
    </div>
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