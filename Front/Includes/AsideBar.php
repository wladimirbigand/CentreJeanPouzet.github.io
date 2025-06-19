<aside class="sidebar">
    <div class="logo">
        <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="">
    </div>
    <nav>
        <ul>
            <li><a href="TableauDeBord.php" class="<?= $currentPage == 'dashboard' ? 'active' : '' ?>">Tableau de bord</a></li>
            <li><a href="TableauDeBordAccueil.php" class="<?= $currentPage == 'accueil' ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="TableauDeBordHebergements.php" class="<?= $currentPage == 'hebergements' ? 'active' : '' ?>">Hébergements</a></li>
            <li><a href="TableauDeBordAgenda.php" class="<?= $currentPage == 'agenda' ? 'active' : '' ?>">Contact</a></li>
            <li><a href="TableauDeBordActus.php" class="<?= $currentPage == 'actus' ? 'active' : '' ?>">Actualités</a></li>
            <li><a href="TableauDeBordEquipe.php" class="<?= $currentPage == 'equipe' ? 'active' : '' ?>">Équipe</a></li>
            <li><a href="TableauDeBordColos.php" class="<?= $currentPage == 'colos' ? 'active' : '' ?>">Colos</a></li>
        </ul>
    </nav>
    <div class="logout">
        <form method="post" action="Logout.php">
            <button type="submit">Se déconnecter</button>
        </form>
    </div>
</aside>
