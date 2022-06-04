window.onload = onReload();

function selectionFilter(x) {
    //controllo per disabilitare ciò che non si desidera cliccabile
    if(x=='mare'){
        disableCheck('montagna');
        disableCheck('citta');
        disableCheck('economico');
        disableCheck('tendenza');
    }
    if(x=='montagna'){
        disableCheck('mare');
        disableCheck('citta');
        disableCheck('economico');
        disableCheck('tendenza');
    }
    if(x=='citta'){
        disableCheck('montagna');
        disableCheck('mare');
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='economico'){
        disableCheck('mare');
        disableCheck('montagna');
        disableCheck('citta');
        disableCheck('cultura');
        disableCheck('famiglia');
        disableCheck('cibo');
        disableCheck('avventura');
        disableCheck('romanticismo');
        disableCheck('neve');
        disableCheck('divertimento');
        disableCheck('relax');
        disableCheck('tendenza');
    }if(x=='tendenza'){
        disableCheck('mare');
        disableCheck('montagna');
        disableCheck('citta');
        disableCheck('cultura');
        disableCheck('famiglia');
        disableCheck('cibo');
        disableCheck('avventura');
        disableCheck('romanticismo');
        disableCheck('neve');
        disableCheck('divertimento');
        disableCheck('relax');
        disableCheck('economico');
    }if(x=='cultura'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='famiglia'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='cibo'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='avventura'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='romanticismo'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='neve'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='divertimento'){
        disableCheck('economico');
        disableCheck('tendenza');
    }if(x=='relax'){
        disableCheck('economico');
        disableCheck('tendenza');
    }
    //all on click del filtro permetto di cambiare immagine
    if (document.getElementById(x).src == '../immagini/' + x + '.jpg') {
        document.getElementById(x).src = '../immagini/pre_' + x + '.jpg';
    } else {
        document.getElementById(x).src = '../immagini/' + x + '.jpg';
    }
}


