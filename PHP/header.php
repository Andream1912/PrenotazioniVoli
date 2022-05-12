<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="../CSS/header.css">
    <link type="text/css" href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <script src="https://kit.fontawesome.com/63a4bcd19a.js" crossorigin="anonymous"></script>
    <script src="../JS/register.js" defer></script>
</head>

<body>
    <header class="header" id="head">
        <div dir="ltl" class="left">
            <img src="../immagini/logo.png" width="160px" height="101,6px">
            <h2>FlyHigh</h2>
        </div>
        <?php
        session_start();
        $user = $_SESSION['username'];
        if(!empty($user)){
        ?>
        <div class="right-logged">
            <img onclick="dropMenu()" src="../immagini/usericon.png" class="user-drop">
            <?php
            echo "<p>Benvenuto $user</p>";
            ?>
            <div class="dropdown-menu">
                <a href="">Area Privata</a>
                <a href="">Le mie prenotazioni</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <?php
        }else{?>
        <div class="right">
            <button type="button" class="btn-register" onclick="openRegister()">Registrati</button>
            <button type="button" class="btn-login" onclick="openLogin()">Accedi</button>
        </div>
        <?php
        }
        ?>
    </header>

    <form data-multi-step class="multi-step-form" method="POST" id="form" action="manager-registration.php">
        <div class="card active" data-step>
            <a href="#" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin" dir="rtl"></i></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">

            <h3 class=" step-title ">Primo step</h3>
            <div class="form-group ">
                <label for="username ">Username</label>
                <br>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <button type="button" dir="rtl" data-next>Avanti</button>
        </div>
        <div class="card" data-step>
            <a href="" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin " dir="rtl "></i></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">
            <h3 class="step-title ">Secondo step</h3>
            <div class="form-group ">
                <label for="email ">Email</label>
                <br>
                <input type="email" name="email-register" id="email-register">
            </div>
            <button type="button" data-previous>Indietro</button>
            <button type="button" data-next>Avanti</button>
        </div>
        <div class="card " data-step>
            <a href="" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin " dir="rtl "></i></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">
            <h3 class="step-title">Terzo step</h3>
            <div class="form-group ">
                <label for="password">Password</label>
                <br>
                <input type="password" name="password-register" id="password-register">
            </div>
            <div class="form-group">
                <label for="verify-password">Conferma Password</label>
                <br>
                <input type="password" name="verify-password" id="verify-password">
            </div>
            <button type="button" data-previous>Indietro</button>
            <input type="submit" name="invia" value="Registrati">
        </div>
    </form>

    <form action="manager-login.php" method="post" class="form-login">
        <a href="" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin " dir="rtl "></i></a>
        <img src="../immagini/world.png" style="width:250px;height:240px;margin-left:5%;">
        <h3>Login</h3>
        <label for="email">Email</label>
        <br>
        <input type="email" name="email" id="email" placeholder="E-mail">
        <br>
        <label for="password">Password</label>
        <br>
        <input type="password" name="password" id="password" placeholder="Inserisci la tua password">
        <br><br>
        <input type="submit" value="Accedi" name="invia" class="login">

    </form>

    <script>
        window.onclick = function(event) {
                if (document.querySelector(".dropdown-menu").style.display == "flex") {
                if (!event.target.matches(".user-drop")) {
                    hideMenu();
                }
            }
        }

        function dropMenu() {
            if (document.querySelector(".dropdown-menu").style.display == "flex") {
                document.querySelector(".dropdown-menu").style.display = "none";
                document.querySelector(".right-logged p").style.display = "block";
            } else {
                document.querySelector(".right-logged p").style.display = "none";
                document.querySelector(".dropdown-menu").style.display = "flex";
                document.querySelector(".dropdown-menu").style.flexDirection = "column";

            }
        }

        function hideMenu() {
            document.querySelector(".dropdown-menu").style.display = "none";
            document.querySelector(".right-logged p").style.display = "block";
        }

        function openRegister() {
            document.querySelector(".multi-step-form").style.display = "block ";
            document.querySelector(".mid-page").style.opacity = "0.5";
            document.querySelector(".cards").style.opacity = "0.5";
            document.querySelector(".body").style.overflow = "hidden";
        }

        function closeWindow() {
            document.querySelector(".multi-step-form").style.display = "none";
            document.querySelector(".form-login").style.display = "none";
            document.querySelector(".header").style.opacity = "1";
            document.querySelector(".mid-page ").style.opacity = "1";
            document.querySelector(".cards").style.opacity = "1";
            currentStep = 0;
            showCurrentStep();
            document.querySelector(".body").style.overflow = "auto";
        }

        function openLogin() {
            document.querySelector(".form-login").style.display = "block";
            document.querySelector(".mid-page").style.opacity = "0.5 "
            document.querySelector(".cards").style.opacity = "0.5";
            document.querySelector(".body").style.overflow = "hidden";
        }
    </script>
</body>

</html>