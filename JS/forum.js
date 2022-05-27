/*inizializzo le costanti prese dal documento*/
const discussionCreator = document.querySelector("[discussionCreator]");
const exitButton = document.querySelector("[exitButton]");
const visibleContainer = document.querySelector("[visibleContainer]");
const exitSearchButton = document.querySelector("[exitSearchButton]");
const borderButton = document.querySelector(".borderButton");
const icon = document.querySelector("[icon]");
let openButton = false;
/*definisco una funzione da svolgere al caricamento della pagina*/
window.onload = onReload();

/*gestisco tramite eventlistener la visibilità dell'overlay tramite i bottoni di apertura e chiusura*/
exitButton.addEventListener("click", e => {
    discussionCreator.classList.toggle("hide");
    visibleContainer.classList.remove("blur");
    document.querySelector(".body").style.overflow = "auto";
})

function showDiscussionButton() {
    visibleContainer.classList.toggle("blur");
    discussionCreator.classList.remove("hide");
    document.querySelector(".body").style.overflow = "hidden";
}

/*gestisco la visibilità del bottone annulamento filtro e creazione discussione al caricamento della pagina*/
function onReload() {
    if (window.location.href.includes("?search=")) {
        exitSearchButton.classList.remove("hide");
    } else {
        exitSearchButton.classList.add("hide");

    }
    borderButton.style.transform = "translateX(220px)";
    icon.style.transform = "rotate(45deg)";
    icon.style.transition = "1s";
    openButton = true;
}

/*effettuo un controllo sul form per verificare che le informazioni inviate siano corrette*/
function validateCreateDiscussion() {
    let title = document.querySelector("[discussionTitle]");
    let discussion = document.querySelector("[discussionText]");
    if (title.value == "" || discussion.value == "") {
        if (title.value == "") {
            title.style.border = "3px solid red";
        } else {
            title.style.border = "1px solid black";
        }
        if (discussion.value == "") {
            discussion.style.border = "3px solid red";
        } else {
            discussion.style.border = "1px solid black";
        }
        return false;
    } else {
        return true;
    }

}

/*funzione per mostrare il bottone di creazione al click dell'icona*/
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