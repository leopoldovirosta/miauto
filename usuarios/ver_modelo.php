<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../modelo.clase.php";
require_once "../miauto.clase.php";

checkLogin();
global $nameFoto;

$modeloId = isset($_REQUEST["id_modelo"]) ? (int)$_REQUEST["id_modelo"] : 0;

if(!$modelo = Modelo::getModelo($modeloId)) {
    mostrarCabecera("Error");
    echo "<div>Este modelo no existe.</div>";
    mostrarPie();
    exit;
}
$nameFoto = $modelo->getValueEncoded("imagen");

if (isset($_POST["action"]) and $_POST["action"] == "Grabar Cambios" ) {
    grabarModelo();
} elseif (isset($_POST["action"]) and $_POST["action"] == "Borrar Modelo" ) {
    borrarModelo();
} else {
    muestraForm(array(), array(), $modelo);
}

function muestraForm($mensajesError, $requeridosFalta, $modelo) {
    global $nameFoto;
    mostrarCabecera("Detalles del modelo: " . $modelo->getMarca() . " " . $modelo->getValueEncoded("nombre_modelo") );
    navUser();
    if($mensajesError) {
        foreach($mensajesError as $mensajeError) {
            echo $mensajeError;
        }
    }
    $start = isset($_REQUEST["start"]) ? (int)$_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z_]/", "", $_REQUEST["order"]) : "id_modelo";

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
            <p class="text-info">Usa punto para especificar decimales.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </div>
    <!-- Fin Modal -->    
   
    <form class="form-horizontal" action="ver_modelo.php" method="post" style="margin-bottom: 50px;" enctype="multipart/form-data">
        <input type="hidden" name="id_modelo" id="id_modelo" value="<?php echo $modelo->getValueEncoded("id_modelo") ?>" />
        <input type="hidden" name="start" id="start" value="<?php echo $start ?>" />
        <input type="hidden" name="order" id="order" value="<?php echo $order ?>" />
     <div class="col-sm-6">
        <div class="form-group <?php validaCampo("fabricante", $requeridosFalta) ?>">
            <label class="control-label col-sm-5" for="inputWarning">Fabricante *</label>
            <div class="col-sm-5">
                <select name="fabricante" id="inputWarning" size="1">
                <?php foreach($modelo->getMarcaClave() as $value => $label) { ?>
                        <option value="<?php echo $value ?>"<?php setSelected($modelo,"fabricante", $value) ?>><?php echo $label ?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group <?php validaCampo("nombre_modelo", $requeridosFalta) ?>">
            <label class="control-label col-sm-5" for="inputWarning">Nombre de modelo  *</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="Introduce el nombre del modelo" name="nombre_modelo" for="inputWarning" value="<?php echo $modelo->getValueEncoded("nombre_modelo") ?>" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("motorizacion", $requeridosFalta) ?>">
            <label class="control-label col-sm-5" for="inputWarning">Motorizacion *</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="Introduce la motorización del vehiculo" name="motorizacion" for="inputWarning" value="<?php echo $modelo->getValueEncoded("motorizacion") ?>" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("combustible", $requeridosFalta) ?>">
            <label class="control-label col-sm-5" for="inputWarning">Combustible *</label>
            <div class="col-sm-5">
                <select name="combustible" id="inputWarning" size="1">
                <?php foreach($modelo->getModeloCombustible() as $valor=>$clave) { ?>
                        <option value="<?php echo $valor ?>"<?php setSelected($modelo,"combustible", $valor) ?>><?php echo $clave ?></option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Potencia CV</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="potencia" for="inputWarning" value="<?php echo $modelo->getValueEncoded("potencia") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Consumo extraurbano l/100Km</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="consumo_extraurbano" for="inputWarning" value="<?php echo $modelo->getValueEncoded("consumo_extraurbano") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Consumo mixto l/100Km</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="consumo_mixto" for="inputWarning" value="<?php echo $modelo->getValueEncoded("consumo_mixto") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Consumo urbano l/100Km</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="consumo_urbano" for="inputWarning" value="<?php echo $modelo->getValueEncoded("consumo_urbano") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Emision CO2 gr/Km</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="emision_co2" for="inputWarning" value="<?php echo $modelo->getValueEncoded("emision_co2") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Depósito litros</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="deposito" for="inputWarning" value="<?php echo $modelo->getValueEncoded("deposito") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Cilindrada cm3</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="cilindrada" for="inputWarning" value="<?php echo $modelo->getValueEncoded("cilindrada") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Velocidades</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="velocidades" for="inputWarning" value="<?php echo $modelo->getValueEncoded("velocidades") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Tipo de cambio</label>
            <div class="col-sm-3">
                <select name="cambio" id="inputWarning" size="1">
                <?php foreach($modelo->getModeloCambio() as $valor=>$clave) { ?>
                        <option value="<?php echo $valor ?>"<?php setSelected($modelo,"cambio", $valor) ?>><?php echo $clave ?></option>
                <?php } ?>
                </select>
            </div>
        </div>
   </div>
       
      <div class="col-sm-6">
        <div class="form-group">
            <img class="img-responsive img-rounded" src="../fotos/<?php echo $nameFoto ?>" alt="<?php echo $nameFoto ?>">
        </div>
        <div class="form-group">
            <label class="control-label col-sm-5" for="inputWarning">Imagen (solo .jpeg, e inferior a 2MB)</label>
            <div class="col-sm-7">
                <img class="img-responsive img-rounded" src="../fotos/<?php echo $nameFoto ?>" height="100" width="150" title="<?php echo $nameFoto ?>">
                <input type="file" class="form-control" name="imagen" id="inputWarning" />
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="submitBoton" value="Grabar Cambios" />
            <?php $repos = new MiAuto(array());
                $filas = $repos->userModelos($_REQUEST["id_modelo"]);
                if ($filas == 0) { ?>
            <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="borrarBoton" value="Borrar Modelo" />
            <?php } ?>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Como editar el modelo</button>
        </div>
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
    global $nameFoto;
    $requeridos = array("fabricante", "nombre_modelo", "motorizacion", "combustible");
    $requeridosFalta = array();
    $mensajesError =  array();
    $foto = $_FILES["imagen"]["name"];
    $temp = $_FILES["imagen"]["tmp_name"];//nombre temporal que asigna el servidor al archivo
    $tamano = $_FILES["imagen"]["size"];
    $tipo = $_FILES["imagen"]["type"];
    if(!$foto) {
        $foto = $nameFoto;
        $tipo = "image/jpeg";
    }
    
    $modelo = new Modelo( array("id_modelo"=>isset($_POST["id_modelo"]) ? (int)$_REQUEST["id_modelo"] : 0, "fabricante"=>isset($_POST["fabricante"]) ? preg_replace("/[^ a-zA-Z0-9]/", "", $_POST["fabricante"]) : "", "nombre_modelo"=>isset($_POST["nombre_modelo"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["nombre_modelo"]) : "", "motorizacion"=>isset($_POST["motorizacion"]) ? preg_replace("/[^ \.\-\_a-zA-Z0-9]/", "", $_POST["motorizacion"]) : "", "combustible"=>isset($_POST["combustible"]) ? preg_replace("/[^ a-zA-Z]/", "", $_POST["combustible"]) : "", "potencia"=>isset($_POST["potencia"]) ? preg_replace("/[^ 0-9]/", "", $_POST["potencia"]) : "", "consumo_extraurbano"=>isset($_POST["consumo_extraurbano"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["consumo_extraurbano"]) : "", "consumo_mixto"=>isset($_POST["consumo_mixto"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["consumo_mixto"]) : "", "consumo_urbano"=>isset($_POST["consumo_urbano"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["consumo_urbano"]) : "", "emision_co2"=>isset($_POST["emision_co2"]) ? preg_replace("/[^ 0-9]/", "", $_POST["emision_co2"]) : "", "deposito"=>isset($_POST["deposito"]) ? preg_replace("/[^ 0-9]/", "", $_POST["deposito"]) : "", "cilindrada"=>isset($_POST["cilindrada"]) ? preg_replace("/[^ 0-9]/", "", $_POST["cilindrada"]) : "", "velocidades"=>isset($_POST["velocidades"]) ? preg_replace("/[^ 0-9]/", "", $_POST["velocidades"]) : "", "cambio"=>isset($_POST["cambio"]) ? preg_replace("/[^ a-zA-Z]/", "", $_POST["cambio"]) : "", "imagen"=>$foto ));
    //print_r($modelo);
    //exit;
    foreach ($requeridos as $requerido ) {
        if(!$modelo->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $modelo);
    } else {
            $kb = $tamano/1024;
            $mb = $kb/1024;
            if ($mb > 2) { ?>
                <script text='text/javascript'>
                alert('La imagen supera los 2 MB, vuelve a intentarlo.');
                window.location = 'ver_modelos.php';
                </script> <?php
                exit;
            }
    
            if ($tipo != "image/jpeg") { ?>
            <script text='text/javascript'>
            alert('La imagen solo puede ser .jpeg, vuelve a intentarlo.');
            window.location = 'ver_modelos.php';
            </script> <?php
            exit;
            }
        move_uploaded_file($temp, "../fotos/$foto");
        $modelo->update();
        confirmar();
    }
}

function borrarModelo() {
    $modelo = new Modelo(array("id_modelo"=>isset($_POST["id_modelo"]) ? (int)$_REQUEST["id_modelo"] : 0, ));
    $modelo->borrar();
    confirmar();
}

function confirmar() {
    $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z_]/","", $_REQUEST["order"]) : "id_modelo";
    mostrarCabecera("Cambios grabados");
?>
<script text='text/javascript'>
            alert('Tus cambios han sido guardados.');
            window.location = 'ver_modelos.php?start=<?php echo $start ?>&amp;order=<?php echo $order ?>';
            </script> <?php
            exit; ?>
<?php
    mostrarPie();
}
?>
