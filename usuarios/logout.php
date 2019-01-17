<?php
require_once "../funciones.php";
session_start();
$_SESSION["usuario"] ="";
mostrarCabecera("Te has desconectado");
navNoUser();
?>
<script text='text/javascript'>
    alert('Acabas de salir del área de usuarios.');
    window.location = '../login.php';
</script> <?php
exit;
mostrarPie();    
?>