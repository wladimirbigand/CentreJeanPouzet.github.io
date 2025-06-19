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

//recuperation du titre et du texte de la bd pour "Chalet"
$stmtchalet = $pdo->query("SELECT titre,description FROM section where id=201;");
$tabchalet = $stmtchalet->fetch();
$titreChalet = $tabchalet[0];
$texteChalet = $tabchalet[1];

//recuperation du titre et du texte de la bd pour "batiment"
$stmtbatiment = $pdo->query("SELECT titre,description FROM section where id=202;");
$tabbatiment = $stmtbatiment->fetch();
$titreBatiment = $tabbatiment[0];
$texteBatiment = $tabbatiment[1];

//recuperation du titre et du texte de la bd pour "Salle"
$stmtsalle = $pdo->query("SELECT titre,description FROM section where id=203;");
$tabsalle = $stmtsalle ->fetch();
$titreSalle  = $tabsalle [0];
$texteSalle  = $tabsalle [1];

// Récupération des images actuelles du carrousel du chalet (id 211 à 216 par exemple)
$carouselChalet = [];
for ($i = 1; $i <= 6; $i++) {
    $stmt = $pdo->prepare("SELECT chemin_acces FROM multimedia WHERE id = ?");
    $stmt->execute([203 + $i]); // exemple : ID 211 à 216
    $carouselChalet[$i] = $stmt->fetchColumn();
}

// Carrousel du bâtiment (IDs 221 à 226 par exemple)
$carouselBatiment = [];
for ($i = 1; $i <= 6; $i++) {
    $stmt = $pdo->prepare("SELECT chemin_acces FROM multimedia WHERE id = ?");
    $stmt->execute([209 + $i]); // Ex : 221 à 226
    $carouselBatiment[$i] = $stmt->fetchColumn();
}

// Carrousel de la salle (IDs 231 à 236 par exemple)
$carouselSalle = [];
for ($i = 1; $i <= 6; $i++) {
    $stmt = $pdo->prepare("SELECT chemin_acces FROM multimedia WHERE id = ?");
    $stmt->execute([215 + $i]); // Ex : 231 à 236
    $carouselSalle[$i] = $stmt->fetchColumn();
}

// Images principales (hors carrousel)
$stmt = $pdo->prepare("SELECT chemin_acces FROM multimedia WHERE id = ?");
$stmt->execute([201]);
$imageChalet = $stmt->fetchColumn();

$stmt->execute([202]);
$imageBatiment = $stmt->fetchColumn();

$stmt->execute([203]);
$imageSalle = $stmt->fetchColumn();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Interface Administrateur</title>
    <!-- Lien vers votre fichier CSS -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordHebergements.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<style>
    .content {
        overflow-y: scroll;
    }
</style>
<body>



