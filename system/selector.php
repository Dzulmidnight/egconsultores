<?php 
	if($_SESSION["autentificado"] == false){
		header("Location: ../login.php");
	}
	mysql_select_db($database_eg_system, $eg_system);

if(isset($_GET['menu'])){
	$menu = $_GET['menu'];
}
switch ($menu) {
	case 'cuenta':
		include('cuenta/detalle.php');
		break;
	case 'usuarios':
		include("users/listado_usuarios.php");
		break;
	case 'articulo':
		include("articulo/articulo.php");
		break;
	case 'clientes':
		include("clientes/clientes.php");
		break;
	case 'manuales':
		include("manuales/manuales.php");
		break;
	case 'cotizaciones':
		include("cotizaciones/cotizaciones.php");
		break;
	case 'servicios':
		include("servicios/servicios.php");
		break;
	case 'facturas':
		include("facturas/facturas.php");
		break;
	case 'bitacora':
		include("bitacora/bitacora.php");
		break;





	default:

		break;
}
 ?>