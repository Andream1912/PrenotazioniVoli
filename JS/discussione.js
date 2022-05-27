/*definisco le costanti prese dal documento*/
const respFormContainer = document.querySelector("[respFormContainer]");
const modifyFormContainer = document.querySelector("[modifyFormContainer]");
const visibleContainer = document.querySelector("[cardTot]");
const respExitButton = document.querySelector("[respExitButton]");
const icon = document.querySelector("[icon]");
const borderButton = document.querySelector(".borderButton");
let openButton = false;
/*definisco una funzione al caricamento della pagina*/
window.onload = onReload();
/*gestisco la visibilità dell'overlay di creazione risposta con i rispettivi bottoni*/
function respDiscussion() {
    respFormContainer.classList.remove("hide");
    visibleContainer.classList.toggle("blur");
    document.querySelector(".body").style.overflow = "hidden";
}

respExitButton.addEventListener("click", e => {
    respFormContainer.classList.toggle("hide");
    document.querySelector(".body").style.overflow = "auto";
    visibleContainer.classList.remove("blur");
})

/*gestisco la visibilità del bottone al caricamento della pagina*/
function onReload() {
    borderButton.style.transform = "translateX(220px)";
    icon.style.transform = "rotate(45deg)";
    icon.style.transition = "1s";
    openButton = true;
}

/*gestisco la visibilità dell'overlay per la modifica della discussione tramite funzioni onclick*/
function modify() {
    modifyFormContainer.classList.remove("hide");
    visibleContainer.classList.toggle("blur");
    document.querySelector(".body").style.overflow = "hidden";
}

function exitModify() {
    modifyFormContainer.classList.toggle("hide");
    visibleContainer.classList.remove("disabled");
    visibleContainer.classList.remove("blur");
    document.querySelector(".body").style.overflow = "auto";
}

/*validazione del form per la creazione di una risposta*/
function validateResponse() {
    let responseText = document.querySelector("[responseText]");
    if (responseText.value == "") {
        responseText.style.border = "3px solid red";
        return false;
    } else {
        responseText.style.border = "1px solid black";
    }
    return true;
}

/*validazione del form per la modifica della discussione*/
function validateModify() {
    let modifyText = document.querySelector("[modifyText]");
    if (modifyText.value == "") {
        modifyText.style.border = "3px solid red";
        return false;
    } else {
        modifyText.style.border = "1px solid black";
    }
    return true;
}

function showButton() {
    if (openButton == false) {
        borderButton.style.transform = "translateX(220px)";
        borderButton.style.transition = "1s";
        icon.style.transform = "rotate(45deg)";
        openButton = true;
    } else {
        borderButton.style.transform = "translateX(0)";
        icon.style.transform = "rotate(0)";
        openButton = false;
    }
    return true
}