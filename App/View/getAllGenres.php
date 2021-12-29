<?php

//var_dump($content);

?>

<table class="table_admin genreMusique">

    <!-- ============ TABLE GENRES ============ -->

    <h3> Table genreMusical </h3>

    <tr>
        <th> Id </th>
        <th> Genre </th>
    </tr>

    <?php foreach ($content as $unGenre): ?>
        <tr>
            <td> <?= $unGenre->getIdGenre() ?> </td>
            <td> <?= $unGenre->getNomGenre(); ?> </td>
        </tr>
    <?php endforeach; ?>

</table>

