<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../miauto.clase.php";
require_once "../modelo.clase.php";

checkLogin();

if (!$comprobar = MiAuto::getVehiculoModelo($_SESSION["usuario"])) { ?>
        <script text='text/javascript'>
            alert('No tienes asignado ningun vehiculo, registra uno.');
            window.location = 'registro_mi_auto.php';
        </script> <?php
        exit;
}

mostrarCabecera("Selecciona tu vehiculo");
navUser();
?>
<div class="container">
  <div class="row">
    <form class="form-horizontal"action="registro_repostaje.php" method="get" style="margin-bottom: 50px;">
        <div class="col-sm-6">
            <div class="col-sm-3"></div>
            <p class="text-info">Selecciona el vehículo:</p>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <div class="form-group">
                    <select name="id_vehiculo" id="id_vehiculo" size="1">
                        <?php $array = MiAuto::getVehiculoModelo($_SESSION["usuario"]);    
                        foreach ($array as $modelo) { 
                        $array1 = Modelo::getModelo($modelo->getValueEncoded("id_modelo")); ?>
                        <option value="<?php echo $modelo->getValueEncoded("id_vehiculo") ?>"><?php echo $array1->getMarca() . " " . $array1->getValueEncoded("nombre_modelo") . " " . $array1->getValueEncoded("motorizacion") ?></option>;
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="col-sm-6"></div>
                        <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="grabarBoton" value="Ver" />
                </div>
<!--                <ul class="pager">
                    <a href="javascript:history.go(-1)" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Volver</a>
                </ul>
-->
            </div>
        </div>
        <div class="col-sm-6">
            <img class="img-circle float-right" src="../fotos/repostar.jpg" width="100%;" >
        </div>
    </form>
  </div>
</div>
<?php
    
    mostrarPie();
?>