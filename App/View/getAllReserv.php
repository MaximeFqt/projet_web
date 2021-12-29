<?php

//var_dump($content);

?>

<table class="table_admin reservation">

    <!-- ============ TABLE RESERVATIONS ============ -->

    <h3> Table reservations </h3>

    <tr>
        <th> Id </th>
        <th> User </th>
        <th> Concert </th>
        <th> Nombre place </th>
        <th> PrixTotal </th>
        <th> idGroupe </th>
        <th> Lieu </th>
        <th> Date </th>
        <th> </th>
    </tr>

    <?php foreach ($content as $uneReserv): ?>
        <tr>
            <td> <?= $uneReserv->getIdReserv(); ?> </td>
            <td> <?= $uneReserv->getIdUser(); ?> </td>
            <td> <?= $uneReserv->getIdConcert(); ?> </td>
            <td> <?= $uneReserv->getNbPlace(); ?> </td>
            <td> <?= $uneReserv->getPrixTotal(); ?> </td>
            <td> <?= $uneReserv->getGroupe(); ?> </td>
            <td> <?= $uneReserv->getLieu(); ?> </td>
            <td> <?= $uneReserv->getDate(); ?> </td>
            <td id="btnAnnulReserv">
                <form action="../../index.php?admin=true&deleteRes=true" method="post">
                    <input type="hidden" name="idRes" value="<?= $uneReserv->getIdReserv(); ?>">
                    <input type="submit" name="annulReserv" value="X">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>
