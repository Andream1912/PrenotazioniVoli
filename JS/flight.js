queryString = window.location.search;
urlparams = new URLSearchParams(queryString);
filter = urlparams.get("filter");
if (document.querySelector(".filter") != null) {
    // A seconda del get che riscontro nell'url avrò selezionato il filtro riportato. Di default sarà lo standard
    if (filter == 'speed') {
        document.querySelector('.secondFilter').style.backgroundColor = "#042759";
        document.querySelector('.secondFilter').style.color = "white";
    } else if (filter == 'economy') {
        document.querySelector('.thirdFilter').style.backgroundColor = "#042759";
        document.querySelector('.thirdFilter').style.color = "white";
    } else {
        document.querySelector('.firstFilter').style.backgroundColor = "#042759";
        document.querySelector('.firstFilter').style.color = "white";
    }
}
if (!(urlparams.has("endDate"))) {
    document.getElementsByName("endDate")[0].disabled = true;
}



function disableDate() {
    document.getElementsByName("endDate")[0].disabled = true;
    document.getElementsByName("endDate")[0].value = "";
}

function enableDate() {
    document.getElementsByName("endDate")[0].disabled = false;
}