<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des colos
    $stmt = $pdo->query("SELECT * FROM colos ORDER BY date_creation DESC");
    $colos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p style='color:red;'>Erreur de connexion à la base de données : " . $e->getMessage() . "</p>";
    $colos = [];
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/User/Nos%20Colos.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../JS/ModalColo.js"></script>
    <title>Centre Jean Pouzet</title>
    <script src="../../JS/Header.js"></script>
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
</head>
<body>
<?php $currentPage = 'colos'; ?>
<?php require_once '../Includes/Header.php'; ?>
    <main>

        <section class="sectionIntro">
            <div class="ContainerIntro">
                <div class="ContenuIntro">
                    <p id="ParagrapheIntro">Le Centre Jean Pouzet, en plus d’être un centre de vacances et d’hébergement, organise chaque année depuis 1949 ses propres colonies de vacances.
                         Une semaine en hiver (sur les vacances de février) et 10 jours en été (en juillet). 
                         Ces séjours sont organisés par les anciens colons et les membres actuels de l’association. 
                    </p>
                </div>
                <div class="ContenuIntro">
                    <p>
                        <b><u>Au programme</u></b> <br><br>  

                        L’hiver les activités se concentrent autour du ski, du snow et du biathlon.
                        L’été, place à la randonnée et aux activités de montagne estivale comme le canyoning ou la via ferrata. 
                        Notre objectif pédagogique, en toute saison, est de faire découvrir l’univers de la montagne aux enfants entre 6 et 17 ans. 
                        Apprendre sur soi en groupe, dans un environnement que l’on ne connaît pas, apprendre à le respecter, à l’aimer, à vivre avec lui et à dépasser ses limites.

                    </p>
                </div>
                <div class="ContenuIntro">
                    <p>
                        <b> <u>Encadrement</u> </b> <br><br>

                        Nos animateurs et animatrices sont des professionnels de l’animation, pour les activités les groupes sont encadrés par des personnes diplômés d’État
                        et des guides de haute-montagne. 

                    </p>
                </div>
                <div class="ContenuIntro">
                    <p>
                        Une phrase est devenue célèbre à la colo “qui vient à Guchen, toujours y revient”. Et on espère vous y voir bientôt ! 
                        Les séjours sont mis en ligne sur ce site et sur nos réseaux sociaux alors n’hésitez pas à nous suivre sur Instagram et Facebook. 
                        Pour toute demande d’inscription : <a href="mailto:colo@centrejeanpouzet.fr"> colo@centrejeanpouzet.fr </a>
                    </p>
                </div>
                <div class="button">
                    <button onclick="document.getElementById('sectionArchives').scrollIntoView({ behavior: 'smooth' })">Nos photos d'archives</button>
                </div>
                
            </div>
        </section>

        <?php foreach ($colos as $index => $colo): ?>
            <section class="sectionColo">
                <h2 class="sectionColo-title text-center fw-bold mb-4"><?= htmlspecialchars($colo['titre']) ?></h2>

                <div class="sectionColo-grid <?= $index % 2 === 0 ? '' : 'reverse-grid' ?>">
                    <!-- Colonne affiche -->
                    <div class="affiche-col d-flex justify-content-center align-items-center">
                        <img src="<?= htmlspecialchars($colo['affiche']) ?>"
                             alt="Affiche <?= htmlspecialchars($colo['titre']) ?>"
                             class="affiche-img">
                    </div>

                    <!-- Colonne photos -->
                    <div class="photos-col">
                        <div class="gallery-grid">
                            <?php for ($i = 1; $i <= 6; $i++):
                                $img = htmlspecialchars($colo["image$i"]);
                                if ($img): ?>
                                    <div class="gallery-img-wrapper">
                                        <img src="<?= $img ?>" alt="Image <?= $i ?>" class="gallery-img modal-img">
                                    </div>
                                <?php endif; endfor; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>




        <section id="sectionArchives">
            <div class="archives-bootstrap py-5">
                <div class="container">
                    <h1 class="text-center mb-5">Nos archives</h1>

                    <div class="row g-5">
                        <?php
                        $images = [
                            "IMG_8011.jpg" => "Rassemblement dans la prairie, date inconnue.",
                            "IMG_8482.jpg" => "Les patrouilles pour dormir à 8, années 70.",
                            "IMG_8490.jpg" => "Randonnée en altitude, année inconnue.",
                            "IMG_8489.jpg" => "Le bivouac des ados. Année inconnue.",
                            "IMG_8478.jpg" => "Foot dans la prairie, années 90.",
                            "IMG_8477.jpg" => "Veillée jeux dans la prairie, années 60.",
                            "IMG_8487.jpg" => "Les totems, groupe des grands, années 90.",
                            "IMG_8488.jpg" => "Spectacle des petits, années 70.",
                            "IMG_8475.jpg" => "Les animateurs du séjour, années 60.",
                            "IMG_8473.jpg" => "Le terrain de foot et la salle de jeux, années 90.",
                            "IMG_8469.jpg" => "Le Centre et le clocher de Guchen. Année inconnue.",
                            "IMG_8463.jpg" => "Jeu dans la prairie. Année inconnue."
                        ];

                        foreach ($images as $file => $alt): ?>
                            <div class="col-6 col-md-3 d-flex justify-content-center align-items-center">
                                <img src="../../Images/Photo%20archives/<?= $file ?>"
                                     class="img-fluid modal-img rounded shadow"
                                     alt="<?= $alt ?>"
                                     style="cursor:pointer;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>


    </main>
<?php
require_once '../Includes/Footer.php';
?>

<!-- Modal pour image -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

</body>
</html>