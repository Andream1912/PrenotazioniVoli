var price = document.getElementById("totalPrice");
const priceconst = parseFloat(price.textContent.slice(0, 6));

function handleChange(src) {
    const two = document.getElementById("twoluggage");
    const one = document.getElementById("oneluggage")
    const zero = document.getElementById("noluggage")
    if (two.checked == false) {
        two.parentElement.parentElement.style.backgroundColor = "#f2f2f2";
        two.parentElement.parentElement.style.color = "black";

    }
    if (one.checked == false) {
        one.parentElement.parentElement.style.backgroundColor = "#f2f2f2";
        one.parentElement.parentElement.style.color = "black";
    }
    if (zero.checked == false) {
        zero.parentElement.parentElement.style.backgroundColor = "#f2f2f2";
        zero.parentElement.parentElement.style.color = "black";
    }
    const x = src.parentElement.parentElement;
    x.style.backgroundColor = "rgb(4, 39, 89)"
    x.style.color = "white"
    newPrice = priceconst + parseFloat(src.value);
    if (document.getElementById("ticket2") != null) {
        newPrice = newPrice * 2;
    }
    price.innerHTML = newPrice.toFixed(2) + " € ";
}

function onlyLettersSpacesDots(str) {
    return /^[a-zA-Z\s.,]+$/.test(str);
}