<div class="dashboard-container">
    <!-- Barre de navigation latérale -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="TableauDeBord.php">Tableau de bord</a></li>
                <li><a href="TableauDeBordAccueil.php">Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php" class="active">Hébergements</a></li>
                <li><a href="TableauDeBordAgenda.php">Contact</a></li>
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

    <!-- Zone de contenu principale -->
    <main class="content">
        <div>
            <!-- En-tête -->
            <header class="header">
                <h1>Tableau de Bord - Hébergements</h1>
            </header>

            <div class="action-options">
                <button id="btn-add" class="active">Chalet</button>
                <button id="btn-modify">Bâtiment</button>
                <button id="btn-delete">Salle de jeu</button>
            </div>

            <section id="section-chalet" class="action-section active"> <!-- active pour la 1ère -->
                <form action="traitementhebergement.inc.php" method="POST" enctype="multipart/form-data">
                    <section class="admin-section scroll">

                        <div class="admin-block">
                            <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                            <input type="text" placeholder="Texte 1" name="nouvtitreChalet" value="<?php echo $titreChalet ?>">
                            <textarea id="editorChalet" name="nouvtexteChalet"><?php echo $texteChalet ?></textarea>
                        </div>

                        <div class="admin-block">
                            <h2>Sélectionnez une image à ajouter / modifier :</h2>
                            <input type="file" name="nouvimageChalet" id="inputImageChalet" accept="image/*" class="d-none">
                            <label for="inputImageChalet" class="file-input-label btn btn-outline-success w-100 d-flex align-items-center justify-content-center" style="gap:.5rem;"><i class="bi bi-image fs-3"></i><span>Modifier l’image d'en-tête</span></label>

                            <?php if (!empty($imageChalet)): ?>
                                <div class="preview-container"><img src="../../Admin/<?php echo $imageChalet; ?>" alt="Image Chalet" style="max-width:200px;max-height:200px;border-radius:8px;margin-bottom:10px;"></div>
                            <?php endif; ?>

                            <div class="preview-container" id="previewImageChalet"></div>
                        </div>

                        <div class="admin-block">
                            <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>
                            <?php for($i=1;$i<=6;$i++): ?>
                                <input type="file" name="chaletcarrousel<?= $i ?>" id="inputChaletCarousel<?= $i ?>" accept="image/*" class="d-none">
                                <label for="inputChaletCarousel<?= $i ?>" class="file-input-label btn btn-outline-success w-100 d-flex align-items-center justify-content-center" style="gap:.5rem;"><i class="bi bi-image fs-3"></i><span>Carrousel <?= $i ?></span></label>
                                <?php if(!empty($carouselChalet[$i])): ?><div class="preview-container"><img src="../../Admin/<?php echo $carouselChalet[$i]; ?>" alt="Carrousel <?= $i ?>" style="max-width:200px;max-height:200px;border-radius:8px;margin-bottom:10px;"></div><?php endif; ?>
                                <div class="preview-container" id="previewChaletCarousel<?= $i ?>"></div>
                            <?php endfor; ?>
                        </div>

                        <div class="admin-block actions">
                            <button id="Add" type="submit" class="btn btn-success w-100">Enregistrer les modifications</button>
                        </div>

                    </section>
                </form>
            </section>

            <section id="section-batiment" class="action-section">
                <form action="traitementhebergement.inc.php" method="POST" enctype="multipart/form-data">
                    <section class="admin-section scroll">
                        <!-- Deuxième bloc : Section batiment -->
                        <div class="admin-block">
                            <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                            <input type="text" placeholder="Texte 2" name="nouvtitreBatiment" value="<?php echo $titreBatiment ?>"/>
                            <textarea id="editorBatiment" name="nouvtexteBatiment"><?php echo $texteBatiment ?></textarea>
                        </div>

                        <div class="admin-block">
                            <h2>Sélectionnez une image à ajouter / modifier :</h2>
                            <input type="file" name="nouvimageBatiment" id="inputImageBatiment" accept="image/*" class="d-none"/>
                            <label for="inputImageBatiment" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-image fs-3"></i>
                                <span>Modifier l’image d’en-tête</span>
                            </label>

                            <?php if (!empty($imageBatiment)): ?>
                                <div class="preview-container">
                                    <img src="../../Admin/<?php echo $imageBatiment; ?>" alt="Image Bâtiment" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-bottom: 10px;">
                                </div>
                            <?php endif; ?>

                            <div class="preview-container" id="previewImageBatiment"></div>
                            <br><br><br>
                            <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>

                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <input type="file" name="batimentcarrousel<?= $i ?>" id="inputBatimentCarousel<?= $i ?>" accept="image/*" class="d-none"/>
                                <label for="inputBatimentCarousel<?= $i ?>" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-image fs-3"></i>
                                    <span>Carrousel <?= $i ?></span>
                                </label>

                                <?php if (!empty($carouselBatiment[$i])): ?>
                                    <div class="preview-container">
                                        <img src="../../Admin/<?php echo $carouselBatiment[$i]; ?>" alt="Carrousel <?= $i ?>" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-bottom: 10px;">
                                    </div>
                                <?php endif; ?>

                                <div class="preview-container" id="previewBatimentCarousel<?= $i ?>"></div>
                                <br>
                            <?php endfor; ?>
                        </div>

                        <div class="admin-block actions">
                            <button id="Add" type="submit">Enregistrer les modifications</button>
                        </div>
                    </section>
                </form>
            </section>

            <section id="section-salle" class="action-section">
                <form action="traitementhebergement.inc.php" method="POST" enctype="multipart/form-data">

                    <section class="admin-section scroll">
                        <!-- Troisieme bloc : Section salle -->
                        <div class="admin-block">
                            <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                            <input type="text" placeholder="Texte 3" name="nouvtitreSalle" value="<?php echo $titreSalle?>"/>
                            <textarea id="editorSalle" name="nouvtexteSalle"><?php echo $texteSalle ?></textarea>
                        </div>

                        <div class="admin-block">
                            <h2>Sélectionnez une image à ajouter / modifier :</h2>
                            <input type="file" name="nouvimageSalle" id="inputImageSalle" accept="image/*" class="d-none"/>
                            <label for="inputImageSalle" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-image fs-3"></i>
                                <span>Modifier l’image d’en-tête</span>
                            </label>

                            <?php if (!empty($imageSalle)): ?>
                                <div class="preview-container">
                                    <img src="../../Admin/<?php echo $imageSalle; ?>" alt="Image Salle" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-bottom: 10px;">
                                </div>
                            <?php endif; ?>

                            <div class="preview-container" id="previewImageSalle"></div>
                            <br><br><br>
                            <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>

                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                <input type="file" name="sallecarrousel<?= $i ?>" id="inputSalleCarousel<?= $i ?>" accept="image/*" class="d-none"/>
                                <label for="inputSalleCarousel<?= $i ?>" class="file-input-label btn btn-outline-success d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-image fs-3"></i>
                                    <span>Carrousel <?= $i ?></span>
                                </label>

                                <?php if (!empty($carouselSalle[$i])): ?>
                                    <div class="preview-container">
                                        <img src="../../Admin/<?php echo $carouselSalle[$i]; ?>" alt="Carrousel <?= $i ?>" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-bottom: 10px;">
                                    </div>
                                <?php endif; ?>

                                <div class="preview-container" id="previewSalleCarousel<?= $i ?>"></div>
                                <br>
                            <?php endfor; ?>
                        </div>

                        <div class="admin-block actions">
                            <button id="Add" type="submit">Enregistrer les modifications</button>
                        </div>
                    </section>
                </form>
            </section>
        </div>
    </main>
