<?php 
	if($_SESSION["autentificado"] == false){
		header("Location: ../../login.php");
	}
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

	mysql_select_db($database_eg_system, $eg_system);

	$fecha = time();

	if(isset($_POST['agregar_cotizacion']) && $_POST['agregar_cotizacion'] == 1){

		$idusuario = $_SESSION['idusuario'];
		$identificador = "COTIZACION";
		$accion = 1;


		$insertSQL = sprintf("INSERT INTO cotizacion (idcliente, idusuario, idservicio, observaciones, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($_POST['cliente'], "int"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($_POST['servicio'], "int"),
			GetSQLValueString($_POST['observaciones'], "text"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());
		$idcotizacion = mysql_insert_id($eg_system);

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idcotizacion, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idcotizacion, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL, $eg_system) or die(mysql_error());

		$mensaje = "Cotización Agregado Correctamente";
	}
	if(isset($_GET['cliente'])){
		$cliente_factura = $_GET['cliente'];
	}

	$row_cliente = mysql_query("SELECT idcliente, empresa FROM cliente ORDER BY empresa",$eg_system) or die(mysql_error());
	$row_servicio = mysql_query("SELECT idservicio, nombre FROM servicios ORDER BY nombre", $eg_system) or die(mysql_error());

?>

<h3>Agregar Cotización</h3>

<?php 
if(isset($mensaje)){
?>
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $mensaje; ?>
</div>
<?php
}
?>

 <div class="row">
 	<div class="col-lg-12">
		<form action="" method="POST" enctype="multipart/form-data">
			<label for="cliente">Cliente</label>
		    <select name="cliente" id="" class="form-control" required>
		    	<option value="">Seleccione un cliente</option>
		    	<?php
		    	while($clientes = mysql_fetch_assoc($row_cliente)){
		    		if(isset($cliente_factura) && $clientes['idcliente'] == $cliente_factura){
		    			echo "<option value='$clientes[idcliente]' selected>$clientes[empresa]</option>";
		    		}else{
		    			echo "<option value='$clientes[idcliente]'>$clientes[empresa]</option>";
		    		}
		    	}
		    	 ?>
		    </select>
			
			<label for="descripcion">Servicio</label>
		    <select name="servicio" id="" class="form-control" required> 
		    	<option value="">Seleccione un Servicio</option>
		    	<?php 
		    	while($servicios = mysql_fetch_assoc($row_servicio)){
		    		echo "<option value='$servicios[idservicio]'>$servicios[nombre]</option>";
		    	}
		    	 ?>
		    </select>
			
			<label for="observaciones">Observaciones</label>
		    <textarea name="observaciones" class="form-control"></textarea>
			
			<label for="fecha">Fecha de Registro</label>
		    <input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo date('d/m/Y', time()); ?>" readonly>
			<hr>
		    <input type="submit" class="btn btn-success form-control" value="Agregar Cotización">
		    <input type="hidden" name="agregar_cotizacion" value="1">
		</form>
 	</div>
 </div>