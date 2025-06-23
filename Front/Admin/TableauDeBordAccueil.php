<?php
session_start();
$currentPage = 'accueil';
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

// Traitement des formulaires (image et texte)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Upload d'image
    if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] == 0) {
        $targetDir = "../../Images/AccueilUploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = basename($_FILES["imageFile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
        if ($check === false) {
            $message = "Le fichier sélectionné n'est pas une image valide.";
        } else {
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $message = "Seuls les formats JPG, JPEG, PNG, GIF, WEBP sont autorisés.";
            } else {
                if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $targetFilePath)) {
                    $relativePath = "../../Images/AccueilUploads/" . $fileName;
                    $stmt = $pdo->prepare("INSERT INTO Multimedia (description, image, chemin_acces) VALUES ('image_accueil', :name, :path)");
                    $stmt->execute([
                        'name' => $fileName,
                        'path' => $relativePath
                    ]);
                    $message .= '
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        Swal.fire({
                          icon: "success",
                          title: "Succès !",
                          text: "Image mise à jour avec succès.",
                          confirmButtonColor: "#3085d6"
                        });
                        </script>';
                } else {
                    $message .= '
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        Swal.fire({
                          icon: "error",
                          title: "Erreur !",
                          text: "Erreur lors du téléversement !",
                          confirmButtonColor: "#3085d6"
                        });
                        </script>';
                }
            }
        }
    }

    // Mise à jour des textes
    if (isset($_POST['text_qui']) && isset($_POST['text_ou'])) {
        $textQui = $_POST['text_qui'];
        $textOu = $_POST['text_ou'];

        $stmt = $pdo->prepare("UPDATE section SET description = :desc WHERE id = :id");
        $stmt->execute(['desc' => $textQui, 'id' => 1]);
        $stmt->execute(['desc' => $textOu, 'id' => 2]);

//        $message .= "<br>Textes mis à jour avec succès.";
        $message .= '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            Swal.fire({
              icon: "success",
              title: "Succès !",
              text: "Textes mis à jour avec succès.",
              confirmButtonColor: "#3085d6"
            });
            </script>';
    }
}

// Récupération de l’image actuelle
$stmt = $pdo->prepare("SELECT chemin_acces FROM Multimedia WHERE description = 'image_accueil' ORDER BY id DESC LIMIT 1");
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$currentImage = $data ? $data['chemin_acces'] : "";

// Récupération des textes actuels
$textQui = $textOu = "";
$stmt = $pdo->prepare("SELECT id, description FROM section WHERE id IN (1, 2)");
$stmt->execute();
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($sections as $section) {
    if ($section['id'] == 1) $textQui = $section['description'];
    if ($section['id'] == 2) $textOu = $section['description'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"><!-- Bootstrap Bundle (inclut Popper.js) -->
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordAccueil.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Barre latérale -->
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
                <h1 class="text-center">Tableau de Bord - Accueil</h1>
            </header>

            <!-- Section de modification -->
            <section class="admin-section">
                <!-- Bloc pour modifier l'image de fond -->
                <div class="admin-block">
                    <h2>Modifier l'image de fond de l'accueil</h2>
                    <br>
                    <!-- Formulaire d'upload -->
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" class="form-control d-none" id="imageFile" name="imageFile" accept="image/*"/>
                        <label for="imageFile" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center file-input-label" style="gap: .5rem;">
                            <i class="bi bi-image fs-3"></i>
                            <span>Modifier l’image de fond</span>
                        </label>
                        <br><br>
                        <h2>Aperçu de l'image de fond de l'accueil :</h2>
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

                <!-- Bloc pour modifier le texte -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="admin-block">
                        <h2>Modifier les différents textes de la page accueil</h2>
                        <p>Modifiez le texte de "Qui sommes nous ?"</p>
                        <br>
                        <textarea id="texteQui" name="text_qui"><?php echo htmlspecialchars($textQui); ?></textarea>
                        <br><br>
                        <p>Modifiez le texte de "Où sommes nous ?"</p>
                        <br>
                        <textarea id="texteOu" name="text_ou"><?php echo htmlspecialchars($textOu); ?></textarea>
                        <br>
                        <div class="admin-block actions">
                            <button id="Add" type="submit">Enregistrer les modifications</button>
                        </div>
                    </div>
                </form>

            </section>
        </div>
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
<script>
    ClassicEditor
        .create(document.querySelector('#texteQui'))
        .catch(error => console.error(error));ClassicEditor
        .create(document.querySelector('#texteOu'))
        .catch(error => console.error(error));ClassicEditor
</script>
</body>
</html>
