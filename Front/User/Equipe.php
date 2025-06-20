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
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <link rel="stylesheet" href="../../CSS/User/Equipe.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../JS/Header.js"></script>
    <link rel="icon" href="../../Images/Logo/logo.png">
</head>
<body>
<?php
$currentPage = 'equipe';
require_once '../Includes/Header.php';

?>

<style>
    .color {
        background-color: #9DBD91;
    }

    main {
        background-color: #f5f1e1;
    }

    .button {
        background-color: #9DBD91;
        color: red;
    }
</style >
<main class="py-5">
    <?php
    $stmt = $equipe->query('SELECT * FROM equipe');
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $chunks = array_chunk($results, 2); // 2 personnes par slide
    ?>

    <div class="container">
        <div id="carouselEquipe" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($chunks as $index => $group): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row justify-content-center text-center">
                            <?php foreach ($group as $row): ?>
                                <div class="col-md-4 rounded p-4 d-flex flex-column">
                                    <img src="../../Images/Equipe/<?= htmlspecialchars($row['img']) ?>" class="img-fluid rounded border border-warning mb-3" alt="Portrait de <?= htmlspecialchars($row['name']) ?>">
                                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                                    <p class="fw-bold text-secondary"><?= htmlspecialchars($row['role']) ?></p>
                                    <p class="text-muted small"><?= htmlspecialchars($row['description']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselEquipe" data-bs-slide="prev">
                <span class="carousel-control-prev-icon color" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselEquipe" data-bs-slide="next">
                <span class="carousel-control-next-icon color" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>

</main>


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

        // Combien de cartes sont visibles (toujours cohérent avec le CSS) :
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

<?php require_once '../Includes/Footer.php'; ?>
<!-- Bootstrap 5 JS (optionnel si tu veux les composants interactifs comme le carrousel natif, modal, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>