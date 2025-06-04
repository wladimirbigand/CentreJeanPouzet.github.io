// Sélectionne la section #actu_container
let divbox = document.getElementById("actu_container");
let pd = document.getElementById('chosen_text');

// Sélectionne tous les éléments avec la classe .actus
let all_actus = document.getElementsByClassName("actus");

// Parcourt chaque élément .actus
for (let i = 0; i < all_actus.length; i++) {
    all_actus[i].addEventListener('click', function(event) {
        event.preventDefault();  // Empêche le comportement par défaut du lien

        //Scroll Into view
        setTimeout(() => {
            pd.scrollIntoView(
                {
                    behavior:"smooth",
                    block: 'start'
                }
            )
        }, 150);

        // Récupère les informations de l'élément cliqué
        let imgSrc = all_actus[i].getElementsByTagName('img')[0].src;  // Récupère la source de l'image
        let titre = all_actus[i].getElementsByClassName('titre')[0].innerText;  // Récupère le titre
        let texte = all_actus[i].getElementsByTagName('p')[0].innerText;  // Récupère le texte
        let date = all_actus[i].getElementsByClassName('date')[0].innerText;

        function formatDateFr(dateString) {
            const mois = [
                "janvier", "février", "mars", "avril", "mai", "juin",
                "juillet", "août", "septembre", "octobre", "novembre", "décembre"
            ];
            const dateObj = new Date(dateString);
            const jour = dateObj.getDate();
            const moisTexte = mois[dateObj.getMonth()];
            const annee = dateObj.getFullYear();
            return `${jour} ${moisTexte} ${annee}`;
        }

        // Met à jour la div #actu_container avec les nouvelles informations
        let chosenImg = divbox.querySelector('#chosen_img');
        let chosenTitre = divbox.querySelector('#chosen_titre');
        let chosenText = divbox.querySelector('#chosen_text');
        let chosenDate = divbox.querySelector('#chosen_date');

        chosenImg.src = imgSrc;  // Met à jour l'image
        chosenTitre.innerText = titre;  // Met à jour le titre
        chosenText.innerText = texte;  // Met à jour le texte
        chosenDate.innerText = formatDateFr(date);

        // Affiche la div #actu_container en ajoutant la classe 'show'
        divbox.classList.add('show');
    });
}

// Vérifier si le clic s'est produit à l'intérieur de #actu_container
if (!divbox.contains(event.target)) {
    // Si l'utilisateur clique à l'extérieur de la zone, on cache la div
    divbox.classList.remove('show');
};

