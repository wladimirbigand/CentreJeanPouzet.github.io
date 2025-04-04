document.addEventListener("DOMContentLoaded", () => {
    const burgerMenu = document.querySelector('.burger-menu');
    const nav = document.querySelector('header nav');
    
    burgerMenu.addEventListener('click', () => {
        burgerMenu.classList.toggle('open'); // Change l'état du burger
        nav.classList.toggle('open');       // Affiche/masque le menu
});
});

window.addEventListener('scroll', () => {
    const header = document.querySelector('header'); // Sélectionne l'élément <header> dans le DOM.

    if (window.scrollY > 1) { // Vérifie si l'utilisateur a défilé verticalement de plus de 50 pixels.
        header.classList.add('scrolled'); // Si oui, ajoute la classe 'scrolled' à l'élément <header>.
    } else {
        header.classList.remove('scrolled'); // Sinon, supprime la classe 'scrolled' de l'élément <header>.
    }
});

let lastScrollY = window.scrollY; // Stocke la dernière position de défilement.

window.addEventListener('scroll', () => {
    const header = document.querySelector('header'); // Sélectionne l'élément <header> dans le DOM.
    const currentScrollY = window.scrollY; // Position actuelle de défilement.

    if (currentScrollY > lastScrollY) {
        // Si l'utilisateur scrolle vers le bas, on masque le header.
        header.classList.add('hidden');
    } else {
        // Si l'utilisateur scrolle vers le haut, on affiche le header.
        header.classList.remove('hidden');
    }

    lastScrollY = currentScrollY; // Met à jour la position de défilement pour la prochaine vérification.
});
