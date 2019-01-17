<?php

require_once "funciones.php";
require_once "config.php";
require_once "modelo.clase.php";

$modelo = isset($_GET["id_modelo"]) ? (int)$_GET["id_modelo"] : 0;

if(!$modelo = Modelo::getModelo($modelo)) {
    mostrarCabecera("Error");
    echo "<div>Este modelo no existe.</div>";
    mostrarPie();
    exit;
}

mostrarCabecera("Detalles del modelo: " . $modelo->getMarca() . " " . $modelo->getValueEncoded("nombre_modelo") );
navNoUser();

?>
<div class="container">
<div class="row">
    <div class="col-sm-6">
    <table class="table table-bordered">
        <tr>
        <td><strong>Fabricante</strong></td><td><?php echo $modelo->getMarca() ?></td>
        </tr>
        <tr>
        <td><strong>Modelo</strong></td><td><?php echo $modelo->getValueEncoded("nombre_modelo") ?></td>
        </tr>
        <tr>
        <td><strong>Motorización</strong></td><td><?php echo $modelo->getValueEncoded("motorizacion") ?></td>
        </tr>
        <tr>
        <td><strong>Combustible</strong></td><td><?php echo ucfirst($modelo->getValueEncoded("combustible")) ?></td>
        </tr>
        <tr>
        <td><strong>Potencia</strong></td><td><?php echo $modelo->getValueEncoded("potencia") . " CV" ?></td>
        </tr>
        <tr>
        <td><strong>Consumo Extraurbano</strong></td><td><?php echo $modelo->getValueEncoded("consumo_extraurbano") . " l/100 km" ?></td>
        </tr>
        <tr>
        <td><strong>Consumo Mixto</strong></td><td><?php echo $modelo->getValueEncoded("consumo_mixto") . " l/100 km" ?></td>
        </tr>
        <tr>
        <td><strong>Consumo Urbano</strong></td><td><?php echo $modelo->getValueEncoded("consumo_urbano") . " l/100 km" ?></td>
        </tr>
        <tr>
        <td><strong>Emisión de CO2</strong></td><td><?php echo $modelo->getValueEncoded("emision_co2") . " g/km" ?></td>
        </tr>
        <tr>
        <td><strong>Capacidad depósito</strong></td><td><?php echo $modelo->getValueEncoded("deposito") . " l" ?></td>
        </tr>
        <tr>
        <td><strong>Cilindrada</strong></td><td><?php echo $modelo->getValueEncoded("cilindrada") . " cm3"  ?></td>
        </tr>
        <tr>
        <td><strong>Velocidades</strong></td><td><?php echo $modelo->getValueEncoded("velocidades") ?></td>
        </tr>
        <tr>
        <td><strong>Cambio</strong></td><td><?php echo ucfirst($modelo->getValueEncoded("cambio")) ?></td>
        </tr>
        <tr>
        <td><strong>Imagen</strong></td><td><img class="img-rounded" src="/fotos/<?php echo $modelo->getValueEncoded("imagen") ?>" height="100" width="150" title="<?php echo $modelo->getValueEncoded("imagen") ?>"></td>
        </tr>
    </table>
    </div>
    <div class="col-sm-6">
        <img class="img-responsive img-rounded" src="/fotos/<?php echo $modelo->getValueEncoded("imagen") ?>" alt="<?php echo $modelo->getValueEncoded("imagen") ?>">
    </div>
</div>

    <ul class="pager">
        <a href="javascript:history.go(-1)" class="btn" role="button" style="background-color:#a17dc6;color:#FFFFFF;">Volver</a>
    </ul>
</div>
<?php
mostrarPie();
?>