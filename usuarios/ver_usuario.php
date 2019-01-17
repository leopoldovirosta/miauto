<?php

require_once "../funciones.php";
require_once "../config.php";
require_once "../usuario.clase.php";
require_once "../miauto.clase.php";
require_once "../logEntradas.clase.php";

checkLogin();
global $array;
$array = Usuario::getUsuario($_SESSION["usuario"]);
$aliasId = isset($_REQUEST["alias"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_REQUEST["alias"]) : "";

if(!$usuario = Usuario::getUsuario($aliasId)) {
    mostrarCabecera("Error");
    echo "<div>Usuario no existe.</div>";
    mostrarPie();
    exit;
}

if (isset($_POST["action"]) and $_POST["action"] == "Grabar Cambios" ) {
    grabarUser();
} elseif (isset($_POST["action"]) and $_POST["action"] == "Borrar Usuario" ) {
    if ($array->getValueEncoded("admin")) {
        borrarUsuario();
    } else  { borrarUsuarioNoAdmin(); }
} else {
    muestraForm(array(), array(), $usuario);
}


function muestraForm($mensajesError, $requeridosFalta, $usuario) {
    global $array;
    $logEntra = LogEntradas::getLogEntradas($usuario->getValue("alias"));
    mostrarCabecera("Detalles del usuario: " . $usuario->getValueEncoded("nombre") . " " . $usuario->getValueEncoded("apellidos") );
    navUser();
    if($mensajesError) {
        foreach($mensajesError as $mensajeError) {
            echo $mensajeError;
        }
    }
    $start = isset($_REQUEST["start"]) ? (int)$_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z]/", "", $_REQUEST["order"]) : "alias";
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
    <form class="form-horizontal" action="ver_usuario.php" method="post" style="margin-bottom: 50px;">
        <input type="hidden" name="alias" id="alias" value="<?php echo $usuario->getValueEncoded('alias') ?>" />
        <input type="hidden" name="start" id="start" value="<?php echo $start ?>" />
        <input type="hidden" name="order" id="order" value="<?php echo $order ?>" />
        <div class="col-sm-12">
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("nombre", $requeridosFalta) ?>>Nombre *</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu nombre" name="nombre" for="inputWarning" value="<?php echo $usuario->getValueEncoded("nombre") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("apellidos", $requeridosFalta) ?>>Apellidos *</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tus apellidos" name="apellidos" for="inputWarning" value="<?php echo $usuario->getValueEncoded("apellidos") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning">Dirección</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu dirección" name="direccion" for="inputWarning" value="<?php echo $usuario->getValueEncoded("direccion") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning">Código postal</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu código postal" name="cp" for="inputWarning" value="<?php echo $usuario->getValueEncoded("cp") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("localidad", $requeridosFalta) ?>>Localidad *</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu localidad" name="localidad" for="inputWarning" value="<?php echo $usuario->getValueEncoded("localidad") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("email", $requeridosFalta) ?>>Email *</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu correo electrónico" name="email" for="inputWarning" value="<?php echo $usuario->getValueEncoded("email") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning">Teléfono</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu teléfono" name="telefono" for="inputWarning" value="<?php echo $usuario->getValueEncoded("telefono") ?>" />
            </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-sm-4" for="inputWarning">Página web</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="Introduce tu página web" name="web" for="inputWarning" value="<?php echo $usuario->getValueEncoded("web") ?>" />
            </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("sexo", $requeridosFalta) ?>>Sexo *</label>
                <div class="col-sm-4">
                    <div class="radio-inline">
                    <input type="radio" name="sexo" id="inputWarning" value="M"<?php setChecked($usuario, "sexo", "M") ?> />Masculino
                    </div>
                    <div class="radio-inline">
                    <input type="radio" name="sexo" id="inputWarning" value="F"<?php setChecked($usuario, "sexo", "F") ?> />Femenino
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-5"></div>
                <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="grabarBoton" value="Grabar Cambios" />
                <?php $repos = new MiAuto(array());
                $filas = $repos->userVehiculos($_GET["alias"]);
                if ($filas == 0) { ?>
                <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="action" id="borrarBoton" value="Borrar Usuario" style="margin-right: 20px;" />
                <?php } ?>
            </div>
            <div class="form-group">
                <div class="col-sm-5"></div>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Como editar tu perfil</button>
            </div>
        </div>
    </form>
        <br><br>
        <ul class="pager">
            <a href="javascript:history.go(-1)" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Volver</a>
        </ul>
          
<?php

if ($array->getValueEncoded("admin")) { //si es admin puede ver usuarios y logs
?>
    <div class="container">
        <p class="text-info">Registro de accesos</p>
        <table class="table table-condensed">
            <tr>
                <th>Página web</th>
                <th>Número de visitas</th>
                <th>Última visita</th>
            </tr>
    <?php
        $filaCount = 0;

        foreach($logEntra as $LogEntradas)  {
            $filaCount++;
    ?>
            <tr<?php if ($filaCount % 2 == 0) echo ' class="alt"' ?>>
                <td><?php echo $LogEntradas->getValueEncoded("pagURL") ?></td>
                <td><?php echo $LogEntradas->getValueEncoded("numVisitas") ?></td>
                <td><?php echo $LogEntradas->getValueEncoded("ultAcceso") ?></td>
            </tr>
    <?php
        }
    }
    ?>
        </table>
      </div>

<?php
    mostrarPie();    
}

