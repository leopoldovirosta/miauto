<?php
require_once "../funciones.php";
require_once "../miauto.clase.php";
require_once "../modelo.clase.php";
require_once "../repostajes.clase.php";

checkLogin();
global $id;
global $odometro_inicial;
$id = $_REQUEST["id_vehiculo"];
$odometro_inicial = Repostaje::getUltimo($id);

if (!$comprobar = MiAuto::getVehiculoModelo($_SESSION["usuario"])) { ?>
        <script text='text/javascript'>
            alert('No tienes asignado ningun vehiculo, registra uno.');
            window.location = 'registro_mi_auto.php';
        </script> <?php
        exit;
}

if (isset($_POST["action"]) and $_POST["action"] == "registro") {
    procesaForm();
} else {
   muestraForm(array(), array(), new Repostaje(array()) );
}

function muestraForm($mensajesError, $requeridosFalta, $repos) {
    global $id;
    global $odometro_inicial;
    mostrarCabecera("Formulario de registro de nuevo repostaje");
    navUser();    
    if($mensajesError) {
        foreach($mensajesError as $mensajeError) {
            echo $mensajeError;
        }
    }
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
            <h4 class="modal-title">Registrar Modelo</h4>
          </div>
          <div class="modal-body">
            <p class="text-info">Completa todos los campos del formulario y pinchar en Enviar.</p>
            <p class="text-info">Los campos marcados con un (*) son necesarios.</p>
            <p class="text-info">Si es tu primer repostaje añade solamente la fecha de hoy por ejemplo, los kilómetros de tu vehiculo tras el último repostaje, y en litros repostados 1. Este repostaje se toma como inicio pero no tiene valor.</p>
            <p class="text-info">Usa punto para especificar decimales.</p>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </div>
    <!-- Fin Modal --> 

    <form class="form-horizontal" action="registro_repostaje.php" method="post" style="margin-bottom: 50px;">
        <div class="col-sm-8">
            <input type="hidden" name="action" value="registro" />
            <input type="hidden" name="id_vehiculo" value="<?php echo $id ?>" />
            <div class="form-group <?php validaCampo("fecha", $requeridosFalta) ?>">
                <label class="control-label col-sm-6" for="inputWarning">Fecha (Año-Mes-Día)  *</label>
                <div class="col-sm-4">
                    <div class="form-group input-group date" data-date-format="YYYY-mm-dd">
                        <input type='text' class="form-control" name="fecha" id="calendario" value="<?php echo $repos->getValueEncoded("fecha") ?>" />
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">        
                <label class="control-label col-sm-6" for="inputWarning">Odometro inicial</label>
                <label class="control-label col-sm-2" for="inputWarning"><?php echo $odometro_inicial ?> </label>
            </div>
            <div class="form-group <?php validaCampo("odometro_final", $requeridosFalta) ?>">        
                <label class="control-label col-sm-6" for="inputWarning">Odometro final *</label>
                <div class="col-sm-3">         
                    <input type="text" class="form-control" placeholder="Kilometros finales" name="odometro_final" id="inputWarning" value="<?php echo $repos->getValueEncoded("odometro_final") ?>" />
                </div>
            </div>
            <div class="form-group <?php validaCampo("combustible", $requeridosFalta) ?>">            
                <label class="control-label col-sm-6" for="inputWarning">Combustible *</label>
                <div class="col-sm-6">
                    <select name="combustible" id="inputWarning" size="1">
                        <option value="Diesel">Diesel</option>
                        <option value="Gasolina 95">Gasolina 95</option>
                        <option value="Gasolina 98">Gasolina 98</option>
                    </select>
                </div>
            </div>
            <div class="form-group <?php validaCampo("cantidad", $requeridosFalta) ?>">
                <label class="control-label col-sm-6" for="inputWarning">Litros repostados *</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="Litros de combustible" name="cantidad" id="inputWarning" value="<?php echo $repos->getValueEncoded("cantidad") ?>" />
                </div>
            </div>
            <div class="form-group">        
                <label class="control-label col-sm-6" for="inputWarning">Precio repostaje</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="Total repostaje €" name="precio_total" id="inputWarning" value="<?php echo $repos->getValueEncoded("precio_total") ?>" />
                </div>
            </div>
            <div class="form-group">        
                <label class="control-label col-sm-6" for="inputWarning">Precio litro</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="Precio litro €" name="precio_litro" id="inputWarning" value="<?php echo $repos->getValueEncoded("precio_litro") ?>" />
                </div>
            </div>
            <div class="form-group">        
                <label class="control-label col-sm-6" for="inputWarning">Observaciones</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="observaciones" id="inputWarning" value="<?php echo $repos->getValueEncoded("observaciones") ?>" />
                </div>
            </div>
            <div class="form-group">        
                <label class="control-label col-sm-6" for="inputWarning">Estacion</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="estacion" placeholder="Estación de servicio" id="inputWarning" value="<?php echo $repos->getValueEncoded("estacion") ?>" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6"></div>
                    <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="submitBoton" id="submitBoton" value="Enviar" />
                    <input type="reset" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="resetBoton" id="resetBoton" value="Reset" style="margin-right: 20px;" />
                </div>
            <div class="form-group">
                <div class="col-sm-6"></div>
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Como añadir un repostaje</button>
            </div>
        </div>
        <div class="col-sm-4">
            <img class="img-rounded float-center" src="../fotos/surtidor.jpg" width="100%;" >
        </div>
    </form>
  </div>
</div>

<?php
        mostrarPie();
}

