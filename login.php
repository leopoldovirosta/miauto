<?php
require_once "funciones.php";
session_start();

if (isset($_POST["action"]) and $_POST["action"] == "login") {
    procesaForm();
} else { 
    muestraForm( array(), array(), new Usuario( array() ));
}

function muestraForm($mensajesError, $requeridosFalta, $usuario) {
    mostrarCabecera("Acceder al área de usuarios");
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
        <p  class="text-info">Para acceder inserta tu alias y contraseña y pincha en el botón Login</p>
    </div>
<?php } ?>
    
    <form class="form-horizontal" action="login.php" method="post" style="margin-bottom: 50px;">
        <div class="form-group <?php validaCampo("alias", $requeridosFalta) ?>">
            <input type="hidden" name="action" value="login" />
            <label class="control-label col-sm-4" for="inputWarning">Alias</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" placeholder="Introduce tu alias" name="alias" for="inputWarning" value="<?php echo $usuario->getValueEncoded("alias") ?>" />
            </div>
        </div>
        <div class="form-group <?php validaCampo("clave", $requeridosFalta); if ($requeridosFalta) echo ' class="error"' ?>">        
            <label class="control-label col-sm-4" for="inputWarning">Contraseña</label>
            <div class="col-sm-5">
                <input type="password" class="form-control" placeholder="Introduce tu contraseña" name="clave" id="inputWarning" value="" />
            </div>
        </div>
        <div class="col-sm-5"></div>
            <input type="submit" class="btn btn-default" style="background-color:#7c5845;color:#FFFFFF;" name="submitBoton" id="submitBoton" value="Login" />
    </form>
        <ul class="pager">
            <a href="javascript:history.go(-1)" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Volver</a>
        </ul>
</div>
<?php
        mostrarPie();    
}

function procesaForm() {
    $requeridos = array("alias", "clave");
    $requeridosFalta = array();
    $mensajesError =  array();
    
    $usuario = new Usuario( array("alias"=>isset($_POST["alias"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["alias"]) : "", "clave"=>isset($_POST["clave"]) ? preg_replace("/[^ \-\_a-zA-Z0-9]/", "", $_POST["clave"]) : "",));
    
    foreach ($requeridos as $requerido ) {
        if(!$usuario->getValue($requerido)) { //getValue devuelve valor si existe en el campo del objeto, sino FALSE, !FALSE es TRUE
            $requeridosFalta[] = $requerido;
        }
    }
    
    if ($requeridosFalta) {
        $mensajesError[] = '<p class="error">Faltan algunos campos por rellenar, por favor completa los campos señalados y pincha en Login para reenviar el formulario.</p>';
    } elseif (!$logandoUsuario = $usuario->logarse() ) {
        $mensajesError[] = '<p class="error">Lo siento pero ese usuario o contraseña no son correctos, inténtalo de nuevo.</p>';
    }
    
    if ($mensajesError) {
        muestraForm($mensajesError, $requeridosFalta, $usuario);
    } else {
        $_SESSION["usuario"] = $_POST["alias"];
        header("Location: usuarios\index.php");
    }
}

?>

