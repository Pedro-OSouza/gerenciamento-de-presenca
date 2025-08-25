export default function autoDismiss(element, time = 5000, fade = true) {
    if (typeof (element) === "string") element = document.querySelector(element)
    if (!element) return;

    setTimeout(() => {
        if (fade) element.classList.add("fade-out")
        setTimeout(() => element.remove(), fade ? 300 : 0)
    }, time)
}