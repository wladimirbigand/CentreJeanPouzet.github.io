<?php
session_start();
$currentPage = 'dashboard';

if (!isset($_SESSION['admin'])) {
    header("Location: Login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de Bord - Interface Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"><!-- Bootstrap Bundle (inclut Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
  <link rel="stylesheet" href="../../CSS/Admin/TableauDeBord.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
</head>
<body>

<div class="dashboard-container">
    <!-- Barre latérale -->
    <?php include '../Includes/AsideBar.php'; ?>
    <button class="btn btn-outline-dark d-md-none position-fixed m-3 z-3"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas"
            aria-controls="sidebarOffcanvas">
        <i class="bi bi-list fs-3"></i>
    </button>
    <!-- Contenu principal du tableau de bord de base -->
  <main class="content">
    <header class="header">
        <h1 class="text-center">Bienvenue sur l'interface administrateur</h1>
    </header>

    <!-- Section d'information et guide d'utilisation -->
    <section class="info-section">
      <h2>Guide d'utilisation de l'interface administrateur</h2>
      <p>
        Cette interface vous permet de gérer l'ensemble des contenus du site du Centre Jean Pouzet.
        Le menu latéral vous donne accès aux différentes sections : Hébergements, Contact, Actualités, Équipe et Colos.
      </p>
      <ul>
        <li><strong>Page "Accueil" :</strong> Modifier l’image de fond de l’accueil et le texte de présentation.</li>
        <li><strong>Page "Hébergements" :</strong> Modifier le texte d’introduction, les images des carrousels.</li>
        <li><strong>Page "Contact" :</strong> Modifier l’emploi du temps et les numéros.</li>
        <li><strong>Page "Actualités" :</strong> Modifier le titre, la description et les images de chaque actualités.</li>
        <li><strong>Page "Équipe" :</strong> Changer toutes les fiches des membres en cas de changement.</li>
        <li><strong>Page "Colos" :</strong> Pouvoir ajouter ou modifiez une colo, l’affiche, le titre et les images.</li>
        <li><strong>Bouton de déconnexion :</strong> Bouton permettant de se déconnecter de l’interface administrateur.</li>
      </ul>
      <p>
        Pour modifier un contenu, sélectionnez la section correspondante puis utilisez les formulaires pour ajouter ou mettre à jour les détails.
        Si vous rencontrez des difficultés, consultez la documentation interne ou contactez le support technique.
      </p>
    </section>
      <section class="info-section">
          <a href="../../Documents/ManuelAdmin.pdf" download class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center file-input-label" style="gap: .5rem;">
              <i class="bi bi-filetype-pdf fs-3"></i>
              <span>Télécharger le manuel administrateur</span>
          </a>
      </section>
  </main>
</div>
</body>
</html>
