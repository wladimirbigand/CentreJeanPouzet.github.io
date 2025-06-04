<?php
session_start();
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
  <link rel="stylesheet" href="../../CSS/Admin/TableauDeBordCommun.css">
  <link rel="stylesheet" href="../../CSS/Admin/TableauDeBord.css">
    <link rel="icon" type="image/vnd.icon" href="../../Images/Logo/logo.png">
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
        <li><a href="TableauDeBord.php" class="active">Tableau de bord</a></li>
        <li><a href="TableauDeBordAccueil.php">Accueil</a></li>
        <li><a href="TableauDeBordHebergements.php">Hébergements</a></li>
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

  <!-- Contenu principal du tableau de bord de base -->
  <main class="content">
    <header class="header">
      <h1>Bienvenue sur l'interface administrateur</h1>
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
  </main>
</div>
</body>
</html>
