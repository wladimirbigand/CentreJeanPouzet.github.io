<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
    <link rel="stylesheet" href="../../CSS/User/Accueil.css">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <link rel="stylesheet" href="../../CSS/User/Actus.css">
    <script src="../../JS/Header.js"></script>
    <script src="../../JS/Actus.js" async></script>
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
</head>
<body>
<?php $currentPage = 'actus'; ?>
<?php require_once '../Includes/Header.php'; ?>

    <main>
        <h1>Nos actualités</h1>
        <section id="main_container">
           
            <div class="actus">
                <a title="Les inscriptions pour le séjour de ski sont ouvertes ">
                    <div>
                        <img src="../../Images/Nos%20colos/AFFICHE%20SKI%202025_page-0001.jpg" alt="" class="images">
                    </div>
                </a>
                <div>
                    <h1 class="titre">Les inscriptions pour le séjour de ski sont ouvertes </h1>
                </div>
                <div>
                    <p>Les inscriptions pour le séjour de ski sont ouvertes ! Du 2 au 7 mars 2025 envoyez vos enfants skier dans les Hautes-Pyrénées. Au programme 4 jours complets de ski et 1 journée d’initiation au biathlon. Tous niveaux pour les 7 à 17 ans. Départ d’Agen (47) ou dépôt à Guchen possible. Contactez-nous pour plus d’informations. </p>
                </div>
            </div>
       
            <div class="actus">
                <a title="Bonne année 2025 !">
                    <div>
                        <img src="../../Images/Actus/2025_ACTUS.jpg" alt="" class="images">
                    </div>
                </a>
                <div>
                    <h1 class="titre">Bonne année 2025 !</h1>
                </div>
                <div>
                    <p>Pour la 4ème édition du nouvel an à Jean Pouzet, le Centre a organisé sa soirée…
                        50 couverts et une bonne bande pour fêter le réveillon et surtout… Santé et meilleurs voeux !</p>
                </div>
            </div>
       
            <div class="actus">
                <a title="Classe découverte">
                    <div>
                        <img src="../../Images/Actus/CLASSE_DECOUVERTE_1.jpg" alt="" class="images">
                    </div>
                </a>
                <div>
                    <h1 class="titre">Classe découverte !</h1>
                </div>
                <div>
                    <p>Nous avons eu le plaisir d'accueillir pour la deuxième année consécutive les élèves de la terminale Sapat service aux personnes et Animation des territoires du Lycée Antoine de Saint-Exupéry de Vitré. Ils sont venus sur 1 semaine afin de découvrir le territoire montagnard, ont été à la rencontre des locaux , la chèvrerie de Gouaux,  la laine mohaire, le directeur adjoint de la station Peyragudes, une sortie raquette avec Xavier et 2 autres guides de hautes montagnes.
                        Un chouette moment de partage et de découverte. À l’année prochaine ;) !</p>
                </div>
            </div>
       
            <div class="actus">
                <a title=" La saison hivernale est lancée !">
                    <div>
                        <img src="../../Images/Actus/SAISON_HIVERNALE.JPG" alt="" class="images">
                    </div>
                </a>
                <div>
                    <h1 class="titre"> La saison hivernale est lancée !</h1>
                </div>
                <div>
                    <p>La neige est là, il ne manque plus que vous. Le chalet est disponible à la réservation en direct ou sur Airbnb et Le Bon Coin. Quand au bâtiment envoyez-nous un mail pour vos devis de groupe et réservations : info@centrejeanpouzet.fr
                    </p>
                </div>
            </div>
       
            <div class="actus">
                <a href="actu_container" title="Entreprises">
                    <div>
                        <img src="../../Images/Actus/entreprises.jpg" alt="" class="images">
                    </div>
                </a>
                <div>
                    <h1 class="titre">Ces entreprises qui nous font confiance ! </h1>
                </div>
                <div>
                    <p>Le Centre Jean Pouzet est à même de proposer des séjours (nuitées et pension) à différentes entreprises pour leur permettre d’organiser leurs séminaires. Nous avons sur l’année 2024/2025 reçu : Airbus, Thalès, Decathlon.</p>
                </div>
            </div>
       
            <div class="actus">
                <a href="#" title="Pause bien-être">
                    <div>
                        <img src="../../Images/Actus/vélo.jpg" alt="" class="images">
                    </div>
                </a>
                <div>
                    <h1 class="titre">Les Pyrénées à vélo !</h1>
                </div>
                <div>
                    <p>Pla d’Adet, Tourmalet, Col d’Aspin, Peyresourdes… Les Pyrénées offrent pléthore de lieux emblématiques pour les passionnés de vélo. Et pour cause, le Centre accueille chaque année des clubs et groupes de cyclistes afin qu’ils se reposent entre leurs différentes étapes et entraînements. </p>
                </div>
            </div>
        </section>
       
   
   
            <section id="actu_container">
                <a id="chosen_actu">
                    <div>
                        <img src="" alt="" id="chosen_img">
                    </div>
                </a>
           
                <div>
                    <h1 id="chosen_titre"></h1>
                </div>
           
                <div>
                    <p id="chosen_text"></p>
                </div>
        </section>
       
   
        </main>

<?php
require_once '../Includes/Footer.php';
?>
</body>
</html>