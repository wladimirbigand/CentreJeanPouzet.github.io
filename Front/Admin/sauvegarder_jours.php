<?php
session_start();

if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit();
}

// Vérifie que la requête est de type JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_SERVER['CONTENT_TYPE']) &&
    strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {

    // Récupère et décode le corps JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['openDates']) || !is_array($data['openDates'])) {
        echo json_encode(['success' => false, 'message' => 'Données invalides']);
        exit();
    }

    $openDates = $data['openDates'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Supprime les anciens jours
        $pdo->beginTransaction();
        $pdo->exec("DELETE FROM jours_ouverts");

        // Prépare l'insertion
        $stmt = $pdo->prepare("INSERT INTO jours_ouverts (date) VALUES (:date)");

        foreach ($openDates as $date) {
            // Vérifie que la date est bien au format AAAA-MM-JJ
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $stmt->execute([':date' => $date]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
?>
