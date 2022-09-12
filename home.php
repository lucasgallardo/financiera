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
        <link rel="stylesheet" href="css/alertify.core.css" />
        <link rel="stylesheet" href="css/alertify.default.css" id="toggleCSS" />
        <script type="text/javascript" src="js/alertify.min.js"></script>
        <script>
            function reset () {
                $("#toggleCSS").attr("href", "css/alertify.bootstrap.css");
                alertify.set({
                    labels : {
                        ok     : "Aceptar",
                        cancel : "Cancelar"
                    },
                    delay : 5000,
                    buttonReverse : false,
                    buttonFocus   : "ok"
                });
            }
        </script>
        <script>
            // function confirmaGuardar(){
            //     var mensaje = "ESTAS SEGURO QUE QUIERES MARCAR TODO COMO PAGADO?";
            //     if(confirm(mensaje)){
            //         return true;
            //     }else{
            //         return false;
            //     }           
            // } 

            $("#confirm").on( 'click', function () {
            reset();
            alertify.confirm("¿ESTAS SEGURO QUE QUIERES MARCAR TODO COMO PAGADO?", function (e) {
                if (e) {
                    return true;
                } else {
                    return false;
                }
            });
            return false;
        });
        </script>
    </head>
    <body style="padding-bottom: 200px;">
        <?php echo panel("home"); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <?php
                    if(isset($_REQUEST['actualizado'])){
                        if ($_REQUEST['actualizado']=='si') {
//echo "<div class='alert alert-success cartel'>Datos actualizados correctamente</div>";
                            echo "<script>alertify.success(\"Datos actualizados correctamente!\");</script>";   

                            ?>
                            <script type="text/javascript">
                                $(".cartel").fadeTo(2000, 500).slideUp(500, function(){
                                   $(".cartel").alert('close');
                               });
                            </script>
                            <?php
                        }elseif ($_REQUEST['actualizado']=='no') {
//echo "<div class='alert alert-danger'>Error al actualizar los datos:</div>";
                            echo "<script>alertify.error(\"Error al actualizar los datos!\");</script>";   
                            ?>
                            <script type="text/javascript">
                                $(".cartel").fadeTo(2000, 500).slideUp(500, function(){
                                    $(".cartel").alert('close');
                                });
                            </script>
                            <?php
                        }
                    }
                    if(isset($_REQUEST['mensaje'])){
                        if ($_REQUEST['mensaje']=='borrado') {
                            echo "<div class='alert alert-warning cartel'>Cliente borrado correctamente</div>";
                            //echo "<script>alertify.warning(\"Cliente borrado correctamente!\");</script>"; 
                            ?>
                            <script type="text/javascript">
                                $(".cartel").fadeTo(5000, 500).slideUp(500, function(){
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


            <form name="f1" action="librerias/marcarPagados.php" method="POST" id="confirm" onsubmit="return confirmaGuardar()"> 
                <table id="example" class="table table-responsive table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Modelo de auto</th>
                            <th>Teléfono</th>
                            <th>Valor Cuota</th>
                            <th>Pagado/Total</th>
                            <th>Pagado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $mes=date('m');$anio=date('Y');      
                        if (isset($_POST["buscado"])) {
                            $rs = mysqli_query( $conexion,"SELECT cliente_id,cliente_nombre,cliente_celular,cliente_cuotas,cliente_cuota_total,cliente_idAuto FROM clientes WHERE cliente_nombre LIKE '%".$_POST["buscado"]."%' ORDER BY cliente_id ASC") or die(mysqli_error($conexion));                            
                        }else{
                            $rs = mysqli_query( $conexion,"SELECT cliente_id,cliente_nombre,cliente_celular,cliente_cuotas,cliente_cuota_total,cliente_idAuto FROM clientes WHERE cliente_estado='no' AND cliente_usuario='".$_SESSION['usuario_id']."' ORDER BY cliente_id ASC") or die(mysqli_error($conexion));
                        }
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
                        <button type="submit" class="btn btn-primary" id="botonPagar" name="guardar">Pagados</button>
                    </div>
                </form>
                
                <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
                    <div class="container-fluid">
                        <p class="navbar-text "><?php echo "Total de clientes activos: ".mysqli_num_rows($rs);?></p>

                        <div class="nav navbar-nav navbar-right foot-barra-home">
                            <a href=javascript:deseleccionar_todo()><button type="button" class="btn btn-warning btn-sm navbar-btn">Desmarcar todo <span class="glyphicon glyphicon-remove-circle"></span></button></a>
                            <a href=javascript:seleccionar_todo()><button type="button" class="btn btn-success btn-sm navbar-btn ">Marcar todo <span class="glyphicon glyphicon-check"></span></button></a>
                            <a href="#botonPagar"><button type="button" class="btn btn-info btn-sm navbar-btn">Ir al final <span class="glyphicon glyphicon-arrow-down"></span></button></a>
                        </div>
                    </div>
                </nav>
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