function checkPersonalData() {
    nome = document.getElementById("nome");
    cognome = document.getElementById("cognome");
    indirizzo = document.getElementById("indirizzo");
    numero = document.getElementById("numero");
    datanascita = document.getElementById("datanascita");
    cap = document.getElementById("cap");
    luogonascita = document.getElementById("luogonascita");
    nazionalita = document.getElementById("nazionalita");
    ccn = document.getElementById("ccn");
    month = document.getElementById("month");
    year = document.getElementById("year");
    cvv = document.getElementById("cvv");
    if (nome.value == "" || cognome.value == "" || datanascita.value == "" || numero.value == "" || indirizzo.value == "" || cap.value == "" || nazionalita.value == "" || luogonascita.value == "" || ccn.value == "" || month.value == "" || year.value == "" || cvv.value == "" || year.value < 2022 || year.value > 3000 || month.value > 12 || month.value == 0 || ((!onlyLettersSpacesDots(nome.value)) && (!onlyLettersSpacesDots(cognome.value)) && (!onlyLettersSpacesDots(luogonascita.value)) && (!onlyLettersSpacesDots(indirizzo.value)) && (!onlyLettersSpacesDots(nazionalita.value)))) {
        if (nome.value == "" || cognome.value == "" || luogonascita.value == "" || indirizzo.value == "" || cap.value == "") {
            window.scrollTo(0, 200);
        } else if (nazionalita.value == "" || datanascita.value == "" || numero.value == "") {
            window.scrollTo(0, 600);
        } else {
            window.scrollTo(0, 1000);
        }
        if (nome.value == "") {
            nome.style.borderColor = "red";
            nome.previousSibling.innerHTML = "Inserisci il tuo nome";
        } else {
            nome.style.borderColor = "#f0f0f0";
            nome.previousSibling.innerHTML = "";
        }
        if (cognome.value == "") {
            cognome.style.borderColor = "red";
            cognome.previousSibling.innerHTML = "Inserisci il tuo cognome";
        } else {
            cognome.style.borderColor = "#f0f0f0";
            cognome.previousSibling.innerHTML = "";
        }
        if (luogonascita.value == "") {
            luogonascita.previousSibling.innerHTML = "Inserisci luogo di nascita";
            luogonascita.style.borderColor = "red";
        } else {
            luogonascita.style.borderColor = "#f0f0f0";
            luogonascita.previousSibling.innerHTML = "";
        }
        if (indirizzo.value == "") {
            indirizzo.previousSibling.innerHTML = "Inserisci il tuo indirizzo";
            indirizzo.style.borderColor = "red";
        } else {
            indirizzo.style.borderColor = "f0f0f0";
            indirizzo.previousSibling.innerHTML = "";
        }
        if (cap.value == "") {
            cap.previousSibling.innerHTML = "Inserisci il tuo luogo CAP";
            cap.style.borderColor = "red";
        } else {
            cap.style.borderColor = "#f0f0f0";
            cap.previousSibling.innerHTML = "";
        }
        if (nazionalita.value == "") {
            nazionalita.previousSibling.innerHTML = "Inserisci la tua nazionalit&agrave";
            nazionalita.style.borderColor = "red";
        } else {
            nazionalita.style.borderColor = "#f0f0f0";
            nazionalita.previousSibling.innerHTML = "";
        }
        if (datanascita.value == "") {
            datanascita.style.borderColor = "red";
        } else {
            datanascita.style.borderColor = "#f0f0f0";
        }
        if (numero.value == "") {
            numero.previousSibling.innerHTML = "Inserisci il tuo numero";
            numero.style.borderColor = "red";
        } else {
            numero.style.borderColor = "#f0f0f0";
        }
        if (ccn.value == "") {
            ccn.style.borderColor = "red";
        } else {
            ccn.style.borderColor = "#f0f0f0"
        }
        if (month.value == "") {
            month.style.border = "2px solid";
            month.style.borderColor = "red";
        } else if (month.value > 12 || month.value == 0) {
            month.style.border = "2px solid";
            month.style.borderColor = "red";
        } else {
            month.style.border = "none";

        }
        if ((year.value == "") || (year.value < 2022) || (year.value > 3000)) {
            year.style.border = "2px solid";
            year.style.borderColor = "red";
        } else {
            year.style.border = "none";
        }
        if (cvv.value == "") {
            cvv.style.borderColor = "red";
        } else {
            cvv.style.borderColor = "#f0f0f0"
        }
        if (!onlyLettersSpacesDots(nome.value)) {
            if (nome.previousSibling.textContent == "") {
                nome.previousSibling.innerHTML = "Non sono ammessi numeri o caratteri speciali";
            }
            nome.style.borderColor = "red";
        } else {
            nome.style.borderColor = "#f0f0f0";
        }
        if (!onlyLettersSpacesDots(cognome.value)) {
            if (cognome.previousSibling.textContent == "") {
                cognome.previousSibling.innerHTML = "Non sono ammessi numeri o caratteri speciali";
            }
            cognome.style.borderColor = "red";
        } else {
            cognome.style.borderColor = "#f0f0f0";
        }
        if (!onlyLettersSpacesDots(luogonascita.value)) {
            if (luogonascita.previousSibling.textContent == "") {
                luogonascita.previousSibling.innerHTML = "Non sono ammessi numeri o caratteri speciali";
            }
            luogonascita.style.borderColor = "red";
        } else {
            luogonascita.style.borderColor = "#f0f0f0";
        }
        if (!onlyLettersSpacesDots(indirizzo.value)) {
            if (indirizzo.previousSibling.textContent == "") {
                indirizzo.previousSibling.innerHTML = "Non sono ammessi numeri o caratteri speciali";
            }
            indirizzo.style.borderColor = "red";
        } else {
            indirizzo.style.borderColor = "#f0f0f0";
        }
        if (!onlyLettersSpacesDots(nazionalita.value)) {
            if (nazionalita.previousSibling.textContent == "") {
                nazionalita.previousSibling.innerHTML = "Non sono ammessi numeri o caratteri speciali";
            }
            nazionalita.style.borderColor = "red";
        } else {
            nazionalita.style.borderColor = "#f0f0f0";
        }
        return false;
    } else {
        return true;
    }
}
input = document.querySelector('.ccn');
input.addEventListener('input', updateValue);

function updateValue(e) {
    if ((e.target.value[0]) == 4) {
        document.querySelector('.mastercard').style.visibility = 'visible';
    } else if (((e.target.value[0] == 2) || (e.target.value[0] == 5))) {
        document.querySelector('.visa').style.visibility = 'visible';
    } else {
        document.querySelector('.mastercard').style.visibility = 'hidden';
        document.querySelector('.visa').style.visibility = 'hidden';


    }
}