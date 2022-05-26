/*inizializzo le costanti prese dal documento*/
const discussionCreator = document.querySelector("[discussionCreator]");
const exitButton = document.querySelector("[exitButton]");
const visibleContainer = document.querySelector("[visibleContainer]");
const exitSearchButton = document.querySelector("[exitSearchButton]");
/*definisco una funzione da svolgere al caricamento della pagina*/
window.onload = onReload();

/*gestisco la visibilità dell'overlay tramite i bottoni di apertura e chiusura*/
exitButton.addEventListener("click", e => {
    discussionCreator.classList.toggle("hide");
    visibleContainer.classList.remove("blur");
    document.querySelector(".body").style.overflow = "auto";
})

function showDiscussionCreator() {
    document.querySelector(".body").style.overflow = "hidden";
    visibleContainer.classList.toggle("blur");
    discussionCreator.classList.remove("hide");
}

/*gestisco la visibilità del bottone annulamento filtro al caricamento della pagina*/
function onReload() {
    if (window.location.href.includes("?search=")) {
        exitSearchButton.classList.remove("hide");
    } else {
        exitSearchButton.classList.add("hide");

    }
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