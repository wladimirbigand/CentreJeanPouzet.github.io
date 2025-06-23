<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer l'image d'accueil
    $stmt = $pdo->prepare("SELECT chemin_acces FROM Multimedia WHERE description = 'image_accueil' ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $backgroundImage = $data ? $data['chemin_acces'] : "../../Images/Accueil/3.jpg";

    // Récupérer les textes (id 1 = qui sommes-nous, id 2 = où sommes-nous)
    $stmt = $pdo->prepare("SELECT id, description FROM section WHERE id IN (1, 2)");
    $stmt->execute();
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $textQui = $textOu = "Texte non disponible.";

    foreach ($sections as $section) {
        if ($section['id'] == 1) $textQui = $section['description'];
        if ($section['id'] == 2) $textOu = $section['description'];
    }

} catch (PDOException $e) {
    $backgroundImage = "../../Images/Accueil/3.jpg";
    $textQui = "Erreur de connexion à la base de données.";
    $textOu = "Erreur de connexion à la base de données.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Centre Jean Pouzet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
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
        <a href="Accueil.php" class="active">NOTRE ASSO</a>
        <a href="Hebergements.php">NOS HEBERGEMENTS</a>
        <a href="Nous Contacter.php">NOUS CONTACTER</a>
        <a href="Actus.php">NOS ACTUS</a>
        <a href="Equipe.php">NOTRE EQUIPE</a>
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
            <p class="text"><?php echo $textQui; ?></p>
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
            <p class="text"><?php echo $textOu; ?></p>
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
