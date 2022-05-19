<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="../CSS/header.css">
    <link type="text/css" href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <script src="https://kit.fontawesome.com/63a4bcd19a.js" crossorigin="anonymous"></script>
    <script src="../JS/register.js" defer></script>
    <script src="../JS/header.js"></script>
</head>

<body>
    <header class="header" id="head">
        <div dir="ltl" class="left">
            <img src="../immagini/logo.png" class="logo" style="width:160px;height:101,6px;cursor:pointer" onclick="comeback()">
            <h2>FlyHigh</h2>
        </div>
        <?php
        session_start();
        if (!empty($_SESSION['username'])) {
            $user = $_SESSION['username'];
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
        } else { ?>
            <div class="right">
                <button type="button" class="btn-register" onclick="openRegister()">Registrati</button>
                <button type="button" class="btn-login" onclick="openLogin()">Accedi</button>
            </div>
        <?php
        }
        ?>
    </header>

    <form data-multi-step class="multi-step-form" method="POST" id="form" action="manager-registration.php" onsubmit="return    validateRegister()">
        <div class="card active" data-step>
            <a href="#" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin" dir="rtl"></i></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">

            <h3 class=" step-title ">Primo step</h3>
            <div class="form-group ">
                <label for="username ">Username</label>
                <br>
                <input type="text" name="username" id="username" placeholder="Username">
                <i class="fas fa-check-circle" id="right-user" style="color:#2ecc71"></i>
                <i class="fas fa-exclamation-circle" id="error-user" style="color:#e74c3c"></i>
            </div>
            <button type="button" dir="rtl" data-next>Avanti</button>
            <p>Hai gi&agrave un account?<span style="cursor:pointer;" onclick="RegistertoLogin()"> Accedi</span></p>
        </div>
        <div class="card" data-step>
            <a href="" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin " dir="rtl "></i></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">
            <h3 class="step-title ">Secondo step</h3>
            <div class="form-group ">
                <label for="email ">Email</label>
                <br>
                <input type="email" name="email-register" id="email-register" placeholder="Email">
                <i class="fas fa-check-circle" id="right-r"></i>
                <i class="fas fa-exclamation-circle" id="wrong-r"></i>
            </div>
            <button type="button" data-previous>Indietro</button>
            <button type="button" data-next>Avanti</button>
            <p>Hai gi&agrave un account?<span style="cursor:pointer;" onclick="RegistertoLogin()"> Accedi</span></p>
        </div>
        <div class="card " data-step>
            <a href="" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin " dir="rtl "></i></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">
            <h3 class="step-title">Terzo step</h3>
            <div class="form-group ">
                <label for="password">Password</label>
                <br>
                <input type="password" name="password-register" id="password-register">
                <i class="fas fa-check-circle" id="right-pass" style="color:#2ecc71"></i>
                <i class="fas fa-exclamation-circle" id="error-pass" style="color:#e74c3c"></i>
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

    <form action="manager-login.php" method="post" class="form-login" onsubmit="return validateForm()">
        <a href="#" class="close" onclick=closeWindow()><i class="fas fa-hand-middle-finger fa-spin " dir="rtl "></i></a>
        <img src="../immagini/world.png" style="width:250px;height:240px;margin-left:5%;">
        <h3>Login</h3>
        <div class="form-control">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="E-mail" />
            <i class="fas fa-check-circle" id="right"></i>
            <i class="fas fa-exclamation-circle" id="wrong" title="Username o Password Errati"></i>
        </div>
        <div class="form-control">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Inserisci la tua password">
        </div>
        <i class="fas fa-exclamation-circle" id="pwrong" title="Username o Password Errati"></i>
        <input type="submit" value="Accedi" name="invia" class="loginsubmit" id="submit">
        <p>Non hai ancora un account?<span style="cursor:pointer;" onclick="LogintoRegister()"> Registrati</span></p>
    </form>
</body>

</html>