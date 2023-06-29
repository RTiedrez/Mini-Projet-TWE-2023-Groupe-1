// header.php
function colorierLiens() {
    // Colorier le lien correspondant à la page active 
    var url = window.location.href;
    var page = url.split("view=")[1];
    if (page == undefined) {
        page = "home";
    }
    $("#"+page).addClass("selected");

}