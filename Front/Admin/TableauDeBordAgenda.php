<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Login.php");
    exit();
}

// Connexion à la BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_CONTENT_TYPE']) && strpos($_SERVER['HTTP_CONTENT_TYPE'], 'application/json') !== false) {
    // C'est une requête AJAX JSON pour sauvegarder les jours ouverts
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['openDates']) || !is_array($data['openDates'])) {
        echo json_encode(['success' => false, 'message' => 'Données invalides']);
        exit();
    }

    $openDates = $data['openDates'];

    try {
        $pdo->beginTransaction();
        $pdo->exec("DELETE FROM jours_ouverts");
        $stmt = $pdo->prepare("INSERT INTO jours_ouverts (date) VALUES (:date)");
        foreach ($openDates as $date) {
            $stmt->execute([':date' => $date]);
        }
        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Accueil</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordAgenda.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Barre latérale -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="TableauDeBord.php">Tableau de bord</a></li>
                <li><a href="TableauDeBordAccueil.php" >Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
                <li><a href="TableauDeBordAgenda.php"class="active">Contact</a></li>
                <li><a href="TableauDeBordActus.php">Actualités</a></li>
                <li><a href="TableauDeBordEquipe.php">Équipe</a></li>
                <li><a href="TableauDeBordColos.php">Colos</a></li>
            </ul>
        </nav>
        <div class="logout">
            <form method="post" action="Logout.php">
                <button type="submit">Se déconnecter</button>
            </form>
        </div>
    </aside>

    <!-- Contenu principal -->
    <main class="content">
        <div class="scroll">
            <header class="header">
                <h1>Tableau de Bord - Contact</h1>
            </header>

            <!-- Section de modification -->
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
                    <div class="toggle-buttons" style="display:flex; gap: 10px; margin-bottom: 20px;">
                        <button id="openAllBtn" style="flex:1; padding: 10px; border-radius: 8px; border:none; background-color:#9DBD91; color:white; font-weight:bold; cursor:pointer;">Tout ouvrir</button>
                        <button id="closeAllBtn" style="flex:1; padding: 10px; border-radius: 8px; border:none; background-color:#FF6F61; color:white; font-weight:bold; cursor:pointer;">Tout fermer</button>
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

                    <button id="saveBtn">Enregistrer les modifications</button>
                </div>
            </section>



        </div>
    </main>
</div>

<script src="../../JS/agenda.js"></script>


</body>
</html>
