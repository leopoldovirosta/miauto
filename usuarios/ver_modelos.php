<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../modelo.clase.php";

$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
$order = isset($_GET["order"]) ? preg_replace("/[^a-zA-Z_]/", "", $_GET["order"]) : "id_modelo";
list($modelos, $totalFilas) = Modelo::getModelos($start, PAGE_SIZE, $order);
mostrarCabecera("Modelos en nuestra base de datos");
navUser();
?>
<div class="container">
    <p class="text-info">Mostrando modelos <?php echo $start +1 ?>-<?php echo min($start + PAGE_SIZE, $totalFilas) ?> de <?php echo $totalFilas ?></p>
    <table class="table table-condensed">
        <thead>
            <tr>
            <th><?php if($order != "id_modelo") { ?><a href="ver_modelos.php?order=id_modelo"><?php } ?>ID_modelo<?php if($order != "id_modelo") { ?></a><?php } ?></th>
            <th><?php if($order != "fabricante") { ?><a href="ver_modelos.php?order=fabricante"><?php } ?>Fabricante<?php if($order != "fabricante") { ?></a><?php } ?></th>
            <th><?php if($order != "nombre_modelo") { ?><a href="ver_modelos.php?order=nombre_modelo"><?php } ?>Nombre modelo<?php if($order != "nombre_modelo") { ?></a><?php } ?></th>
            <th>Motorizacion</th>
            <th><?php if($order != "potencia") { ?><a href="ver_modelos.php?order=potencia"><?php } ?>Potencia<?php if($order != "potencia") { ?></a><?php } ?></th>
            <th><?php if($order != "cilindrada") { ?><a href="ver_modelos.php?order=cilindrada"><?php } ?>Cilindrada<?php if($order != "cilindrada") { ?></a><?php } ?></th>
            <th>Cambio</th>    
            <th>Imagen</th>
            </tr>
        </thead>
        <tbody>

<?php
$filaCount = 0;
foreach ($modelos as $modelo) {
    $filaCount++;
?>
    <tr<?php if ($filaCount % 2 == 0) echo ' class="alt"' ?>>
        <td><a href="ver_modelo.php?id_modelo=<?php echo $modelo->getValueEncoded("id_modelo") ?>" class="btn btn-info" role="button"><?php echo $modelo->getValueEncoded("id_modelo") ?></a>
        <td><?php echo $modelo->getMarca() ?></td>
        <td><?php echo $modelo->getValueEncoded("nombre_modelo") ?></td>
        <td><?php echo $modelo->getValueEncoded("motorizacion") ?></td>
        <td><?php echo $modelo->getValueEncoded("potencia") ?></td>
        <td><?php echo $modelo->getValueEncoded("cilindrada") ?></td>
        <td><?php echo $modelo->getValueEncoded("cambio") ?></td>
        <td><img class="img-rounded" src="/fotos/<?php echo $modelo->getValueEncoded("imagen") ?>" height="100" width="150" title="<?php echo $modelo->getValueEncoded("imagen") ?>"></td>
    </tr>
<?php
}
?>
        </tbody>
    </table>
    <ul class="pager">
        
<?php if($start >0) { ?>
        <li><a href="ver_modelos.php?start=<?php echo max($start - PAGE_SIZE, 0) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Anterior</a></li>
            
<?php } ?>

<?php if($start + PAGE_SIZE < $totalFilas) { ?>
        <li><a href="ver_modelos.php?start=<?php echo min($start + PAGE_SIZE, $totalFilas) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Siguiente</a></li>
<?php } ?>
    </ul>
</div>
<?php
    mostrarPie();
?>