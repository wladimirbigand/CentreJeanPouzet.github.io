<?php

session_start();
$currentPage = 'actus';
include_once ('../../SQL/fonction_connexion.inc.php');
$connect = connectionPDO('config');

$stmt = $connect->prepare("SELECT * FROM actus ORDER BY date DESC");
$stmt->execute();
$actus = $stmt->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['saveModif'])) {

    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];
    // Pour l’image :
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../../Images/Actus/';
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $filePath);
        $image = $filePath;
    } else if (isset($_POST['image'])) {
        $image = $_POST['image'];
    } else {
        $stmtImg = $connect->prepare("SELECT image FROM actus WHERE id = ?");
        $stmtImg->execute([$id]);
        $image = $stmtImg->fetchColumn();
    }

    $stmt = $connect->prepare("UPDATE actus SET titre = ?, texte = ?, image = ? WHERE id = ?");
    $ok = $stmt->execute([$titre, $texte, $image, $id]);


    if ($ok) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Succès !',
            'message' => 'Actualité modifiée avec succès.'
        ];
        header("Location: TableauDeBordActus.php");
        exit;

        // On recharge la liste pour mettre à jour le tableau JS
        $stmt = $connect->prepare("SELECT * FROM actus ORDER BY id");
        $stmt->execute();
        $actus = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

if (isset($_POST['addActus'])) {
    $titre = $_POST['titre'];
    $texte = $_POST['texte'];

    // Gérer l'image (upload ou chemin direct)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../../Images/Actus/';
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $filePath);
        $image = $filePath;
    } else if (isset($_POST['image'])) {
        $image = $_POST['image'];
    } else {
        $image = ''; // Aucun chemin fourni
    }

    $stmt = $connect->prepare("INSERT INTO actus (titre, texte, image, date) VALUES (?, ?, ?, CURRENT_DATE)");
    $ok = $stmt->execute([$titre, $texte, $image]);

    if ($ok) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Succès !',
            'message' => 'Actualité ajoutée avec succès.'
        ];
        header("Location: TableauDeBordActus.php");
        exit;
    }
    // On recharge la liste pour mettre à jour le tableau JS
    $stmt = $connect->prepare("SELECT * FROM actus ORDER BY date DESC");
    $stmt->execute();
    $actus = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['deleteActus']) && !empty($_POST['selectActusToDelete'])) {
    $ids = $_POST['selectActusToDelete'];

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $connect->prepare("DELETE FROM actus WHERE id IN ($placeholders)");
    $ok = $stmt->execute($ids);

    if ($ok) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Succès !',
            'message' => 'Actualités supprimées avec succès.'
        ];
        header("Location: TableauDeBordActus.php");
        exit;
    }
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Actualités</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordActus.css">
    <script>
        // Affichage Dynamique du titre choisi pour l'actualité présente.
        const actusData = <?php
            $array = [];
            foreach ($actus as $a) {
                $array[$a['id']] = [
                    'titre' => $a['titre'],
                    'texte' => $a['texte'],
                    'image' => $a['image'],
                    'date' => $a['date'],
                ];
            }
            echo json_encode($array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            ?>;
    </script>

    <script src="../../JS/TableauDeBordActus.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MQ6+Fgj3wMPEe0iHYOgklxm3b5b+gkQjahLhRjz6kTd9k9uQ0s+F/gK+77hL847K" crossorigin="anonymous"/>
</head>
<?php if (!empty($message)) : ?>
    <div class="notif"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>


<body>
<?php if (isset($_SESSION['alert'])) : ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION['alert']['type'] ?>',
            title: '<?= $_SESSION['alert']['title'] ?>',
            text: '<?= $_SESSION['alert']['message'] ?>',
            confirmButtonColor: '#3085d6'
        });
    </script>
    <?php unset($_SESSION['alert']); ?>
<?php endif; ?>

<?php

