<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centre Jean Pouzet - Équipe</title>
<!--    <link rel="stylesheet" href="../../CSS/User/Accueil.css">-->
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
<!--    <link rel="stylesheet" href="../../CSS/User/Equipe.css">-->
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
<style>
    .color {
        background-color: #F5F5E1;
    }

    main {
        background-color: #f5f1e1;
    }

    .button {
        background-color: #9DBD91;
        color: red;
    }
</style>
<main class="py-5">
    <div class="container">
        <div id="carouselEquipe" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $chunks = array_chunk($team, 2); // 3 membres par slide
                foreach ($chunks as $index => $group):
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row justify-content-center text-center">
                            <?php foreach ($group as $member): ?>
                                <div class="col-md-4 color rounded p-4 d-flex flex-column">
                                    <img src="<?= $member['img'] ?>" class="img-fluid rounded border border-warning mb-3" alt="Portrait de <?= htmlspecialchars($member['name']) ?>">
                                    <h3><?= htmlspecialchars($member['name']) ?></h3>
                                    <p class="fw-bold text-secondary"><?= htmlspecialchars($member['role']) ?></p>
                                    <p class="text-muted small"><?= htmlspecialchars($member['desc']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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


<?php require_once '../Includes/Footer.php'; ?>
<!-- Bootstrap 5 JS (optionnel si tu veux les composants interactifs comme le carrousel natif, modal, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

