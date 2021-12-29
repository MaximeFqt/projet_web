<?php

//var_dump($content);

?>

<table class="table_admin groupes">

    <!-- ============ TABLE GROUPES ============ -->

    <h3> Table groupes </h3>

    <tr>
        <th> Id </th>
        <th> Nom </th>
        <th> Genre </th>
        <th> Image </th>
    </tr>

    <?php foreach ($content as $unGrp): ?>
        <tr>
            <td> <?= $unGrp->getIdGroupe() ?> </td>
            <td> <?= $unGrp->getNom(); ?> </td>
            <td> <?= $unGrp->getGenre(); ?> </td>
            <td> <?= $unGrp->getImage(); ?> </td>
        </tr>
    <?php endforeach; ?>

</table>
