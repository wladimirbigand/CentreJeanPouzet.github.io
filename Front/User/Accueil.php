<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT image_fond FROM page_accueil WHERE id = 1");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    // Si aucune image n’est définie, on utilise une image par défaut
    $backgroundImage = isset($data['image_fond']) ? $data['image_fond'] : "/Images/Accueil/default.jpg";
} catch (PDOException $e) {
    $backgroundImage = "/Images/Accueil/default.jpg";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Centre Jean Pouzet</title>
    <link rel="stylesheet" href="../../CSS/User/Accueil.css">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/HeaderAccueil.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="../../JS/Header.js"></script>
    <!-- jQuery depuis le CDN de Google -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        /* Section 1 avec l'image de fond récupérée depuis la BDD */
        #section1 {
            background: url('<?php echo htmlspecialchars($backgroundImage); ?>') no-repeat center center/cover;
        }
    </style>
</head>
<body>
<header>
    <button class="burger-menu" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <nav>
        <a href="Accueil.php" class="active">NOTRE ASSOCIATION</a>
        <a href="Hebergements.php">NOS HEBERGEMENTS</a>
        <a href="Nous Contacter.php">NOUS CONTACTER</a>
        <a href="Actus.php">NOS ACTUS</a>
        <a href="Equipe.php">EQUIPE</a>
        <a href="Colos.php">NOS COLOS</a>
    </nav>
</header>

<main>
    <section id="section1">
        <div class="overlay">
            <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="">
            <button onclick="document.getElementById('section2').scrollIntoView({ behavior: 'smooth' })">En savoir plus</button>
        </div>
    </section>

    <section id="section2">
        <div id="text">
            <h1 class="title">Qui sommes-nous ?</h1>
            <p class="text">Le Centre Jean Pouzet est avant tout une association loi 1901 qui a pour vocation de permettre à toutes et tous de découvrir la montagne.
                Le site se compose d'hébergements (82 places) et d'un parc boisé clôturé de 1,5ha. Il convient aussi bien à des classes de découvertes qu'à des grands groupes : groupes scolaires, particuliers, comités d’entreprises, clubs de sport et randonneurs peuvent se réunir chez nous et profiter de nos formules de pensions toute l’année.
                <br>
                Et vous… C’est quand qu’on vous y retrouve ?
            </p>
        </div>
        <div class="images">
            <img class="ImageBW" src="../../Images/Accueil/B&W.png" alt="Image">
            <img class="ImageBW" src="../../Images/IMG_20230824_142853.jpg" alt="Image">
            <img class="ImageBW" src="../../Images/Accueil/B&W1.png" alt="Image">
        </div>
    </section>

    <section id="section3">

        <div id="text">
            <h1 class="title">Où sommes-nous ?</h1>
            <p class="text">Le Centre Jean Pouzet est situé au cœur de la Vallée d’Aure dans l’authentique village de Guchen, à 750m d’altitude !
                Aux portes du prestigieux Parc National des Pyrénées et à 6 km de Saint-Lary-Soulan la localisation du Centre offre des choix presque illimités d’activités ou de visites à faire à proximité toute l’année.
                Pour l’hiver, les premières stations de ski (Peyragudes, Saint-Lary-Soulan, Val-Louron, Piau-Engaly) se trouvent dans un rayon de 30 min.
                Pour l’été, outre le Tour de France qui passe quasiment chaque année devant la porte, des sociétés proposent du canyoning, du rafting, de l’accrobranche, de la trottinette, du VTT en montagne et de nombreux circuits de randonnées se font au départ du centre.… et beaucoup d’autres. Nos équipes se feront un plaisir de vous renseigner !
                Pour voir le détail des hébergements, rendez-vous dans l’onglet intitulé « hébergement » et pour toutes demandes de devis dans celui intitulé « nous contacter », à bientôt dans la vallée.
            </p>
        </div>
        <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2924.485360022628!2d0.33584437681092266!3d42.86259877115068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a86a7f925aec29%3A0x80f0c4cff3b2d62d!2sCentre%20de%20vacances%20Jean%20Pouzet!5e0!3m2!1sfr!2sfr!4v1732116567217!5m2!1sfr!2sfr"
                width="100%"
                height="350"
                style="border:0; border-radius: 8px;"
                allowfullscreen=""
                loading="lazy">
        </iframe>
    </section>
</main>
<?php require_once '../Includes/Footer.php'; ?>
</body>
</html>
