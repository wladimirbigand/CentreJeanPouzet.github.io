<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Actualités</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordActus.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Barre latérale -->
    <aside class="sidebar">
        <div class="logo">
            <h2>Centre Jean Pouzet</h2>
        </div>
        <nav>
            <ul>
                <li><a href="TableauDeBord.php">Tableau de bord</a></li>
                <li><a href="TableauDeBordAccueil.php">Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="TableauDeBordActus.html" class="active">Actualités</a></li>
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
            <h1>Tableau de Bord - Actualités</h1>
        </header>

        <!-- Section de modification des actualités -->
        <section class="admin-section">
            <!-- Bloc d'édition d'une actualité -->
            <div class="admin-block actu-item">
                <h2>Modifier une actualité</h2>
                <p>Titre de l'actualité :</p>
                <input type="text" placeholder="Titre de l'actualité">

                <p>Description :</p>
                <textarea placeholder="Description de l'actualité" rows="5"></textarea>

                <p>Ajouter/modifier les images :</p>
                <!-- Permet la sélection de plusieurs images -->
                <input type="file" id="fileInputActu1" accept="image/*" multiple>
                <!-- Zone d'aperçu des images sélectionnées -->
                <div class="preview-container" id="previewActu1"></div>
            </div>

            <!-- Bloc d'actions commun aux actualités -->
            <div class="admin-block actions">
                <button id="Add">Ajouter une actualité</button>
                <button id="Modify">Modifier une actualité</button>
                <button id="Delete">Supprimer une actualité</button>
            </div>
        </section>
    </main>
</div>

<script>
    // Fonction pour afficher l'aperçu des images sélectionnées
    function previewImages(inputElement, previewContainer) {
        previewContainer.innerHTML = ""; // On vide le container d'aperçu
        if (inputElement.files) {
            Array.from(inputElement.files).forEach(function(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Ajout de l'aperçu pour le premier bloc d'actualités
    const fileInputActu1 = document.getElementById("fileInputActu1");
    const previewActu1 = document.getElementById("previewActu1");

    fileInputActu1.addEventListener("change", function() {
        previewImages(this, previewActu1);
    });

    // Vous pourrez ajouter ici d'autres scripts pour la gestion dynamique des actualités
</script>
</body>
</html>
