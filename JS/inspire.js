window.onload = onReload();

function selectionFilter(x) {
    if (document.getElementById(x).src == '../immagini/' + x + '.jpg') {
        document.getElementById(x).src = '../immagini/pre_' + x + '.jpg';
    } else {
        document.getElementById(x).src = '../immagini/' + x + '.jpg';
    }
}


function onReload() {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    if (window.location.href.includes("?")) {
        window.scrollTo(0, 500);
    }

    if (urlParams.has('mare')) {
        var mare = urlParams.get('mare');
        document.getElementById('mare').src = '../immagini/' + mare + '.jpg';
        document.getElementsByName('mare')[0].checked = true;
    } else {
        document.getElementById('mare').src = '../immagini/pre_mare.jpg';
    }

    if (urlParams.has('montagna')) {
        var montagna = urlParams.get('montagna');
        document.getElementById('montagna').src = '../immagini/' + montagna + '.jpg';
        document.getElementsByName('montagna')[0].checked = true;
    } else {
        document.getElementById('montagna').src = '../immagini/pre_montagna.jpg';

    }

    if (urlParams.has('citta')) {
        var citta = urlParams.get('citta');
        document.getElementById('citta').src = '../immagini/' + citta + '.jpg';
        document.getElementsByName('citta')[0].checked = true;
    } else {
        document.getElementById('citta').src = '../immagini/pre_citta.jpg';
    }

    if (urlParams.has('economico')) {
        var economico = urlParams.get('economico');
        document.getElementById('economico').src = '../immagini/' + economico + '.jpg';
        document.getElementsByName('economico')[0].checked = true;
    } else {
        document.getElementById('economico').src = '../immagini/pre_economico.jpg';
    }

    if (urlParams.has('tendenza')) {
        var tendenza = urlParams.get('tendenza');
        document.getElementById('tendenza').src = '../immagini/' + tendenza + '.jpg';
        document.getElementsByName('tendenza')[0].checked = true;
    } else {
        document.getElementById('tendenza').src = '../immagini/pre_tendenza.jpg';
    }

    if (urlParams.has('cultura')) {
        var cultura = urlParams.get('cultura');
        document.getElementById('cultura').src = '../immagini/' + cultura + '.jpg';
        document.getElementsByName('cultura')[0].checked = true;
    } else {
        document.getElementById('cultura').src = '../immagini/pre_cultura.jpg';
    }

    if (urlParams.has('famiglia')) {
        var famiglia = urlParams.get('famiglia');
        document.getElementById('famiglia').src = '../immagini/' + famiglia + '.jpg';
        document.getElementsByName('famiglia')[0].checked = true;
    } else {
        document.getElementById('famiglia').src = '../immagini/pre_famiglia.jpg';
    }

    if (urlParams.has('cibo')) {
        var cibo = urlParams.get('cibo');
        document.getElementById('cibo').src = '../immagini/' + cibo + '.jpg';
        document.getElementsByName('cibo')[0].checked = true;
    } else {
        document.getElementById('cibo').src = '../immagini/pre_cibo.jpg';
    }

    if (urlParams.has('avventura')) {
        var avventura = urlParams.get('avventura');
        document.getElementById('avventura').src = '../immagini/' + avventura + '.jpg';
        document.getElementsByName('avventura')[0].checked = true;
    } else {
        document.getElementById('avventura').src = '../immagini/pre_avventura.jpg';
    }

    if (urlParams.has('romanticismo')) {
        var romanticismo = urlParams.get('romanticismo');
        document.getElementById('romanticismo').src = '../immagini/' + romanticismo + '.jpg';
        document.getElementsByName('romanticismo')[0].checked = true;
    } else {
        document.getElementById('romanticismo').src = '../immagini/pre_romanticismo.jpg';
    }

    if (urlParams.has('neve')) {
        var neve = urlParams.get('neve');
        document.getElementById('neve').src = '../immagini/' + neve + '.jpg';
        document.getElementsByName('neve')[0].checked = true;
    } else {
        document.getElementById('neve').src = '../immagini/pre_neve.jpg';
    }

    if (urlParams.has('divertimento')) {
        var divertimento = urlParams.get('divertimento');
        document.getElementById('divertimento').src = '../immagini/' + divertimento + '.jpg';
        document.getElementsByName('divertimento')[0].checked = true;
    } else {
        document.getElementById('divertimento').src = '../immagini/pre_divertimento.jpg';
    }

    if (urlParams.has('relax')) {
        var relax = urlParams.get('relax');
        document.getElementById('relax').src = '../immagini/' + relax + '.jpg';
        document.getElementsByName('relax')[0].checked = true;
    } else {
        document.getElementById('relax').src = '../immagini/pre_relax.jpg';
    }
}

function onScroll() {
    window.scrollTo(0, 800);
}