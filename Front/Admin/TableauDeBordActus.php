<?php
session_start();
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

if (isset($_POST['deleteActus'])) {
    $id = $_POST['id'];

    $stmt = $connect->prepare("DELETE FROM actus WHERE id = ?");
    $ok = $stmt->execute([$id]);
    if ($ok) {
        $_SESSION['alert'] = [
            'type' => 'success',
            'title' => 'Succès !',
            'message' => 'Actualité supprimée avec succès.'
        ];
        header("Location: TableauDeBordActus.php");
        exit;
    }
    // On recharge la liste pour mettre à jour le tableau JS
    $stmt = $connect->prepare("SELECT * FROM actus ORDER BY date DESC");
    $stmt->execute();
    $actus = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Actualités</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordActus.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script>
        // Affichage Dynamique du titre choisi pour l'actualité présente.
        const actusData = <?php
            $array = [];
            foreach ($actus as $a) {
                $array[$a['id']] = [
                    'titre' => $a['titre'],
                    'texte' => $a['texte'],
                    'image' => $a['image'],
                ];
            }
            echo json_encode($array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            ?>;
    </script>

    <script src="../../JS/TableauDeBordActus.js" defer></script>


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

<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="Logo Centre Jean Pouzet">
        </div>
        <nav>
            <ul>
                <li><a href="TableauDeBord.php">Tableau de bord</a></li>
                <li><a href="TableauDeBordAccueil.php">Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
                <li><a href="TableauDeBordAgenda.php">Contact</a></li>
                <li><a href="TableauDeBordActus.php" class="active">Actualités</a></li>
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
            <h1>Tableau de Bord – Actualités</h1>
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
                        <input type="text" id="addActusTitle" placeholder="Nouveau titre" name="titre" required>

                        <label for="addActusImage">Image d’illustration :</label>
                        <input type="file" id="addActusImage" accept="image/*" name="image">
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
                <section class="admin-section">
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

                    <label for="modifyActusImage">Image d’illustration :</label>
                    <input type="file" id="modifyActusImage" accept="image/*" name="image">
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
            <form method="POST" action="">
                <section class="admin-section">
                <div class="admin-block">
                    <h2>Supprimer une actualité</h2>
                    <p>Sélectionner :</p>
                    <select id="selectActusToDelete" name="id">
                        <?php foreach ($actus as $a) : ?>
                            <option value="<?= $a['id']; ?>"><?= htmlspecialchars($a['titre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="admin-block actions">
                    <button id="btn-delete-actus-save" type="submit" name="deleteActus">Confirmer la suppression</button>
                </div>
                </section>
            </form>

        </section>

    </main>
</div>

<script>

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

</script>

</body>
</html>
