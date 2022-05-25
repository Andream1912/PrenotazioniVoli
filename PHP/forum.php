<!DOCTYPE html>
<?php
require_once "parametri.php";
?>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/forum.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <script src="https://kit.fontawesome.com/d9cb1c2f34.js" crossorigin="anonymous"></script>
    <script src="../JS/forum.js" defer></script>
    <title>Forum Assistenza</title>
</head>

<body class="body">
    <!--Inserisco l'header-->
    <div class="header">
        <?php include 'header.php' ?>
    </div>
    <div class="mid-page">
        <!--Definisco l'overlay per la creazione della discussione-->
        <div class="discussion-creator hide" discussionCreator>
            <div class="creator-container-exitButton">
                <button class="creator-exitButton" exitButton><i class="fa-solid fa-xmark"></i></button>
            </div>
            <!--Form per la creazione della discussione con funzione js per la validazione-->
            <form action="create-discussion.php" method="GET" class="creator-form" onsubmit="return validateCreateDiscussion()">
                <div class="creator-title">
                    <h1>Inserire il titolo della discussione</h1>
                    <input type="text" name="discussionTitle" class="creator-discussionTitle" placeholder="Inserisci il titolo..." discussionTitle>
                </div>
                <div class="creator-text">
                    <h1>Descrivi il problema</h1>
                    <textarea name="discussionText" class="creator-discussionText" placeholder="Descrivi il problema..." discussionText></textarea>
                </div>
                <div class="creator-container-submit">
                    <input type="submit" name="creatorSubmit" class="creator-submit" value="Crea discussione">
                </div>
            </form>
        </div>
        <div class="visible" visibleContainer>
            <!--Contenitore superiore della pagina contenente searchbar immmagine e bottone-->
            <div class="top">
                <div class="searchImage"><img src="../immagini/sfondo-barraricerca.jpg"></div>
                <div class="imageText">
                    <h1>Come possiamo aiutarti?</h1>
                </div>
                <?php
                if (!empty($_SESSION['username'])) {
                    echo '<button class="create-button" createButton>Crea discussione</button>';
                } else {
                    echo '<button class="create-button" onclick="openLogin()">Per creare una discussione<br>accedi</button>';
                }
                ?>
                <div class="search">
                    <a href="../PHP/forum.php"><button class="exitSearchButton hide" exitSearchButton><i class="fa-solid fa-xmark"></i></button></a>
                    <form action="forum.php" method="GET" class="searchForm">
                        <div><input type="text" name="search" class="searchText" placeholder="Cosa cerci?" value="<?php if (isset($_GET['search'])) {
                                                                                                                        echo $_GET['search'];
                                                                                                                    } ?>"></div>
                        <button type="submit" class="searchButton" searchButton><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            <!--div contenente le il corpo della pagina-->
            <div class="main">
                <!--query per ottenere le  discussioni, avendo in cima la più aggiornata-->
                <?php
                $result = pg_query($db, "SELECT * FROM discussioni ORDER BY data_creazione DESC");
                if (!$result) {
                    echo "Errore nel caricamento delle discussioni";
                    exit;
                }
                /*Gestisco la barra di ricerca con un get*/
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                } else {
                    $search = '';
                }
                $i = 0;
                ?>
                <!--Contenitore di tutte le discussioni-->
                <div class="discussionContainer">
                    <!--Tramite un while prendo ogni discussione nella tabella e la riporto con codice html-->
                    <?php while ($arr = pg_fetch_array($result)) {
                        if (strstr($arr['titolo'], $search)) {
                            $i = $i + 1 ?>
                            <form method="GET" action="discussione.php" class="subDiscussion" onclick="this.submit()" target="_self">
                                <label>
                                    <div class="subDiscussionRow">
                                        <input type="hidden" name="id" value="<?php echo $arr['id'] ?>">
                                        <div class="subDiscussionDescription">
                                            <h1><?php echo $arr['titolo']; ?></h1>
                                            <p> <?php echo $arr['descrizione']; ?></p>
                                            <div class="subDiscussionInfo">
                                                <b>Postato da <?php echo $arr['creatore']; ?></b>
                                                <br>
                                                Il <small><?php echo $arr['data_creazione']; ?></small>
                                                <br>
                                                Ultima modifica: <small><?php echo $arr['data_modifica']; ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </form>
                    <?php
                        }
                    }
                    /*Scritta in caso di nessuna discussione trovata*/
                    if ($i == 0) {
                        echo "<h1 class='noDescriptionFound'>Nessuna discussione trovata</h1>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--includo il footer-->
    <?php include("../HTML/footer.html"); ?>
</body>

</html>