<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Jean Pouzet</title>
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
