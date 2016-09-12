<?php
	include("../connections/sesion.php");
  include("../connections/eg_system.php");

  mysql_select_db($database_eg_system, $eg_system);

if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}
  

?>

<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="../../favicon.ico">-->

    <title>EGConsultores</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript">tinymce.init({ selector:'.textarea' });</script>



    <script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    </script>

  </head>

  <body>

    <?php
    if(isset($_GET['menu'])){
      $menu = $_GET['menu']; 
    }else{
      $menu = "";
    }

    $row_cliente = mysql_query("SELECT * FROM cliente",$eg_system) or die(mysql_error());
    $total_cliente = mysql_num_rows($row_cliente);

    $query_usuario = mysql_query("SELECT clase, leer, crear, editar, eliminar FROM usuario WHERE idusuario = ".$_SESSION['idusuario']."");
    $row_usuario = mysql_fetch_assoc($query_usuario);

    ?>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">EG Consultores</a>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="visible-xs nav navbar-nav navbar-right">
            <li>
              <p style="color:white">Usuario: <strong style="color:#c0392b"><?php echo $_SESSION['username'];?></strong></p>
            </li>
            <li <?php if(empty($menu)){ echo 'class="active"';} ?>>
              <a href="index.php">Inicio</span></a>
            </li>
            <li <?php if($menu == "clientes"){ echo 'class="active"';} ?>>
              <a href="?menu=clientes&listado">Clientes <span class="badge"><?php echo $total_cliente; ?></span></a>
            </li>

            <?php 
            if($row_usuario['clase'] == 'adm'){
            ?>
              <li <?php if($menu == "usuarios"){ echo 'class="active"';}?> ><a href="?menu=usuarios">Usuarios <span class="badge"><?php echo $total_usuario; ?></span></a></li>
            <?php
            }
             ?>

            <li <?php if($menu == "cuenta"){ echo 'class="active"';} ?>>
              <a href="?menu=cuenta">Mi Cuenta</a>
            </li>
            <li>
              <a href="../connections/salir.php">Cerrar Sesión</a>
            </li>

          </ul>
          <!--<form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
        </div>
      </div>
    </nav>




    <div class="container-fluid">
      <div class="row">
        <!------------------------ INICIA SECCIÓN MENÚ OPCIONES ------------------------------>
        <div class="col-sm-2 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="#" class="disabled"><p>Usuario: <strong style="color:#c0392b"><?php echo $_SESSION['username'];?></strong></p></a></li>

            <li <?php if(empty($menu)){ echo 'class="active"';} ?>><a href="index.php">Inicio</span></a></li>

            <li <?php if($menu == "clientes"){ echo 'class="active"';} ?>><a href="?menu=clientes&listado">Clientes <span class="badge"><?php echo $total_cliente; ?></span></a></li>

            <li <?php if($menu == "manuales"){ echo 'class="active"';}?>>
              <a href="?menu=manuales&listado">Manuales</a>
            </li>
            <li <?php if($menu == "cotizaciones"){ echo 'class="active"';}?>>
              <a href="?menu=cotizaciones">Cotizaciónes</a>
            </li>
            <li <?php if($menu == "facturas"){ echo 'class="active"';}?>>
              <a href="?menu=facturas">Facturas</a>
            </li>
            <li <?php if($menu == "servicios"){ echo 'class="active"';}?>>
              <a href="?menu=servicios">Servicios</a>
            </li>
            <?php 
            if($row_usuario['clase'] == 'adm'){
            ?>
              <li <?php if($menu == "bitacora"){ echo 'class="active"';}?>>
                <a href="?menu=bitacora">Bitacora</a>
              </li>
            <?php
            } 
             ?>
            <?php 
            if($row_usuario['clase'] == 'adm'){
            ?>
              <li <?php if($menu == "usuarios"){ echo 'class="active"';}?> ><a href="?menu=usuarios">Usuarios</a></li>
            <?php
            }
             ?>
            <li <?php if($menu == "cuenta"){ echo 'class="active"';} ?>><a href="?menu=cuenta">Mi Cuenta</a></li>
            <li><a href="../connections/salir.php">Cerrar Sesión</a></li>
          </ul>

        </div>
        <!------------------------ TERMINA SECCIÓN MENÚ OPCIONES ------------------------------>

        <!------------------------ INICIA SECCIÓN MENÚ SISTEMA ------------------------------>
        <div class="col-sm-10 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="padding:10px;">
          <?php 
            include("selector.php");
           ?>
        </div>
        <!------------------------ TERMINA SECCIÓN MENÚ SISTEMA ------------------------------>
      </div>
    </div>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
