<!DOCTYPE html>
<html lang="it">


<head>
    <link rel="stylesheet" href="../CSS/header.css">
    <link type="text/css" href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/register.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="icon" type="image/x-icon" href="../immagini/world.ico">
    <script src="https://kit.fontawesome.com/63a4bcd19a.js" crossorigin="anonymous"></script>
    <script src="../JS/register.js" defer></script>
    <script src="../JS/header.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
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
            $ruolo = $_SESSION['ruolo'];
        ?>
            <div class="right-logged">
                <img onclick="dropMenu()" src="../immagini/usericon.png" class="user-drop">
                <?php
                echo "<p>Benvenuto $user</p>";
                ?>
                <div class="dropdown-menu">
                    <?php if ($ruolo == 'visitatore') { ?>
                        <a href="private_page.php?card=informazioni_personali">Area Privata</a>
                        <a href="private_page.php?card=prenotazioni&prenotazioni=correnti">Le mie prenotazioni</a>
                        <a href="forum.php">Topic</a>
                    <?php } else if ($ruolo == 'admin') { ?>
                        <a href="admin.php?card=eliminautenti">Elimina utenti</a>
                        <a href="admin.php?card=aggiungivoli">Aggiungi voli</a>
                    <?php } ?>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php
        } else { ?>
            <div class="right">
                <a href="forum.php" class="discussioni">Discussioni</a>
                <button type="button" class="btn-register" onclick="openRegister()">Registrati</button>
                <button type="button" class="btn-login" onclick="openLogin()">Accedi</button>
            </div>
        <?php
        }
        ?>
    </header>

    <form data-multi-step class="multi-step-form" method="POST" id="form" action="manager-registration.php" onsubmit="return validateRegister()">
        <div class="card active" data-step>
            <a href="#" class="close" onclick=closeWindow()><svg style="height:35px;" fill="#4361ee" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />
                </svg></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">

            <h3 class=" step-title ">Primo step</h3>
            <div class="form-group ">
                <label for="username ">Username</label>
                <br>
                <p style="margin:0;margin-right:40px;color:red" id="usernameError" dir="rtl"></p>
                <input type="text" name="username" id="username" placeholder="Username">
                <i class="fas fa-check-circle" id="right-user" style="color:#2ecc71"></i>
                <i class="fas fa-exclamation-circle" id="error-user" style="color:#e74c3c"></i>
            </div>
            <button type="button" dir="rtl" data-next>Avanti</button>
            <p>Hai gi&agrave un account?<span style="cursor:pointer;color:#3498db" onclick="RegistertoLogin()"> Accedi</span></p>
        </div>
        <div class="card" data-step>
            <a href="" class="close" onclick=closeWindow()><svg style="height:35px;" fill="#4361ee" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />
                </svg></a>
            <img src="../immagini/world.png" style="width:250px;height:250px;margin-left:5%;">
            <h3 class="step-title ">Secondo step</h3>
            <div class="form-group ">
                <label for="email ">Email</label>
                <br>
                <p style="margin:0;margin-right:40px;color:red" id="emailError" dir="rtl"></p>
                <input type="email" name="email-register" id="email-register" placeholder="Email">
                <i class="fas fa-check-circle" id="right-r"></i>
                <i class="fas fa-exclamation-circle" id="wrong-r"></i>
            </div>
            <button type="button" data-previous>Indietro</button>
            <button type="button" data-next>Avanti</button>
            <p>Hai gi&agrave un account?<span style="cursor:pointer;color:#3498db" onclick="RegistertoLogin()"> Accedi</span></p>
        </div>
        <div class="card " data-step>
            <a href="" class="close" onclick=closeWindow()><svg style="height:35px;" fill="#4361ee" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />
                </svg></a>
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
                <i class="fas fa-check-circle" id="right-verifypass" style="color:#2ecc71;top:435px"></i>
                <i class="fas fa-exclamation-circle" id="wrong-verifypass" style="color:#e74c3c;top:435px"></i>
            </div>
            <button type="button" data-previous>Indietro</button>
            <input type="submit" name="invia" value="Registrati">
        </div>
    </form>

    <form action="manager-login.php" method="post" class="form-login" onsubmit="return validateForm()">
        <a href="#" class="close" onclick=closeWindow()><svg style="height:35px;" fill="#4361ee" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" />
            </svg></i></a>
        <img src="../immagini/world.png" style="width:250px;height:240px;margin-left:5%;">
        <h3>Login</h3>
        <p style="color:red;text-align:center;margin:0;" id="loginError"></p>
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
        <p>Non hai ancora un account?<span style="cursor:pointer;color:#3498db;" onclick="LogintoRegister()"> Registrati</span></p>
    </form>
    <script>
        <?php
        if (isset($_GET['error']) || !empty($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'username' || $error == 'email') {
                if ($error == 'username') { ?>
                    let username = document.getElementById("username")
                    let errorUsername = document.getElementById("usernameError")
                    username.style.borderColor = "red";
                    errorUsername.innerHTML = "Username gi&agrave esistente";
                <?php
                } else if ($error = 'email') { ?>
                    let email = document.getElementById("email-register");
                    let errorEmail = document.getElementById("emailError");
                    email.style.borderColor = "red";
                    errorEmail.innerHTML = "Email gi&agrave esistente";
                <?php
                }
                ?>
                openRegisterError();
            <?php
            } else if ($error == 'login') { ?>
                let loginError = document.getElementById("loginError").innerHTML = "Email e/o Password incorretti";
                let loginEmail = document.getElementById("email").style.borderColor = "red";
                let loginPass = document.getElementById("password").style.borderColor = "red";
                openLogin();

            <?php
            } else if ($error == 'success') { ?>
                success();

        <?php
            }
        } ?>


        function success() {
            var queryString = window.location.href;
            var string = queryString.replace('?error=success', '');
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Account registrato con successo',
                showConfirmButton: false,
                timer: 2000
            })
            setTimeout(function() {
                location.href = string
            }, 1500);

        }
    </script>
</body>


</html>