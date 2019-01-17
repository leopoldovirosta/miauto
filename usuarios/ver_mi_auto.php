<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../miauto.clase.php";
require_once "../modelo.clase.php";
require_once "../repostajes.clase.php";

checkLogin();

$autoId = isset($_GET["id_vehiculo"]) ? (int)$_GET["id_vehiculo"] : 0;
$auto = MiAuto::getAuto($autoId);

/*if(!$auto = MiAuto::getAuto($autoId)) {
    mostrarCabecera("Error");
    echo "<div>Este vehículo no es de tu propiedad.</div>";
    mostrarPie();
    exit;
}*/

if (isset($_POST["action"]) and $_POST["action"] == "Grabar Cambios" ) {
    grabarModelo();
} elseif (isset($_POST["action"]) and $_POST["action"] == "Borrar Vehiculo" ) {
    borrarModelo();
} else {
    muestraForm(array(), array(), $auto);
}

function muestraForm($mensajesError, $requeridosFalta, $auto) {
    
    mostrarCabecera("Detalles del vehiculo");
    navUser();
    if($mensajesError) {
        foreach($mensajesError as $mensajeError) {
            echo $mensajeError;
        }
    }
    $start = isset($_REQUEST["start"]) ? (int)$_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z_]/", "", $_REQUEST["order"]) : "id_vehiculo";