</div>

<script>
    const buttons = {
        chalet: document.getElementById('btn-add'),
        batiment: document.getElementById('btn-modify'),
        salle: document.getElementById('btn-delete'),
    };

    const sections = {
        chalet: document.getElementById('section-chalet'),
        batiment: document.getElementById('section-batiment'),
        salle: document.getElementById('section-salle'),
    };

    function resetSections() {
        Object.values(sections).forEach(section => section.classList.remove('active'));
        Object.values(buttons).forEach(btn => btn.classList.remove('active'));
    }

    buttons.chalet.addEventListener('click', () => {
        resetSections();
        buttons.chalet.classList.add('active');
        sections.chalet.classList.add('active');
    });

    buttons.batiment.addEventListener('click', () => {
        resetSections();
        buttons.batiment.classList.add('active');
        sections.batiment.classList.add('active');
    });

    buttons.salle.addEventListener('click', () => {
        resetSections();
        buttons.salle.classList.add('active');
        sections.salle.classList.add('active');
    });

    function previewSingleImage(input, previewContainer) {
        if (!input.files || !input.files[0]) {
            previewContainer.innerHTML = '';
            return;
        }
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Aperçu" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 10px;" />';
        }
        reader.readAsDataURL(file);
    }

    // Exemple pour l’image principale du chalet
    const inputChalet = document.querySelector('input[name="nouvimageChalet"]');
    const previewChalet = document.getElementById('previewChaletImage');
    inputChalet.addEventListener('change', function() {
        previewSingleImage(this, previewChalet);
    });

    //Châlet
    for (let i = 1; i <= 6; i++) {
        const input = document.getElementById('inputChaletCarousel' + i);
        const preview = document.getElementById('previewChaletCarousel' + i);
        input.addEventListener('change', function () {
            previewSingleImage(this, preview);
        });
    }

    // Bâtiment
    for (let i = 1; i <= 6; i++) {
        const input = document.getElementById('inputBatimentCarousel' + i);
        const preview = document.getElementById('previewBatimentCarousel' + i);
        input.addEventListener('change', function () {
            previewSingleImage(this, preview);
        });
    }

    // Salle
    for (let i = 1; i <= 6; i++) {
        const input = document.getElementById('inputSalleCarousel' + i);
        const preview = document.getElementById('previewSalleCarousel' + i);
        input.addEventListener('change', function () {
            previewSingleImage(this, preview);
        });
    }

    document.getElementById("inputImageChalet").addEventListener('change', function () {
        previewSingleImage(this, document.getElementById('previewImageChalet'));
    });

    document.getElementById("inputImageBatiment").addEventListener('change', function () {
        previewSingleImage(this, document.getElementById('previewImageBatiment'));
    });

    document.getElementById("inputImageSalle").addEventListener('change', function () {
        previewSingleImage(this, document.getElementById('previewImageSalle'));
    });

</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Modifications enregistrées !',
            text: 'Les contenus ont bien été mis à jour.',
            confirmButtonColor: '#3085d6'
        });
    </script>
<?php endif; ?>

<script>ClassicEditor
        .create(document.querySelector('#editorChalet'))
        .catch(error => console.error(error));ClassicEditor
        .create(document.querySelector('#editorBatiment'))
        .catch(error => console.error(error));ClassicEditor
        .create(document.querySelector('#editorSalle'))
        .catch(error => console.error(error));
</script>
</body>
</html>