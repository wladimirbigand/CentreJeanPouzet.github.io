<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
    <link rel="stylesheet" href="../CSS/Accueil.css">
    <link rel="stylesheet" href="../CSS/Footer.css">
    <link rel="stylesheet" href="../CSS/Equipe.css">
    <link rel="stylesheet" href="../CSS/Header.css">
    <link rel="stylesheet" href="../CSS/Fonts.css">
    <script src="../JS/Header.js" ></script>
    <link rel="icon" type="image/vnd.icon" href="../Images/Logo/logo.png">
</head>
    
    <body>
    <?php $currentPage = 'equipe'; ?>
    <?php require_once '../Includes/header.php'; ?>

    <main>
        <section class="notre_equipe">
 
            <div id="conteneur_equipe">
                <div id="titre_equipe">
                    <h1> L’association du Centre Jean Pouzet est constituée d’un bureau associatif et de salariés, on se présente ! </h1>
                </div>
                <div id="equipe">
                    <div id="equipe_une">
                        <div class="ContainerEquipe">
                            <img src="../Images/Equipe/Xavier.jpg" alt="Image Introuvable">
                            <div>
                                <b> <p> Xavier </p> </b>
                                <b> <p> Directeur de la structure </p> </b>
                            </div>
                            <div class="Description">
                                <p class="description_equipe"> Xavier est salarié de l’association et travaille à l’intendance
                                de la structure et à l’accueil des groupes. Il sera
                                votre interlocuteur particulier concernant les devis et
                                les réservations (hors colonie Jean Pouzet).
                                </p>
                            </div>
                        </div>
                        <div class="ContainerEquipe"><img src="../Images/Equipe/FABIENNE.jpg" alt="Image Introuvable">
                            <div>
                                <b> <p> Fabienne </p> </b>
                                <b> <p> Cheffe cuisinière </p> </b>
                            </div>
                            <div class="Description">
                                <p class="description_equipe"> Fabienne est salariée de l’association et s’occupe de
                                    préparer avec ses équipes vos délicieux repas
                                    chauds et pique-nique. N’hésitez pas à lui dire quand
                                    vous vous êtes régalez !
                                </p>
                            </div>
                        </div>
                    </div>
                 <hr>
                    <div id="president">
                        <div class="ContainerEquipe">
                            <img src="../Images/Equipe/Olivier.png" alt="Image Introuvable">
                            <div>
                                <b> <p> Olivier </p> </b>
                                <b> <p> Président de l’association </p> </b>
                            </div>
                            <div class="Description">
                                <p class="description_equipe"> L’histoire d’amour entre Guchen et Olivier a commencé
                                il y a un moment… Quand il est venu en colonie de vacances.
                                Depuis il a été colons, animateur, sous-directeur de la
                                colonie et maintenant Président de l’association. Demandez-lui les
                                secrets du centre si vous le croisez il en connaît un paquet !
                            </p>
                            </div>
                        </div>
                        <div class="ContainerEquipe">  
                            <img src="../Images/Equipe/Laurianne.png" alt="Image Introuvable">
                            <div>
                                <b> <p> Laurianne </p> </b>
                                <b> <p> Présidente adjointe de l’association </p></b>
                            </div>
                           
                            <div class="Description">
                                <p class="description_equipe"> Elle est tombée dans la marmite enfant ! Au total, tous
                                ses frères et ses cousins ont été colons et animateurs…
                                Étant la plus jeune… Il a bien fallu qu’elle continue dans
                                les pas de ses anciens. Aujourd’hui Laurianne est
                                animatrice sur les séjours d’été et d’hiver au centre et
                                s’occupe de leur promotion et de leur organisation.
                            </p>
                            </div>
                           
                        </div>
                    </div>
                <hr>
                    <div id="equipe_deux">
                        <div class="ContainerEquipe">
                            <img src="../Images/Equipe/Alice.png" alt="Image Introuvable">
                            <div>
                            <b> <p> Alice </p> </b>
                            <b> <p> Secrétaire générale de l’association </p> </b>
                            </div>
                            <div class="Description">
                                <p class="description_equipe"> Ancienne colon et animatrice, Alice s’occupe
                                des réseaux sociaux et du digital de l’association
                                (n’hésitez pas à nous taguer dans vos publications
                                ou stories!) et participe à l’organisation des séjours
                                de colonies de vacances.</p>
                            </div>
                        </div>
                        <div class="ContainerEquipe">
                            <img src="../Images/Equipe/Iana.png" alt="Image Introuvable">
                            <div>
                                <b> <p> Iana </p> </b>
                                <b> <p> Trésorière de l’association </p> </b>
                            </div>
                            <div class="Description">
                                <p class="description_equipe"> Iana découvre l'association lors d’un séjour
                                 de colonie de vacances où elle est animatrice…
                                  Elle n’a plus jamais coupé les ponts !
                                </p>
                            </div>
                        </div>
                        <div class="ContainerEquipe">
                            <img src="../Images/Equipe/Marie-Agnès.png" alt="Image Introuvable">
                            <div>
                                <b> <p> Marie-Agnès </p> </b>
                                <b> <p> Secrétaire et trésorière de l’association </p> </b>
                            </div>
                            <div class="Description">
                                <p class="description_equipe"> Ancienne colon, animatrice et maintenant secrétaire
                                et trésorière de la colonie de vacances, Marie-Agnès
                                vous contactera en cas d'irrégularités alors : attention !
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
        <footer>
            <div class="footer-left">
                <a href="Mentions Legales.php">Mentions légales</a>
                <a href="Politique de Confidentialite.php">Politique de confidentialité</a>
            </div>
            <div class="footer-center">
                <a href="../HTML/Test.html">Admin <span>&#128274;</span></a>
                ©2024 ColoConnect | Tous droits réservés
            </div>
            <div class="footer-right">
                <div class="contact"><a href="Nous Contacter.php"><b>Nous contacter</b></a></div>
                <div class="social-icons">
                    <a href="https://www.facebook.com/centrejeanpouzet/"><img src="../Images/Logo/Icone_Facebook.svg" alt="Facebook"></a>
                    <a href="https://www.instagram.com/centrejeanpouzet/?hl=fr"><img src="../Images/Logo/Icone_Instagram.svg" alt="Instagram"></a>
                </div>
            </div>
        </footer>
    
</body>
</html>
