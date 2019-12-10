function onClickBtnLike(event) {
    // annule le comportement du lien
    event.preventDefault()

    // recupère les element de la page
    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('i');

    axios.get(url).then(function(response) {
        // console.log(response);
        // recupère la variable likes dans la data de axios, voir console.log()
        spanCount.textContent = response.data.likes;

        // modification des icone <i> en fonction de leur affichage actuelle
        if(icone.classList.contains('fas')) icone.classList.replace('fas', 'far');
        else icone.classList.replace('far', 'fas');
    })
        // si le statut vaut 403 = utilisateur non connecté, renvoi alert
        .catch(function (error) {
            if(error.response.status === 403 ) {
                // window.alert('vous devez etre connecté pour aimé l\'article');
                // document.location.href="/login";

                // test dialogwindow
                // const favDialog = document.getElementById('dialogModal');
                // favDialog.showModal();
                // const dialogBtnLogin = document.getElementById('dialogBtnLogin');
                // function redirectLogin() {
                //     document.location.href="/login";
                // }
                // dialogBtnLogin.addEventListener('click', redirectLogin)
                // end test dialogwindow

            } else {
                //pour toute autre staut que 200 ou 403, afficher une alerte.
                window.alert('une erreur s\'est produite');
            }
        });
}
// recupére tous les liens <a> avec la classe js-like et boucle dessus
document.querySelectorAll('a.js-like').forEach(function(link){
    // ecoute l'evenement click de chaque lien et crée une fonction onClickBtnLike
    link.addEventListener('click', onClickBtnLike);
})