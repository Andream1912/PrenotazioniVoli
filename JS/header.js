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
        document.getElementById("password").style.borderColor = "#e74c3c"
        document.getElementById("pwrong").style.visibility = "visible";
        return false;
    } else {
        if (isEmail(email.value)) {
            wrong.style.visibility = "hidden";
            email.style.borderColor = "#2ecc71";
            right.style.visibility = "visible";
            if (document.getElementById("password").value === "") {
                document.getElementById("pwrong").style.visibility = "visible";
                document.getElementById("password").style.borderColor = "#e74c3c"

                return false;
            } else {
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