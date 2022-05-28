document.getElementById("startDate").min = new Date();
/*           FACCIO UN CONTROLLO SUGLI INPUT DELLA SEARCH BAR               */
function checkInput() {
    from = document.getElementById("departure");
    to = document.getElementById("landing");
    startDate = document.getElementById("startDate");
    if (from.value == "" || to.value == "" || startDate.value == "") {
        if (from.value == "") {
            from.style.borderColor = "red";
        } else {
            from.style.borderColor = "#f0f0f0";
        }
        if (to.value == "") {
            to.style.borderColor = "red";
        } else {
            to.style.borderColor = "#f0f0f0";
        }
        if ((startDate.value == "") || (startDate.value < new Date())) {
            startDate.style.borderColor = "red";
        } else {
            startDate.style.borderColor = "#f0f0f0";
        }
        // Se entrato in questo if sicuramente tornerà false 
        return false;
    } else {
        return true;
    }
}


/*                  Funzionalita' dello switch tra città di partenza e ritorno          */
let rotateSwitch = false;

function switchCity() {
    x = document.getElementById("landing").value;
    document.getElementById("landing").value = document.getElementById("departure").value;
    document.getElementById("departure").value = x;
    img = document.querySelector(".switch");
    if (rotateSwitch == false) {
        img.style.transform = "rotate(180deg)";
        img.style.transition = "1s";
        rotateSwitch = true;
    } else {
        img.style.transform = "rotate(0deg)";
        rotateSwitch = false;
    }

}

/*                  Disabilita l'input del data picker del ritorno quando è spuntato "SOLO ANDATA" */
function disableDate() {
    document.getElementById("endDate").disabled = true;
    document.getElementById("endDate").value = "";
}
/*                 Riabilita l'input del data picker               */
function enableDate() {
    document.getElementById("endDate").disabled = false;
}

document.getElementById("startDate").valueAsDate = new Date(); //inserisco nel dataPicker la data di oggi
document.getElementById("endDate").disabled = true;