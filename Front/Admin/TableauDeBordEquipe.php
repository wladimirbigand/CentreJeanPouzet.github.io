<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Équipe</title>
    <!-- Fichier de styles commun -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <!-- Fichier de styles spécifique à l'équipe -->
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordEquipe.css">
</head>
<body>
<div class="dashboard-container">
    <!-- Barre latérale -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="TableauDeBord.php">Tableau de bord</a></li>
                <li><a href="TableauDeBordAccueil.php">Accueil</a></li>
                <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
                <li><a href="#">Contact</a></li>
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
            <h1>Tableau de Bord - Équipe</h1>
        </header>

        <!-- Section de modification des fiches membres -->
        <section class="admin-section">
            <!-- Bloc de modification d'une fiche membre -->
            <div class="admin-block team-member">
                <h2>Modifier la fiche d'un membre</h2>

                <!-- Section pour modifier l'image du membre -->
                <div class="image-section">
                    <label>Image du membre :</label>
                    <input type="file" id="memberImage" accept="image/*">
                    <button id="removeMemberImage">Supprimer l'image</button>
                    <div class="preview-container">
                        <img id="memberImagePreview" src="" alt="Aperçu de l'image" style="display: none;">
                    </div>
                </div>

                <!-- Section pour le nom et prénom du membre -->
                <div class="info-section">
                    <label>Nom et Prénom :</label>
                    <input type="text" placeholder="Nom et Prénom du membre" id="memberName">
                </div>

                <!-- Section pour la description du membre -->
                <div class="description-section">
                    <label>Description :</label>
                    <textarea placeholder="Description du membre" rows="5" id="memberDescription"></textarea>
                </div>
            </div>

            <!-- Bloc d'actions -->
            <div class="admin-block actions">
                <button id="addMember">Ajouter un membre</button>
                <button id="modifyMember">Modifier la fiche</button>
                <button id="deleteMember">Supprimer la fiche</button>
            </div>
        </section>
    </main>
</div>

<script>
    // Gestion de l'aperçu de l'image pour la fiche membre
    const memberImageInput = document.getElementById('memberImage');
    const memberImagePreview = document.getElementById('memberImagePreview');
    const removeMemberImageBtn = document.getElementById('removeMemberImage');

    memberImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                memberImagePreview.setAttribute('src', this.result);
                memberImagePreview.style.display = 'block';
            });
            reader.readAsDataURL(file);
        } else {
            memberImagePreview.setAttribute('src', '');
            memberImagePreview.style.display = 'none';
        }
    });

    removeMemberImageBtn.addEventListener('click', function(event) {
        event.preventDefault();
        memberImageInput.value = '';
        memberImagePreview.setAttribute('src', '');
        memberImagePreview.style.display = 'none';
    });
</script>
</body>
</html>