?>

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
        <header class="header">
            <h1 class="text-center">Tableau de Bord – Actualités</h1>
        </header>

        <!-- Boutons d’option -->
        <div class="action-options">
            <button id="btn-add-actus" class="active" type="button">Ajouter une actualité</button>
            <button id="btn-modify-actus" type="button">Modifier une actualité</button>
            <button id="btn-delete-actus" type="button">Supprimer une actualité</button>
        </div>

        <!-- Section Ajouter -->
        <section id="add-actus" class="action-section active">
            <form method="POST" action="" enctype="multipart/form-data">
                <section class="admin-section">
                    <div class="admin-block actu-form">
                        <h2>Ajouter une actualité</h2>
                        <label for="addActusTitle">Titre :</label>
                        <input type="text" id="addActusTitle" placeholder="Titre de l'actualité..." name="titre" required>

                        <input type="file" name="image" id="addActusImage" accept="image/*" class="d-none">
                        <label for="addActusImage" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-image fs-3"></i>
                            <span>Choisir une image</span>
                        </label>
                        <div class="preview-container" id="previewAddActusImage"></div>


                        <label for="addActusDesc">Description :</label>
                        <textarea id="addActusDesc" rows="5" placeholder="Texte de l’actualité…" name="texte" required></textarea>
                    </div>
                    <div class="admin-block actions">
                        <button id="btn-add-actus-save" type="submit" name="addActus">Enregistrer une nouvelle actualité</button>
                    </div>
                </section>
            </form>
        </section>


        <!-- Section Modifier -->

        <section id="modify-actus" class="action-section">
            <form method="POST" action="TableauDeBordActus.php" enctype="multipart/form-data">
                <section class="admin-section scroll">
                    <div class="admin-block actu-form">
                        <h2>Modifier une actualité</h2>
                        <p>Veuillez sélectionner l'actualité à modifier :</p>
                        <select id="selectActusToEdit" name="id">
                            <?php foreach ($actus as $a) : ?>
                                <option value="<?= $a['id']; ?>"><?= htmlspecialchars($a['titre']); ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label for="modifyActusTitle">Titre :</label>
                        <input type="text" id="modifyActusTitle" value="" name="titre">

                        <input type="file" name="image" id="modifyActusImage" accept="image/*" class="d-none">
                        <label for="modifyActusImage" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-image fs-3"></i>
                            <span>Modifier l’image</span>
                        </label>
                        <div class="preview-container">
                            <img src="" id="previewModifyActusImage" alt="Image actuelle">
                        </div>

                        <label for="modifyActusText">Description :</label>
                        <textarea id="modifyActusText" rows="5" name="texte"> </textarea>
                    </div>
                    <div class="admin-block actions">
                        <button id="btn-modify-actus-save" type="submit" name="saveModif">Enregistrer la modification</button>
                    </div>
                </section>
            </form>
        </section>

        <!-- Section Supprimer -->

        <section id="delete-actus" class="action-section">
            <section class="admin-section scroll">
            <form method="POST" action="" id="form-delete-actus">
                    <div class="admin-block">
                        <h2>Supprimer une actualité</h2>
                        <div class="admin-block actu-form">
                            <?php foreach ($actus as $a) : ?>
                                <label for="selectActusToDelete<?= $a['id'] ?>" class="actu-item">
                                    <input type="checkbox" id="selectActusToDelete<?= $a['id'] ?>" name="selectActusToDelete[]" value="<?= $a['id']; ?>">
                                    <?= htmlspecialchars($a['titre']); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <br>
                        <div class="admin-block actions">
                            <button id="btn-delete-actus-save" type="button">Confirmer la suppression</button>
                        </div>
                    </div>
                <section class="admin-section mt-4">
                    <div class="admin-block d-grid gap-3 py-3 px-3" style="min-height: 50px; padding: 10px;" id="selected-actus-list">
                    </div>
                </section>
            </form>
            </section>

        </section>


    </main>
