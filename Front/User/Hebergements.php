<?php
// Connexion à la BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$requetetxt = $pdo->query("SELECT * FROM section where id >200 and id < 250;");
$requeteimg = $pdo->query("SELECT * FROM multimedia where id >200 and id < 250;");
$hebergementsdataimg = $requeteimg->fetchAll(PDO::FETCH_ASSOC);
$hebergementsdatatxt = $requetetxt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <script src="../../JS/Header.js"></script>
    <script src="../../JS/ModalHebergements.js"></script>
    <script src="../../JS/hebergement.js" async></script>
    <script src="../../JS/carroussel.js" async></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MQ6+Fgj3wMPEe0iHYOgklxm3b5b+gkQjahLhRjz6kTd9k9uQ0s+F/gK+77hL847K" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../../CSS/User/Hebergements.css">
</head>
<body>
<?php $currentPage = 'hebergements'; ?>
<?php require_once '../Includes/Header.php'; ?>


<main>
    <section id="intro">
        <div class="contenuIntro">
            Le Centre Jean Pouzet c’est un parc boisé, une cuisine maison avec des produits de saison et bien-sûr
            des infrastructures : le bâtiment, le chalet et la salle de jeux.
            <br>
            <b>Cliquez sur ces logements pour lire leurs descriptions et en savoir plus.</b>
            <br>
            Le Centre propose deux formules d'hébergement :
            <div id='liste'>
                <ul>
                    <li>la pension complète (déjeuner, repas du midi, repas du soir)</li>
                    <li>la demi-pension (déjeuner et repas du soir)</li>
                    <li>la nuitée</li>
                    <li>la nuitée avec petit-déjeuner</li>
                </ul>
            </div>
            <p>Pour toutes demandes supplémentaires <a class="link" href="Nous Contacter.php">contactez-nous.</a></p>
        </div>
        <div class="ContenuPage">
            <div class="container">
                <div class="thumbex">
                    <div class="thumbnail">
                        <img src="../Admin/<?php echo $hebergementsdataimg[0]["chemin_acces"];?>" id='chalet'>
                        <span><?php echo $hebergementsdataimg[0]["image"]?></span>
                    </div>
                </div>
                <div class="thumbex">
                    <div class="thumbnail">
                        <img src="../Admin/<?php echo $hebergementsdataimg[1]["chemin_acces"];?>" id='batiment'>
                        <span><?php echo $hebergementsdataimg[1]["image"]?></span>
                    </div>
                </div>
                <div class="thumbex">
                    <div class="thumbnail">
                        <img src="../Admin/<?php echo $hebergementsdataimg[2]["chemin_acces"];?>" id='sallejeux'>
                        <span><?php echo $hebergementsdataimg[2]["image"]?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id='vert1'>
        <h3 class="titreimages">
            <?= htmlspecialchars($hebergementsdatatxt[0]['titre']) ?>
        </h3>
        <?php
        // On autorise seulement <strong>, <em>, <a> et <br>, et on supprime les autres <p>…
        $clean = strip_tags($hebergementsdatatxt[0]['description'], '<strong><em><a><br>');
        ?>
        <p class="textimage">
            <?= nl2br($clean) ?>
        </p>

        <div class="ContainerSlide">
            <div class="slideshow-container">

                <!-- Full-width images with number and caption text -->
                <!-- <div class="mySlides fade">
                <img src="../Images/hebergement/chalet1.png" style="width:100%;border-radius: 15px;">
                </div> -->

                <div class="mySlides fade">
                    <img src="../Admin/<?php echo $hebergementsdataimg[3]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides fade">
                    <img src="../Admin/<?php echo $hebergementsdataimg[4]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides fade">
                    <img src="../Admin/<?php echo $hebergementsdataimg[5]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides fade">
                    <img src="../Admin/<?php echo $hebergementsdataimg[6]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides fade">
                    <img src="../Admin/<?php echo $hebergementsdataimg[7]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides fade">
                    <img src="../Admin/<?php echo $hebergementsdataimg[8]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>
            <br>
            <!-- The dots/circles -->
            <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                <span class="dot" onclick="currentSlide(5)"></span>
                <span class="dot" onclick="currentSlide(6)"></span>
            </div>
        </div>
    </section>

    <br>

    <section id='vert2'>
        <h3 class='titreimages'><?php echo $hebergementsdatatxt[1]['titre'] ?></h3>
        <?php
        // On autorise seulement <strong>, <em>, <a> et <br>, et on supprime les autres <p>…
        $clean = strip_tags($hebergementsdatatxt[1]['description'], '<strong><em><a><br>');
        ?>
        <p class="textimage">
            <?= nl2br($clean) ?>
        </p>
        <div class="ContainerSlide1">
            <div class="slideshow-container1">

                <!-- Full-width images with number and caption text -->
                <!-- <div class="mySlides1 fade1">
                <img src="../Images/hebergement/batiment1.png" style="width:100%;border-radius: 15px;">
                </div> -->

                <div class="mySlides1 fade1">
                    <img src="../Admin/<?php echo $hebergementsdataimg[9]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides1 fade1">
                    <img src="../Admin/<?php echo $hebergementsdataimg[10]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides1 fade1">
                    <img src="../Admin/<?php echo $hebergementsdataimg[11]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides1 fade1">
                    <img src="../Admin/<?php echo $hebergementsdataimg[12]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides1 fade1">
                    <img src="../Admin/<?php echo $hebergementsdataimg[13]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides1 fade1">
                    <img src="../Admin/<?php echo $hebergementsdataimg[14]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <!-- Next and previous buttons -->
                <a class="prev1" onclick="plusSlides1(-1)">&#10094;</a>
                <a class="next1" onclick="plusSlides1(1)">&#10095;</a>
            </div>
            <br>
            <!-- The dots/circles -->
            <div style="text-align:center">
                <span class="dot1" onclick="currentSlide1(1)"></span>
                <span class="dot1" onclick="currentSlide1(2)"></span>
                <span class="dot1" onclick="currentSlide1(3)"></span>
                <span class="dot1" onclick="currentSlide1(4)"></span>
                <span class="dot1" onclick="currentSlide1(5)"></span>
                <span class="dot1" onclick="currentSlide1(6)"></span>
            </div>
        </div>
    </section>


    <br>


    <section id='vert3'>

        <h3 class='titreimages'><?php echo $hebergementsdatatxt[2]['titre'] ?></h3>
        <?php
        // On autorise seulement <strong>, <em>, <a> et <br>, et on supprime les autres <p>…
        $clean = strip_tags($hebergementsdatatxt[2]['description'], '<strong><em><a><br>');
        ?>
        <p class="textimage">
            <?= nl2br($clean) ?>
        </p>

        <div class="ContainerSlide2">
            <div class="slideshow-container2">

                <!-- Full-width images with number and caption text -->
                <div class="mySlides2 fade2">
                    <img src="../Admin/<?php echo $hebergementsdataimg[15]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides2 fade2">
                    <img src="../Admin/<?php echo $hebergementsdataimg[16]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides2 fade2">
                    <img src="../Admin/<?php echo $hebergementsdataimg[17]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides2 fade2">
                    <img src="../Admin/<?php echo $hebergementsdataimg[18]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides2 fade2">
                    <img src="../Admin/<?php echo $hebergementsdataimg[19]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>

                <div class="mySlides2 fade2">
                    <img src="../Admin/<?php echo $hebergementsdataimg[20]["chemin_acces"];?>" style="width:100%;border-radius: 15px;">
                </div>
                <!-- Next and previous buttons -->
                <a class="prev2" onclick="plusSlides2(-1)">&#10094;</a>
                <a class="next2" onclick="plusSlides2(1)">&#10095;</a>
            </div>
            <br>
            <!-- The dots/circles -->
            <div style="text-align:center">
                <span class="dot2" onclick="currentSlide2(1)"></span>
                <span class="dot2" onclick="currentSlide2(2)"></span>
                <span class="dot2" onclick="currentSlide2(3)"></span>
                <span class="dot2" onclick="currentSlide2(4)"></span>
                <span class="dot2" onclick="currentSlide2(5)"></span>
                <span class="dot2" onclick="currentSlide2(6)"></span>
            </div>
        </div>
    </section>

</main>

<?php
require_once '../Includes/Footer.php';
?>
<!-- Popper.js, nécessaire pour certains composants Bootstrap -->
<script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-vFmR4M6lM9WWJZt3UQp0QwSdwxvDjk5z0ulP7n3U0eiJQdkb5fB5Xn0ZUrpOe2nd"
        crossorigin="anonymous"
></script>

<!-- Bootstrap 5 JS -->
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-M0v4f7+zeZAd3vJXGy1LQ7kXfJupixz5/3Vq+aT+xy9ZZi8+Rp1U5mW7tXJj7Lu5"
        crossorigin="anonymous"
></script>

</body>
</html>