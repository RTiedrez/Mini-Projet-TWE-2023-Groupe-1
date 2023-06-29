// header.php
function colorierLiens() {
    // Colorier le lien correspondant à la page active 
    var url = window.location.href;
    var page = url.split("view=")[1];
    if (page == undefined) {
        page = "home";
    }
    $("#"+page).addClass("selected");

    $("#menu-image").click(function() {
        $("#dropdown").toggle();
    });

    // Cliquer sur le logo redirige vers l'accueil
    $("#logo").click(function() {
        window.location.href = "index.php?view=home";
    });

}