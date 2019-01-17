<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../repostajes.clase.php";
require_once "../modelo.clase.php";

checkLogin();

$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
$order = isset($_GET["order"]) ? preg_replace("/[^ \-._0-9a-zA-Z]/", "", $_GET["order"]) : "id_repostaje";
list($repostajes, $totalFilas) = Repostaje::getReposVehiculo($_GET["id_vehiculo"], $start, PAGE_SIZE_REPOS, $order);
mostrarCabecera("Registro de repostajes");
navUser();
?>
<div class="container">
    <p class="text-info">Mostrando repostajes <?php echo $start +1 ?>-<?php echo min($start + PAGE_SIZE_REPOS, $totalFilas) ?> de <?php echo $totalFilas ?></p>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th><?php if($order != "id_repostaje") { ?><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;order=id_repostaje"><?php } ?>Id<?php if($order != "id_repostaje") { ?></a><?php } ?></th>
                <th>Vehiculo</th>
                <th><?php if($order != "fecha") { ?><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;order=fecha"><?php } ?>Fecha<?php if($order != "fecha") { ?></a><?php } ?></th>
                <th>Odometro</th>
                <th>Odometro</th>
                <th>Km</th>
                <th>Combustible</th>
                <th><?php if($order != "cantidad") { ?><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;order=cantidad"><?php } ?>Litros<?php if($order != "cantidad") { ?></a><?php } ?></th>
                <th><?php if($order != "precio_total") { ?><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;order=precio_total"><?php } ?>Euros<?php if($order != "precio_total") { ?></a><?php } ?></th>
                <th>Litro €</th>
                <th>L/100Km</th>
                <th><?php if($order != "estacion") { ?><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;order=estacion"><?php } ?>Estacion<?php if($order != "estacion") { ?></a><?php } ?></th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
<?php
$filaCount = 0;
foreach ($repostajes as $repostaje) {
    $filaCount++;
    $array = Modelo::getModeloRepos($repostaje->getValueEncoded("id_repostaje"));
?>
        <tr<?php if ($filaCount % 2 == 0) echo ' class="alt"' ?>>
            <td><a href="ver_mi_repostaje.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;id_repostaje=<?php echo $repostaje->getValueEncoded("id_repostaje") ?>"><?php echo $repostaje->getValueEncoded("id_repostaje") ?></a></td>
            <td><a href="ver_mi_auto.php?id_vehiculo=<?php echo $repostaje->getValueEncoded("id_vehiculo") ?>"><?php echo $array->getMarca() . " " . $array->getValueEncoded("nombre_modelo") . " " . $array->getValueEncoded("motorizacion") ?></a></td>
            <td><?php echo date("d-m-Y", strtotime($repostaje->getValueEncoded("fecha"))) ?></td>
            <td><?php echo $repostaje->getValueEncoded("odometro") ?></td>
            <td><?php echo $repostaje->getValueEncoded("odometro_final") ?></td>
            <td><?php echo $repostaje->getValueEncoded("odometro_final") - $repostaje->getValueEncoded("odometro") ?></td>
            <td><?php echo $repostaje->getValueEncoded("combustible") ?></td>
            <td><?php echo $repostaje->getValueEncoded("cantidad") ?></td>
            <td><?php echo $repostaje->getValueEncoded("precio_total") ?></td>
            <td><?php echo $repostaje->getValueEncoded("precio_litro") ?></td>
            <td><strong><?php echo $repostaje->getValueEncoded("consumo") ?></strong></td>
            <td><?php echo $repostaje->getValueEncoded("estacion") ?></td>
            <td><?php echo $repostaje->getValueEncoded("observaciones") ?></td>
        </tr>
<?php
}
?>
        </tbody>
    </table>
    <ul class="pager">
    
<?php if($start >0) { ?>
        <li><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;start=<?php echo max($start - PAGE_SIZE_REPOS, 0) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Página anterior</a></li>
<?php } ?>
&nbsp;
<?php if($start + PAGE_SIZE_REPOS < $totalFilas) { ?>
        <li><a href="ver_repostajes.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>&amp;start=<?php echo min($start + PAGE_SIZE_REPOS, $totalFilas) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Página siguiente</a></li>
          
<?php } ?>
    </ul>
    <ul class="pager">
        <a href="registro_repostaje.php?id_vehiculo=<?php echo $_GET["id_vehiculo"] ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Añadir repostaje</a>
    </ul> 
</div> <?php
    mostrarPie();
?>