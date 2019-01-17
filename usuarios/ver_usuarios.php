<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../usuario.clase.php";

checkLoginNoLog();

$array = Usuario::getUsuario($_SESSION["usuario"]);

if (!$array->getValueEncoded("admin")) { //si no es admin no puede ver usuarios
    $user = $_SESSION["usuario"];
    ?>
    <script text='text/javascript'>
        window.location = 'ver_usuario.php?alias=<?php echo $user ?>';
    </script> <?php
    exit;
} else {

$start = isset($_GET["start"]) ? (int)$_GET["start"] : 0;
$order = isset($_GET["order"]) ? preg_replace("/[^a-zA-Z]/", "", $_GET["order"]) : "alias";
list($usuarios, $totalFilas) = Usuario::getUsuarios($start, PAGE_SIZE, $order);
mostrarCabecera("Ver usuarios");
navUser();
?>
<div class="container">
    <p class="text-info">Mostrando usuarios <?php echo $start +1 ?>-<?php echo min($start + PAGE_SIZE, $totalFilas) ?> de <?php echo $totalFilas ?></p>
    <table class="table table-condensed">
        <thead>
        <tr>
            <th><?php if($order != "alias") { ?><a href="ver_usuarios.php?order=alias"><?php } ?>Alias<?php if($order != "alias") { ?></a><?php } ?></th>
            <th><?php if($order != "nombre") { ?><a href="ver_usuarios.php?order=nombre"><?php } ?>Nombre<?php if($order != "nombre") { ?></a><?php } ?></th>
            <th><?php if($order != "apellidos") { ?><a href="ver_usuarios.php?order=apellidos"><?php } ?>Apellidos<?php if($order != "apellidos") { ?></a><?php } ?></th>
            <th><?php if($order != "antiguedad") { ?><a href="ver_usuarios.php?order=antiguedad"><?php } ?>Antiguedad<?php if($order != "antiguedad") { ?></a><?php } ?></th>
            <th><?php if($order != "localidad") { ?><a href="ver_usuarios.php?order=localidad"><?php } ?>Localidad<?php if($order != "localidad") { ?></a><?php } ?></th>
            <th><?php if($order != "direccion") { ?><a href="ver_usuarios.php?order=direccion"><?php } ?>Direccion<?php if($order != "direccion") { ?></a><?php } ?></th>
            <th><?php if($order != "cp") { ?><a href="ver_usuarios.php?order=cp"><?php } ?>CP<?php if($order != "cp") { ?></a><?php } ?></th>
            <th><?php if($order != "telefono") { ?><a href="ver_usuarios.php?order=telefono"><?php } ?>Teléfono<?php if($order != "telefono") { ?></a><?php } ?></th>
            <th><?php if($order != "sexo") { ?><a href="ver_usuarios.php?order=sexo"><?php } ?>Sexo<?php if($order != "sexo") { ?></a><?php } ?></th>
            <th><?php if($order != "web") { ?><a href="ver_usuarios.php?order=web"><?php } ?>Web<?php if($order != "web") { ?></a><?php } ?></th>
            <th><?php if($order != "admin") { ?><a href="ver_usuarios.php?order=admin"><?php } ?>Admin<?php if($order != "admin") { ?></a><?php } ?></th>
        </tr>
        </thead>
        <tbody>
    <?php
    $filaCount = 0;
    foreach ($usuarios as $usuario) {
        $filaCount++;
    ?>
        <tr<?php if ($filaCount % 2 == 0) echo ' class="alt"' ?>>
            <td><a href="ver_usuario.php?alias=<?php echo $usuario->getValueEncoded("alias") ?>"><?php echo $usuario->getValueEncoded("alias") ?></a></td> <!-- getValueEncoded recupera los valores -->
            <td><?php echo $usuario->getValueEncoded("nombre") ?></td>
            <td><?php echo $usuario->getValueEncoded("apellidos") ?></td>
            <td><?php echo $usuario->getValueEncoded("antiguedad") ?></td>
            <td><?php echo $usuario->getValueEncoded("localidad") ?></td>
            <td><?php echo $usuario->getValueEncoded("direccion") ?></td>
            <td><?php echo $usuario->getValueEncoded("cp") ?></td>
            <td><?php echo $usuario->getValueEncoded("telefono") ?></td>
            <td><?php echo $usuario->getValueEncoded("sexo") ?></td>
            <td><?php echo $usuario->getValueEncoded("web") ?></td>
            <td><?php echo $usuario->getValueEncoded("admin") ?></td>
        </tr>
        
    <?php
    }
    ?>
        </tbody>
    </table>
    <ul class="pager">

    <?php if($start >0) { ?>
        <li><a href="ver_usuarios.php?start=<?php echo max($start - PAGE_SIZE, 0) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Página anterior</a></li>
    <?php } ?>
    &nbsp;
    <?php if($start + PAGE_SIZE < $totalFilas) { ?>
        <li><a href="ver_usuarios.php?start=<?php echo min($start + PAGE_SIZE, $totalFilas) ?>&amp;order=<?php echo $order ?>" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Página siguiente</a></li>
    <?php } ?>
    </ul>

    <?php mostrarPie();
    }
?>