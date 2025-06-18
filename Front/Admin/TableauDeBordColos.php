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

$activeTab = 'add'; // Valeur par défaut

if (isset($_POST['addColo'])) {
    $activeTab = 'add';
} elseif (isset($_POST['deleteColo'])) {
    $activeTab = 'delete';
} elseif (isset($_POST['modifyColo'])) {
    $activeTab = 'modify';
}


if (isset($_POST['addColo'])) {
    $titre = $_POST['titre'];

    $uploadDir = __DIR__ . '/../../Images/Colos/';

    function uploadImage($name, $uploadDir) {
        if (isset($_FILES[$name]) && $_FILES[$name]['error'] === UPLOAD_ERR_OK) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES[$name]['name']);
            $absolutePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$name]['tmp_name'], $absolutePath)) {
                // Pour le stockage en BDD : chemin relatif
                return '../../Images/Colos/' . $fileName;
            }
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

if (isset($_POST['modifyColo']) && !empty($_POST['idToModify'])) {
    $id = (int)$_POST['idToModify'];
    $newTitle = $_POST['newTitle'];

    // Récupération actuelle (pour supprimer si remplacement)
    $stmtOld = $pdo->prepare("SELECT * FROM colos WHERE id = :id");
    $stmtOld->execute(['id' => $id]);
    $oldData = $stmtOld->fetch(PDO::FETCH_ASSOC);

    $uploadDir = __DIR__ . '/../../Images/Colos/';
    function uploadImageUpdate($inputName, $oldPath, $uploadDir) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = uniqid() . '_' . basename($_FILES[$inputName]['name']);
            $newPath = '../../Images/Colos/' . $fileName;
            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir . $fileName)) {
                $oldAbs = __DIR__ . '/../../' . ltrim($oldPath, './');
                if (file_exists($oldAbs)) unlink($oldAbs);
                return $newPath;
            }
        }
        return $oldPath; // on garde l'ancienne
    }

    $newAffiche = uploadImageUpdate('affiche', $oldData['affiche'], $uploadDir);
    $newImages = [];
    for ($i = 1; $i <= 6; $i++) {
        $newImages[$i] = uploadImageUpdate("image$i", $oldData["image$i"], $uploadDir);
    }

    // Mise à jour
    $stmtUpdate = $pdo->prepare("
        UPDATE colos SET titre = :titre, affiche = :affiche, 
        image1 = :img1, image2 = :img2, image3 = :img3, 
        image4 = :img4, image5 = :img5, image6 = :img6 WHERE id = :id
    ");
    $stmtUpdate->execute([
        'titre' => $newTitle ?: $oldData['titre'],
        'affiche' => $newAffiche,
        'img1' => $newImages[1],
        'img2' => $newImages[2],
        'img3' => $newImages[3],
        'img4' => $newImages[4],
        'img5' => $newImages[5],
        'img6' => $newImages[6],
        'id' => $id
    ]);

    $message = '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "success",
            title: "Colo modifié !",
            text: "La colo et ses images ont été modifiées avec succès.",
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
            text: "Impossible de modifier la colo. Veuillez réessayer.",
            confirmButtonColor: "#d33"
        });
        </script>';


    $activeTab = 'modify';
    $message = '<script>Swal.fire("Modifiée !", "La colo a été mise à jour.", "success")</script>';
}

