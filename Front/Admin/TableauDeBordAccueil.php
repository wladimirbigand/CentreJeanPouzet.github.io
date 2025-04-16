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

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] == 0) {
        // Le dossier physique cible : on remonte de deux niveaux depuis Front/Admin pour atteindre public
        $targetDir = "../../Images/AccueilUploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = basename($_FILES["imageFile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Vérifier que le fichier est une image
        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if ($check === false) {
            $message = "Le fichier sélectionné n'est pas une image valide.";
        } else {
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $message = "Seuls les formats JPG, JPEG, PNG, GIF, WEBP sont autorisés.";
            } else {
                if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $targetFilePath)) {
                    // Le chemin enregistré est absolu par rapport à la racine public
                    $relativePath = "/Images/AccueilUploads/" . $fileName;
                    $stmt = $pdo->prepare("UPDATE page_accueil SET image_fond = :img WHERE id = 1");
                    $stmt->execute(['img' => $relativePath]);
                    $message = "Image mise à jour avec succès.";
                } else {
                    $message = "Erreur lors du téléversement.";
                }
            }
        }
    } else {
        $message = "Veuillez sélectionner un fichier.";
    }
}

// Récupération du chemin enregistré en BDD
$stmt = $pdo->query("SELECT image_fond FROM page_accueil WHERE id = 1");
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$currentImage = isset($data['image_fond']) ? $data['image_fond'] : "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Accueil</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordAccueil.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Barre latérale -->
    <aside class="sidebar">
        <div class="logo">
            <h2>Centre Jean Pouzet</h2>
        </div>
        <nav>
            <ul>
                <li><a href="TableauDeBord.php">Tableau de bord</a></li>
                <li><a href="TableauDeBordAccueil.php" class="active">Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
                <li><a href="#">Contact</a></li>
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
        <header class="header">
            <h1>Tableau de Bord - Accueil</h1>
        </header>

        <!-- Section de modification -->
        <section class="admin-section">
            <!-- Bloc pour modifier l'image de fond -->
            <div class="admin-block">
                <h2>Modifier l'image de fond de l'accueil</h2>
                <br>
                <!-- Formulaire d'upload -->
                <form method="post" enctype="multipart/form-data">
                    <input type="file" id="imageFile" name="imageFile" accept="image/*">
                    <br><br>
                    <div class="preview-container">
                        <?php if (!empty($currentImage)) : ?>
                            <img id="imagePreview" src="<?php echo htmlspecialchars($currentImage); ?>" alt="Aperçu de l'image" style="max-width: 400px;">
                        <?php else : ?>
                            <img id="imagePreview" src="" alt="Aperçu de l'image">
                        <?php endif; ?>
                    </div>
                    <br>
                    <div class="admin-block actions">
                        <button id="Add" type="submit">Enregistrer les modifications</button>
                    </div>
                    <br>
                </form>
                <?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>
            </div>

            <!-- Bloc pour modifier le texte (inchangé ici) -->
            <div class="admin-block">
                <h2>Modifier le texte de présentation</h2>
                <p>
                    Modifiez le texte qui apparaît sur la page d'accueil pour présenter le Centre Jean Pouzet.
                </p>
                <br>
                <textarea placeholder="Tapez ici le texte de présentation..." rows="8"></textarea>
            </div>
        </section>
    </main>
</div>

<script>
    const imageFileInput = document.getElementById('imageFile');
    const imagePreview = document.getElementById('imagePreview');

    imageFileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                imagePreview.setAttribute('src', this.result);
                imagePreview.style.display = 'block';
            });
            reader.readAsDataURL(file);
        } else {
            imagePreview.setAttribute('src', '');
            imagePreview.style.display = 'none';
        }
    });
</script>
</body>
</html>
