<?php

//var_dump($content);

?>

<p class="presentation">  </p>

<div id="detail">
    <ul>
        <?php foreach ($content as $unGroupe) : ?>
            <li>
                <?php $img_groupe = $unGroupe['image']; ?>
                <img src="<?= $img_groupe; ?>" alt="<?= $_GET['nom']; ?>">
                <p>
                    Le concert du groupe <?= $unGroupe['nom']; ?> va avoir lieu à <?= $unGroupe['lieu']; ?>.
                </p>
                <p>
                    Il est prévu pour le <?= $unGroupe['date']; ?>.
                </p>
                <p>
                    Le prix de la place est de <?= $unGroupe['prixPlace']; ?> € par personne.
                </p>
            </li>
        <?php endforeach; ?>
        <li>
            <form action="#" id="buy" method="post">
                <p>
                    <label for="buy"> Réserver : </label>
                    <input type="number" id="buy" min="1" name="nbPlace" placeholder="Nombre de place" required/>
                </p>
                <p>
                    <input type="submit" id="btnOkReserv" value="Ok" name="sendBuy">
                </p>
            </form>
        </li>
    </ul>
</div>

<p class="retourIndex">
    <a href="../../index.php"> Retour </a>
</p>
