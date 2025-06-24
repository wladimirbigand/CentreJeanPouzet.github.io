<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/User/Footer.css">
    <link rel="stylesheet" href="../../CSS/User/Header.css">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <link rel="stylesheet" href="../../CSS/User/Nous%20Contacter.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="../../JS/Header.js" ></script>
    </head>
    
    <body>
    <?php $currentPage = 'contact'; ?>
    <?php require_once '../Includes/Header.php'; ?>

        <main>
            <section class="info-section">

                <div class="info-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                    </svg>
                    <p>Pendant nos jours de fermeture les appels peuvent être indisponibles. N’hésitez pas à envoyer un mail pour que nous en prenions connaissance dès notre retour !</p>
                </div>
            </section>
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
                            <button id="prev-month" class="month-nav">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                                </svg>
                            </button>
                            <div class="month-display">
                                <span id="month-picker">Mois</span>
                                <span id="year">Année</span>
                            </div>
                            <button id="next-month" class="month-nav">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </button>
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
                    <?php
                    $pdo = new PDO('mysql:host=localhost;dbname=admin_panel;charset=utf8', 'root', '', [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]);

                    $stmt = $pdo->query("SELECT * FROM infos_contact");
                    while ($row = $stmt->fetch()) {
                        echo '<div><b><p class="titres">' . htmlspecialchars($row['label']) . '</p></b></div>';
                        echo '<div class="ElementContact">';

                        if (!empty($row['tel'])) {
                            echo '<img src="../../Images/Logo/telephone.png" alt="Image Introuvable" width="4.5%">';
                            echo '<a href="tel:' . htmlspecialchars($row['tel']) . '"> ' . htmlspecialchars($row['tel']) . ' </a>';
                        }

                        if (!empty($row['mail'])) {
                            echo '<img src="../../Images/Logo/enveloppe.png" alt="Image Introuvable" width="3%">';
                            echo '<a href="mailto:' . htmlspecialchars($row['mail']) . '"> ' . htmlspecialchars($row['mail']) . ' </a>';
                        }

                        echo '</div>';
                    }
                    ?>
                </div>
            </section>
        </main>

    <?php
    require_once '../Includes/Footer.php';
    ?>
    <script src="../../JS/AgendaResponsive.js"></script>
    </body>
</html>
