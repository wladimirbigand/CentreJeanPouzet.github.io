<?php
include_once ('../../SQL/fonction_connexion.inc.php') ;
$equipe = connectionPDO('../../SQL/config');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Équipe</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordEquipe.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
</head>
<body>
<div class="dashboard-container">
    <!-- Sidebar -->
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
                <li><a href="TableauDeBordEquipe.php" class="active">Équipe</a></li>
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
            <h1>Tableau de Bord – Équipe</h1>
        </header>

        <!-- Boutons d’option -->
        <div class="action-options">
            <button id="btn-add-member" class="active">Ajouter un membre</button>
            <button id="btn-modify-member">Modifier un membre</button>
            <button id="btn-delete-member">Supprimer un membre</button>
        </div>

        <!-- Section « Ajouter » -->
        <section id="add-member" class="action-section active">
            <form method="post" action="" enctype="multipart/form-data">
                <section class="admin-section">
                <div class="admin-block team-member-info">
                    <h2>Ajouter un membre</h2>
                    <label for="addMemberName">Prénom :</label>
                    <input type="text" id="addMemberName" name="addMemberName" placeholder="Qui-est-ce ?" required>

                    <label for="addMemberImage">Photo du membre :</label>
                    <input type="file" id="addMemberImage" name="addMemberImage" accept="image/*" required>
                    <div class="preview-container" id="previewAddMemberImage"></div>

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
                            header('Location: TableauDeBordEquipe.php?section_modif');
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
    // Basculement de sections et mise en surbrillance du bouton actif
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
        Object.values(buttons).forEach(b => b.classList.remove('active'));
        Object.values(sections).forEach(s => s.classList.remove('active'));
    }

    buttons.add.addEventListener('click', () => {
        resetAll();
        buttons.add.classList.add('active');
        sections.add.classList.add('active');
    });
    buttons.modify.addEventListener('click', () => {
        resetAll();
        buttons.modify.classList.add('active');
        sections.modify.classList.add('active');
    });
    buttons.del.addEventListener('click', () => {
        resetAll();
        buttons.del.classList.add('active');
        sections.del.classList.add('active');
    });

    // Aperçu d’image
    function previewImage(input, previewEl) {
        previewEl.innerHTML = '';
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            previewEl.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }

    // Liaisons pour l'ajout
    const addImgIn = document.getElementById('addMemberImage');
    const addImgPrev = document.getElementById('previewAddMemberImage');
    addImgIn.addEventListener('change', () => previewImage(addImgIn, addImgPrev));

    // Liaisons pour la modification
    const modImgIn = document.getElementById('modifyMemberImage');
    const modImgPrev = document.getElementById('previewModifyMemberImage');
    modImgIn.addEventListener('change', () => previewImage(modImgIn, modImgPrev));
</script>
</body>
</html>
