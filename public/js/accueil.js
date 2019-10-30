//attend que le DOM soit chargé
$( document ).ready(function(){
    //nombre de tricks affiché
    const loadMore = $("#loadMore");
    const loadMoreDiv = $("#loadMoreDiv");
    let nbTotalCard;//total de cards

    $('#ajax-loading').hide(); // On masque le gif au chargement de la page

    loadMore.click(function(e){
        $('#ajax-loading').show();// On montre le gif pour le chargement des tricks
        let nbCard = $(".card.border-info.trick-card").length;

        e.preventDefault();
        $.ajax({
            url: "/trick/more",
            type: "POST",
            data: { "nbCard": nbCard }

        }).done(function(data){
            //console.log(data);
            //recupere l'emplacement
            const placeToInsert = $(".row.mx-3");

            //insertion avec boucle
            for(let i=0; i<data.length;i++){

                let divAuto = document.createElement('div');
                divAuto.className = 'mx-auto my-5';

                let div = document.createElement('div');
                div.className = 'card border-info trick-card';

                let divHeader = document.createElement('div');
                divHeader.className = "card-header";

                let imageCover = document.createElement('img');
                imageCover.className = 'rounded img-fluid trick-picture';
                imageCover.alt = 'image du trick ' + data[i].titre;

                if(data[i].coverImage){
                    imageCover.src = 'uploads/images/' + data[i].coverImage;
                }else{
                    imageCover.src = 'imageApp/snowboard.jpg';
                }

                let divBody = document.createElement('div');
                divBody.className = 'card-body';

                let divRow = document.createElement('div');
                divRow.className = 'row';

                let divCol = document.createElement('div');
                divRow.className = 'col-12';

                let lienSlug = document.createElement('a');
                lienSlug.href = "/trick/" + data[i].slug;

                let titreCard = document.createElement('h4');
                titreCard.className = "card-title text-center";
                titreCard.textContent = data[i].titre;

                lienSlug.append(titreCard);
                divCol.append(lienSlug);
                divRow.append(divCol);
                divBody.append(divRow);
                divHeader.append(imageCover);
                div.append(divHeader);
                div.append(divBody);
                divAuto.append(div);
                placeToInsert.append(divAuto);


                //**** nombre total de trick
                const nbTrick = data[i].total;
                //Nombre total de card affiché
                nbTotalCard = nbCard + data.length;
                //****Verifie le total pour supprimer le bouton load more
                if (nbTotalCard === nbTrick){
                    loadMoreDiv.remove();
                }
            }

            $('#ajax-loading').hide(); // On masque le gif
        });

    });

});