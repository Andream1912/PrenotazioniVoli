<!DOCTYPE html>
<?php 
    require_once "parametri.php";
    $var =  $_GET['id'];
    $result = pg_query($db, "SELECT * FROM discussioni WHERE id = $var");
    if(!$result){
        echo "Errore nel caricamento della discussine";
        exit;
    }
    $row=pg_fetch_array($result);
?>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/discussione.css" type="text/css">
    <script type="text/javascript" src="../JS/discussione.js" defer></script>
    <script src="https://kit.fontawesome.com/d9cb1c2f34.js" crossorigin="anonymous"></script>
    <title>Discussione</title>
</head>
<body class="body">
    <!--includo l'header-->
    <div class="header">
        <?php 
            include("header.php");
        ?>
    </div>
    <div class="mid-page">
    <!--creo l'overlay per la creazione di unna  risposta-->
    <div class="respFormContainer hide" respFormContainer>
        <div class="respExitButtonContainer">
            <button class="respExitButton" respExitButton><i class="fa-solid fa-xmark"></i></button>
        </div>
        <!--form per la creazione della risposta-->
        <form action="create-response.php" method="GET" class="create-response-form" onsubmit="return validateResponse()">
            <!--creo un input type hidden per potermi passare l'id della discussione-->
            <input type="hidden" name="code" value="<?php echo $var; ?>">
            <div class="create-response-text">
                <h1>Inserisci la risposta</h1>
                <textarea class="responseText" name="responseText" placeholder="Scrivi la risposta..." maxlength="600" responseText></textarea> 
            </div>
            <div class="respSubmitButtonContainer">
                <button type="submit" class="respSubmitButton" respSubmitButton>Inoltra risposta</button>
            </div>
        </form>
    </div>
    <!--creo l'overlay per la modifica di una discussione-->
    <div class="modifyFormContainer hide" modifyFormContainer>
        <div class="modifyExitButtonContainer">
            <button class="modifyExitButton" onclick="exitModify()" modifyExitButton><i class="fa-solid fa-xmark"></i></button>
        </div>
        <!--form per la modifica della discussione-->
        <form action="modify-discussion.php" method="GET" class="modify-discussion-form" onsubmit="return validateModify()">
            <input type="hidden" name="code" value="<?php echo $var; ?>">
            <div class="modify-discussion-description">
                <h1>Modifica la descrizione</h1>
                <textarea class="descriptionText" name="descriptionText" placeholder="Cambia la descrizione..." maxlength="600" modifyText></textarea>
            </div>
            <div class="modifySubmitButtonContainer">
                <button class="modifySubmitButton" type="submit" modifySubmitButton>Cambia descrizione</button>
            </div>
        </form>
    </div>
    <!--contenitore totale-->
    <div class="cardTot" cardTot>
        <!--contenitore del titolo e dei bottoni-->
        <div class="topCard">
                <?php
                /*verifico l'utente tramite il session e permetto la visualizzazione di diversi bottoni*/
                    if(!empty($_SESSION['username'])){
                        if($_SESSION['username']==$row['creatore']){
                            echo '<button class="modifyButton" modifyButton onclick="modify()">Modifica discussione</button>';
                            echo '<div class="borderButton">
                            <button class="respButton" onclick="respDiscussion()" >Rispondi alla discussione</button>
                            <div class="respButtonIcon"><button class="buttonIcon" onclick="showButton()"><i class="fa-solid fa-plus" icon></i></button></div>
                            </div>';
                        }
                        else{
                            echo '<div class="borderButton">
                            <button class="respButton" onclick="respDiscussion()" >Rispondi alla discussione</button>
                            <div class="respButtonIcon"><button class="buttonIcon" onclick="showButton()"><i class="fa-solid fa-plus" icon></i></button></div>
                            </div>';
                        }
                    }
                    else{
                        echo '<div class="borderButton">
                        <button class="respButton" onclick="openLogin()" enterButton>Accedi per partecipare<br>alla discussione</button>
                        <div class="respButtonIcon"><button class="buttonIcon" onclick="showButton()"><i class="fa-solid fa-plus" icon></i></button></div>
                        </div>';
                    }
                ?>
            <!--titolo della discussione-->
            <div class="cardTit">
                <?php echo $row['titolo']; ?>
            </div>
            <!--contenitore della discussione-->
            <div class="cardPrinc">
                <div><b>Postato da <?php echo $row['creatore']; ?></b></div>
                <div class="cardDesc"><?php echo $row['descrizione']; ?></div>
                <div class="cardInfor">
                    Il <small><?php echo $row['data_creazione']; ?></small>
                </div>
            </div>
        </div>
        <!--contenitore delle risposte-->
        <div class="cardRisp">
            <?php 
            /*tramite un while prendo il contenuto della tabella e stampo le risposte inerenti alla discussione*/
            $result = pg_query($db, "SELECT * FROM risposte WHERE id_discussione=$var ORDER BY data_risposta DESC");
            if(!$result){
                echo "Errore nel caricamento delle risposte";
                exit;
            }
            $count=0;
            while($arr=pg_fetch_array($result)){
                $count++;
            ?>
            <!--contenitore risposta singola-->
            <div class="subCardRisp">
                <div class="userRisp"><b>Postato da <?php echo $arr['partecipante']; ?></b></div>
                <div class="rispDesc"><?php echo $arr['testo']; ?></div>
                <div class="rispInfor">
                    Il <small><?php echo $arr['data_risposta']; ?></small>
                </div>
            </div>
            <?php
            }
            if($count==0){
                echo "<h1>Non ci sono risposte</h1>";
            }
            else{
                echo "<div class='numRisp'><p>Questa discussione ha $count risposta/e</p></div>";
            }
            ?>
        </div>
    </div>
    </div>
    <!--includo il footer-->
    <?php include("../HTML/footer.html") ?>
</body>
</html>