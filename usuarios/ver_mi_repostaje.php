<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../repostajes.clase.php";

checkLogin();

$reposId = isset($_REQUEST["id_repostaje"]) ? (int)$_REQUEST["id_repostaje"] : 0;

if(!$repos = Repostaje::getRepo($reposId)) {
    mostrarCabecera("Error");
    echo "<div>No existen repostajes.</div>";
    mostrarPie();
    exit;
}

if (isset($_POST["action"]) and $_POST["action"] == "Grabar Cambios" ) {
    grabarModelo();
} elseif (isset($_POST["action"]) and $_POST["action"] == "Borrar Entrada" ) {
    borrarModelo();
} else {
    muestraForm(array(), array(), $repos);
}

function muestraForm($mensajesError, $requeridosFalta, $repos) {
    mostrarCabecera("Detalles del repostaje");
    navUser();
    if($mensajesError) {
        foreach($mensajesError as $mensajeError) {
            echo $mensajeError;
        }
    }
    $start = isset($_REQUEST["start"]) ? (int)$_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z_]/", "", $_REQUEST["order"]) : "id_repostaje";
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

    <form class="form-horizontal" action="ver_mi_repostaje.php" method="post" style="margin-bottom: 50px;">
        <div class="col-sm-12">
            <input type="hidden" name="id_repostaje" id="id_repostaje" value="<?php echo $repos->getValueEncoded("id_repostaje") ?>" />
            <input type="hidden" name="start" id="start" value="<?php echo $start ?>" />
            <input type="hidden" name="order" id="order" value="<?php echo $order ?>" />
            <div class="form-group <?php validaCampo("fecha", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Fecha (Año-Mes-Día)  *</label>
                <div class="col-sm-2">
                    <div class="form-group input-group date" data-date-format="YYYY-mm-dd">
                        <input type='text' class="form-control" name="fecha" id="calendario" value="<?php echo $repos->getValueEncoded("fecha") ?>" />
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group <?php validaCampo("odometro", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Odometro  *</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="kilometros iniciales" name="odometro" for="inputWarning" value="<?php echo $repos->getValueEncoded("odometro") ?>" />
                </div>
            </div>
            <div class="form-group <?php validaCampo("odometro_final", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Odometro final *</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="kilometros finales" name="odometro_final" for="inputWarning" value="<?php echo $repos->getValueEncoded("odometro_final") ?>" />
                </div>
            </div>
            <div class="form-group <?php validaCampo("combustible", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Combustible *</label>
                <div class="col-sm-3">
                    <select name="combustible" id="combustible" size="1">
                        <?php foreach($repos->getCombustible() as $valor => $clave) { ?>
                        <option value="<?php echo $valor ?>" <?php setSelected($repos, "combustible", $valor ) ?>><?php echo $clave ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group <?php validaCampo("cantidad", $requeridosFalta) ?>">
                <label class="control-label col-sm-5" for="inputWarning">Litros repostados *</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="Litros de combustible" name="cantidad" for="inputWarning" value="<?php echo $repos->getValueEncoded("cantidad") ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="inputWarning">Precio repostaje</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="Total repostaje €" name="precio_total" for="inputWarning" value="<?php echo $repos->getValueEncoded("precio_total") ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="inputWarning">Precio del litro</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="Precio litro €" name="precio_litro" for="inputWarning" value="<?php echo $repos->getValueEncoded("precio_litro") ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="inputWarning">Observaciones</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" name="observaciones" for="inputWarning" value="<?php echo $repos->getValueEncoded("observaciones") ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-5" for="inputWarning">Estacion</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" placeholder="Estación de repostaje" name="estacion" for="inputWarning" value="<?php echo $repos->getValueEncoded("estacion") ?>" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-5"></div>
                    <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="grabarBoton" value="Grabar Cambios" />
                    <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="borrarBoton" value="Borrar Entrada" />
            </div>
            <div class="form-group">
                <div class="col-sm-5"></div>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Como editar el repostaje</button>
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
    $requeridos = array("fecha", "odometro", "odometro_final", "combustible", "cantidad");
    $requeridosFalta = array();
    $mensajesError =  array();
    $consumo = ($_POST["cantidad"] * 100);
    $consumo1 = ($_POST["odometro_final"] - $_POST["odometro"]);
    $consumo2 = number_format(( $consumo / $consumo1),2);
    
    $repos = new Repostaje( array("id_repostaje"=>isset($_POST["id_repostaje"]) ? (int)$_REQUEST["id_repostaje"] : 0, "fecha"=>isset($_POST["fecha"]) ? preg_replace("/[^ \-0-9]/", "", $_POST["fecha"]) : "", "odometro"=>isset($_POST["odometro"]) ? (int)$_REQUEST["odometro"] : 0, "odometro_final"=>isset($_POST["odometro_final"]) ? (int)$_REQUEST["odometro_final"] : 0, "combustible"=>isset($_POST["combustible"]) ? preg_replace("/[^ a-zA-Z 0-9]/", "", $_POST["combustible"]) : "", "cantidad"=>isset($_POST["cantidad"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["cantidad"]) : 0, "precio_total"=>isset($_POST["precio_total"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["precio_total"]) : 0, "precio_litro"=>isset($_POST["precio_litro"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["precio_litro"]) : 0, "observaciones"=>isset($_POST["observaciones"]) ? preg_replace("/[^ \.\ña-zA-Z0-9]/", "", $_POST["observaciones"]) : "", "estacion"=>isset($_POST["estacion"]) ? preg_replace("/[^ \.\ña-zA-Z0-9]/", "", $_POST["estacion"]) : "", "consumo"=>$consumo2));
    //print_r($consumo2);
    //exit();
    
    foreach ($requeridos as $requerido ) {
        if(!$repos->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $repos);
    } else {
        $repos->update();
        confirmar();
    }
}

function borrarModelo() {
    $repos = new Repostaje( array("id_repostaje"=>isset($_POST["id_repostaje"]) ? (int)$_REQUEST["id_repostaje"] : 0 ));
    $repos->borrar();
    confirmar();
}

function confirmar() {
    $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z_]/","", $_REQUEST["order"]) : "id_repostaje";
    mostrarCabecera("Cambios grabados");
?>
    <script text='text/javascript'>
        alert('Cambios guardados.');
        window.location = 'ver_repostajes_previo.php';
    </script>
    
<?php
    mostrarPie();
}
?>