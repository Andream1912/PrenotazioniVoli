//definisco le costanti tramite i data attributes definiti in html
const multiStepForm = document.querySelector("[data-multi-step]")
const formSteps = [...multiStepForm.querySelectorAll("[data-step]")]

//definisco currentStep come lo step attuale controllando se ha la classe active
let currentStep = formSteps.findIndex(step => {
    return step.classList.contains("active")
})

//se non c'è  un active class la setta al primo elemento
if (currentStep < 0) {
    currentStep = 0
    showCurrentStep()
}

//gestisco il click sul bottone next e previous tramite un event listener
multiStepForm.addEventListener("click", e => {
    let incrementor
    if (e.target.matches("[data-next]")) {
        incrementor = 1
    } else if (e.target.matches("[data-previous]")) {
        incrementor = -1
    }
    //se non faccio nulla allora non incremento
    if (incrementor == null) return
        //creo costante contenente tutti gli input del mio step
    const inputs = [...formSteps[currentStep].querySelectorAll("input")]
        //creo una costante in grado di verificare se il mio input è valido o meno
    const allValid = inputs.every(input => input.reportValidity())
        //se gli input sono validi allora vado al prossimo step
    if (allValid) {
        currentStep += incrementor
        showCurrentStep()
    }
})

//definisco come non mostrare step non utilizzati 
formSteps.forEach(step => {
    step.addEventListener("animationend", (e) => {
        formSteps[currentStep].classList.remove("hide")
        e.target.classList.toggle("hide", !e.target.classList.contains("active"))
    })
})

//creo una funzione  che  mi permette di cambiare la classe di uno step in active e farla visualizzare di conseguenza
function showCurrentStep() {
    formSteps.forEach((step, index) => {
        step.classList.toggle("active", index === currentStep)
    })
}