if (isset($_POST['deleteColo']) && isset($_POST['idToDelete'])) {
    $idToDelete = (int) $_POST['idToDelete'];

    // Récupérer les chemins des images associées à la colo
    $stmtFetch = $pdo->prepare("SELECT affiche, image1, image2, image3, image4, image5, image6 FROM colos WHERE id = :id");
    $stmtFetch->execute(['id' => $idToDelete]);
    $data = $stmtFetch->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Supprimer les fichiers images si existants
        foreach ($data as $path) {
            $absolute = __DIR__ . '/../../' . ltrim($path, './');
            if (file_exists($absolute)) {
                unlink($absolute);
            }
        }

        // Supprimer la ligne de la base
        $stmtDelete = $pdo->prepare("DELETE FROM colos WHERE id = :id");
        $stmtDelete->execute(['id' => $idToDelete]);

        $message = '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "success",
            title: "Colo supprimée !",
            text: "La colo et ses images ont été supprimées avec succès.",
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
            text: "La colo sélectionnée n\'existe pas.",
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
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
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
        <form method="post" enctype="multipart/form-data">
            <section id="modify-colo" class="action-section">
                <?php if (isset($message)) echo $message; ?>
                <div class="admin-block colo-info">
                    <h2>Modifier une colo</h2>

                    <label for="modifyColoSelect">Sélectionnez une colo :</label>
                    <select name="idToModify" id="modifyColoSelect" class="form-select mb-3" required>
                    <option value="">-- Choisissez une colo à modifier --</option>
                        <?php
                        $stmtColos = $pdo->query("SELECT id, titre FROM colos ORDER BY id DESC");
                        $colos = $stmtColos->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($colos as $colo): ?>
                            <option value="<?= $colo['id'] ?>"><?= htmlspecialchars($colo['titre']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="modifyColoTitle">Titre/Nom de la colo :</label>
                    <input name="newTitle" type="text" id="modifyColoTitle" placeholder="Nouveau titre de la colo">

                    <label for="modifyColoAffiche">Affiche :</label>
                    <input type="file" id="modifyColoAffiche" name="affiche" accept="image/*">
                    <div class="preview-container" id="previewModifyAffiche"></div>
                </div>

                <div class="admin-block colo-images">
                    <h2>Images associées (6 fixées)</h2>
                    <div class="colo-colonnes">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="image-slot">
                                <label>Image <?= $i ?> :</label>
                                <input type="file" id="modifyColoImage<?= $i ?>" name="image<?= $i ?>" accept="image/*">
                                <div class="preview-container" id="previewModifyImage<?= $i ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="admin-block actions">
                    <button id="btn-modify-colo" type="submit" name="modifyColo">Enregistrer les modifications</button>
                </div>
            </section>
        </form>

        <!-- Section Supprimer une colo -->
            <form method="post">
                <section id="delete-colo" class="action-section">
                <div class="admin-block">
                    <h2>Supprimer une colo</h2>
                    <p>Sélectionnez la colo à supprimer :</p>
                    <select name="idToDelete" id="deleteColoSelect" class="form-select mb-3" required>
                    <option value="">-- Choisissez une colo --</option>
                        <?php
                        $stmtColos = $pdo->query("SELECT id, titre FROM colos ORDER BY id DESC");
                        $colos = $stmtColos->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($colos as $colo): ?>
                            <option value="<?= $colo['id'] ?>"><?= htmlspecialchars($colo['titre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="admin-block actions">
                    <button id="btn-delete-colo" type="submit" name="deleteColo">Confirmer la suppression</button>
                </div>
                </section>
            </form>


    </main>
</div>

<script>
    const activeTab = "<?php echo $activeTab; ?>";
</script>

<script>
    const optionButtons = document.querySelectorAll('.action-options button');
    optionButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            optionButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

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

    btnAdd.addEventListener('click', function () {
        hideAllSections();
        sectionAdd.classList.add('active');
    });
    btnModify.addEventListener('click', function () {
        hideAllSections();
        sectionModify.classList.add('active');
    });
    btnDelete.addEventListener('click', function () {
        hideAllSections();
        sectionDelete.classList.add('active');
    });

    // Affiche la bonne section au rechargement
    hideAllSections();
    // Retire la classe active de tous les boutons
    optionButtons.forEach(b => b.classList.remove('active'));

    // Affiche la bonne section et active le bon bouton
    if (activeTab === "add") {
        sectionAdd.classList.add('active');
        btnAdd.classList.add('active');
    } else if (activeTab === "delete") {
        sectionDelete.classList.add('active');
        btnDelete.classList.add('active');
    } else if (activeTab === "modify") {
        sectionModify.classList.add('active');
        btnModify.classList.add('active');
    }


    // Fonction d'aperçu d'image
    function previewSingleImage(input, previewContainer) {
        if (!input.files || !input.files[0]) {
            previewContainer.innerHTML = '';
            return;
        }
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Aperçu" />';
        }
        reader.readAsDataURL(file);
    }

    // Ajouter une colo
    const addAffiche = document.getElementById('addColoAffiche');
    const previewAddAffiche = document.getElementById('previewAddAffiche');
    addAffiche.addEventListener('change', function () {
        previewSingleImage(this, previewAddAffiche);
    });
    for (let i = 1; i <= 6; i++) {
        const fileInput = document.getElementById('addColoImage' + i);
        const previewCont = document.getElementById('previewAddImage' + i);
        fileInput.addEventListener('change', function () {
            previewSingleImage(this, previewCont);
        });
    }

    // Modifier une colo
    const modifyAffiche = document.getElementById('modifyColoAffiche');
    const previewModifyAffiche = document.getElementById('previewModifyAffiche');
    modifyAffiche.addEventListener('change', function () {
        previewSingleImage(this, previewModifyAffiche);
    });
    for (let i = 1; i <= 6; i++) {
        const fileInput = document.getElementById('modifyColoImage' + i);
        const previewCont = document.getElementById('previewModifyImage' + i);
        fileInput.addEventListener('change', function () {
            previewSingleImage(this, previewCont);
        });
    }

    document.getElementById('modifyColoSelect').addEventListener('change', function () {
        const id = this.value;
        if (!id) return;

        fetch('getColoData.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Remplir le champ titre
                document.getElementById('modifyColoTitle').value = data.titre;

                // Affiche
                const previewAffiche = document.getElementById('previewModifyAffiche');
                previewAffiche.innerHTML = `<img src="../Admin/${data.affiche}" alt="Affiche actuelle" />`;

                // Images
                for (let i = 1; i <= 6; i++) {
                    const preview = document.getElementById(`previewModifyImage${i}`);
                    const path = data[`image${i}`];
                    preview.innerHTML = `<img src="../Admin/${path}" alt="Image ${i} actuelle" />`;
                }
            })
            .catch(error => {
                console.error('Erreur AJAX :', error);
            });
    });
</script>

</body>
</html>
