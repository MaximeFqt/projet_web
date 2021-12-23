<?php

use App\Config\Database;

$db = new Database();
$connexion = $db->getConnection();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    $login = $_SESSION['login'];
    $pass = $_SESSION['pass'];
}

$sql = "select * from genremusical";
$genres = $connexion->query($sql);
$genre = $genres->fetchAll(PDO::FETCH_OBJ);

?>

<!-- ===============================
     HEADER COMMUN A TOUTES LES PAGES
     =============================== -->

<header class="principal">
    <h1 id="titreSite"> Concertôt </h1>

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
            <li>
                <form action="categorie.php" method="post">
                    <label for="selectMenu"> Genre : </label>
                    <select name="selectGenre" id="selectMenu">
                        <?php foreach ($genre as $unGenre) : ?>
                            <option value="<?= $unGenre->id_genre; ?>"> <?= $unGenre->nomGenre; ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Ok" id="selectMenu" name="sendSelectGenre">
                </form>
            </li>
        </ul>
    </nav>
</header>