</div>
<script>
    document.getElementById('form-delete-actus').addEventListener('submit', function(e) {
        const checkedBoxes = this.querySelectorAll('input[name="selectActusToDelete[]"]:checked');
        if (checkedBoxes.length === 0) {
            alert("Veuillez sélectionner au moins une actualité.");
            e.preventDefault();
            return;
        }
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('input[name="selectActusToDelete[]"]');
        const selectedList = document.getElementById('selected-actus-list');

        function updateSelectedList() {
            const selectedItems = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const id = checkbox.value;
                    const data = actusData[id];
                    if (data) {
                        selectedItems.push(`
            <div class="selected-actu">
              <h3>${data.titre}</h3>
              <p><em>Date :</em> ${data.date}</p>
              <p>${data.texte}</p>
              <img src="${data.image}" alt="${data.titre}" style="max-width:200px; max-height:150px; object-fit:contain;">
            </div>
          `);
                    }
                }
            });

            if (selectedItems.length > 0) {
                selectedList.style.display = 'block';
                selectedList.innerHTML = selectedItems.join('');
            } else {
                selectedList.style.display = 'none';
                selectedList.innerHTML = '';
            }
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedList);
        });

        updateSelectedList(); // initialisation au chargement
    });



    // Basculement de sections et bouton actif
    const btns = {
        add: document.getElementById('btn-add-actus'),
        mod: document.getElementById('btn-modify-actus'),
        del: document.getElementById('btn-delete-actus')
    };
    const secs = {
        add: document.getElementById('add-actus'),
        mod: document.getElementById('modify-actus'),
        del: document.getElementById('delete-actus')
    };
    function resetAll() {
        Object.values(btns).forEach(b=>b.classList.remove('active'));
        Object.values(secs).forEach(s=>s.classList.remove('active'));
    }
    btns.add.addEventListener('click', ()=>{ resetAll(); btns.add.classList.add('active'); secs.add.classList.add('active'); });
    btns.mod.addEventListener('click', ()=>{ resetAll(); btns.mod.classList.add('active'); secs.mod.classList.add('active'); });
    btns.del.addEventListener('click', ()=>{ resetAll(); btns.del.classList.add('active'); secs.del.classList.add('active'); });

    document.getElementById('btn-delete-actus-save').addEventListener('click', function() {
        const form = document.getElementById('form-delete-actus');
        const checkedBoxes = form.querySelectorAll('input[name="selectActusToDelete[]"]:checked');

        if (checkedBoxes.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Aucune sélection',
                text: 'Veuillez sélectionner au moins une actualité à supprimer.'
            });
            return;
        }

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Non, annuler !',
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let input = form.querySelector('input[name="deleteActus"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'deleteActus';
                    input.value = '1';
                    form.appendChild(input);
                }
                form.submit()
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Annulé',
                    text: 'La suppression a été annulée.',
                    icon: 'info'
                });
            }
        });
    });


</script>

<!-- Popper.js, nécessaire pour certains composants Bootstrap -->
<script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-vFmR4M6lM9WWJZt3UQp0QwSdwxvDjk5z0ulP7n3U0eiJQdkb5fB5Xn0ZUrpOe2nd"
        crossorigin="anonymous"
></script>

<!-- Bootstrap 5 JS -->
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-M0v4f7+zeZAd3vJXGy1LQ7kXfJupixz5/3Vq+aT+xy9ZZi8+Rp1U5mW7tXJj7Lu5"
        crossorigin="anonymous"
></script>
<script>
    // Gestion de la persistance de l'onglet actif
    const btnsPersist = {
        add: document.getElementById('btn-add-actus'),
        mod: document.getElementById('btn-modify-actus'),
        del: document.getElementById('btn-delete-actus')
    };
    const secsPersist = {
        add: document.getElementById('add-actus'),
        mod: document.getElementById('modify-actus'),
        del: document.getElementById('delete-actus')
    };

    function resetPersistTabs() {
        Object.values(btnsPersist).forEach(b => b.classList.remove('active'));
        Object.values(secsPersist).forEach(s => s.classList.remove('active'));
    }

    function activateTab(tab) {
        resetPersistTabs();
        if (btnsPersist[tab] && secsPersist[tab]) {
            btnsPersist[tab].classList.add('active');
            secsPersist[tab].classList.add('active');
            localStorage.setItem('activeTabActus', tab);
        }
    }

    btnsPersist.add.addEventListener('click', () => activateTab('add'));
    btnsPersist.mod.addEventListener('click', () => activateTab('mod'));
    btnsPersist.del.addEventListener('click', () => activateTab('del'));

    // Activation au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        const storedTab = localStorage.getItem('activeTabActus') || 'add';
        activateTab(storedTab);
    });
</script>

</body>
</html>