queryString = window.location.search;
urlparams = new URLSearchParams(queryString);
filter = urlparams.get("filter");
if (filter == 'standard') {
    document.querySelector('.firstFilter').style.backgroundColor = "#042759";
    document.querySelector('.firstFilter').style.color = "white";
}
if (filter == 'speed') {
    document.querySelector('.secondFilter').style.backgroundColor = "#042759";
    document.querySelector('.secondFilter').style.color = "white";
}
if (filter == 'economy') {
    document.querySelector('.thirdFilter').style.backgroundColor = "#042759";
    document.querySelector('.thirdFilter').style.color = "white";
}
if (!(urlparams.has("endDate"))) {
    console.log(document.getElementsByName("endDate")[0].disabled);
    document.getElementsByName("endDate")[0].disabled = true;
}


function disableDate() {
    document.getElementsByName("endDate")[0].disabled = true;
    document.getElementsByName("endDate")[0].value = "";
}

function enableDate() {
    document.getElementsByName("endDate")[0].disabled = false;
}