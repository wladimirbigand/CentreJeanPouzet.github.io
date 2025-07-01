<?php
session_start();
include_once('../../SQL/fonction_connexion.inc.php');
$equipe = connectionPDO('../../SQL/config');
$currentPage = 'equipe';

// ─── AJOUT D’UN MEMBRE ───────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addMemberName'])) {
    $cheminImage = null;
    if (isset($_FILES['addMemberImage']) && $_FILES['addMemberImage']['error'] === UPLOAD_ERR_OK) {
        $dossier   = __DIR__ . '/../../Images/Equipe/';
        if (!is_dir($dossier)) mkdir($dossier, 0777, true);
        $nomFichier = time() . '_' . basename($_FILES['addMemberImage']['name']);
        $chemin     = $dossier . $nomFichier;
        if (move_uploaded_file($_FILES['addMemberImage']['tmp_name'], $chemin)) {
            $cheminImage = $nomFichier;
        }
    }
    $success = false;
    if ($cheminImage) {
        $stmt = $equipe->prepare("
            INSERT INTO equipe (img, name, role, description)
            VALUES (:img, :name, :role, :description)
        ");
        $stmt->bindValue(':img',         $cheminImage);
        $stmt->bindValue(':name',        $_POST['addMemberName']);
        $stmt->bindValue(':role',        $_POST['addMemberRole']);
        $stmt->bindValue(':description', $_POST['addMemberDesc']);
        $success = $stmt->execute();
    }
    header('Location: TableauDeBordEquipe.php?section=add&success=' . ($success ? '1' : '0'));
    exit();
}

// ─── MODIFICATION D’UN MEMBRE ────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-modify-member-save'])) {
    $memberId   = (int)$_POST['selectMemberToEdit'];
    $stmtSelect = $equipe->prepare("SELECT img FROM equipe WHERE id = :id");
    $stmtSelect->execute([':id' => $memberId]);
    $row = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    $success = false;
    if ($row) {
        $cheminImage = $row['img'];
        if (isset($_FILES['modifyMemberImage']) && $_FILES['modifyMemberImage']['error'] === UPLOAD_ERR_OK) {
            $dossier    = __DIR__ . '/../../Images/Equipe/';
            if (!is_dir($dossier)) mkdir($dossier, 0777, true);
            $nomFichier = time() . '_' . basename($_FILES['modifyMemberImage']['name']);
            $chemin     = $dossier . $nomFichier;
            if (move_uploaded_file($_FILES['modifyMemberImage']['tmp_name'], $chemin)) {
                $cheminImage = $nomFichier;
            }
        }
        $stmt = $equipe->prepare("
            UPDATE equipe
               SET img         = :img,
                   name        = :name,
                   role        = :role,
                   description = :description
             WHERE id = :id
        ");
        $stmt->bindValue(':img',         $cheminImage);
        $stmt->bindValue(':name',        $_POST['modifyMemberName']);
        $stmt->bindValue(':role',        $_POST['modifyMemberRole']);
        $stmt->bindValue(':description', $_POST['modifyMemberDesc']);
        $stmt->bindValue(':id',          $memberId, PDO::PARAM_INT);
        $success = $stmt->execute();
    }
    header('Location: TableauDeBordEquipe.php?section=modify&success=' . ($success ? '1' : '0'));
    exit();
}

