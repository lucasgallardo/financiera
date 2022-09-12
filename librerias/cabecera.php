<?php  
function head(){
	$cabecera = '<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Financiera</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">        

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery-1.12.3.js"></script>';

    return $cabecera;
}

function panel($seleccionado){
    switch ($seleccionado) {
        case 'home':
            $seleccion='<li class="active"><a href="home.php">Inicio <span class="sr-only">(current)</span></a></li>
        <li><a href="clienteNuevo.php">Nuevo</a></li>
        <li><a href="resumen.php">Resumen</a></li>';
            break;
        case 'clienteNuevo':
            $seleccion='<li><a href="home.php">Inicio</a></li>
        <li class="active"><a href="clienteNuevo.php">Nuevo <span class="sr-only">(current)</span></a></li>
        <li><a href="resumen.php">Resumen</a></li>';
            break;
        case 'resumen':
            $seleccion='<li><a href="home.php">Inicio</a></li>
        <li><a href="clienteNuevo.php">Nuevo</a></li>
        <li class="active"><a href="resumen.php">Resumen <span class="sr-only">(current)</span></a></li>';
            break;
        case 'detallesCliente':
            $seleccion='<li><a href="home.php">Inicio</a></li>
        <li><a href="clienteNuevo.php">Nuevo</a></li>
        <li><a href="resumen.php">Resumen</a></li>
        <li class="active"><a href="home.php">Volver <span class="sr-only">(current)</span></a></li>';
            break;
        default:
            $seleccion='<li><a href="home.php">Inicio</a></li>
        <li><a href="clienteNuevo.php">Nuevo</a></li>
        <li><a href="resumen.php">Resumen</a></li>
        <li class="active"><a href="home.php">Volver <span class="sr-only">(current)</span></a></li>';
            break;
    }
    $mipanel = '<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="home.php">Financiera</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          '.$seleccion.'      
        </ul>
    <form class="navbar-form navbar-left" action="home.php" method="POST" role="search">
        <div class="form-group">
          <input type="text" class="form-control" name=buscado placeholder="Buscar Cliente">
      </div>
      <button type="submit" name="busca" class="btn btn-default">Buscar</button>
  </form>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrar <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="autos.php">Autos</a></li>
            <li><a href="clientes.php">Borrar Clientes</a></li>
            <li><a href="#">Usuarios</a></li>
            <li><a href="historial.php">Historial de Pagos</a></li>
            <li><a href="historialAltas.php">Historial de Clientes Nuevos</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="registro.php">Usuario Nuevo</a></li>
        </ul>
    </li>
<li><a href="perfil.php">'.$_SESSION["usuario_nombre"].'</a></li>
<li><a href="salir.php"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-off"></span></button></a></li>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>';
return $mipanel;
}

?>