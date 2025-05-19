<?php
include_once ('../../SQL/fonction_connexion.inc.php') ;
$equipe = connectionPDO('../../SQL/config');
?>

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
                    <?php
                    $stmt = $equipe->query('SELECT * FROM equipe');

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                        $name = htmlspecialchars($row['name'], ENT_QUOTES);
                        $img = '../../Images/Equipe/' . htmlspecialchars($row['img'], ENT_QUOTES);
                        $role = htmlspecialchars($row['role'], ENT_QUOTES);
                        $description = htmlspecialchars($row['description'], ENT_QUOTES);
                        ?>
                        <li class="carousel-slide">
                            <img src="<?= $img ?>" alt="Portrait de <?= $name ?>">
                            <div class="profile">
                                <h3><?= $name ?></h3>
                                <p class="role"><?= $role ?></p>
                                <p class="description"><?= $description ?></p>
                            </div>
                        </li>
                    <?php endwhile; ?>
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
