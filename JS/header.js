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
    if (dropdown_menu = document.querySelector(".dropdown-menu")) {
        if (dropdown_menu.style.visibility == "visible") {
            if (!event.target.matches(".user-drop")) {
                hideMenu();
            }
        }
    }
}


function dropMenu() {
    if (document.querySelector(".dropdown-menu").style.visiblity == "visible") {
        document.querySelector(".dropdown-menu").style.visibility = "hidden";
        document.querySelector(".right-logged p").style.visibility = "visible";
    } else {
        document.querySelector(".right-logged p").style.visibility = "hidden";
        document.querySelector(".dropdown-menu").style.visibility = "visible";

    }
}

function hideMenu() {
    document.querySelector(".dropdown-menu").style.visibility = "hidden";
    document.querySelector(".right-logged p").style.visibility = "visible";
}

function openRegister() {
    document.querySelector(".multi-step-form").style.display = "block ";
    document.querySelector(".mid-page").style.opacity = "0.5";
    document.querySelector(".body").style.overflow = "hidden";
}

function openRegisterError() {
    document.querySelector(".multi-step-form").style.display = "block ";
    document.querySelector(".body").style.overflow = "hidden";
}

function closeWindow() {
    document.querySelector(".multi-step-form").style.display = "none";
    document.querySelector(".form-login").style.display = "none";
    document.querySelector(".header").style.opacity = "1";
    document.querySelector(".mid-page ").style.opacity = "1";
    currentStep = 0;
    showCurrentStep();
    document.querySelector(".body").style.overflow = "auto";
}

function openLogin() {
    document.querySelector(".form-login").style.display = "block";
    document.querySelector(".mid-page").style.opacity = "0.5";
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
    let rightMail = document.getElementById("right-r");
    let rightVPass = document.getElementById("right-verifypass");
    let wrongVPass = document.getElementById("wrong-verifypass");
    const r = "^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])";
    const regex = new RegExp(r)
    if (username.value == "") {
        currentStep = 0;
    } else if (email.value == "") {
        currentStep = 1;
    } else if (password.value == "") {
        currentStep = 2;
    } else if (vpass.value == "") {
        currentStep = 2;
    }
    if ((username.value === "") || (email.value === "") || (vpass.value === "") || (pass.value === "")) {
        showCurrentStep();
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
            if (pass.value > 6 && regex.test(pass.value)) {
                pass.style.borderColor = "#2ecc71";
                wrongPass.style.visibility = "hidden";
                rightPass.style.visibility = "visible";
            } else {
                pass.style.borderColor = "#e74c3c";
                wrongPass.style.visibility = "visible";
                rightPass.style.visibility = "hidden";
            }
        }
        if (vpass.value === "") {
            vpass.style.borderColor = "#e74c3c";
            wrongVPass.style.visibility = "visible";
            rightVPass.style.visibility = "hidden";
        } else if (pass.value == vpass.value) {
            vpass.style.borderColor = "#2ecc71";
            rightVPass.style.visibility = "visible";
            wrongVPass.style.visibility = "hidden";
        }
        return false;
    } else {
        if (pass.value.length > 6 && regex.test(pass.value)) {
            pass.style.borderColor = "#2ecc71";
            wrongPass.style.visibility = "hidden";
            rightPass.style.visibility = "visible";
        } else {
            vpass.style.borderColor = "#e74c3c";
            wrongVPass.style.visibility = "visible";
            rightVPass.style.visibility = "hidden";
            pass.style.borderColor = "#e74c3c";
            wrongPass.style.visibility = "visible";
            rightPass.style.visibility = "hidden";
            return false;
        }
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