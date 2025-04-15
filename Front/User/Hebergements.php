<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
    <link rel="stylesheet" href="../../CSS/User/Hebergements.css">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <script src="../../JS/Header.js"></script>
    <script src="../../JS/ModalHebergements.js"></script>
    <script src="../../JS/hebergement.js" async></script>
    <script src="../../JS/carroussel.js" async></script>
    <link rel="icon" type="image/vnd.icon" href="../Images/Logoù/logo.png">
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
                            <img src="../../Images/hebergement/chalet.jpg" id='chalet'>
                            <span>Chalet</span>
                        </div>
                    </div>
                    <div class="thumbex">
                        <div class="thumbnail">
                            <img src="../../Images/hebergement/batiment.jpg" id='batiment'>
                            <span>Batiment</span>
                        </div>
                    </div>
                    <div class="thumbex">
                        <div class="thumbnail">
                            <img src="../../Images/hebergement/sallejeux.jpg" id='sallejeux'>
                            <span>Salle de Jeux</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

        <section id='vert1'>
            <h3 class='titreimages'>Le Chalet</h3>
            <p class='textimage'>
                Le chalet se trouve au centre de la prairie,
                c’est un bâtiment indépendant. Il peut accueillir jusqu’à 14 personnes.
                Il est disponible avec les formules classiques du centre : pension, demi-pension,
                nuitée ou nuitée et petit déjeuner ou bien  <b>en gestion libre contrairement au reste du bâtiment.</b><br>
                Ce chalet dispose de deux dortoirs de 6 lits, d’une salle de bain commune avec 3 douches,
                4 lavabos et 2 toilettes. Au fond du couloir une salle à manger et cuisine toute équipée avec
                2 lits individuels supplémentaires. Il est possible de réserver pour
                le chalet en contactant le mail info@centrejeanpouzet.fr ou via
 
                <a class='lien' href='https://www.airbnb.fr/rooms/1005104591530298710?
                adults=1&viralityEntryPoint=1&s=76&unique_share_id=67CA596B-D710-4889-859C-B13DEB7F58EE&fbc
                lid=PAZXh0bgNhZW0CMTEAAaZt84IdVmH5qg5PrdwmY88zI-8pCoWfD15T9VTDrFM5b10RcDpHElpOpnQ_aem_e
                J0yy0NBdAAl-uku_XNhcg&_branch_match_id=1367507739982566449&_branch_referrer=H4sIAAAAAAA
                AAwXB3QqCMBgA0LfpzpyUZIHEcoYWmpWoeTM2nT%2F4tz4VqYuevXOqaZLjQVUZ7%2Fm6E2qzC%2FvomsGG8GPBs7b
                OzQCnSYV46VdpjCwvtDFm6WRs3TzqHP1d6gHkS%2FcyjK%2BrGNIa4oJoeriPQgJnT%2BcaemREOnYrb7K%2FUyY6Ki7
                o80H%2BKce4VeZmpolfZeXqB6IQAHVfUg7DMgown6xgUP8BA0cxSKUAAAA%3D&source_impression_id=p3_17333161
                11_P3RMcIwCCQvFSQ5M'>Airbnb</a>
               
                et
               
                <a class='lien' href='https://www.leboncoin.fr/ad/locations_saisonnieres/2430585807'>Le Bon Coin.</a>
            </p>



            <div class="ContainerSlide">
                <div class="slideshow-container">

                    <!-- Full-width images with number and caption text -->
                    <!-- <div class="mySlides fade">
                    <img src="../Images/hebergement/chalet1.png" style="width:100%;border-radius: 15px;">
                    </div> -->
                
                    <div class="mySlides fade">
                    <img src="../../Images/hebergement/chalet3.png" style="width:100%;border-radius: 15px;">
                    </div>
                
                    <div class="mySlides fade">
                    <img src="../../Images/hebergement/chalet6.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides fade">
                    <img src="../../Images/hebergement/chalet2.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides fade">
                    <img src="../../Images/hebergement/chalet5.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides fade">
                    <img src="../../Images/hebergement/chalet8.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides fade">
                    <img src="../../Images/hebergement/chalet7.png" style="width:100%;border-radius: 15px;">
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
                    <span class="dot" onclick="currentSlide(7)"></span>
                </div>
            </div>     
        </section>
        



        <br>
 


        <section id='vert2'>
            <h3 class='titreimages'>Le bâtiment</h3>
            <p class='textimage'>
                Le bâtiment principal est un lieu d'accueil
                pouvant loger jusqu’à 66 personnes. Les chambres sont de 2, 4 ou 6
                personnes avec des lits superposés (draps et oreillers fournis) et des sanitaires
                dans chacune d’entre elles avec douche lavabo et toilettes. Ce bâtiment dispose d’une chambre PMR.
                Dans ce même bâtiment se trouve la salle polyvalente, qui peut faire office de
                salle de jeux (babyfoot, billard…), de télé, de conférence, et même de
                salle de classe (tables et chaises disponibles).
                Au rez-de-chaussée se trouve le réfectoire pouvant accueillir
                jusqu’à 88 personnes assises, où les plats chauds sont servis.
                Veuillez nous contacter par mail pour toute demande de devis d’accueil de
                groupe à info@centrejeanpouzet.fr
            </p>
            

            <div class="ContainerSlide1">
                <div class="slideshow-container1">

                    <!-- Full-width images with number and caption text -->
                    <!-- <div class="mySlides1 fade1">
                    <img src="../Images/hebergement/batiment1.png" style="width:100%;border-radius: 15px;">
                    </div> -->
                
                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment9.png" style="width:100%;border-radius: 15px;">
                    </div>
                
                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment5.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment4.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment8.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment10.png" style="width:100%;border-radius: 15px;">
                    </div>
                    
                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment12.png" style="width:100%;border-radius: 15px;">
                    </div>
                    
                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment14.png" style="width:100%;border-radius: 15px;">
                    </div>
    
                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment13.png" style="width:100%;border-radius: 15px;">
                    </div>
    
                    <div class="mySlides1 fade1">
                    <img src="../../Images/hebergement/batiment2.png" style="width:100%;border-radius: 15px;">
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
                    <span class="dot1" onclick="currentSlide1(7)"></span>
                    <span class="dot1" onclick="currentSlide1(9)"></span>
                    <span class="dot1" onclick="currentSlide1(10)"></span>
                    <span class="dot1" onclick="currentSlide1(11)"></span>
                </div>
            </div> 
        </section>


        <br>

   
        <section id='vert3'>
 
            <h3 class='titreimages'>La salle de jeux</h3>
            <p class='textimage'>
                La salle de jeux est
                un bâtiment indépendant et polyvalent fort
                de sa superficie au sol et sa cheminée fonctionnelle.
                Il peut être utilisé pour des veillées (bancs à disposition),
                entrepôt de matériel (par exemple skis), salle d’entraînement (danse)
                ou de réception (banquet, cousinade, mariage).
            </p>
            <div class="ContainerSlide2">
                <div class="slideshow-container2">

                    <!-- Full-width images with number and caption text -->
                    <div class="mySlides2 fade2">
                    <img src="../../Images/hebergement/sallejeux6.png" style="width:100%;border-radius: 15px;">
                    </div>
                
                    <div class="mySlides2 fade2">
                    <img src="../../Images/hebergement/sallejeux1.png" style="width:100%;border-radius: 15px;">
                    </div>
                
                    <div class="mySlides2 fade2">
                    <img src="../../Images/hebergement/sallejeux4.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides2 fade2">
                    <img src="../../Images/hebergement/sallejeux2.png" style="width:100%;border-radius: 15px;">
                    </div>

                    <div class="mySlides2 fade2">
                    <img src="../../Images/hebergement/sallejeux3.png" style="width:100%;border-radius: 15px;">
                    </div>
                    
                    <div class="mySlides2 fade2">
                    <img src="../../Images/hebergement/sallejeux3.png" style="width:100%;border-radius: 15px;">
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
</body>
</html>