function procesaForm() {
    $requeridos = array("id_vehiculo", "fecha", "odometro_final", "combustible", "cantidad");
    $requeridosFalta = array();
    $mensajesError =  array();
    global $odometro_inicial;
    $consumo = ($_POST["cantidad"] * 100);
    $consumo1 = ($_POST["odometro_final"] - $odometro_inicial);
    $consumo2 = number_format(( $consumo / $consumo1),2);
    
    $repos = new Repostaje( array("id_vehiculo"=>isset($_POST["id_vehiculo"])  ? preg_replace("/[^ 0-9]/", "", $_POST["id_vehiculo"]) : "", "fecha"=>isset($_POST["fecha"]) ? preg_replace("/[^ \-0-9]/", "", $_POST["fecha"]) : "", "odometro"=>$odometro_inicial, "odometro_final"=>isset($_POST["odometro_final"]) ? preg_replace("/[^ 0-9]/", "", $_POST["odometro_final"]) : "", "combustible"=>isset($_POST["combustible"]) ? preg_replace("/[^ a-zA-Z0-9]/", "", $_POST["combustible"]) : "", "cantidad"=>isset($_POST["cantidad"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["cantidad"]) : "", "precio_total"=>isset($_POST["precio_total"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["precio_total"]) : "", "precio_litro"=>isset($_POST["precio_litro"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["precio_litro"]) : "", "observaciones"=>isset($_POST["observaciones"]) ? preg_replace("/[^ ña-zA-Z]/", "", $_POST["observaciones"]) : "", "estacion"=>isset($_POST["estacion"]) ? preg_replace("/[^ ña-zA-Z]/", "", $_POST["estacion"]) : "", "consumo"=>$consumo2)) ;
    //print_r($repos);
    //exit;
    
    foreach ($requeridos as $requerido ) {
        if(!$repos->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ($_POST["odometro_final"] < $odometro_inicial) { ?>
        <script text='text/javascript'>
            alert('Los kilometros finales no pueden ser inferiores a los kilometros iniciales.');
            window.location = 'registro_repostaje.php?id_vehiculo=<?php echo $_POST["id_vehiculo"] ?>';
        </script> <?php
        exit;
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $repos);
    } else {
        $repos->insert();
        muestraGracias();
    }
}

function muestraGracias() {
?>
    <script text='text/javascript'>
        alert('Cambios guardados.');
        window.location = 'ver_repostajes_previo.php';
    </script>

<?php
    mostrarPie();
}
?>