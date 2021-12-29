<?php

//var_dump($content);

?>

<table class="table_admin concerts">

    <!-- ============ TABLE CONCERTS ============ -->

    <h3> Table concerts </h3>

    <tr>
        <th> Id </th>
        <th> Id_groupe </th>
        <th> Lieu </th>
        <th> Date </th>
        <th> Prix </th>
    </tr>

    <?php foreach ($content as $unConcert): ?>
        <tr>
            <td> <?= $unConcert->getIdConcert(); ?> </td>
            <td> <?= $unConcert->getGroupe(); ?> </td>
            <td> <?= $unConcert->getLieu(); ?> </td>
            <td> <?= $unConcert->getDate(); ?> </td>
            <td> <?= $unConcert->getPrixPlace(); ?> </td>
        </tr>
    <?php endforeach; ?>

</table>
