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

        // Met à jour la div #actu_container avec les nouvelles informations
        let chosenImg = divbox.querySelector('#chosen_img');
        let chosenTitre = divbox.querySelector('#chosen_titre');
        let chosenText = divbox.querySelector('#chosen_text');

        chosenImg.src = imgSrc;  // Met à jour l'image
        chosenTitre.innerText = titre;  // Met à jour le titre
        chosenText.innerText = texte;  // Met à jour le texte

        // Affiche la div #actu_container en ajoutant la classe 'show'
        divbox.classList.add('show');
    });
}

   // Vérifier si le clic s'est produit à l'intérieur de #actu_container
   if (!divbox.contains(event.target)) {
    // Si l'utilisateur clique à l'extérieur de la zone, on cache la div
    divbox.classList.remove('show');
};



document.getElementById('saveBtn').addEventListener('click', () => {
    fetch('sauvegarder_jours.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ openDays: Object.keys(openDays) })
    })
        .then(response => response.text())
        .then(data => {
            alert("Jours ouverts enregistrés !");
            console.log(data);
        })
        .catch(error => {
            alert("Erreur lors de l'enregistrement.");
            console.error(error);
        });
});
