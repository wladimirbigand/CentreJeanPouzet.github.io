<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centre Jean Pouzet - Équipe</title>
    <link rel="stylesheet" href="../../CSS/User/Accueil.css">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Equipe.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <script src="../../JS/Header.js"></script>
    <link rel="icon" href="../../Images/Logo/logo.png">
</head>
<body>
<?php
$currentPage = 'equipe';
require_once '../Includes/Header.php';

$team = [
    [
        'name' => 'Xavier',
        'role' => 'Directeur de la structure',
        'img'  => '../../Images/Equipe/Xavier.jpg',
        'desc' => 'Xavier est salarié de l’association et travaille à l’intendance de la structure et à l’accueil des groupes. Il sera votre interlocuteur particulier concernant les devis et les réservations (hors colonie Jean Pouzet).'
    ],
    [
        'name' => 'Fabienne',
        'role' => 'Cheffe cuisinière',
        'img'  => '../../Images/Equipe/FABIENNE.jpg',
        'desc' => 'Fabienne est salariée de l’association et s’occupe de préparer avec ses équipes vos délicieux repas chauds et pique-niques. N’hésitez pas à lui dire quand vous vous êtes régalé !'
    ],
    [
        'name' => 'Olivier',
        'role' => 'Président de l’association',
        'img'  => '../../Images/Equipe/Olivier.png',
        'desc' => 'L’histoire d’amour entre Guchen et Olivier a commencé il y a un moment… Quand il est venu en colonie de vacances. Depuis il a été colons, animateur, sous-directeur de la colonie et maintenant Président de l’association. Demandez-lui les secrets du centre si vous le croisez il en connaît un paquet !'
    ],
    [
        'name' => 'Laurianne',
        'role' => 'Présidente adjointe',
        'img'  => '../../Images/Equipe/Laurianne.png',
        'desc' => 'Elle est tombée dans la marmite enfant ! Au total, tous ses frères et ses cousins ont été colons et animateurs… Étant la plus jeune… Il a bien fallu qu’elle continue dans les pas de ses anciens. Aujourd’hui Laurianne est animatrice sur les séjours d’été et d’hiver au centre et s’occupe de leur promotion et de leur organisation.'
    ],
    [
        'name' => 'Alice',
        'role' => 'Secrétaire générale',
        'img'  => '../../Images/Equipe/Alice.png',
        'desc' => 'Ancienne colon et animatrice, Alice s’occupe des réseaux sociaux et du digital de l’association (n’hésitez pas à nous taguer dans vos publications ou stories!) et participe à l’organisation des séjours de colonies de vacances.'
    ],
    [
        'name' => 'Iana',
        'role' => 'Trésorière',
        'img'  => '../../Images/Equipe/Iana.png',
        'desc' => "Iana découvre l'association lors d’un séjour de colonie de vacances où elle est animatrice… Elle n’a plus jamais coupé les ponts !"
    ],
    [
        'name' => 'Marie-Agnès',
        'role' => 'Secrétaire et trésorière',
        'img'  => '../../Images/Equipe/Marie-Agnès.png',
        'desc' => "Ancienne colon, animatrice et maintenant secrétaire et trésorière de la colonie de vacances, Marie-Agnès vous contactera en cas d'irrégularités alors : attention !"
    ]
];
?>
<main class="team-section">
    <div class="container">
        <!--        <h1 class="team-title">-->
        <!--            L’association du Centre Jean Pouzet est constituée d’un bureau associatif et de salariés. Découvrez notre équipe !-->
        <!--        </h1>-->
        <div class="carousel">
            <button class="carousel-btn prev-btn" aria-label="Précédent">←</button>
            <div class="carousel-track-container">
                <ul class="carousel-track">
                    <?php foreach ($team as $member): ?>
                        <li class="carousel-slide">
                            <img src="<?= $member['img'] ?>"
                                 alt="Portrait de <?= htmlspecialchars($member['name'], ENT_QUOTES) ?>">
                            <div class="profile">
                                <h3><?= htmlspecialchars($member['name'], ENT_QUOTES) ?></h3>
                                <p class="role"><?= htmlspecialchars($member['role'], ENT_QUOTES) ?></p>
                                <p class="description"><?= htmlspecialchars($member['desc'], ENT_QUOTES) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <button class="carousel-btn next-btn" aria-label="Suivant">→</button>
        </div>
    </div>
</main>

<?php require_once '../Includes/Footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', initCarousel);
    window.addEventListener('resize', debounce(initCarousel, 150));

    function initCarousel() {
        const track       = document.querySelector('.carousel-track');
        const slides      = Array.from(track.children);
        const prevBtn     = document.querySelector('.prev-btn');
        const nextBtn     = document.querySelector('.next-btn');
        let currentIndex  = 0;

        // On mesure largeur et gap dynamiquement
        const slideWidth  = slides[0].getBoundingClientRect().width;
        const gap         = parseFloat(getComputedStyle(track).gap) || 0;
        const step        = slideWidth + gap;

        // Combien de cartes sont visibles (toujours cohérent avec le CSS) :
        // on déduit visibleCount du ratio entre container et slideWidth
        const containerW  = document.querySelector('.carousel-track-container').getBoundingClientRect().width;
        const visibleCount = Math.round(containerW / step) || 1;

        // Calcul de l’index max
        const maxIndex    = slides.length - visibleCount;

        // Positionnement initial
        slides.forEach((slide, i) => {
            slide.style.left = `${step * i}px`;
        });

        // Fonction de déplacement
        const moveTo = i => {
            track.style.transform = `translateX(-${step * i}px)`;
        };

        // Bouton “Suivant”
        nextBtn.onclick = () => {
            currentIndex = (currentIndex < maxIndex) ? currentIndex + 1 : 0;
            moveTo(currentIndex);
        };
        // Bouton “Précédent”
        prevBtn.onclick = () => {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : maxIndex;
            moveTo(currentIndex);
        };
    }

    // Debounce pour éviter trop d’exécutions au resize
    function debounce(fn, ms) {
        let timer;
        return () => {
            clearTimeout(timer);
            timer = setTimeout(fn, ms);
        };
    }
</script>


</body>
</html>
