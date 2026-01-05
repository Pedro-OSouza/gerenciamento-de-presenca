/* const toClose = document.querySelector(".toggle-closer")
const toggleCloserBtn = document.querySelector(".toggle-closer-btn")

function closeElememt(){
    toClose.toggleAttribute("hidden")
    if(toClose.hasAttribute("hidden")) toClose.style.display = "none"
    console.log(toClose)
}

toggleCloserBtn.addEventListener('click', closeElememt) */

export default function closer(elementTarget, elementSelector){
    if (typeof elementTarget === "string") elementTarget = document.querySelector(elementTarget)
    if(!elementTarget) return;

    const selector = typeof elementSelector === "string" ? document.querySelector(elementSelector) : elementSelector
    if(!selector) return;


    selector.addEventListener('click', () => {
        elementTarget.remove()
    })

}