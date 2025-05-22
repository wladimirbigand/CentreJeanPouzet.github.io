<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $identifiant = "Administrateur";
    $motdepasse = password_hash("motdepasse123", PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO Administrateur (Identifiant, Mot_de_passe) VALUES (:identifiant, :motdepasse)");
    $stmt->execute([
        'identifiant' => $identifiant,
        'motdepasse' => $motdepasse
    ]);

    echo "Administrateur ajouté avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
