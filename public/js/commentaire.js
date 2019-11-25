//attend que le DOM soit chargé
$( document ).ready(function(){

    const loadMoreComment = $("#loadMoreCom");
    const loadMoreComDiv = $("#loadMoreComDiv");
    const animGifajax = $("#ajax-loading-com");

    const dataComment = $("#dataComment");// recupere les informations pour le javascript
    const route = dataComment.data("route");// route pour l'appel ajax

    let nbCom = dataComment.data("total");// total de comments enregistré en Bdd
    let nbTotalComment;// initialisation du total de comments

    //Pour afficher le load more ap partir de 6 commentaires
    if(nbCom < 6){
        loadMoreComDiv.remove();
    }

    animGifajax.hide(); // On masque le gif au chargement de la page

    loadMoreComment.click(function(e){
        animGifajax.show();// On montre le gif pour le chargement des tricks
        let nbComment = $(".alert.alert-info.comment").length; //Nombre de comment avant l'appel ajax

        e.preventDefault();
        $.ajax({
            url: route,
            type: "POST",
            data: { "nbComment": nbComment }

        }).done(function(data){

            //recupere l'emplacement
            const placeToInsert = $("#insertComment");

            //insertion avec boucle
            for(let i=0; i<data.length;i++){

                let divRowCom = document.createElement("div");
                divRowCom.className = "row d-flex justify-content-center";

                let divUser = document.createElement("div");
                divUser.className = "col-md-1 col-sm-2 col-2";
                divUser.textContent = data[i].author;

                let iUser = document.createElement("i");
                iUser.className = "fas fa-user-circle fa-3x";

                let divComContent = document.createElement("div");
                divComContent.className = "col-md-8 col-sm-8 col-8";

                let smallDate = document.createElement("small");
                smallDate.textContent = "Le "+data[i].createdAt;

                let divAlert = document.createElement("div");
                divAlert.className = "alert alert-info comment";
                divAlert.innerHTML = data[i].contentCom;

                divUser.append(iUser);
                divRowCom.append(divUser);

                divComContent.append(smallDate);
                divComContent.append(divAlert);

                divRowCom.append(divComContent);
                placeToInsert.append(divRowCom);

                //Nombre total de comments affiché
                nbTotalComment = nbComment + data.length;

                //****Verifie le total pour supprimer le bouton load more
                if (nbTotalComment === nbCom){
                    loadMoreComDiv.remove();
                }
            }
            animGifajax.hide(); // On masque le gif
        });

    });

});