function grabarUser() {
    $requeridos = array("nombre", "apellidos", "localidad", "email", "sexo");
    $requeridosFalta = array();
    $mensajesError =  array();
    
    $usuario = new Usuario( array("alias"=>isset($_POST["alias"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["alias"]) : "", "nombre"=>isset($_POST["nombre"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["nombre"]) : "", "apellidos"=>isset($_POST["apellidos"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["apellidos"]) : "", "direccion"=>isset($_POST["direccion"]) ? preg_replace("/[^ \-\/\_ña-zA-Z0-9]/", "", $_POST["direccion"]) : "", "cp"=>isset($_POST["cp"]) ? preg_replace("/[^ 0-9]/", "", $_POST["cp"]) : "",  "localidad"=>isset($_POST["localidad"]) ? preg_replace("/[^ \-\ña-zA-Z]/", "", $_POST["localidad"]) : "", "email"=>isset($_POST["email"]) ? preg_replace("/[^ \@\.\-\_ña-zA-Z]/", "", $_POST["email"]) : "", "telefono"=>isset($_POST["telefono"]) ? preg_replace("/[^ 0-9]/", "", $_POST["telefono"]) : "",  "web"=>isset($_POST["web"]) ? preg_replace("/[^ \:\/\-\.\_ña-zA-Z0-9]/", "", $_POST["web"]) : "", "sexo"=>isset($_POST["sexo"]) ? preg_replace("/[^ MF]/", "", $_POST["sexo"]) : "" ));
    
    foreach ($requeridos as $requerido ) {
        if(!$usuario->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ($existeUser = Usuario::getByEmail($usuario->getValue("email")) and $existeUser->getValue("alias") != $usuario->getValue("alias") ) {
        $mensajesError[] = '<p class="error">Ya existe un usuario con ese email, introduce otro email por favor.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $usuario);
    } else {
        
        $usuario->update();
        confirmarUpdate();
    }
}
    
function borrarUsuario() {
    $usuario = new Usuario(array("alias"=>isset($_POST["alias"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["alias"]) : "" ));
    LogEntradas::borrarDeUsuarios($usuario->getValue("alias"));
       $usuario->borrar();
       confirmarBorrar();
}

function borrarUsuarioNoAdmin() {
    $usuario = new Usuario(array("alias"=>isset($_POST["alias"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["alias"]) : "" ));
    LogEntradas::borrarDeUsuarios($usuario->getValue("alias"));
       $usuario->borrar();
       confirmarBorrarNoAdmin();
}

function confirmarUpdate() {
    $usuario = Usuario::getUsuario($_SESSION["usuario"]);
    if ($usuario->getValueEncoded("admin")) {
    $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 0;
    $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z]/","", $_REQUEST["order"]) : "alias";
?>
    <script type = "text/javascript">
        alert('Cambios grabados!');
        window.location = 'ver_usuarios.php?start=<?php echo $start ?>&amp;order=<?php echo $order ?>';
    </script>
<?php
     } else {
?>  
    <script type = 'text/javascript'>
        alert('Actualizado!');
        window.location = 'index.php';
    </script>    
<?php 
    } 
}

function confirmarBorrar() {
    $usuario = Usuario::getUsuario($_SESSION["usuario"]);
    if ($usuario->getValueEncoded("admin")) {
        $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 0;
        $order = isset($_REQUEST["order"]) ? preg_replace("/[^ a-zA-Z]/","", $_REQUEST["order"]) : "alias";
?>
    <script type = 'text/javascript'>
        alert('Cambios grabados!');
        window.location = 'ver_usuarios.php?start=<?php echo $start ?>&amp;order=<?php echo $order ?>';
    </script>
<?php exit;
    }
}

function confirmarBorrarNoAdmin() {
?>  
    <script type = 'text/javascript'>
        alert('Has sido dado de baja.');
        window.location = 'logout.php';
    </script>
<?php exit;
}

?>