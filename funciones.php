<?php
require_once "config.php";
require_once "usuario.clase.php";
require_once "modelo.clase.php";
require_once "miauto.clase.php";
require_once "repostajes.clase.php";
require_once "logEntradas.clase.php";

// Comprueba si el campo esta en la lista de campos olvidados de rellenar y señala la label
function validaCampo($campo, $requeridosFalta) {
    if(in_array($campo, $requeridosFalta)) {
        echo 'has-warning has-feedback';
//      echo 'class="error"';
    }
}

// Funcion para preseleccionar una casilla de verificación
function setChecked(DataObject $obj, $campo, $valor) {
    if($obj->getValue($campo) == $valor) {
        echo 'checked="checked"';
    }
}

// Funcion para preseleccionar una casilla de verificación en un campo select
function setSelected(DataObject $obj, $campo, $valor) {
    if($obj->getValue($campo) == $valor) {
        echo 'selected="selected"';
    }
}

// Funcion para comprobar que se ha conectado un miembro
function checkLogin() {
    session_start();
    if (!$_SESSION["usuario"]) { // si no encuentra el objeto usuario no se ha conectado ningun miembro
        $_SESSION["usuario"] = "";
        header("Location:../login.php"); //se redirige a la pagina de registro
        exit;
    } else {
        $logEntradas = new LogEntradas( array(
            "alias" => $_SESSION["usuario"],
            "pagURL" => basename($_SERVER["PHP_SELF"])
        ));
        $logEntradas ->grabar();
        return $_SESSION["usuario"];
    }
}

// Funcion igual que la anterior pero esta no graba en el log
function checkLoginNoLog() {
    session_start();
    if (!$_SESSION["usuario"]) { // si no encuentra el objeto usuario no se ha conectado ningun miembro
        $_SESSION["usuario"] = "";
        header("Location:../login.php"); //se redirige a la pagina de registro
        exit;
    } else {
        return $_SESSION["usuario"];
    }
}
    
// Muestra cabecera de página estandar
function mostrarCabecera($tituloPagina) {
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $tituloPagina ?></title>
        <meta http-equiv="Content-Type" charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="datepicker/css/datepicker.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $.datepicker.regional['es'] = {
             closeText: 'Cerrar',
             prevText: '< Ant',
             nextText: 'Sig >',
             currentText: 'Hoy',
             monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
             monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
             dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
             dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
             dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
             weekHeader: 'Sm',
             dateFormat: 'dd/mm/yy',
             firstDay: 1,
             isRTL: false,
             showMonthAfterYear: false,
             yearSuffix: ''
             };
             $.datepicker.setDefaults($.datepicker.regional['es']);
            $(function () {
                $("#calendario").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });
        </script>
        
        <style type="text/css">
            th {text-align: left; background-color: #bbb;}
            th,td {padding: 0.4em;}
            tr.alt td {background: #ddd;}
            .error {background: #d33; color: white; padding: 0.2em;}
            .in2 {background: #84a88d; color: white;}
            .in1 {background: #84a88d; color: white;}
            
            .header-fixed-1 {
                width: 100%;
            }
            .header-fixed-1 > thead,
            .header-fixed-1 > tbody,
            .header-fixed-1 > thead > tr,
            .header-fixed-1 > tbody > tr {
                display: inline-block;
            }
            
            .header-fixed-1 > tbody {
                overflow-x: scroll;
                height: 150px;
                width: 77%;
                white-space: nowrap;
            }
            
            .header-fixed {
                width: 100%;
            }
            .header-fixed > thead,
            .header-fixed > tbody,
            .header-fixed > thead > tr,
            .header-fixed > tbody > tr,
            .header-fixed > thead > tr > th,
            .header-fixed > tbody > tr > td {
                display: block;
            }
            .header-fixed > tbody > tr:after,
            .header-fixed > thead > tr:after {
                content: ' ';
                display: block;
                visibility: hidden;
                clear: both;
            }
            .header-fixed > tbody {
                overflow-y: auto;
                height: 200px;
            }

            .header-fixed > tbody > tr > td {
                width: 10%;
                float: left;
                        }            
            .header-fixed > thead > tr > th {
                width: 10%;
                float: left;
            }
        </style>
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="50">
        <div class="container">
        <div class="container bg-primary">
            <h2><strong><?php echo $tituloPagina ?></strong></h2>
        </div>
<?php
}

// Barra de navegacion para no usuarios
function navNoUser() { ?>
<div class="container">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">MiAuto</a>
        </div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Inicio</a></li>
          <li><a href="ver_modelos.php">Modelos</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="registro.php"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
          <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Entrar</a></li>
        </ul>
      </div>
    </nav>
</div>
<?php
}

// Barra de navegacion para usuarios
function navUser() { ?>
<div class="container">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">MiAuto</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="/usuarios/index.php">Inicio</a></li>
            <li><a href="ver_usuarios.php">Mis datos</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Modelos
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/usuarios/ver_modelos.php">Ver Modelos</a></li>
                    <li><a href="/usuarios/registro_modelo.php">Añadir Modelo</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Mis Vehiculos
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/usuarios/ver_mis_autos.php">Ver mis vehiculos</a></li>
                    <li><a href="/usuarios/registro_mi_auto.php">Añadir vehiculo</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Repostajes
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/usuarios/ver_repostajes_previo.php">Ver mis repostajes</a></li>
                    <li><a href="/usuarios/registro_repostaje_previo.php">Añadir repostaje</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/usuarios/logout.php"><span class="glyphicon glyphicon-user"></span> Salir</a></li>
        </ul>
      </div>
    </nav>
</div>
<?php
}

// Muestra pié de página estandar
function mostrarPie() {
?>
        <div class="container" style="background-color:#07141d;color:#fff;height:50px;">    
            <p></p>
            <p class="text-center">Copyright @ 2017 Leo Virosta</p>            
        </div>
        </div>
    </body>
</html>
<?php
}
?>