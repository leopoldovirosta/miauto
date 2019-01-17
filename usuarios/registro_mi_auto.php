<?php

require_once "../funciones.php";
require_once "../miauto.clase.php";
require_once "../modelo.clase.php";
require_once "../repostajes.clase.php";

checkLogin();

if (isset($_POST["action"]) and $_POST["action"] == "registro") {
    procesaForm();
} else {
    muestraForm(array(), array(), new MiAuto(array()) );
}

function muestraForm($mensajesError, $requeridosFalta, $miauto) {
    mostrarCabecera("Formulario de registro de mis vehiculos");
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
            <p class="text-info">Si tu modelo no aparece en el desplegable vete al menú Modelos, y añade a la base de datos tu modelo.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </div>
    <!-- Fin Modal --> 

    <form class="form-horizontal" action="registro_mi_auto.php" method="post" style="margin-bottom: 50px;" enctype="multipart/form-data">
        <input type="hidden" name="action" value="registro" />
            <div class="col-sm-12">
                <div class="form-group <?php validaCampo("tipo", $requeridosFalta) ?>">            
                    <label class="control-label col-sm-4" for="inputWarning">Tipo *</label>
                    <div class="col-sm-6">
                        <select name="tipo" id="inputWarning" size="1">
                            <option value="automovil">Automovil</option>
                            <option value="comercial">Comercial</option>
                            <option value="motocicleta">Motocicleta</option>
                            <option value="quad">Quad</option>
                        </select>
                    </div>
                </div>
                <div class="form-group <?php validaCampo("color", $requeridosFalta) ?>">        
                    <label class="control-label col-sm-4" for="inputWarning">Color  *</label>
                    <div class="col-sm-3">         
                        <input type="text" class="form-control" placeholder="Introduce el color" name="color" id="inputWarning" value="<?php echo $miauto->getValueEncoded("color") ?>" />
                    </div>
                </div>
                <div class="form-group <?php validaCampo("manufacturado", $requeridosFalta) ?>">        
                    <label class="control-label col-sm-4" for="inputWarning">Fecha de fabricación (Año-Mes-Día)  *</label>
                    <div class="col-sm-3">
                        <div class="form-group input-group date" data-date-format="YYYY-mm-dd">
                            <input type='text' class="form-control" name="manufacturado" id="calendario" value="<?php echo $miauto->getValueEncoded("manufacturado") ?>" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group <?php validaCampo("id_modelo", $requeridosFalta) ?>">
                    <label class="control-label col-sm-4" for="inputWarning">Modelo *</label>
                    <div class="col-sm-6">
                    <select name="id_modelo" id="inputWarning" size="1">
                        <?php $array = Modelo::getTodosModelo();
                            foreach ($array as $modelo) { ?>
                            <option value="<?php echo $modelo->getValueEncoded("id_modelo") ?>"><?php echo $modelo->getMarca() . " " . $modelo->getValueEncoded("nombre_modelo") . " " . $modelo->getValueEncoded("motorizacion") ?></option>;
                    <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="form-group <?php validaCampo("odometro", $requeridosFalta) ?>">        
                    <label class="control-label col-sm-4" for="inputWarning">Kilómetros actuales</label>
                    <div class="col-sm-3">         
                        <input type="text" class="form-control" placeholder="Introduce los kilómetros" name="odometro" id="inputWarning"  />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="inputWarning">Imagen (solo .jpeg, e inferior a 2MB)</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" name="imagen" id="inputWarning" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="submitBoton" id="submitBoton" value="Enviar" />
                    <input type="reset" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="resetBoton" id="resetBoton" value="Reset" style="margin-right: 20px;" />
                </div>
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Como registrar el modelo</button>
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

function procesaForm() {
    $requeridos = array("tipo", "manufacturado", "id_modelo", "color", "alias", "odometro");
    $requeridosFalta = array();
    $mensajesError =  array();
    $foto = $_FILES["imagen"]["name"];
    $temp = $_FILES["imagen"]["tmp_name"];//nombre temporal que asigna el servidor al archivo
    $tamano = $_FILES["imagen"]["size"];
    $tipo = $_FILES["imagen"]["type"];
    
    $miauto = new MiAuto( array("alias"=>$_SESSION["usuario"], "tipo"=>isset($_POST["tipo"]) ? preg_replace("/[^ a-zA-Z]/", "", $_POST["tipo"]) : "", "id_modelo"=>isset($_POST["id_modelo"]) ? preg_replace("/[^ 0-9]/", "", $_POST["id_modelo"]) : "", "color"=>isset($_POST["color"]) ? preg_replace("/[^ a-zA-Z]/", "", $_POST["color"]) : "", "manufacturado"=>isset($_POST["manufacturado"]) ? preg_replace("/[^ \-0-9]/", "", $_POST["manufacturado"]) : "", "odometro"=>isset($_POST["odometro"]) ? preg_replace("/[^ 0-9]/", "", $_POST["odometro"]) : "", "imagen"=>$foto ));
    
    foreach ($requeridos as $requerido ) {
        if(!$miauto->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $miauto);
    } elseif ($foto != "") {
            $kb = $tamano/1024;
            $mb = $kb/1024;
            if ($mb > 2) { ?>
                <script text='text/javascript'>
                alert('La imagen supera los 2 MB, vuelve a intentarlo.');
                window.location = 'registro_mi_auto.php';
                </script> <?php
                exit;
            }
    
        if ($tipo != "image/jpeg" and $tipo != "image/png") { ?>
            <script text='text/javascript'>
            alert('La imagen solo puede ser .jpeg o .png, vuelve a intentarlo.');
            window.location = 'registro_mi_auto.php';
            </script> <?php
            exit;
            }
        move_uploaded_file($temp, "../fotos/$foto");
        $miauto->insert();
// Inserto un primer repostaje para meter los kilometros
        $id = MiAuto::getVehiculoUltimo();
        foreach ($id as $id1) { 
            $repos = new Repostaje( array("id_vehiculo"=>$id1->getValueEncoded("id_vehiculo"), "fecha"=>date("Y-m-d"), "odometro"=>"0", "odometro_final"=>isset($_POST["odometro"]) ? preg_replace("/[^ 0-9]/", "", $_POST["odometro"]) : "", "cantidad"=>"0", "precio_total"=>"0", "consumo"=>"0")) ;
        }
        $repos->insert();
        muestraGracias();
    
        } else {
        $miauto->insert();
// Inserto un primer repostaje para meter los kilometros
        $id = MiAuto::getVehiculoUltimo();
        foreach ($id as $id1) { 
            $repos = new Repostaje( array("id_vehiculo"=>$id1->getValueEncoded("id_vehiculo"), "fecha"=>date("Y-m-d"), "odometro"=>"0", "odometro_final"=>isset($_POST["odometro"]) ? preg_replace("/[^ 0-9]/", "", $_POST["odometro"]) : "", "cantidad"=>"0", "precio_total"=>"0", "consumo"=>"0")) ;
        }
        $repos->insert();
        muestraGracias();
    }
}

function muestraGracias() {
    mostrarCabecera("Vehiculo registrado a tu nombre!");
?>
    <script text='text/javascript'>
        alert('Vehiculo registrado a tu nombre!');
        window.location = 'ver_mis_autos.php';
    </script> <?php
    exit;

    mostrarPie();
}
?>


























