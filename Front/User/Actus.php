<?php

session_start();
include_once ('../../SQL/fonction_connexion.inc.php');
$connect = connectionPDO('config');

$stmt = $connect->prepare("SELECT * FROM actus ORDER BY date DESC");
$stmt->execute();
$actus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
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
        <?php foreach ($actus as $a): ?>
            <div class="actus">
                <a title="<?= htmlspecialchars($a['titre']) ?>">
                    <img src="<?= htmlspecialchars($a['image']) ?>" alt="" class="images" loading="eager">
                </a>
                <div>
                    <h1 class="titre"><?= htmlspecialchars($a['titre']) ?></h1>
                </div>
                <div>
                    <p><?= nl2br(htmlspecialchars($a['texte'])) ?></p>
                    <p class="date"><?= nl2br(htmlspecialchars($a ['date'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>

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

        <div>
            Mis en ligne le <b><p id="chosen_date"> </p></b>
        </div>
    </section>


</main>

<?php
require_once '../Includes/Footer.php';
?>
</body>
</html>
