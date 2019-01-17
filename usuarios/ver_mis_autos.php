<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../miauto.clase.php";
require_once "../modelo.clase.php";

checkLogin();

$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
$order = isset($_GET["order"]) ? preg_replace("/[^ \_a-zA-Z]/", "", $_GET["order"]) : "id_vehiculo";
list($misautos, $totalFilas) = MiAuto::getAutosAlias($_SESSION["usuario"], $start, PAGE_SIZE, $order);
mostrarCabecera("Ver mis vehículos");
navUser();
?>
<div class="container">
    <p class="text-info">Mostrando mis vehículos <?php echo $start +1 ?>-<?php echo min($start + PAGE_SIZE, $totalFilas) ?> de <?php echo $totalFilas ?></p>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th><?php if($order != "id_vehiculo") { ?><a href="ver_mis_autos.php?order=id_vehiculo"><?php } ?>Id_vehiculo<?php if($order != "id_vehiculo") { ?></a><?php } ?></th>
            <th><?php if($order != "tipo") { ?><a href="ver_mis_autos.php?order=tipo"><?php } ?>Tipo<?php if($order != "tipo") { ?></a><?php } ?></th>
            <th>Modelo</th>
            <th><?php if($order != "color") { ?><a href="ver_mis_autos.php?order=color"><?php } ?>Color<?php if($order != "color") { ?></a><?php } ?></th>
            <th><?php if($order != "manufacturado") { ?><a href="ver_mis_autos.php?order=manufacturado"><?php } ?>Manufacturado<?php if($order != "manufacturado") { ?></a><?php } ?></th>
            <th><?php if($order != "repostajes") { ?><a href="ver_mis_autos.php?order=repostajes"><?php } ?>Repostajes<?php if($order != "repostajes") { ?></a><?php } ?></th>
            <th>Imagen</th>
        </tr>
        </thead>
        <tbody>        
<?php
    $filaCount = 0;
    foreach ($misautos as $misauto) {
        $filaCount++;
        $array = Modelo::getModelo($misauto->getValueEncoded("id_modelo"));
?>
        <tr<?php if ($filaCount % 2 == 0) echo ' class="alt"' ?>>
            <td><a href="ver_mi_auto.php?id_vehiculo=<?php echo $misauto->getValueEncoded("id_vehiculo") ?>" class="btn btn-info" role="button"><?php echo $misauto->getValueEncoded("id_vehiculo") ?></a></td>
            <td><?php echo $misauto->getValueEncoded("tipo") ?></td>
            <td><a href="ver_modelo.php?id_modelo=<?php echo $misauto->getValueEncoded("id_modelo") ?>"><?php echo $array->getMarca() . " " . $array->getValueEncoded("nombre_modelo") . " " . $array->getValueEncoded("motorizacion") ?></a></td>
            <td><?php echo $misauto->getValueEncoded("color") ?></td>
            <td><?php echo date("d-m-Y", strtotime($misauto->getValueEncoded("manufacturado"))) ?></td>
            <td><?php echo $misauto->getValueEncoded("repostajes") ?></td>
            <td><img class="img-rounded" src="../fotos/<?php echo $misauto->getValueEncoded("imagen") ?>" height="100" width="150" title="<?php echo $misauto->getValueEncoded("imagen") ?>"></td>
        </tr>
<?php
    }
?>
        </tbody>
    </table>
    <ul class="pager">
    
<?php if($start >0) { ?>
        <li><a href="ver_mis_autos.php?start=<?php echo max($start - PAGE_SIZE, 0) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Anterior</a></li>
<?php } ?>

<?php if($start + PAGE_SIZE < $totalFilas) { ?>
        <li><a href="ver_mis_autos.php?start=<?php echo min($start + PAGE_SIZE, $totalFilas) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Siguiente</a></li>
    </ul>
</div>          
<?php }

    mostrarPie();
?>