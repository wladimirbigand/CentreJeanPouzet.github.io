<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Interface Administrateur</title>
    <!-- Lien vers votre fichier CSS -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
<link rel="stylesheet" href="../../CSS/Admin/TableauDeBordHebergements.css">
</head>
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
        <!-- En-tête -->
        <header class="header">
            <h1>Tableau de Bord - Hébergements</h1>
        </header>

        <!-- Section d’édition (à personnaliser selon vos besoins) -->
        <section class="admin-section">
            <!-- Premier bloc : modifier du texte -->
            <div class="admin-block">
                <h2>Sélectionnez le texte à ajouter / modifier :</h2>
                <input type="text" placeholder="Texte 1" />
                <textarea placeholder="Aperçu du texte à modifier"></textarea>
            </div>

            <!-- Deuxième bloc : modifier des images ou carrousels -->
            <div class="admin-block">
                <h2>Sélectionnez une image à ajouter / modifier :</h2>
                <input type="text" placeholder="Image 1" />

                <h2>Sélectionnez les images du carrousel à ajouter / modifier :</h2>
                <input type="text" placeholder="Carrousel 1" />
                <input type="text" placeholder="Carrousel 2" />
            </div>

            <!-- Troisième bloc : boutons d'actions sur les actualités -->
            <div class="admin-block actions">
                <button id="Add">Ajouter un hébergement</button>
                <button id="Modify">Modifier une hébergement</button>
                <button id="Delete">Supprimer une hébergement</button>
            </div>
        </section>
    </main>
</div>

</body>
</html>
