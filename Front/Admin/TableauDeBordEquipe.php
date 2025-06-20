<?php
session_start();
include_once ('../../SQL/fonction_connexion.inc.php') ;
$equipe = connectionPDO('../../SQL/config');
$currentPage = 'equipe';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Équipe</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"><!-- Bootstrap Bundle (inclut Popper.js) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordEquipe.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
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
            <h1 class="text-center">Tableau de Bord – Équipe</h1>
        </header>

        <div class="action-options">
            <button id="btn-add-member" class="active d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Ajouter un membre</span>
            </button>
            <button id="btn-modify-member" class="d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-pencil-square"></i>
                <span>Modifier un membre</span>
            </button>
            <button id="btn-delete-member" class="d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-trash3"></i>
                <span>Supprimer un membre</span>
            </button>
        </div>

        <!-- Section « Ajouter » -->
        <section id="add-member" class="action-section active">
            <form method="post" action="" enctype="multipart/form-data">
                <section class="admin-section">
                <div class="admin-block team-member-info">
                    <h2>Ajouter un membre</h2>
                    <label for="addMemberName">Prénom :</label>
                    <input type="text" id="addMemberName" name="addMemberName" placeholder="Qui-est-ce ?" required>

                    <input type="file" id="addMemberImage" name="addMemberImage" accept="image/*" class="d-none" required>
                    <label for="addMemberImage" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2 mb-3">
                        <i class="bi bi-person-square fs-4"></i>
                        <span>Choisir la photo du membre</span>
                    </label>
                    <div id="previewAddMemberImage" class="preview-container text-center"></div>

                    <label for="addMemberRole">Poste :</label>
                    <input type="text" id="addMemberRole" name="addMemberRole" placeholder="Quel est son poste ?" required>

                    <label for="addMemberDesc">Description :</label>
                    <textarea id="addMemberDesc" rows="5" name="addMemberDesc" placeholder="Présentation du membre..." required></textarea>
                </div>

                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $cheminImage = null;
                    $message = "";

                    if (isset($_FILES['addMemberImage']) && $_FILES['addMemberImage']['error'] === 0) {
                        $dossier = "../../Images/Equipe/";
                        $nomFichier = time() . '_' . basename($_FILES['addMemberImage']['name']);
                        $chemin = $dossier . $nomFichier;

                        if (move_uploaded_file($_FILES['addMemberImage']['tmp_name'], $chemin)) {
                            $cheminImage = $nomFichier;
                        }
                    }

                    if (!empty($_POST['addMemberName']) && !empty($_POST['addMemberDesc']) && !empty($_POST['addMemberRole']) && $cheminImage !== null) {
                        $name = $_POST['addMemberName'];
                        $role = $_POST['addMemberRole'];
                        $description = $_POST['addMemberDesc'];

                        $stmt = $equipe->prepare("INSERT INTO equipe (img, name, role, description) VALUES (:img, :name, :role, :description)");
                        $stmt->bindValue(':img', $cheminImage);
                        $stmt->bindValue(':name', $name);
                        $stmt->bindValue(':role', $role);
                        $stmt->bindValue(':description', $description);

                        if ($stmt->execute() == true) {
                            $message .= '
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        Swal.fire({
                          icon: "success",
                          title: "Succès !",
                          text: "Membre ajouté avec succès.",
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
                                  text: "Erreur lors de l\'ajout !",
                                  confirmButtonColor: "#3085d6"
                                });
                                </script>';
                        }
                    }
                }

                ?>

                <div class="admin-block actions">
                    <button type="submit" id="btn-add-member-save">Enregistrer un membre</button>
                </div>
                </section>
            </form>

            <?php if (!empty($message)) echo $message; ?>
        </section>

        <!-- Section « Modifier » -->
        <section id="modify-member" class="action-section">
            <form method="post" action="" enctype="multipart/form-data">
                <section class="admin-section">
                <div class="admin-block team-member-info">
                    <h2>Modifier un membre</h2>
                    <p>Choisir le membre :</p>
                    <select id="selectMemberToEdit" name="selectMemberToEdit" onchange="this.form.submit()">
                        <option value=" "> -- Choisissez un membre -- </option>
                        <?php
                        $stmt = $equipe->query('SELECT name FROM equipe');
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($results as $value) {
                            $sauvegarde = (isset($_POST['selectMemberToEdit']) && $_POST['selectMemberToEdit'] === $value['name']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($value['name']) . '" ' . $sauvegarde . '>' . htmlspecialchars($value['name']) . '</option>';

                        }
                        ?>
                    </select>

                    <?php

                    $name = '';
                    $role = '';
                    $description = '';
                    $img = '';

                    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selectMemberToEdit"])) {
                        $choix = $_POST["selectMemberToEdit"];
                        $stmt = $equipe->prepare('SELECT * FROM equipe WHERE name = :name');
                        $stmt->bindParam(':name', $choix);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($row){
                            $name = $row['name'];
                            $role = $row['role'];
                            $description = $row['description'];
                            $img = $row['img'];
                        }
                    }
                    ?>


                    <label for="modifyMemberName">Prénom :</label>
                    <input type="text" id="modifyMemberName" name="modifyMemberName" value="<?php echo htmlspecialchars($name); ?>">

                    <label for="modifyMemberImage">Photo du membre :</label>
                    <input type="file" id="modifyMemberImage" name="modifyMemberImage" accept="image/*">

                    <div class="preview-container" id="previewModifyMemberImage">
                        <img src="../../Images/Equipe/<?php echo htmlspecialchars($img); ?>" alt="Photo actuelle">
                    </div>

                    <label for="modifyMemberRole">Poste :</label>
                    <input type="text" id="modifyMemberRole" name="modifyMemberRole" value="<?php echo htmlspecialchars($role); ?>">

                    <label for="modifyMemberDesc">Description :</label>
                    <textarea id="modifyMemberDesc" name="modifyMemberDesc" rows="5"><?php echo htmlspecialchars($description); ?></textarea>
                </div>
                <div class="admin-block actions">
                    <button type="submit" name="btn-modify-member-save" id="btn-modify-member-save">Enregistrer la modification</button>
                    <?php

                    if (isset($_POST["btn-modify-member-save"])) {
                        $nomavantmodif = $_POST["selectMemberToEdit"];
                        $name = $_POST['modifyMemberName'];
                        $role = $_POST['modifyMemberRole'];
                        $description = $_POST['modifyMemberDesc'];
                        $cheminImage = null;

                        $stmt = $equipe->prepare('SELECT id, img FROM equipe WHERE name = :name');
                        $stmt->bindValue(':name', $nomavantmodif);
                        $stmt->execute();
                        $member = $stmt->fetch(PDO::FETCH_ASSOC);


                        if ($member) {
                            $memberId = $member['id'];
                            $cheminImage = $member['img'];

                            if (isset($_FILES['modifyMemberImage']) && $_FILES['modifyMemberImage']['error'] === 0) {
                                $dossier = "../../Images/Equipe/";
                                $nomFichier = time() . '_' . basename($_FILES['modifyMemberImage']['name']);
                                $chemin = $dossier . $nomFichier;

                                if (move_uploaded_file($_FILES['modifyMemberImage']['tmp_name'], $chemin)) {
                                    $cheminImage = $nomFichier;
                                }
                            }

                            $stmt = $equipe->prepare("UPDATE equipe SET img = :img, name = :name, role = :role, description = :description WHERE id = :id");
                            $stmt->bindValue(':id', $memberId);
                            $stmt->bindValue(':img', $cheminImage);
                            $stmt->bindValue(':name', $name);
                            $stmt->bindValue(':role', $role);
                            $stmt->bindValue(':description', $description);
                            $stmt->execute();

                            header('Location: TableauDeBordEquipe.php?section_modif');
                            $message = '
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                            Swal.fire({
                              icon: "success",
                              title: "Succès !",
                              text: "Membre modifié avec succès.",
                              confirmButtonColor: "#3085d6"
                            });
                            </script>';
                            echo $message;
                            header('Location: TableauDeBordEquipe.php?section=modify&success=1');
                            exit();
                        }
                    }

                    ?>
                </div>
                </section>
            </form>
        </section>

        <!-- Section « Supprimer » -->
        <section id="delete-member" class="action-section">
            <div class="admin-block team-member-delete">
                <h2>Supprimer un membre</h2>
                <p>Choisir le membre à supprimer :</p>
                <form method="post" action="">
                    <div>
                        <select id="selectMemberToDelete" name="selectMemberToDelete">
                            <?php
                            $stmt = $equipe->query('SELECT name, id FROM equipe');
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($results as $value) {
                                echo '<option value="' . htmlspecialchars($value['id']) . '">' . htmlspecialchars($value['name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="admin-block actions">
                        <button type="submit" id="btn-delete-member-save">Confirmer la suppression</button>
                    </div>
                    <?php
                    $success = false;

                    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["selectMemberToDelete"])) {
                        $id = (int) $_POST["selectMemberToDelete"];
                        $stmt = $equipe->prepare('DELETE FROM equipe WHERE id = :id');
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $success = $stmt->execute();
                    }
                    if ($success) {
                        $message = '
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        Swal.fire({
                          icon: "success",
                          title: "Succès !",
                          text: "Membre supprimé avec succès.",
                          confirmButtonColor: "#3085d6"
                        });
                        </script>';
                        echo $message;
                        header('Location: TableauDeBordEquipe.php');
                        exit();
                    }
                    ?>
                </form>
            </div>
        </section>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = {
            add: document.getElementById('btn-add-member'),
            modify: document.getElementById('btn-modify-member'),
            del: document.getElementById('btn-delete-member')
        };

        const sections = {
            add: document.getElementById('add-member'),
            modify: document.getElementById('modify-member'),
            del: document.getElementById('delete-member')
        };

        function resetAll() {
            Object.values(buttons).forEach(btn => btn.classList.remove('active'));
            Object.values(sections).forEach(sec => sec.classList.remove('active'));
        }

        function setSectionInURL(sectionName) {
            const url = new URL(window.location);
            url.searchParams.set('section', sectionName);
            window.history.replaceState(null, '', url);
        }

        function activateSection(sectionName) {
            if (sections[sectionName] && buttons[sectionName]) {
                resetAll();
                buttons[sectionName].classList.add('active');
                sections[sectionName].classList.add('active');
                setSectionInURL(sectionName);
            }
        }

        // Appliquer la section via l'URL
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');
        if (section) {
            activateSection(section);
        } else {
            activateSection('add'); // valeur par défaut
        }

        // Ajout des événements aux boutons
        buttons.add.addEventListener('click', () => activateSection('add'));
        buttons.modify.addEventListener('click', () => activateSection('modify'));
        buttons.del.addEventListener('click', () => activateSection('del'));

        // Prévisualisation d'image
        function previewImage(input, previewEl) {
            if (!input.files || !input.files[0]) {
                previewEl.innerHTML = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                previewEl.innerHTML = `<img src="${e.target.result}" alt="Aperçu" class="img-fluid" style="max-width: 300px;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }

        // Ajout
        const addImgIn = document.getElementById('addMemberImage');
        const addImgPrev = document.getElementById('previewAddMemberImage');
        if (addImgIn && addImgPrev) {
            addImgIn.addEventListener('change', () => previewImage(addImgIn, addImgPrev));
        }

        // Modification
        const modImgIn = document.getElementById('modifyMemberImage');
        const modImgPrev = document.getElementById('previewModifyMemberImage');
        if (modImgIn && modImgPrev) {
            modImgIn.addEventListener('change', () => previewImage(modImgIn, modImgPrev));
        }
    });
</script>



</body>
</html>
