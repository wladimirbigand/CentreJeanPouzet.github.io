<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Actualités</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordActus.css">
</head>
<body>
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
                <li><a href="#">Contact</a></li>
                <li><a href="#" class="active">Actualités</a></li>
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
            <button id="btn-add-actus" class="active">Ajouter une actualité</button>
            <button id="btn-modify-actus">Modifier une actualité</button>
            <button id="btn-delete-actus">Supprimer une actualité</button>
        </div>

        <!-- Section Ajouter -->
        <section id="add-actus" class="action-section active">
            <div class="admin-block actu-form">
                <h2>Ajouter une actualité</h2>
                <label for="addActusTitle">Titre :</label>
                <input type="text" id="addActusTitle" placeholder="Nouveau titre">

                <label for="addActusImage">Image d’illustration :</label>
                <input type="file" id="addActusImage" accept="image/*">
                <div class="preview-container" id="previewAddActusImage"></div>

                <label for="addActusDesc">Description :</label>
                <textarea id="addActusDesc" rows="5" placeholder="Texte de l’actualité…"></textarea>
            </div>
            <div class="admin-block actions">
                <button id="btn-add-actus-save">Enregistrer une nouvelle actualité</button>
            </div>
        </section>

        <!-- Section Modifier -->
        <section id="modify-actus" class="action-section">
            <div class="admin-block actu-form">
                <h2>Modifier une actualité</h2>
                <p>Veuillez sélectionner l'actualité à modifier :</p>
                <select id="selectActusToEdit">
                    <option value="1">Les Pyrénées à vélo !</option>
                    <option value="2">Les inscriptions pour le séjour de ski sont ouvertes</option>
                </select>

                <label for="modifyActusTitle">Titre :</label>
                <input type="text" id="modifyActusTitle" value="Les Pyrénées à vélo !">

                <label for="modifyActusImage">Image d’illustration :</label>
                <input type="file" id="modifyActusImage" accept="image/*">
                <div class="preview-container" id="previewModifyActusImage">
                    <img src="../../Images/Actus/vélo.jpg" alt="Image actuelle">
                </div>

                <label for="modifyActusDesc">Description :</label>
                <textarea id="modifyActusDesc" rows="5">Pla d’Adet, Tourmalet, Col d’Aspin, Peyresourdes… Les Pyrénées offrent pléthore de lieux emblématiques pour les passionnés de vélo. Et pour cause, le Centre accueille chaque année des clubs et groupes de cyclistes afin qu’ils se reposent entre leurs différentes étapes et entraînements.
                </textarea>
            </div>
            <div class="admin-block actions">
                <button id="btn-modify-actus-save">Enregistrer la modification</button>
            </div>
        </section>

        <!-- Section Supprimer -->
        <section id="delete-actus" class="action-section">
            <div class="admin-block">
                <h2>Supprimer une actualité</h2>
                <p>Sélectionner :</p>
                <select id="selectActusToDelete">
                    <option value="1">Les Pyrénées à vélo !</option>
                    <option value="2">Les inscriptions pour le séjour de ski sont ouvertes</option>
                </select>
            </div>
            <div class="admin-block actions">
                <button id="btn-delete-actus-save">Confirmer la suppression</button>
            </div>
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

    // Aperçu d’image
    function previewImage(input, previewEl) {
        previewEl.innerHTML = '';
        if (!input.files[0]) return;
        const fr = new FileReader();
        fr.onload = e => previewEl.innerHTML = `<img src="${e.target.result}">`;
        fr.readAsDataURL(input.files[0]);
    }
    document.getElementById('addActusImage')
        .addEventListener('change', e=> previewImage(e.target, document.getElementById('previewAddActusImage')));
    document.getElementById('modifyActusImage')
        .addEventListener('change', e=> previewImage(e.target, document.getElementById('previewModifyActusImage')));
</script>
</body>
</html>
