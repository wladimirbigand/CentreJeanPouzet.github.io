<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: Login.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=admin_panel", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$message = "";

if (isset($_POST['addColo'])) {
    $titre = $_POST['titre'];

    $uploadDir = '././Images/Colos/';

    function uploadImage($name, $uploadDir) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . basename($_FILES[$name]['name']);
            $filePath = $uploadDir . $fileName;
            move_uploaded_file($_FILES[$name]['tmp_name'], $filePath);
            return $filePath;
        }
        return null;
    }

    $affiche = uploadImage('affiche', $uploadDir);
    $images = [];
    for ($i = 1; $i <= 6; $i++) {
        $images[$i] = uploadImage("image$i", $uploadDir);
    }

    if ($affiche && !in_array(null, $images)) {
        $stmt = $pdo->prepare("INSERT INTO colos (titre, affiche, image1, image2, image3, image4, image5, image6) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $affiche, $images[1], $images[2], $images[3], $images[4], $images[5], $images[6]]);

        $message = '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
      icon: "success",
      title: "Colo ajoutée !",
      text: "La colo a été ajoutée avec succès.",
      confirmButtonColor: "#3085d6"
    });
    </script>';
    } else {
        $message = '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
      icon: "error",
      title: "Erreur",
      text: "Un problème est survenu lors de l’upload des images.",
      confirmButtonColor: "#d33"
    });
    </script>';
    }
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Colos</title>
    <!-- Styles communs -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <!-- Styles spécifiques pour la page Colos -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordColos.css">
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
                <li><a href="TableauDeBordAccueil.php">Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
                <li><a href="TableauDeBordAgenda.php">Contact</a></li>
                <li><a href="TableauDeBordActus.php">Actualités</a></li>
                <li><a href="TableauDeBordEquipe.php">Équipe</a></li>
                <li><a href="TableauDeBordColos.php" class="active">Colos</a></li>
            </ul>
        </nav>
        <div class="logout">
            <form method="post" action="Logout.php">
                <button type="submit">Se déconnecter</button>
            </form>
        </div>
    </aside>

    <!-- Contenu principal -->
    <main class="content scroll">
        <header class="header">
            <h1>Tableau de Bord - Colos</h1>
        </header>

        <!-- Boutons d'option -->
        <div class="action-options">
            <button id="btn-add" class="active">Ajouter une colo</button>
            <button id="btn-modify">Modifier une colo</button>
            <button id="btn-delete">Supprimer une colo</button>
        </div>

        <!-- Ajouter une colo -->
        <form method="post" enctype="multipart/form-data">
            <section id="add-colo" class="action-section">
                <div class="admin-block colo-info">
                    <h2>Ajouter une colo</h2>

                    <label for="addColoTitle">Titre/Nom de la colo :</label>
                    <input name="titre" type="text" id="addColoTitle" placeholder="Ex : Colo d'hiver 2025" required>

                    <label for="addColoAffiche">Affiche :</label>
                    <input type="file" id="addColoAffiche" name="affiche" accept="image/*" required>
                    <div class="preview-container" id="previewAddAffiche"></div>
                </div>

                <!-- Bloc dédié aux 6 images fixes -->
                <div class="admin-block colo-images">
                    <h2>Images associées (6 fixées)</h2>
                    <div class="colo-colonnes">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="image-slot">
                                <label for="addColoImage<?= $i ?>">Image <?= $i ?> :</label>
                                <input type="file" id="addColoImage<?= $i ?>" name="image<?= $i ?>" accept="image/*" required>
                                <div class="preview-container" id="previewAddImage<?= $i ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="admin-block actions">
                    <input type="hidden" name="addColo" value="1">
                    <button id="btn-add-colo" type="submit">Enregistrer</button>
                </div>

                <?php if (isset($message)) echo $message; ?>
            </section>
        </form>

        <!-- Section Modifier une colo -->
        <section id="modify-colo" class="action-section">
            <div class="admin-block colo-info">
                <h2>Modifier une colo</h2>
                <!-- Les valeurs par défaut peuvent être générées par PHP ou chargées via AJAX -->
                <label for="modifyColoTitle">Titre/Nom de la colo :</label>
                <input type="text" id="modifyColoTitle" placeholder="Ex: Colo d'hiver 2025" value="Titre actuel">

                <label for="modifyColoAffiche">Affiche :</label>
                <input type="file" id="modifyColoAffiche" accept="image/*">
                <div class="preview-container" id="previewModifyAffiche">
                    <!-- Exemple de prévisualisation de l'affiche actuelle -->
                    <img src="../../Images/Colos/Affiche%20séjour%202024%20été_page-0001.jpg" alt="Affiche actuelle">
                </div>

