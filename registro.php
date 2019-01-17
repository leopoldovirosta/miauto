<?php

require_once "funciones.php";
require_once "usuario.clase.php";
    
if (isset($_POST["action"]) and $_POST["action"] == "registro") {
    procesaForm();
} else {
    muestraForm(array(), array(), new Usuario(array()) );
}

function muestraForm($mensajesError, $requeridosFalta, $usuario) {
    mostrarCabecera("Formulario de registro para nuevos usuarios");
    navNoUser();
    if($mensajesError) {
        foreach($mensajesError as $mensajeError) {
            echo $mensajeError;
        }
    } else {
?>
<div class="container">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <p class="text-info">Para registrarte rellena todos los campos y pincha en el botón Enviar</p>
        <p class="text-info">Los campos marcados con un (*) son necesarios</p>
    </div>
<?php } ?>

    <form class="form-horizontal" action="registro.php" method="post" style="margin-bottom: 50px;">
        <input type="hidden" name="action" value="registro" />
        <div class="form-group <?php validaCampo("alias", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning">Elige un alias *</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu alias" name="alias" for="inputWarning" value="<?php echo $usuario->getValueEncoded("alias") ?>" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("clave", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning">Introduce una contraseña  *</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" placeholder="Introduce tu contraseña" name="clave1" id="inputWarning" value="" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("clave", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("clave", $requeridosFalta) ?>>Repite la contraseña  *</label>            
            <div class="col-sm-5">
                <input type="password" class="form-control" placeholder="Repite tu contraseña" name="clave2" id="inputWarning" value="" />            
            </div>
        </div>
        <div class="form-group <?php validaCampo("nombre", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("nombre", $requeridosFalta) ?>>Nombre *</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu nombre" name="nombre" id="inputWarning" value="<?php echo $usuario->getValueEncoded("nombre") ?>" />            
            </div>
        </div>
        <div class="form-group <?php validaCampo("apellidos", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("apellidos", $requeridosFalta) ?>>Apellidos *</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tus apellidos" name="apellidos" id="inputWarning" value="<?php echo $usuario->getValueEncoded("apellidos") ?>" />            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Dirección</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu dirección" name="direccion" id="inputWarning" value="<?php echo $usuario->getValueEncoded("direccion") ?>" />            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Código postal</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu código postal" name="cp" id="inputWarning" value="<?php echo $usuario->getValueEncoded("cp") ?>" />            
            </div>
        </div>
        <div class="form-group <?php validaCampo("localidad", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("localidad", $requeridosFalta) ?>>Localidad *</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu localidad" name="localidad" id="inputWarning" value="<?php echo $usuario->getValueEncoded("localidad") ?>" />            
            </div>
        </div>
            <div class="form-group <?php validaCampo("email", $requeridosFalta) ?>">
            <label class="control-label col-sm-4" for="inputWarning" <?php validaCampo("email", $requeridosFalta) ?>>Email *</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu email" name="email" id="inputWarning" value="<?php echo $usuario->getValueEncoded("email") ?>" />            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Teléfono</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu teléfono" name="telefono" id="inputWarning" value="<?php echo $usuario->getValueEncoded("telefono") ?>" />            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="inputWarning">Página web</label>            
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu página web" name="web" id="inputWarning" value="<?php echo $usuario->getValueEncoded("web") ?>" />            
            </div>
        </div>
        <div class="form-group <?php validaCampo("sexo", $requeridosFalta) ?>">
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
        <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="submitBoton" id="submitBoton" value="Enviar" />
            <input type="reset" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="resetBoton" id="resetBoton" value="Reset" />
        
    </form>
    <ul class="pager">
        <a href="javascript:history.go(-1)" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Volver</a>
    </ul>
</div>
<?php
        mostrarPie();
}

function procesaForm() {
    $requeridos = array("alias", "clave", "nombre", "apellidos", "localidad", "email", "sexo");
    $requeridosFalta = array();
    $mensajesError =  array();
    
    $usuario = new Usuario( array("alias"=>isset($_POST["alias"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["alias"]) : "", "clave"=>(isset($_POST["clave1"]) and isset($_POST["clave2"]) and $_POST["clave1"] == $_POST["clave2"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["clave1"]) : "", "nombre"=>isset($_POST["nombre"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["nombre"]) : "", "apellidos"=>isset($_POST["apellidos"]) ? preg_replace("/[^ \-\_ña-zA-Z0-9]/", "", $_POST["apellidos"]) : "", "direccion"=>isset($_POST["direccion"]) ? preg_replace("/[^ \-\/\_ña-zA-Z0-9]/", "", $_POST["direccion"]) : "", "cp"=>isset($_POST["cp"]) ? preg_replace("/[^ 0-9]/", "", $_POST["cp"]) : "",  "localidad"=>isset($_POST["localidad"]) ? preg_replace("/[^ \-\ña-zA-Z]/", "", $_POST["localidad"]) : "", "email"=>isset($_POST["email"]) ? preg_replace("/[^ \@\.\-\_ña-zA-Z]/", "", $_POST["email"]) : "", "telefono"=>isset($_POST["telefono"]) ? preg_replace("/[^ 0-9]/", "", $_POST["telefono"]) : "",  "web"=>isset($_POST["web"]) ? preg_replace("/[^ \:\/\-\.\_ña-zA-Z0-9]/", "", $_POST["web"]) : "", "sexo"=>isset($_POST["sexo"]) ? preg_replace("/[^ MF]/", "", $_POST["sexo"]) : "" ));
    
    foreach ($requeridos as $requerido ) {
        if(!$usuario->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Enviar para reenviar el formulario.</p>';
    }
    
    if ( !isset($_POST["clave1"]) or !isset($_POST["clave2"]) or ($_POST["clave1"] != $_POST["clave2"]) ) {
        $mensajesError[] = '<p class="error">Las contraseñas no coinciden, introduce la misma contraseña en ambos campos.</p>';
    }
    
    if (Usuario::getByAlias($usuario->getValue("alias"))) {
        $mensajesError[] = '<p class="error">Ya existe un usuario con ese alias, elige otro por favor.</p>';
    }
    
    if (Usuario::getByEmail($usuario->getValue("email"))) {
        $mensajesError[] = '<p class="error">Ya existe un usuario con ese email, introduce otro email por favor.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $usuario);
    } else {
        $usuario->insert();
        muestraGracias();
    }
}

function muestraGracias() {
    mostrarCabecera("Gracias por registrarte!");
?>
    <script text='text/javascript'>
        alert('Bienvenido!!, ya eres usuario registrado de miauto club.');
        window.location = 'login.php';
    </script>
<?php
    mostrarPie();
}
?>


























