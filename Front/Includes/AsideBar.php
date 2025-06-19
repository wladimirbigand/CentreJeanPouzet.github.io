<!-- SIDEBAR BOOTSTRAP RESPONSIVE -->
<aside id="sidebarOffcanvas"
       class="offcanvas-md offcanvas-start d-flex flex-column p-3 sidebar-custom"
       tabindex="-1">
    <div class="text-center mb-4">
        <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="Logo" class="img-fluid" style="max-height: 120px;">
    </div>

    <ul class="nav flex-column w-100 gap-3">
        <li><a href="TableauDeBord.php" class="sidebar-link <?= $currentPage == 'dashboard' ? 'active' : '' ?>">Tableau de bord</a></li>
        <li><a href="TableauDeBordAccueil.php" class="sidebar-link <?= $currentPage == 'accueil' ? 'active' : '' ?>">Accueil</a></li>
        <li><a href="TableauDeBordHebergements.php" class="sidebar-link <?= $currentPage == 'hebergements' ? 'active' : '' ?>">Hébergements</a></li>
        <li><a href="TableauDeBordAgenda.php" class="sidebar-link <?= $currentPage == 'agenda' ? 'active' : '' ?>">Contact</a></li>
        <li><a href="TableauDeBordActus.php" class="sidebar-link <?= $currentPage == 'actus' ? 'active' : '' ?>">Actualités</a></li>
        <li><a href="TableauDeBordEquipe.php" class="sidebar-link <?= $currentPage == 'equipe' ? 'active' : '' ?>">Équipe</a></li>
        <li><a href="TableauDeBordColos.php" class="sidebar-link <?= $currentPage == 'colos' ? 'active' : '' ?>">Colos</a></li>
    </ul>

    <div class="mt-auto text-center logout">
        <form method="post" action="Logout.php">
            <button type="submit" class="btn btn-danger w-100 mt-4">Se déconnecter</button>
        </form>
    </div>
</aside>
