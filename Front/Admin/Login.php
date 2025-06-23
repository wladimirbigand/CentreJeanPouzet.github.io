<?php
session_start();
$_SESSION['admin'] = true; //

// Connexion à la BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = $_POST['identifiant'];
    $motdepasse = $_POST['motdepasse'];

    $stmt = $pdo->prepare("SELECT * FROM Administrateur WHERE Identifiant = :identifiant");
    $stmt->execute(['identifiant' => $identifiant]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($motdepasse, $admin['Mot_de_passe'])) {
        $_SESSION['admin'] = $admin['Identifiant'];
        header("Location: TableauDeBord.php");
        exit();
    } else {
        $erreur = "L'identifiant ou le mot de passe est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Centre Jean Pouzet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/User/Fonts.css">
    <link rel="stylesheet" href="../../CSS/Admin/Login.css">
    <!-- jQuery depuis le CDN de Google -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<section class="Login">
    <div class="LoginContainer">
        <div class="Interface">
            <img id="AdminIMG" src="../../Images/Admin/Admin.png" alt="Logo admin">
            <h1>Connexion admin</h1>
        </div>
        <div class="Formulaire">
            <?php if (isset($erreur)) echo "<p style='color: red;'>$erreur</p>"; ?>
            <form method="post" action="">
                <div class="champ">
                    <label for="identifiant">Identifiant :</label>
                    <input type="text" id="identifiant" name="identifiant" placeholder="Votre identifiant" required>
                </div>
                <div class="champ">
                    <label for="motdepasse">Mot de passe :</label>
                    <input type="password" id="motdepasse" name="motdepasse" placeholder="Votre mot de passe" required>
                </div>
                <div class="champ">
                    <button type="submit">Connexion</button>
                </div>
                <div class="champ">
                    <a href="../User/Accueil.php" class="retour-site">← Retour au site</a>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>
