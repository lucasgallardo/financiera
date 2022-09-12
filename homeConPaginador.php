<?php 
session_start();

include ('librerias/cabecera.php');
include ('librerias/conexion.php');
include ('librerias/operaciones.php');

if (isset($_SESSION['usuario_nombre'])){
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <?php echo head(); ?>
    </head>
    <body>
        <?php echo panel("home"); ?>
        <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12 col-md-8">
                  <?php
                  if(isset($_REQUEST['actualizado'])){
                    if ($_REQUEST['actualizado']=='si') {
                        echo "<div class='alert alert-success cartel'>Datos actualizados correctamente</div>";
                        ?>
                        <script type="text/javascript">
                            $(".cartel").fadeTo(2000, 500).slideUp(500, function(){
                                $(".cartel").alert('close');
                            });
                        </script>
                        <?php
                    }elseif ($_REQUEST['actualizado']=='no') {
                        echo "<div class='alert alert-danger'>Error al actualizar los datos:</div>";
                        ?>
                        <script type="text/javascript">
                            $(".cartel").fadeTo(2000, 500).slideUp(500, function(){
                                $(".cartel").alert('close');
                            });
                        </script>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="col-xs-6 col-md-4 text-right">
                <a href="home.php">Ver Todos</a> | <a href="morosos.php">Ver Morosos</a>
            </div>
        </div> 

        <?php 
        $rs_noticias = mysqli_query($conexion,"SELECT * FROM clientes") or die(mysqli_error($conexion));
        $num_total_registros = mysqli_num_rows($rs_noticias);
//Si hay registros

        if ($num_total_registros > 0) {
    //Limito la busqueda
            $TAMANO_PAGINA = 10;
            $pagina = false;

    //examino la pagina a mostrar y el inicio del registro a mostrar
            if (isset($_GET["pagina"]))
                $pagina = $_GET["pagina"];

            if (!$pagina) {
                $inicio = 0;
                $pagina = 1;
            }
            else {
                $inicio = ($pagina - 1) * $TAMANO_PAGINA;
            }    

    //calculo el total de paginas
            $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

            ?>
            <form name="f1" action="librerias/marcarPagados.php" method="POST"> 
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Modelo de auto</th>
                            <th>Teléfono</th>
                            <th>Valor Cuota</th>
                            <th>Pagado/Total</th>
                            <th>Pagado <a href=javascript:seleccionar_todo()>   <span class="glyphicon glyphicon-check"></span></a><a href=javascript:deseleccionar_todo()>   <span class="glyphicon glyphicon-remove-circle"></span></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $mes=date('m');$anio=date('Y');                
                        $rs = mysqli_query( $conexion,"SELECT cliente_id,cliente_nombre,cliente_celular,cliente_cuotas,cliente_cuota_total,cliente_idAuto FROM clientes WHERE MONTH(cliente_inicio)<='$mes' AND YEAR(cliente_inicio)<='$anio' ORDER BY cliente_id ASC LIMIT ".$inicio.",".$TAMANO_PAGINA."") or die(mysqli_error($conexion));

                        while ($row = mysqli_fetch_array($rs)) { ?>
                            <tr>
                                <td><a href="detallesCliente.php?accion=<?php echo $row['cliente_id'] ?>"><?php echo $row['cliente_nombre']; ?></a></td>
                                <td><?php echo buscaAuto($row['cliente_idAuto'],$conexion); ?></td>
                                <td><?php echo $row['cliente_celular']; ?></td>
                                <td><?php echo $row['cliente_cuota_total']; ?></td>
                                <td><?php echo cuotasPagadas($row['cliente_id'],$conexion)."/".$row['cliente_cuotas']; ?></td>

                                <?php echo estadoPago($row['cliente_id'],$conexion); ?>
                            </tr>
                            <?php } ?>
                        </tbody>  
                    </table>
                    <div class="text-right">
                    <button type="submit" class="btn btn-primary" name="guardar">Pagados</button>
                    </div>
                </form>

                <p><?php echo "Total de clientes: $num_total_registros";?></p>
                <?php
                echo '<p>';

                if ($total_paginas > 1) { ?>
                    <ul class="pagination">
                        <?php
                        if ($pagina != 1)
                            echo '<li><a href="'.$url.'?pagina='.($pagina-1).'">&laquo;</a></li>';
                        for ($i=1;$i<=$total_paginas;$i++) {
                            if ($pagina == $i)
                //si muestro el �ndice de la p�gina actual, no coloco enlace
                                echo '<li class="disabled"><a href="#">'.$pagina.'</a></li>';
                            else
                //si el �ndice no corresponde con la p�gina mostrada actualmente,
                //coloco el enlace para ir a esa p�gina
                                echo '  <li><a href="'.$url.'?pagina='.$i.'">'.$i.'</a></li>  ';
                        }
                        if ($pagina != $total_paginas)
                            echo '<li><a href="'.$url.'?pagina='.($pagina+1).'">&raquo;</a></li>';
                    } ?>
                </ul>
                <?php
                echo '</p>';
            }else{
                echo "<div class='alert alert-success'>Sin clientes</div>";
            }
            ?>
        </div>
        <script src="js/bootstrap.min.js"></script>
        <script>
            function seleccionar_todo(){ 
               for (i=0;i<document.f1.elements.length;i++) 
                  if(document.f1.elements[i].type == "checkbox")    
                     document.f1.elements[i].checked=1 
             }
             function deseleccionar_todo(){ 
   for (i=0;i<document.f1.elements.length;i++) 
      if(document.f1.elements[i].type == "checkbox")    
         document.f1.elements[i].checked=0 
}
         </script>
         <?php
     } else {
      header("Location: salir.php");
  }
  ?>
</body>
</html>