?>
<div class="container">
  <div class="row">
    
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar detalles</h4>
          </div>
          <div class="modal-body">
            <p class="text-info">Si existe algún dato erróneo puedes cambiarlo directamente y pinchar en Grabar Cambios.</p>
            <p class="text-info">Los campos marcados con un (*) son necesarios.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </div>
    <!-- Fin Modal -->  
    <form class="form-horizontal" action="ver_mi_auto.php" method="post" style="margin-bottom: 50px;" enctype="multipart/form-data">
        <div class="col-sm-6">
            <input type="hidden" name="id_vehiculo" id="id_vehiculo" value="<?php echo $auto->getValueEncoded("id_vehiculo") ?>" />
            <input type="hidden" name="start" id="start" value="<?php echo $start ?>" />
            <input type="hidden" name="order" id="order" value="<?php echo $order ?>" />
            <div class="form-group <?php validaCampo("tipo", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Tipo *</label>
                <div class="col-sm-5">
                    <select name="tipo" id="inputWarning" size="1">
                    <?php foreach($auto->getTipo() as $valor => $clave) { ?>
                            <option value="<?php echo $valor ?>" <?php setSelected($auto, "tipo", $valor ) ?>><?php echo $clave ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group <?php validaCampo("color", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Color *</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="Introduce el color" name="color" for="inputWarning" value="<?php echo $auto->getValueEncoded("color") ?>" />
                </div>
            </div>
            <div class="form-group <?php validaCampo("manufacturado", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Fecha de fabricación (Año-Mes-Día) *</label>
                <div class="col-sm-4">
                    <div class="form-group input-group date" data-date-format="YYYY-mm-dd">
                            <input type='text' class="form-control" name="manufacturado" id="calendario" value="<?php echo $auto->getValueEncoded("manufacturado") ?>" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                </div>
            </div>
            <div class="form-group <?php validaCampo("id_modelo", $requeridosFalta) ?>">
                <label class="control-label col-sm-4" for="inputWarning">Modelo *</label>
                <div class="col-sm-3">
                    <select name="id_modelo" id="inputWarning" size="1">
                    <?php $array = Modelo::getTodosModelo();
                        foreach ($array as $modelo) {
                            ?>
                            <option value="<?php echo $modelo->getValueEncoded("id_modelo") ?>" <?php if($modelo->getValueEncoded("id_modelo") == $auto->getValueEncoded("id_modelo")) echo 'selected="selected"' ?>><?php echo $modelo->getMarca() . " " . $modelo->getValueEncoded("nombre_modelo") . " " . $modelo->getValueEncoded("motorizacion") ?></option>;
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="inputWarning">Imagen (solo .jpeg, e inferior a 2MB)</label>
                <div class="col-sm-8">
                    <img class="img-responsive img-rounded" src="../fotos/<?php echo $auto->getValueEncoded("imagen") ?>" height="100" width="150" title="<?php echo $auto->getValueEncoded("imagen") ?>">
                    <input type="file" class="form-control" name="imagen" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4"></div>
                <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="grabarBoton" value="Grabar Cambios" />
                <?php $repos = new Repostaje(array());
                    $filas = $repos->reposExiste($_REQUEST["id_vehiculo"]);
                    if ($filas == 0) { ?>
                    <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="borrarBoton" value="Borrar Vehiculo" style="margin-right: 20px;" />
                <?php } ?>
            </div>
            <div class="form-group">
                <div class="col-sm-4"></div>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Como editar el modelo</button>
            </div>
        </div>
        <div class="col-sm-6">
             <img class="img-responsive img-rounded" src="../fotos/<?php echo $auto->getValueEncoded("imagen") ?>" title="<?php echo $auto->getValueEncoded("imagen") ?>">
        </div>    
    </form>
  </div>
</div>
     <ul class="pager">
        <a href="javascript:history.go(-1)" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Volver</a>
    </ul>
<?php
    mostrarPie();
}

function grabarModelo() {
    
    $requeridos = array("tipo", "manufacturado", "id_modelo", "color");
    $requeridosFalta = array();
    $mensajesError =  array();
    $foto = $_FILES["imagen"]["name"];
    $temp = $_FILES["imagen"]["tmp_name"];//nombre temporal que asigna el servidor al archivo
    $tamano = $_FILES["imagen"]["size"];
    $tipo = $_FILES["imagen"]["type"];
    
    if(!$_FILES["imagen"]["name"]) {
        $vehiculo = MiAuto::getAuto($_REQUEST["id_vehiculo"]);
        $foto = $vehiculo->getValueEncoded("imagen");
        $tipo = "image/jpeg";
    }
    
    $auto = new MiAuto( array("id_vehiculo"=>isset($_POST["id_vehiculo"]) ? (int)$_REQUEST["id_vehiculo"] : 0, "tipo"=>isset($_POST["tipo"]) ? preg_replace("/[^ a-zA-Z]/", "", $_POST["tipo"]) : "", "id_modelo"=>isset($_POST["id_modelo"]) ? preg_replace("/[^ 0-9]/", "", $_POST["id_modelo"]) : "", "color"=>isset($_POST["color"]) ? preg_replace("/[^ a-zA-Z]/", "", $_POST["color"]) : "", "manufacturado"=>isset($_POST["manufacturado"]) ? preg_replace("/[^ \-0-9]/", "", $_POST["manufacturado"]) : "", "imagen"=>$foto));
 
    foreach ($requeridos as $requerido ) {
        if(!$auto->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $auto);
    } else {
            $kb = $tamano/1024;
            $mb = $kb/1024;
            if ($mb > 2) { ?>
                <script text='text/javascript'>
                alert('La imagen supera los 2 MB, vuelve a intentarlo.');
                window.location = 'ver_mis_autos.php';
                </script> <?php
                exit;
            }

            if ($tipo != "image/jpeg") { ?>
            <script text='text/javascript'>
            alert('La imagen solo puede ser .jpeg, vuelve a intentarlo.');
            window.location = 'ver_mis_autos.php';
            </script> <?php
            exit;
            }
            move_uploaded_file($temp, "../fotos/$foto");
            $auto->update();
            confirmar();
    }
}

function borrarModelo() {
    $auto = new MiAuto(array("id_vehiculo"=>isset($_POST["id_vehiculo"]) ? (int)$_REQUEST["id_vehiculo"] : 0, ));
    $auto->borrar();
    confirmar();
}

function confirmar() {
    $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z_]/","", $_REQUEST["order"]) : "id_vehiculo";
    mostrarCabecera("Cambios grabados");
?>
    <script text='text/javascript'>
        alert('Cambios grabados!');
        window.location = 'ver_mis_autos.php?start=<?php echo $start ?>&amp;order=<?php echo $order ?>';
    </script>
<?php
    exit;

    mostrarPie();
}
?>
