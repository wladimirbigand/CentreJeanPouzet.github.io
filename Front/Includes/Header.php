<header>
    <a href="../User/Accueil.php" class="image-zoom">
        <img src="../../Images/Logo/LogoJeanPouzet.svg" alt="Logo">
    </a>
    <button class="burger-menu" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <nav>
        <a id="ligne"></a>
        <a href="Accueil.php" class="<?= ($currentPage === 'accueil') ? 'active' : '' ?>">NOTRE ASSO</a>
        <a href="Hebergements.php" class="<?= ($currentPage === 'hebergements') ? 'active' : '' ?>">NOS HEBERGEMENTS</a>
        <a href="Nous Contacter.php" class="<?= ($currentPage === 'contact') ? 'active' : '' ?>">NOUS CONTACTER</a>
        <a href="Actus.php" class="<?= ($currentPage === 'actus') ? 'active' : '' ?>">NOS ACTUS</a>
        <a href="Equipe.php" class="<?= ($currentPage === 'equipe') ? 'active' : '' ?>">NOTRE EQUIPE</a>
        <a href="Colos.php" class="<?= ($currentPage === 'colos') ? 'active' : '' ?>">NOS COLOS</a>
    </nav>
</header>