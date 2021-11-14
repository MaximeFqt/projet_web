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
            <li> <a href="index.php"> Accueil </a> </li>

            <?php if (isset($role) && $role == 'admin') : ?>
                    <li> <a href="admin.php"> Admin </a> </li>
            <?php endif; ?>

            <?php if (isset($role)) : ?>
                <li> <a href="logout.php"> Déconnection </a> </li>
            <?php else : ?>
                <li> <a id="login"> Connection </a> </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Recherche d'element dans le site -->
    <!--
    <form id="search" action="recherche.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="searchText">Rechercher :</label>
            <input id="searchText" name="query" type="text" value="" />
            <input id ="searchBtn" type="submit" class="bouton" value="OK" />
        </p>
    </form>
    -->
</header>
