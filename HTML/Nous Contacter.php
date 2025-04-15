<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
    <link rel="stylesheet" href="../CSS/Footer.css">
    <link rel="stylesheet" href="../CSS/Header.css">
    <link rel="stylesheet" href="../CSS/Fonts.css">
    <link rel="stylesheet" href="../CSS/Nous Contacter.css">
    <link rel="icon" type="image/vnd.icon" href="../Images/Logo/logo.png">
    <script src="../JS/Header.js" ></script>
    </head>
    
    <body>
    <?php $currentPage = 'contact'; ?>
    <?php require_once '../Includes/header.php'; ?>

        <main>
            <section>
                <div class="container">
                    <div class="legend">
                        <div class="legend-item">
                            <div class="legend-case legend-open"></div>
                            <span>Ouvert</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-case legend-closed"></div>
                            <span>Fermé</span>
                        </div>
                    </div>
            <div>
                
            </div>
                    <div class="calendar">
                        <div class="calendar-header">
                            <button id="prev-month" class="month-nav">←</button>
                            <div class="month-display">
                                <span id="month-picker">Mois</span>
                                <span id="year">Année</span>
                            </div>
                            <button id="next-month" class="month-nav">→</button>
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-week-days">
                                <div>Dim</div>
                                <div>Lun</div>
                                <div>Mar</div>
                                <div>Mer</div>
                                <div>Jeu</div>
                                <div>Ven</div>
                                <div>Sam</div>
                            </div>
                            <div class="calendar-days"></div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="SectionContact">
                <div class="ContainerContact">
                    <div><b> <p class="titres"> NOUS APPELER </p> </b></div>
                    <div class="ElementContact"><img src="../Images/Logo/telephone.png" alt="Image Introuvable" width="4.5%"><a href="tel:0603366176"> 06 03 36 61 76 </a></div>
                    <div><b> <p class="titres"> LOGEMENTS DE GROUPE </p> </b></div>
                    <div class="ElementContact"><img src="../Images/Logo/enveloppe.png" alt="Image Introuvable" width="3%"><a href="mailto:info@centrejeanpouzet.fr"> info@centrejeanpouzet.fr </a></div>
                    <div><b> <p class="titres"> S'INSCRIRE A LA COLO </p> </b></div>
                    <div class="ElementContact"><img src="../Images/Logo/enveloppe.png" alt="Image Introuvable" width="3%"><a href="mailto:colo@centrejeanpouzet.fr"> colo@centrejeanpouzet.fr </a></div>
                </div>
            </section>
        </main>

    <?php
    require_once '../Includes/Footer.php';
    ?>
    <script src="../JS/AgendaResponsive.js" async></script>
</body>
</html>
