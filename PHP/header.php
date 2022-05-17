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
            <img src="../immagini/logo.png" class="logo" style="width:160px;height:101,6px;cursor:pointer" onclick="comeback()">
            <h2>FlyHigh</h2>
        </div>
        <?php
        session_start();
        $user = $_SESSION['username'];
        if (!empty($user)) {
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
            <i class="fas fa-exclamation-circle" id="wrong"></i>
        </div>
        <div class="form-control">
            <label for="password">Password</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Inserisci la tua password">
            <br><br>
        </div>
        <input type="submit" value="Accedi" name="invia" class="login" id="submit">
        <p>Non hai ancora un account?<span style="cursor:pointer;" onclick="LogintoRegister()"> Registrati</span></p>
    </form>

    <script>
        function LogintoRegister() {
            closeWindow();
            openRegister();
        }

        function RegistertoLogin() {
            closeWindow();
            openLogin();
        }

        function comeback() {
            location.href = "../PHP/homepage.php";
        }
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

        function validateRegister() {
            let username = document.getElementById("username");
            let email = document.getElementById("email-register");
            let pass = document.getElementById("password-register");
            let vpass = document.getElementById("verify-password");
            let wrongUser = document.getElementById("error-user");
            let rightUser = document.getElementById("right-user");
            let wrongPass = document.getElementById("error-pass");
            let rightPass = document.getElementById("right-pass");
            let wrongMail = document.getElementById("wrong-r");
            let rightMail = document.getElementById("right-r")
            if ((username.value === "") || (email.value === "") || (vpass.value === "") || (pass.value === "")) {
                if (username.value === "") {
                    username.style.borderColor = "#e74c3c";
                    wrongUser.style.visibility = "visible";
                    rightUser.style.visibility = "hidden";
                } else {
                    username.style.borderColor = "#2ecc71";
                    wrongUser.style.visibility = "hidden";
                    rightUser.style.visibility = "visible";
                }
                if (email.value === "") {
                    email.style.borderColor = "#e74c3c";
                    wrongMail.style.visibility = "visible";
                    rightMail.style.visibility = "hidden";
                } else {
                    email.style.borderColor = "#2ecc71";
                    wrongMail.style.visibility = "hidden";
                    rightMail.style.visibility = "visible";
                }
                if (pass.value === "") {
                    pass.style.borderColor = "#e74c3c";
                    wrongPass.style.visibility = "visible";
                    rightPass.style.visibility = "hidden";
                } else {
                    pass.style.borderColor = "#2ecc71";
                    wrongPass.style.visibility = "hidden";
                    rightPass.style.visibility = "visible";
                }
                if (vpass.value === "") {
                    vpass.style.borderColor = "#e74c3c";
                } else {
                    pass.style.borderColor = "#2ecc71";
                }
                currentStep = 0;
                showCurrentStep();
                return false;
            } else {
                if (pass.value === vpass.value) {
                    return true;
                } else {
                    pass.style.borderColor = "#e74c3c";
                    vpass.style.borderColor = "#e74c3c";
                    return false;
                }
            }
        }

        function validateForm() {
            let email = document.getElementById("email");
            let wrong = document.getElementById("wrong");
            let right = document.getElementById("right");
            if (email.value === "") {
                email.style.borderColor = "#e74c3c"
                wrong.style.visibility = "visible";
                return false;
            } else {
                if (isEmail(email.value)) {
                    wrong.style.visibility = "hidden";
                    email.style.borderColor = "#2ecc71";
                    right.style.visibility = "visible";
                    if(document.getElementById("password").value === "") {
                        document.getElementById("password").style.borderColor = "#e74c3c"
                        return false;
                    }else{
                        return true;;
                    }
                } else {
                    return false;
                }
            }
        }

        function isEmail(email) {
            return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
        }
    </script>
</body>

</html>