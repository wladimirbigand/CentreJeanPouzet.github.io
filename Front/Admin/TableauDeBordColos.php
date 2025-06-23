<?php
session_start();
$currentPage = 'colos';
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

if (isset($_POST['modifyColo'])) {
    if (!empty($_POST['idToModify'])) {
        $stmtOld = $pdo->prepare("SELECT * FROM colos WHERE id = :id");
        $stmtOld->execute(['id' => (int)$_POST['idToModify']]);
        $oldData = $stmtOld->fetch(PDO::FETCH_ASSOC);

        if ($oldData) {
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
                return $oldPath;
            }

            $newAffiche = uploadImageUpdate('affiche', $oldData['affiche'], $uploadDir);
            $newImages = [];
            for ($i = 1; $i <= 6; $i++) {
                $newImages[$i] = uploadImageUpdate("image$i", $oldData["image$i"], $uploadDir);
            }

            $stmtUpdate = $pdo->prepare("
                UPDATE colos SET titre = :titre, affiche = :affiche,
                image1 = :img1, image2 = :img2, image3 = :img3,
                image4 = :img4, image5 = :img5, image6 = :img6 WHERE id = :id
            ");
            $stmtUpdate->execute([
                'titre' => $_POST['newTitle'] ?: $oldData['titre'],
                'affiche' => $newAffiche,
                'img1' => $newImages[1],
                'img2' => $newImages[2],
                'img3' => $newImages[3],
                'img4' => $newImages[4],
                'img5' => $newImages[5],
                'img6' => $newImages[6],
                'id' => $oldData['id']
            ]);

            $message = '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                Swal.fire({
                    icon: "success",
                    title: "Colo modifiée !",
                    text: "La colo a été mise à jour avec succès.",
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
                    text: "La colo n’existe pas.",
                    confirmButtonColor: "#d33"
                });
                </script>';
        }
    } else {
        $message = ''; // pas de message si l’id est vide
    }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!-- Styles spécifiques pour la page Colos -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordColos.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
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
        <header class="header">
            <h1 class="text-center">Tableau de Bord - Colos</h1>
        </header>

        <!-- Boutons d'option -->
        <div class="action-options">
            <button id="btn-add" class="active d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Ajouter une colo</span>
            </button>
            <button id="btn-modify" class="d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-pencil-square"></i>
                <span>Modifier une colo</span>
            </button>
            <button id="btn-delete" class="d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-trash3"></i>
                <span>Supprimer une colo</span>
            </button>
        </div>


        <!-- Ajouter une colo -->
        <section id="add-colo" class="action-section">
        <form method="post" enctype="multipart/form-data" class="mt-3">
            <section id="add-colo" class="admin-section scroll">
                <div class="admin-block colo-info">
                    <h2>Ajouter une colo</h2>

                    <label for="addColoTitle">Titre/Nom de la colo :</label>
                    <input name="titre" type="text" id="addColoTitle" placeholder="Ex : Colo d'hiver 2025" required>

                    <label>Affiche :</label>
                    <input type="file" id="addColoAffiche" name="affiche" accept="image/*" class="d-none">
                    <label for="addColoAffiche" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-image fs-4"></i>
                        <span>Choisir une affiche</span>
                    </label>
                    <div class="preview-container mt-2" id="previewAddAffiche"></div>
                </div>

                <div class="admin-block colo-images">
                    <h2>Images associées (6 fixées)</h2>
                    <div class="colo-colonnes">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="image-slot">
                                <label for="addColoImage<?= $i ?>">Image <?= $i ?> :</label>
                                <input type="file" id="addColoImage<?= $i ?>" name="image<?= $i ?>" accept="image/*" class="d-none">
                                <label for="addColoImage<?= $i ?>" class="file-input-label btn btn-outline-success w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-image fs-4"></i>
                                    <span>Choisir l’image <?= $i ?></span>
                                </label>
                                <div class="preview-container mt-2" id="previewAddImage<?= $i ?>"></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="admin-block actions">
                    <input type="hidden" name="addColo" value="1">
                    <button id="btn-add-colo" type="submit">Enregistrer une nouvelle colo</button>
                </div>

                <?php if (isset($message)) echo $message; ?>
            </section>
        </form>
        </section>


        <!-- Section Modifier une colo -->
        <section id="modify-colo" class="action-section">
        <form method="post" enctype="multipart/form-data">
            <section id="modify-colo" class="admin-section scroll">
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
                    <input type="file" id="modifyColoAffiche" name="affiche" accept="image/*" class="d-none">
                    <label for="modifyColoAffiche" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-image fs-4"></i>
                        <span>Choisir une nouvelle affiche</span>
                    </label>
                    <div class="preview-container" id="previewModifyAffiche"></div>
                </div>

                <div class="admin-block colo-images">
                    <h2>Images associées (6 fixées)</h2>
                    <div class="colo-colonnes">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="image-slot">
                                <label>Image <?= $i ?> :</label>
                                <input type="file" id="modifyColoImage<?= $i ?>" name="image<?= $i ?>" accept="image/*" class="d-none">
                                <label for="modifyColoImage<?= $i ?>" class="file-input-label btn btn-outline-success w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-image fs-4"></i>
                                    <span>Choisir l’image <?= $i ?></span>
                                </label>
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
        </section>

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
    // Gestion des boutons et sections
    const btns = {
        add: document.getElementById('btn-add'),
        modify: document.getElementById('btn-modify'),
        delete: document.getElementById('btn-delete')
    };
    const sections = {
        add: document.getElementById('add-colo'),
        modify: document.getElementById('modify-colo'),
        delete: document.getElementById('delete-colo')
    };

    function resetTabs() {
        Object.values(btns).forEach(b => b?.classList.remove('active'));
        Object.values(sections).forEach(s => s?.classList.remove('active'));
    }

    function activateTab(tab) {
        resetTabs();
        if (btns[tab] && sections[tab]) {
            btns[tab].classList.add('active');
            sections[tab].classList.add('active');
            localStorage.setItem('activeTabColo', tab);
        }
    }

    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        const savedTab = localStorage.getItem('activeTabColo') || 'add';
        activateTab(savedTab);

        // Ajout des événements sur les boutons
        Object.entries(btns).forEach(([key, btn]) => {
            btn?.addEventListener('click', () => activateTab(key));
        });

        // Aperçu images - Ajout
        const addAffiche = document.getElementById('addColoAffiche');
        const previewAddAffiche = document.getElementById('previewAddAffiche');
        addAffiche?.addEventListener('change', () => previewSingleImage(addAffiche, previewAddAffiche));

        for (let i = 1; i <= 6; i++) {
            const input = document.getElementById('addColoImage' + i);
            const preview = document.getElementById('previewAddImage' + i);
            input?.addEventListener('change', () => previewSingleImage(input, preview));
        }

        // Aperçu images - Modification
        const modifyAffiche = document.getElementById('modifyColoAffiche');
        const previewModifyAffiche = document.getElementById('previewModifyAffiche');
        modifyAffiche?.addEventListener('change', () => previewSingleImage(modifyAffiche, previewModifyAffiche));

        for (let i = 1; i <= 6; i++) {
            const input = document.getElementById('modifyColoImage' + i);
            const preview = document.getElementById('previewModifyImage' + i);
            input?.addEventListener('change', () => previewSingleImage(input, preview));
        }

        // Chargement des infos à modifier
        document.getElementById('modifyColoSelect')?.addEventListener('change', function () {
            const id = this.value;
            if (!id) return;

            fetch('getColoData.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) return alert(data.error);
                    document.getElementById('modifyColoTitle').value = data.titre;
                    document.getElementById('previewModifyAffiche').innerHTML =
                        `<img src="../Admin/${data.affiche}" alt="Affiche actuelle" />`;

                    for (let i = 1; i <= 6; i++) {
                        document.getElementById(`previewModifyImage${i}`).innerHTML =
                            `<img src="../Admin/${data[`image${i}`]}" alt="Image ${i} actuelle" />`;
                    }
                })
                .catch(error => console.error('Erreur AJAX :', error));
        });
    });

    // Fonction d’aperçu d’image
    function previewSingleImage(input, previewContainer) {
        if (!input.files || !input.files[0]) {
            previewContainer.innerHTML = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            previewContainer.innerHTML = `<img src="${e.target.result}" alt="Aperçu" />`;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>

</body>
</html>
