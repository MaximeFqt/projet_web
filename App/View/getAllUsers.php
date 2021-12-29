<?php

//var_dump($content);

?>

<table class="table_admin users">

    <!-- ============ TABLE USERS ============ -->

    <h3> Table users </h3>

    <tr>
        <th> Id </th>
        <th> Login </th>
        <th> Email </th>
    </tr>

    <?php foreach ($content as $unUsr): ?>
        <tr>
            <td> <?= $unUsr->getIdUser(); ?> </td>
            <td> <?= $unUsr->getLogin(); ?> </td>
            <td> <?= $unUsr->getEmail(); ?> </td>
        </tr>
    <?php endforeach; ?>

</table>
