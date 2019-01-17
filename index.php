<?php
require_once "funciones.php";

mostrarCabecera("Bienvenido a miauto");
navNoUser();
list($modelos) = Modelo::getModelosIndex();
list($repostajes) = Repostaje::getReposIndex();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8">    
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background-color:rgba(69, 101, 124, 0.76);color:#FFFFFF;">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Encuentra tu modelo en nuestra base de datos</a>
                    </h4>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse in">
                      <div class="panel-body">Nuestra base de datos cuenta con los <a href="ver_modelos.php">modelos</a> que han ido registrando los usuarios, si tu modelo no se encuentra entre ellos puedes usar el formulario de registro y darlo de alta. Cada modelo cuenta con su propia ficha y los datos más relevantes.</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" style="background-color:rgba(69, 124, 82, 0.66);color:#FFFFFF;">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Registra tu vehiculo</a>
                    </h4>
                  </div>
                  <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">Identifica tu modelo o crealo en caso de no existir, asignalo a tu usuario y empieza a ingresar tus repostajes. Puedes añadir uno o más vehículos a tu cuenta personal.</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" style="background-color:rgba(124, 113, 69, 0.66);color:#FFFFFF;">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Ingresa tus repostajes</a>
                    </h4>
                  </div>
                  <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">En nuestra base de datos podrás añadir todos los repostajes de tu vehículo, para poder controlar los consumos de tu auto.</div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <img class="img-circle float-right" src="fotos/ds.jpg" width="100%;" >     
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12"> 
            <p class="text-info">Últimos modelos en nuestra base de datos</p>
            <table class="table table-condensed header-fixed-1">
                <tbody>
        <?php
        $filaCount = 0;
        foreach ($modelos as $modelo) {
            $filaCount++;
        ?>
            <tr>
                <td><a href="ver_modelo.php?id_modelo=<?php echo $modelo->getValueEncoded("id_modelo") ?>"><img class="img-rounded" src="/fotos/<?php echo $modelo->getValueEncoded("imagen") ?>" height="113" width="150" title="<?php echo $modelo->getMarca() . " " . $modelo->getValueEncoded("nombre_modelo") ?>"></a></td>
            </tr>
        <?php
        }
        ?>
                </tbody>
            </table>    
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12"> 
            <p class="text-info">Últimos repostajes en nuestra base de datos</p>
            <table class="table table-condensed header-fixed">
                <thead>
                    <tr>
                        <th>Repostaje</th>
                        <th>Vehiculo</th>
                        <th>Fecha</th>
                        <th>Km</th>
                        <th>Combustible</th>
                        <th>Litros</th>
                        <th>Euros</th>
                        <th>Litro €</th>
                        <th>L/100Km</th>
                        <th>Estación</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $filaCount = 0;
        foreach ($repostajes as $repostaje) {
            $filaCount++;
            $array = Modelo::getModeloRepos($repostaje->getValueEncoded("id_repostaje"));
        ?>
            <tr<?php if ($filaCount % 2 == 0) echo ' class="in2"' ?> >
                <td><?php echo $repostaje->getValueEncoded("id_repostaje") ?></td>
                <td><?php echo $array->getMarca() . " " . $array->getValueEncoded("nombre_modelo") . " " . $array->getValueEncoded("motorizacion") ?></td>
                <td><?php echo $repostaje->getValueEncoded("fecha") ?></td>
                <td><?php echo $repostaje->getValueEncoded("odometro_final") - $repostaje->getValueEncoded("odometro") ?></td>
                <td><?php echo $repostaje->getValueEncoded("combustible") ?></td>
                <td><?php echo $repostaje->getValueEncoded("cantidad") ?> L</td>
                <td><?php echo $repostaje->getValueEncoded("precio_total") ?> €</td>
                <td><?php echo $repostaje->getValueEncoded("precio_litro") ?> €</td>
                <td><strong><?php echo number_format( ( ($repostaje->getValueEncoded("cantidad") * 100) / ($repostaje->getValueEncoded("odometro_final") - $repostaje->getValueEncoded("odometro"))),2 ) ?></strong></td>
                <td><?php echo $repostaje->getValueEncoded("estacion") ?></tr>
        <?php
        }
        ?>
                </tbody>
            </table>    
        </div>
    </div>
</div>
<?php
mostrarPie();    
?>
