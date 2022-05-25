/*definisco le costanti prese dal documento*/
const respButton = document.querySelector("[respButton]");
const respFormContainer = document.querySelector("[respFormContainer]");
const modifyFormContainer = document.querySelector("[modifyFormContainer]");
const visibleContainer = document.querySelector("[cardTot]");
const respExitButton = document.querySelector("[respExitButton]");

/*gestisco la visibilità dell'overlay di creazione risposta con i rispettivi bottoni*/
respButton.addEventListener("click", e => {
    respFormContainer.classList.remove("hide");
    visibleContainer.classList.toggle("blur");
    visibleContainer.classList.toggle("disabled");
})

respExitButton.addEventListener("click", e => {
    respFormContainer.classList.toggle("hide");
    visibleContainer.classList.remove("disabled");
    visibleContainer.classList.remove("blur");
})

/*gestisco la visibilità dell'overlay per la modifica della discussione tramite funzioni onclick*/
function modify() {
    modifyFormContainer.classList.remove("hide");
    visibleContainer.classList.toggle("blur");
    visibleContainer.classList.toggle("disabled");

}

function exitModify() {
    modifyFormContainer.classList.toggle("hide");
    visibleContainer.classList.remove("disabled");
    visibleContainer.classList.remove("blur");
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