//attend que le DOM soit chargé
$( document ).ready(function() {
    //************* Pour gerer le voir medias ***********
    const boutonSeeMedia = $("#see-media");
    const divMedia = $("div.row.my-3.col.mx-auto.media-trick");
    let nbMedia = $("div.col-lg-3.col-md-6.mb-3").length;

    if (nbMedia === 0) {
        boutonSeeMedia.remove();
    }

    //Permet de montrer les medias suite au click du bouton
    boutonSeeMedia.click(function () {
        this.style.display = "none";
        divMedia[0].style.display = "block";
    });
});
//*************************************************