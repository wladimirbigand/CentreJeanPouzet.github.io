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
        <div class="scroll">
            <!-- En-tête -->
            <header class="header">
                <h1>Tableau de Bord - Hébergements</h1>
            </header>

            <div><?php if(isset($_GET['success']) && ($_GET['success'] === 1)){echo "<h3>Données Mises à jour !</h3><br>";}?></div>

            <!-- Section d’édition (à personnaliser selon vos besoins) -->
            <form action="traitementhebergement.inc.php" method="POST" enctype="multipart/form-data">

                <section class="admin-section">
                    <!-- Premier bloc : modifier du texte -->
                    <div class="admin-block">
                        <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                        <input type="text" placeholder="Texte 1" name="nouvtitreChalet" value="<?php echo $titreChalet ?>">
                        <textarea placeholder="Aperçu du texte à modifier" name="nouvtexteChalet"><?php echo $texteChalet ?></textarea>
                    </div>

                    <!-- Deuxième bloc : modifier des images ou carrousels -->
                    <div class="admin-block">
                        <h2>Sélectionnez une image à ajouter / modifier :</h2>
                        <input type="file" placeholder="Image 1" name="nouvimageChalet" accept="image/*"/>
                        <br><br><br>
                        <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>
                        <input type="file" placeholder="Carrousel 1" name="chaletcarrousel1"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="chaletcarrousel2"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="chaletcarrousel3"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="chaletcarrousel4"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="chaletcarrousel5"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="chaletcarrousel6"/>
                    </div>


                    <!-- Deuxième bloc : Section batiment -->
                    <div class="admin-block">
                        <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                        <input type="text" placeholder="Texte 2" name="nouvtitreBatiment" value="<?php echo $titreBatiment ?>"/>
                        <textarea placeholder="Aperçu du texte à modifier" name="nouvtexteBatiment"><?php echo $texteBatiment?></textarea>
                    </div>

                    <div class="admin-block">
                        <h2>Sélectionnez une image à ajouter / modifier :</h2>
                        <input type="file" placeholder="Image 1" name="nouvimageBatiment" accept="image/*"/>
                        <br><br><br>
                        <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>
                        <input type="file" placeholder="Carrousel 1" name="batimentcarrousel1"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="batimentcarrousel2"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 3" name="batimentcarrousel3"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 4" name="batimentcarrousel4"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 5" name="batimentcarrousel5"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 6" name="batimentcarrousel6"/>
                    </div>


                    <!-- Troisieme bloc : Section salle -->
                    <div class="admin-block">
                        <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                        <input type="text" placeholder="Texte 3" name="nouvtitreSalle" value="<?php echo $titreSalle?>"/>
                        <textarea placeholder="Aperçu du texte à modifier" name="nouvtexteSalle"><?php echo $texteSalle?></textarea>
                    </div>

                    <div class="admin-block">
                        <h2>Sélectionnez une image à ajouter / modifier :</h2>
                        <input type="file" placeholder="Image 1" name="nouvimageSalle" accept="image/*"/>
                        <br><br><br>
                        <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>
                        <input type="file" placeholder="Carrousel 1" name="sallecarrousel1"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="sallecarrousel2"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="sallecarrousel3"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="sallecarrousel4"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="sallecarrousel5"/>
                        <br><br>
                        <input type="file" placeholder="Carrousel 2" name="sallecarrousel6"/>
                    </div>


                    <input type="submit" value="Valider">
                </section>
            </form>
        </div>
    </main>
</div>

</body>
</html>