<!--                <label for="modifyColoDescription">Description :</label>-->
<!--                <textarea id="modifyColoDescription" rows="5">Description actuelle de la colo...</textarea>-->
            </div>

            <div class="admin-block colo-images">
                <h2>Images associées (6 fixées)</h2>
                <div class="colo-colonnes">
                    <div class="image-slot">
                        <label>Image 1 :</label>
                        <input type="file" id="modifyColoImage1" accept="image/*">
                        <div class="preview-container" id="previewModifyImage1">
                            <img src="../../Images/Colos/IMG_6608.jpg" alt="Image 1 actuelle">
                        </div>
                    </div>
                    <div class="image-slot">
                        <label>Image 2 :</label>
                        <input type="file" id="modifyColoImage2" accept="image/*">
                        <div class="preview-container" id="previewModifyImage2">
                            <img src="../../Images/Colos/IMG_6612.jpg" alt="Image 2 actuelle">
                        </div>
                    </div>
                    <div class="image-slot">
                        <label>Image 3 :</label>
                        <input type="file" id="modifyColoImage3" accept="image/*">
                        <div class="preview-container" id="previewModifyImage3">
                            <img src="../../Images/Colos/IMG_6619.jpg" alt="Image 3 actuelle">
                        </div>
                    </div>
                    <div class="image-slot">
                        <label>Image 4 :</label>
                        <input type="file" id="modifyColoImage4" accept="image/*">
                        <div class="preview-container" id="previewModifyImage4">
                            <img src="../../Images/Colos/IMG_6626.jpg" alt="Image 4 actuelle">
                        </div>
                    </div>
                    <div class="image-slot">
                        <label>Image 5 :</label>
                        <input type="file" id="modifyColoImage5" accept="image/*">
                        <div class="preview-container" id="previewModifyImage5">
                            <img src="../../Images/Colos/IMG_6642.jpg" alt="Image 5 actuelle">
                        </div>
                    </div>
                    <div class="image-slot">
                        <label>Image 6 :</label>
                        <input type="file" id="modifyColoImage6" accept="image/*">
                        <div class="preview-container" id="previewModifyImage6">
                            <img src="../../Images/Colos/IMG_8605.JPG" alt="Image 6 actuelle">
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-block actions">
                <button id="btn-modify-colo">Enregistrer les modifications</button>
            </div>
        </section>

        <!-- Section Supprimer une colo -->
        <section id="delete-colo" class="action-section">
            <div class="admin-block">
                <h2>Supprimer une colo</h2>
                <p>Sélectionnez la colo à supprimer :</p>
                <!-- Ici, vous pouvez utiliser un select pour lister les colos existantes -->
                <select id="deleteColoSelect">
                    <option value="1">Colo d'hiver 2025</option>
                    <option value="2">Colo d'été 2025</option>
                    <!-- Ajoutez d'autres options selon vos données -->
                </select>
            </div>
            <div class="admin-block actions">
                <button id="btn-delete-colo">Confirmer la suppression</button>
            </div>
        </section>

    </main>
</div>

<script>
    // Ajoutez ce code dans un bloc <script> ou dans votre fichier JS global
    const optionButtons = document.querySelectorAll('.action-options button');
    optionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Supprime la classe active de tous les boutons
            optionButtons.forEach(b => b.classList.remove('active'));
            // Ajoute la classe active au bouton cliqué
            this.classList.add('active');
        });
    });


    // Gestion du basculement entre les sections selon le bouton cliqué
    const btnAdd = document.getElementById('btn-add');
    const btnModify = document.getElementById('btn-modify');
    const btnDelete = document.getElementById('btn-delete');

    const sectionAdd = document.getElementById('add-colo');
    const sectionModify = document.getElementById('modify-colo');
    const sectionDelete = document.getElementById('delete-colo');

    function hideAllSections() {
        sectionAdd.classList.remove('active');
        sectionModify.classList.remove('active');
        sectionDelete.classList.remove('active');
    }

    btnAdd.addEventListener('click', function() {
        hideAllSections();
        sectionAdd.classList.add('active');
    });
    btnModify.addEventListener('click', function() {
        hideAllSections();
        sectionModify.classList.add('active');
    });
    btnDelete.addEventListener('click', function() {
        hideAllSections();
        sectionDelete.classList.add('active');
    });

    // Affichage par défaut : "Ajouter une colo"
    sectionAdd.classList.add('active');

    // Fonction générique d'aperçu d'image
    function previewSingleImage(input, previewContainer) {
        if (!input.files || !input.files[0]) {
            previewContainer.innerHTML = '';
            return;
        }
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Aperçu" />';
        }
        reader.readAsDataURL(file);
    }

    // Pour la section "Ajouter une colo"
    const addAffiche = document.getElementById('addColoAffiche');
    const previewAddAffiche = document.getElementById('previewAddAffiche');
    addAffiche.addEventListener('change', function() {
        previewSingleImage(this, previewAddAffiche);
    });
    for (let i = 1; i <= 6; i++) {
        const fileInput = document.getElementById('addColoImage' + i);
        const previewCont = document.getElementById('previewAddImage' + i);
        fileInput.addEventListener('change', function() {
            previewSingleImage(this, previewCont);
        });
    }

    // Pour la section "Modifier une colo"
    const modifyAffiche = document.getElementById('modifyColoAffiche');
    const previewModifyAffiche = document.getElementById('previewModifyAffiche');
    modifyAffiche.addEventListener('change', function() {
        previewSingleImage(this, previewModifyAffiche);
    });
    for (let i = 1; i <= 6; i++) {
        const fileInput = document.getElementById('modifyColoImage' + i);
        const previewCont = document.getElementById('previewModifyImage' + i);
        fileInput.addEventListener('change', function() {
            previewSingleImage(this, previewCont);
        });
    }
</script>
</body>
</html>
