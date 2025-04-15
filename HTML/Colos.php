<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Nos Colos.css">
    <link rel="stylesheet" href="../CSS/Header.css">
    <link rel="stylesheet" href="../CSS/Footer.css">
    <link rel="stylesheet" href="../CSS/Fonts.css">
    <script src="../JS/ModalColo.js"></script>
    <title>Centre Jean Pouzet</title>
    <script src="../JS/Header.js"></script>
    <link rel="icon" type="image/vnd.icon" href="../Images/Logo/logo.png">
</head>
<body>
<?php $currentPage = 'colos'; ?>
<?php require_once '../Includes/header.php'; ?>
    <main>
        <div id="myModal" class="modal">
            <!-- Bouton de fermeture -->
            <span class="close">&times;</span>
          
            <!-- Modal Content (The Image) -->
            <img class="modal-content" id="img01">
          
            <!-- Modal Caption (Image Text) -->
            <div id="caption"></div>
        </div>

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

        <section class="sectionSKI">
            <div class="Container">
                <div class="title">
                    <H1>Colo d'hiver 2025</H1>    
                </div>
                <div class="Container1">
                    <div class="ContainerIMG">
                        <div><img src="../Images/PHOTOS VRAC COLO/IMG_8473.jpg" id="IMG" alt="Image1"></div>
                        <div><img src="../Images/PHOTOS VRAC COLO/IMG_8475.jpg" id="IMG" alt="Image2"></div>
                        <div><img src="../Images/PHOTOS VRAC COLO/IMG_8477.jpg" id="IMG" alt="Image3"></div>
                    </div>
                    <div class="ContainerIMG">
                        <div><img src="../Images/PHOTOS VRAC COLO/IMG_8478.jpg" id="IMG" alt="Image4"></div>
                        <div><img src="../Images/PHOTOS VRAC COLO/IMG_8482.jpg" id="IMG" alt="Image5"></div>
                        <div><img src="../Images/PHOTOS VRAC COLO/IMG_8487.jpg" id="IMG" alt="Image6"></div>
                    </div>
                </div>
            </div>
            <div class="IMG">
                <img src="../Images/Nos colos/AFFICHE SKI 2025_page-0001.jpg" alt="Affiche ski">
            </div>
        </section>
        
        <section class="sectionETE">
            <div class="IMG">
                <img src="../Images/Nos colos/Affiche séjour 2024 été_page-0001.jpg" alt="Affiche été">
            </div>
            <div class="Container">
                <div class="title">
                    <H1>Colo d'été 2024</H1>
                </div>
            <div class="Container1">
                <div class="ContainerIMG">
                    <div><img src="../Images/Nos colos/photo été 1.jpeg" id="IMG" alt="Image7"></div>
                    <div><img src="../Images/Nos colos/photo été 2.jpeg" id="IMG" alt="Image8"></div>
                    <div><img src="../Images/Nos colos/photo été 4.jpeg" id="IMG" alt="Image9"></div>
                </div>
                <div class="ContainerIMG">
                    <div><img src="../Images/Nos colos/IMG_6612.jpg" id="IMG" alt="Image10"></div>
                    <div><img src="../Images/Nos colos/photo été 6.jpeg" id="IMG" alt="Image11"></div>
                    <div><img src="../Images/Nos colos/photo été 7.jpeg" id="IMG" alt="Image12"></div>
                </div>
            </div>
            </div>
        </section>

        <section id="sectionArchives">
            <div class="titleArchives">
                <H1>Nos archives</H1>
            </div>
            <div class="ContainerArchives">
                <div class="ContainerIMGArchives">
                    <div><img src="../Images/Photo archives/IMG_8011.jpg" id="IMG" alt="Rassemblement dans la prairie, date inconnue."></div> 
                    <div><img src="../Images/Photo archives/IMG_8482.jpg" id="IMG" alt="Les patrouilles pour dormir à 8, années 70."></div>
                    <div><img src="../Images/Photo archives/IMG_8490.jpg" id="IMG" alt="Randonnée en altitude, année inconnue."></div>
                    <div><img src="../Images/Photo archives/IMG_8489.jpg" id="IMG" alt="Le bivouac des ados. Année inconnue."></div>
                </div>
                <hr>
                <div class="ContainerIMGArchives">
                    <div><img src="../Images/Photo archives/IMG_8478.jpg" id="IMG" alt="Foot dans la prairie, années 90."></div>
                    <div><img src="../Images/Photo archives/IMG_8477.jpg" id="IMG" alt="Veillée jeux dans la prairie, années 60."></div>
                    <div><img src="../Images/Photo archives/IMG_8487.jpg" id="IMG" alt="Les totems, groupe des grands, années 90."></div>
                    <div><img src="../Images/Photo archives/IMG_8488.jpg" id="IMG" alt="Spectacle des petits, années 70."></div>
                </div>
                <hr>
                <div class="ContainerIMGArchives">
                    <div><img src="../Images/Photo archives/IMG_8475.jpg" id="IMG" alt="Les animateurs du séjour, années 60."></div>
                    <div><img src="../Images/Photo archives/IMG_8473.jpg" id="IMG" alt="Le terrain de foot et la salle de jeux, années 90."></div>
                    <div><img src="../Images/Photo archives/IMG_8469.jpg" id="IMG" alt=" Le Centre et le clocher de Guchen. Année inconnue."></div>
                    <div><img src="../Images/Photo archives/IMG_8463.jpg" id="IMG" alt="Jeu dans la prairie. Année inconnue."></div>
                </div>
                <!-- <hr> -->
            </div>
        </section>

    </main>
<?php
require_once '../Includes/Footer.php';
?>
</body>
</html>