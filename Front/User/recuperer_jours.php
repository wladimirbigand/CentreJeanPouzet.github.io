<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT date FROM jours_ouverts");
    $dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(['success' => true, 'openDates' => $dates]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
//k:jhzlkfjd