function onReload() {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    //al ricaricarsi del sito se dovesse avere filtri selezionati la pagina visualizzera di nuovo la finestra dei filtri
    if (window.location.href.includes("?")) {
        window.scrollTo(0, 500);
    }

    if (urlParams.has('mare')) {
        //diabilito tutto cio che non voglio venga cliccato dopo l' immissione del filtro
        disableCheck('montagna');
        disableCheck('citta');
        disableCheck('economico');
        disableCheck('tendenza');
        var mare = urlParams.get('mare');
        //permetto di salvare la selezione del filtro anche dopo il caricamento pagina
        document.getElementById('mare').src = '../immagini/' + mare + '.jpg';
        document.getElementsByName('mare')[0].checked = true;
    } else {
        //il filtro rimarrà deselezionato
        document.getElementById('mare').src = '../immagini/pre_mare.jpg';
    }

    if (urlParams.has('montagna')) {
        disableCheck('mare');
        disableCheck('citta');
        disableCheck('economico');
        disableCheck('tendenza');
        var montagna = urlParams.get('montagna');
        document.getElementById('montagna').src = '../immagini/' + montagna + '.jpg';
        document.getElementsByName('montagna')[0].checked = true;
    } else {
        document.getElementById('montagna').src = '../immagini/pre_montagna.jpg';

    }

    if (urlParams.has('citta')) {
        disableCheck('mare');
        disableCheck('montagna');
        disableCheck('economico');
        disableCheck('tendenza');
        var citta = urlParams.get('citta');
        document.getElementById('citta').src = '../immagini/' + citta + '.jpg';
        document.getElementsByName('citta')[0].checked = true;
    } else {
        document.getElementById('citta').src = '../immagini/pre_citta.jpg';
    }

    if (urlParams.has('economico')) {
        disableCheck('mare');
        disableCheck('montagna');
        disableCheck('citta');
        disableCheck('cultura');
        disableCheck('famiglia');
        disableCheck('cibo');
        disableCheck('avventura');
        disableCheck('romanticismo');
        disableCheck('neve');
        disableCheck('divertimento');
        disableCheck('relax');
        disableCheck('tendenza');
        var economico = urlParams.get('economico');
        document.getElementById('economico').src = '../immagini/' + economico + '.jpg';
        document.getElementsByName('economico')[0].checked = true;
    } else {
        document.getElementById('economico').src = '../immagini/pre_economico.jpg';
    }

    if (urlParams.has('tendenza')) {
        disableCheck('mare');
        disableCheck('montagna');
        disableCheck('citta');
        disableCheck('cultura');
        disableCheck('famiglia');
        disableCheck('cibo');
        disableCheck('avventura');
        disableCheck('romanticismo');
        disableCheck('neve');
        disableCheck('divertimento');
        disableCheck('relax');
        disableCheck('economico');
        var tendenza = urlParams.get('tendenza');
        document.getElementById('tendenza').src = '../immagini/' + tendenza + '.jpg';
        document.getElementsByName('tendenza')[0].checked = true;
    } else {
        document.getElementById('tendenza').src = '../immagini/pre_tendenza.jpg';
    }

    if (urlParams.has('cultura')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var cultura = urlParams.get('cultura');
        document.getElementById('cultura').src = '../immagini/' + cultura + '.jpg';
        document.getElementsByName('cultura')[0].checked = true;
    } else {
        document.getElementById('cultura').src = '../immagini/pre_cultura.jpg';
    }

    if (urlParams.has('famiglia')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var famiglia = urlParams.get('famiglia');
        document.getElementById('famiglia').src = '../immagini/' + famiglia + '.jpg';
        document.getElementsByName('famiglia')[0].checked = true;
    } else {
        document.getElementById('famiglia').src = '../immagini/pre_famiglia.jpg';
    }

    if (urlParams.has('cibo')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var cibo = urlParams.get('cibo');
        document.getElementById('cibo').src = '../immagini/' + cibo + '.jpg';
        document.getElementsByName('cibo')[0].checked = true;
    } else {
        document.getElementById('cibo').src = '../immagini/pre_cibo.jpg';
    }

    if (urlParams.has('avventura')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var avventura = urlParams.get('avventura');
        document.getElementById('avventura').src = '../immagini/' + avventura + '.jpg';
        document.getElementsByName('avventura')[0].checked = true;
    } else {
        document.getElementById('avventura').src = '../immagini/pre_avventura.jpg';
    }

    if (urlParams.has('romanticismo')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var romanticismo = urlParams.get('romanticismo');
        document.getElementById('romanticismo').src = '../immagini/' + romanticismo + '.jpg';
        document.getElementsByName('romanticismo')[0].checked = true;
    } else {
        document.getElementById('romanticismo').src = '../immagini/pre_romanticismo.jpg';
    }

    if (urlParams.has('neve')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var neve = urlParams.get('neve');
        document.getElementById('neve').src = '../immagini/' + neve + '.jpg';
        document.getElementsByName('neve')[0].checked = true;
    } else {
        document.getElementById('neve').src = '../immagini/pre_neve.jpg';
    }

    if (urlParams.has('divertimento')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var divertimento = urlParams.get('divertimento');
        document.getElementById('divertimento').src = '../immagini/' + divertimento + '.jpg';
        document.getElementsByName('divertimento')[0].checked = true;
    } else {
        document.getElementById('divertimento').src = '../immagini/pre_divertimento.jpg';
    }

    if (urlParams.has('relax')) {
        disableCheck('economico');
        disableCheck('tendenza');
        var relax = urlParams.get('relax');
        document.getElementById('relax').src = '../immagini/' + relax + '.jpg';
        document.getElementsByName('relax')[0].checked = true;
    } else {
        document.getElementById('relax').src = '../immagini/pre_relax.jpg';
    }
}

//funzione per disabilitare il filtro che si desidera
function disableCheck(x){
    document.getElementById('checkbox_'+x).disabled=true;
    document.getElementById(x).style.opacity= 0.3;
    document.getElementById(x).style.pointerEvents = "none";
}