// ─── SUPPRESSION D’UN MEMBRE ─────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-delete-member-save'])) {
    $memberId = (int)$_POST['selectMemberToDelete'];
    $stmt     = $equipe->prepare("DELETE FROM equipe WHERE id = :id");
    $success  = $stmt->execute([':id' => $memberId]);
    header('Location: TableauDeBordEquipe.php?section=delete&success=' . ($success ? '1' : '0'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Équipe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Vos CSS -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordEquipe.css">
    <link rel="icon" type="image/png" href="../../Images/Logo/logo.png">
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

    <main class="content">
        <header class="header">
            <h1 class="text-center">Tableau de Bord – Équipe</h1>
        </header>

        <div class="action-options mb-4">
            <button id="btn-add-member"    class="btn btn-outline-success me-2"><i class="bi bi-plus-circle"></i> Ajouter</button>
            <button id="btn-modify-member" class="btn btn-outline-primary me-2"><i class="bi bi-pencil-square"></i> Modifier</button>
            <button id="btn-delete-member" class="btn btn-outline-danger"><i class="bi bi-trash3"></i> Supprimer</button>
        </div>

        <!-- AJOUT -->
        <section id="add-member" class="action-section">
            <form method="post" enctype="multipart/form-data">
                <div class="admin-section">
                    <div class="admin-block">
                        <h2>Ajouter un membre</h2>
                        <input type="text"    class="form-control mb-3" placeholder="Prénom"            name="addMemberName" required>
                        <input type="file"    id="addMemberImage" name="addMemberImage" accept="image/*" class="d-none" required>
                        <label for="addMemberImage" class="file-input-label mb-3">
                            <i class="bi bi-person-square fs-4"></i> Choisir la photo
                        </label>
                        <div id="previewAddMemberImage" class="preview-container text-center mb-3"></div>
                        <input type="text"    class="form-control mb-3" placeholder="Poste"              name="addMemberRole" required>
                        <textarea            class="form-control mb-3" placeholder="Description" rows="4" name="addMemberDesc" required></textarea>
                        <button id="btn-add-member-save" type="submit" class="btn btn-success w-100" name="btn-add-member-save">Enregistrer le nouveau membre</button>
                    </div>
                </div>
            </form>
        </section>

        <!-- MODIFICATION -->
        <section id="modify-member" class="action-section d-none">
            <form method="post" enctype="multipart/form-data">
                <div class="admin-section">
                    <div class="admin-block">
                        <h2>Modifier un membre</h2>
                        <select id="selectMemberToEdit" name="selectMemberToEdit" class="form-select mb-3" onchange="this.form.submit()">
                            <option value="">-- Sélectionner --</option>
                            <?php
                            $stm = $equipe->query('SELECT id,name FROM equipe ORDER BY name');
                            while ($r = $stm->fetch(PDO::FETCH_ASSOC)) {
                                $sel = (isset($_POST['selectMemberToEdit']) && $_POST['selectMemberToEdit']==$r['id'])?' selected':'';
                                echo "<option value=\"{$r['id']}\"{$sel}>".htmlspecialchars($r['name'])."</option>";
                            }
                            ?>
                        </select>
                        <?php
                        $mod = ['name'=>'','role'=>'','description'=>'','img'=>''];
                        if (!empty($_POST['selectMemberToEdit'])) {
                            $q = $equipe->prepare('SELECT * FROM equipe WHERE id = :id');
                            $q->execute([':id'=>(int)$_POST['selectMemberToEdit']]);
                            $f = $q->fetch(PDO::FETCH_ASSOC);
                            if ($f) $mod = $f;
                        }
                        ?>
                        <input type="text"    class="form-control mb-3" name="modifyMemberName" value="<?=htmlspecialchars($mod['name'])?>">
                        <input type="file"    id="modifyMemberImage" name="modifyMemberImage" accept="image/*" class="d-none">
                        <label for="modifyMemberImage" class="file-input-label mb-3">
                            <i class="bi bi-person-square fs-4"></i> Choisir la photo
                        </label>
                        <div id="previewModifyMemberImage" class="preview-container text-center mb-3">
                            <?php if ($mod['img']): ?>
                                <img src="../../Images/Equipe/<?=htmlspecialchars($mod['img'])?>" alt="Photo actuelle">
                            <?php endif; ?>
                        </div>
                        <input type="text"    class="form-control mb-3" name="modifyMemberRole" value="<?=htmlspecialchars($mod['role'])?>">
                        <textarea            class="form-control mb-3" name="modifyMemberDesc" rows="4"><?=htmlspecialchars($mod['description'])?></textarea>
                        <button id="btn-modify-member-save" type="submit" class="btn btn-primary w-100" name="btn-modify-member-save">Enregistrer les modifications</button>
                    </div>
                </div>
            </form>
        </section>

        <!-- SUPPRESSION -->
        <section id="delete-member" class="action-section d-none">
            <div class="admin-section">
                <div class="admin-block">
                    <h2>Supprimer un membre</h2>
                    <form method="post">
                        <select id="selectMemberToDelete" name="selectMemberToDelete" class="form-select mb-3">
                            <option value="">-- Choisissez un membre à supprimer --</option>
                            <?php
                            $stm = $equipe->query('SELECT id,name FROM equipe ORDER BY name');
                            while ($r = $stm->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$r['id'].'">'.htmlspecialchars($r['name']).'</option>';
                            }
                            ?>
                        </select>
                        <button id="btn-delete-member-save" type="submit" class="btn btn-danger w-100" name="btn-delete-member-save">Confirmer</button>
                    </form>
                </div>
            </div>
        </section>

    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Récupération des boutons et des sections
        const buttons = {
            add:    document.getElementById('btn-add-member'),
            modify: document.getElementById('btn-modify-member'),
            del:    document.getElementById('btn-delete-member'),
        };
        const sections = {
            add:    document.getElementById('add-member'),
            modify: document.getElementById('modify-member'),
            del:    document.getElementById('delete-member'),
        };

        // Masque toutes les sections et désactive tous les boutons
        function resetAll() {
            Object.values(buttons).forEach(btn => btn.classList.remove('active'));
            Object.values(sections).forEach(sec => {
                sec.classList.add('d-none');
                sec.classList.remove('active');
            });
        }

        // Met à jour l’URL sans recharger la page
        function setSectionInURL(name) {
            const url = new URL(window.location);
            url.searchParams.set('section', name);
            window.history.replaceState({}, '', url);
        }

        // Active la section et le bouton correspondant
        function activateSection(name) {
            if (!sections[name] || !buttons[name]) return;
            resetAll();
            buttons[name].classList.add('active');
            sections[name].classList.remove('d-none');
            sections[name].classList.add('active');
            setSectionInURL(name);
        }

        // Lecture des paramètres URL
        const params  = new URLSearchParams(window.location.search);
        const initial = params.get('section') || 'add';
        activateSection(initial);

        // Affichage de la SweetAlert si success=1
        if (params.get('success') === '1') {
            let config = { icon: 'success', confirmButtonColor: '#3085d6' };
            switch (initial) {
                case 'add':
                    config.title = 'Ajout réussi !';
                    config.text  = 'Le membre a bien été ajouté.';
                    break;
                case 'modify':
                    config.title = 'Modification réussie !';
                    config.text  = 'Le membre a bien été modifié.';
                    break;
                case 'delete':
                    config.title = 'Suppression réussie !';
                    config.text  = 'Le membre a bien été supprimé.';
                    break;
            }
            Swal.fire(config);
        }

        // Événements sur les boutons
        buttons.add   .addEventListener('click', () => activateSection('add'));
        buttons.modify.addEventListener('click', () => activateSection('modify'));
        buttons.del   .addEventListener('click', () => activateSection('del'));

        // Prévisualisation d’image
        function previewImage(input, previewEl, maxW = 300) {
            if (!input.files || !input.files[0]) {
                previewEl.innerHTML = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                previewEl.innerHTML =
                    `<img src="${e.target.result}" class="img-fluid" style="max-width:${maxW}px;" alt="Aperçu">`;
            };
            reader.readAsDataURL(input.files[0]);
        }

        // Liaison preview ajout
        const addIn   = document.getElementById('addMemberImage');
        const addPrev = document.getElementById('previewAddMemberImage');
        if (addIn && addPrev) addIn.addEventListener('change', () => previewImage(addIn, addPrev));

        // Liaison preview modif
        const modIn   = document.getElementById('modifyMemberImage');
        const modPrev = document.getElementById('previewModifyMemberImage');
        if (modIn && modPrev) modIn.addEventListener('change', () => previewImage(modIn, modPrev));
    });

    // Confirmation SweetAlert avant suppression d’un membre
    document.getElementById('btn-delete-member-save').addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Non, annuler !',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // on ajoute le champ pour PHP
                if (!form.querySelector('input[name="btn-delete-member-save"]')) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'btn-delete-member-save';
                    input.value = '1';
                    form.appendChild(input);
                }
                form.submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Annulé',
                    text: 'La suppression a été annulée.',
                    icon: 'info',
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    });
</script>

</body>
</html>
