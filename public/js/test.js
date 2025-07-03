window.addEventListener("load", function () {
    if (!localStorage.getItem("popupShown")) {
        document.getElementById("popup").style.display = "block";
        document.getElementById("overlay").style.display = "block";
        document.body.style.overflow = "hidden";
        localStorage.setItem("popupShown", "true");
    }
});

function closePopup() {
    document.getElementById("popup").style.display = "none";
    document.body.style.overflow = "auto";
    document.getElementById("overlay").style.display = "none";
}
