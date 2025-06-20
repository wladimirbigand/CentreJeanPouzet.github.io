<?php
session_start();
$currentPage = 'agenda';
if (!isset($_SESSION['admin'])) {
    header("Location: Login.php");
    exit();
}

// Connexion à la BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les infos de contact
    $stmt = $pdo->query("SELECT * FROM infos_contact");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traitement du formulaire de mise à jour
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_contact'])) {
        $stmt = $pdo->prepare("UPDATE infos_contact SET tel = ?, mail = ? WHERE label = ?");

        foreach ($_POST['contacts'] as $label => $data) {
            $stmt->execute([$data['tel'], $data['mail'], $label]);
        }

        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Succès !',
            'message' => 'Informations de contact mises à jour.'
        ];
        header("Location: TableauDeBordAgenda.php");
        exit();
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"><!-- Bootstrap Bundle (inclut Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordAgenda.css">
</head>
<body>

<div class="dashboard-container">
    <?php include '../Includes/AsideBar.php'; ?>
    <button class="btn btn-outline-dark d-md-none position-fixed m-3 z-3"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas"
            aria-controls="sidebarOffcanvas">
        <i class="bi bi-list fs-3"></i>
    </button>
    <!-- Contenu principal -->
    <main class="content">
        <div class="scroll">
            <header class="header">
                <h1 class="text-center">Tableau de Bord - Dispos</h1>
            </header>

            <!-- Section de modification -->
            <section class="">
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
                    <div class="toggle-buttons">
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
            <section class="SectionContact">
                <form method="POST" action="" class="ContainerContact">
                    <?php foreach ($contacts as $contact): ?>
                        <div>
                            <b><p class="titres"><?= htmlspecialchars($contact['label']) ?></p></b>
                        </div>
                        <div class="ElementContact">
                            <?php if ($contact['tel']): ?>
                                <img src="../../Images/Logo/telephone.png" alt="Téléphone" width="4.5%">
                                <input type="tel"
                                       maxlength="17"
                                       id="telInput"
                                       name="contacts[<?= htmlspecialchars($contact['label']) ?>][tel]"
                                       value="<?= htmlspecialchars($contact['tel']) ?>"
                                       class="contact-input">
                            <?php endif; ?>

                            <?php if ($contact['mail']): ?>
                                <img src="../../Images/Logo/enveloppe.png" alt="Email" width="3%">
                                <input type="email"
                                       name="contacts[<?= htmlspecialchars($contact['label']) ?>][mail]"
                                       value="<?= htmlspecialchars($contact['mail']) ?>"
                                       class="contact-input">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" name="update_contact" class="saveBtnContact">
                        Enregistrer les modifications
                    </button>
                </form>
            </section>
        </div>
    </main>
</div>

<script src="../../JS/agenda.js"></script>


</body>
</html>
