<?php

require_once "../funciones.php";
require_once "../modelo.clase.php";

checkLogin();

if (isset($_POST["action"]) and $_POST["action"] == "registro") {
    procesaForm();
} else {
    muestraForm(array(), array(), new Modelo(array()) );
}

function muestraForm($mensajesError, $requeridosFalta, $modelo) {
    mostrarCabecera("Formulario de registro de nuevo modelo");
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
            <p class="text-info">Usa punto para especificar decimales.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </div>
    <!-- Fin Modal --> 

    <form class="form-horizontal" action="registro_modelo.php" method="post" style="margin-bottom: 50px;" enctype="multipart/form-data">
       <input type="hidden" name="action" value="registro" />
       <div class="col-sm-7">
        <div class="form-group <?php validaCampo("fabricante", $requeridosFalta) ?>">            
            <label class="control-label col-sm-4" for="inputWarning">Fabricante *</label>
            <div class="col-sm-5">
                <select name="fabricante" id="inputWarning" size="1">
                    <?php foreach ($modelo->getMarcaClave() as $value =>$label) { ?>
                    <option value="<?php echo $value ?>"<?php setSelected($modelo,"fabricante", $value) ?>><?php echo $label ?></option>
        <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group <?php validaCampo("nombre_modelo", $requeridosFalta) ?>">        
            <label class="control-label col-sm-4" for="inputWarning">Nombre de modelo  *</label>
            <div class="col-sm-7">         
                <input type="text" class="form-control" placeholder="Introduce el nombre del modelo" name="nombre_modelo" id="inputWarning" value="<?php echo $modelo->getValueEncoded("nombre_modelo") ?>" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("motorizacion", $requeridosFalta) ?>">
            <label class="control-label col-sm-4"  for="inputWarning">Motorizacion *</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" placeholder="Introduce la motorizacion" name="motorizacion" id="inputWarning" value="<?php echo $modelo->getValueEncoded("motorizacion") ?>" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("combustible", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning">Combustible *</label>
            <div class="col-sm-5">
                <select name="combustible" id="inputWarning" size="1">
                    <option value="gasolina">Gasolina</option>
                    <option value="gasoil">Gasoil</option>
                    <option value="hibrido">Hibrido</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Potencia CV</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="potencia" id="inputWarning" value="<?php echo $modelo->getValueEncoded("potencia") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Cilindrada cm3</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="cilindrada" id="cilindrada" value="<?php echo $modelo->getValueEncoded("cilindrada") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Tipo de cambio</label>
            <div class="col-sm-2">
                <select name="cambio" id="inputWarning" size="1">
                <option value="automatico">Automático</option>
                <option value="manual">Manual</option>
            </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Imagen (solo .jpeg, e inferior a 2MB)</label>
            <div class="col-sm-7">
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
        <div class="col-sm-5">
            <div class="form-group">
                <label class="control-label col-sm-6" for="inputWarning">Consumo extraurbano l/100Km</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="consumo_extraurbano" id="inputWarning" value="<?php echo $modelo->getValueEncoded("consumo_extraurbano") ?>" />
            </div>
            </div>
        </div>
       <div class="col-sm-5">
        <div class="form-group">
            <label class="control-label col-sm-6" for="inputWarning">Consumo mixto l/100Km</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="consumo_mixto" id="inputWarning" value="<?php echo $modelo->getValueEncoded("consumo_mixto") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-6" for="inputWarning">Consumo urbano l/100Km</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="consumo_urbano" id="inputWarning" value="<?php echo $modelo->getValueEncoded("consumo_urbano") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-6" for="inputWarning">Emision CO2 gr/Km</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="emision_co2" id="inputWarning" value="<?php echo $modelo->getValueEncoded("emision_co2") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-6" for="inputWarning">Depósito litros</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="deposito" id="inputWarning" value="<?php echo $modelo->getValueEncoded("deposito") ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-6" for="velocidades">Velocidades</label>    
            <div class="col-sm-3">
                <input type="text" class="form-control"  name="velocidades" id="inputWarning" value="<?php echo $modelo->getValueEncoded("velocidades") ?>" />
            </div>
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
    $requeridos = array("fabricante", "nombre_modelo", "motorizacion", "combustible");
    $requeridosFalta = array();
    $mensajesError =  array();
    $foto = $_FILES["imagen"]["name"];
    $temp = $_FILES["imagen"]["tmp_name"];//nombre temporal que asigna el servidor al archivo
    $tamano = $_FILES["imagen"]["size"];
    $tipo = $_FILES["imagen"]["type"];
    
    $modelo = new Modelo( array("fabricante"=>isset($_POST["fabricante"]) ? preg_replace("/[^ a-zA-Z0-9]/", "", $_POST["fabricante"]) : "", "nombre_modelo"=>isset($_POST["nombre_modelo"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["nombre_modelo"]) : "", "motorizacion"=>isset($_POST["motorizacion"]) ? preg_replace("/[^ \.\-\_a-zA-Z0-9]/", "", $_POST["motorizacion"]) : "", "combustible"=>isset($_POST["combustible"]) ? preg_replace("/[^ a-z]/", "", $_POST["combustible"]) : "", "potencia"=>isset($_POST["potencia"]) ? preg_replace("/[^ 0-9]/", "", $_POST["potencia"]) : "", "consumo_extraurbano"=>isset($_POST["consumo_extraurbano"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["consumo_extraurbano"]) : "", "consumo_mixto"=>isset($_POST["consumo_mixto"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["consumo_mixto"]) : "", "consumo_urbano"=>isset($_POST["consumo_urbano"]) ? preg_replace("/[^ \.0-9]/", "", $_POST["consumo_urbano"]) : "", "emision_co2"=>isset($_POST["emision_co2"]) ? preg_replace("/[^ 0-9]/", "", $_POST["emision_co2"]) : "", "deposito"=>isset($_POST["deposito"]) ? preg_replace("/[^ 0-9]/", "", $_POST["deposito"]) : "", "cilindrada"=>isset($_POST["cilindrada"]) ? preg_replace("/[^ 0-9]/", "", $_POST["cilindrada"]) : "", "telefono"=>isset($_POST["telefono"]) ? preg_replace("/[^ 0-9]/", "", $_POST["cilindrada"]) : "",  "velocidades"=>isset($_POST["velocidades"]) ? preg_replace("/[^ 0-9]/", "", $_POST["velocidades"]) : "", "cambio"=>isset($_POST["cambio"]) ? preg_replace("/[^ a-z]/", "", $_POST["cambio"]) : "", "imagen"=>$_FILES["imagen"]["name"] ));
    
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
    } elseif ($foto !="") {
            $kb = $tamano/1024;
            $mb = $kb/1024;
            if ($mb > 2) { ?>
                <script text='text/javascript'>
                alert('La imagen supera los 2 MB, vuelve a intentarlo.');
                window.location = 'registro_modelo.php';
                </script> <?php
                exit;
            }
    
        if ($tipo != "image/jpeg") { ?>
            <script text='text/javascript'>
            alert('La imagen solo puede ser .jpeg, vuelve a intentarlo.');
            window.location = 'registro_modelo.php';
            </script> <?php
            exit;
            }
        move_uploaded_file($temp, "../fotos/$foto");
        $modelo->nuevo();
        muestraGracias();
    
    } else {
        $modelo->nuevo();
        muestraGracias();
    }
}

function muestraGracias() {
    mostrarCabecera("Modelo registrado!");
?>
    <p>Gracias, modelo añadido a la base de datos de miauto.</p>
    <p><a href='index.php'>Volver a Menú</a></p>

<?php
    mostrarPie();
}
?>


























