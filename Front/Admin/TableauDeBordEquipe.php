<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord – Équipe</title>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordEquipe.css">
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
                <li><a href="#" class="active">Équipe</a></li>
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
            <div class="admin-block team-member-info">
                <h2>Ajouter un membre</h2>
                <label for="addMemberName">Prénom :</label>
                <input type="text" id="addMemberName" placeholder="Alice">

                <label for="addMemberImage">Photo du membre :</label>
                <input type="file" id="addMemberImage" accept="image/*">
                <div class="preview-container" id="previewAddMemberImage"></div>

                <label for="addMemberDesc">Description :</label>
                <textarea id="addMemberDesc" rows="5" placeholder="Présentation du membre..."></textarea>
            </div>
            <div class="admin-block actions">
                <button id="btn-add-member-save">Enregistrer un membre</button>
            </div>
        </section>

        <!-- Section « Modifier » -->
        <section id="modify-member" class="action-section">
            <div class="admin-block team-member-info">
                <h2>Modifier un membre</h2>
                <p>Choisir le membre :</p>
                <select id="selectMemberToEdit">
                    <option value="1">Alice</option>
                    <option value="2">Olivier</option>
                    <option value="2">Iana</option>
                    <option value="2">Xavier</option>
                    <option value="2">Fabienne</option>
                    <option value="2">Marie-Agnès</option>
                    <!-- … -->
                </select>

                <label for="modifyMemberName">Prénom :</label>
                <input type="text" id="modifyMemberName" value="Alice">

                <label for="modifyMemberImage">Photo du membre :</label>
                <input type="file" id="modifyMemberImage" accept="image/*">

                <div class="preview-container" id="previewModifyMemberImage">
                    <img src="../../Images/Equipe/ALICE.webp" alt="Photo actuelle">
                </div>

                <label for="modifyMemberDesc">Description :</label>
                <textarea id="modifyMemberDesc" rows="5">Description actuelle…</textarea>
            </div>
            <div class="admin-block actions">
                <button id="btn-modify-member-save">Enregistrer la modification</button>
            </div>
        </section>

        <!-- Section « Supprimer » -->
        <section id="delete-member" class="action-section">
            <div class="admin-block team-member-delete">
                <h2>Supprimer un membre</h2>
                <p>Choisir le membre à supprimer :</p>
                <select id="selectMemberToDelete">
                    <option value="1">Alice</option>
                    <option value="2">Olivier</option>
                    <option value="2">Iana</option>
                    <option value="2">Xavier</option>
                    <option value="2">Fabienne</option>
                    <option value="2">Marie-Agnès</option>
                    <!-- … -->
                </select>
            </div>
            <div class="admin-block actions">
                <button id="btn-delete-member-save">Confirmer la suppression</button>
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
