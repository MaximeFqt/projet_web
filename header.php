<?php

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    $login = $_SESSION['login'];
    $pass = $_SESSION['pass'];
}

?>

<!-- ===============================
     HEADER COMMUN A TOUTES LES PAGES
     =============================== -->

<header class="principal">
    <h1 id="titreSite"> TrouveTonConcert </h1>

    <!-- Navigation dans le site -->
    <nav>
        <ul class="nav">
            <li><a href="index.php"> Accueil </a></li>
            <li><a href="panier.php"> Panier </a></li>

            <?php if (isset($role) && $role == 'admin') : ?>
                <li><a href="admin.php"> Admin </a></li>
            <?php endif; ?>

            <?php if (isset($role)) : ?>
                <li><a href="logout.php"> Déconnection </a></li>
            <?php else : ?>
                <li><a id="login"> Connection </a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <nav>
        <ul class="menu_categorie">
            <li><a href="categorie.php?cat=all"> Tous les genres </a></li>
            <li><a href="categorie.php?cat=1"> Rock </a></li>
            <li><a href="categorie.php?cat=2"> Chanson Française </a></li>
        </ul>
    </nav>
</header>
