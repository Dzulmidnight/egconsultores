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

	/***** INICIAN VARIABLES DE BITACORA *****/
	$idusuario = $_SESSION['idusuario'];
	$idcotizacion = $_GET['idcotizacion'];
	$fecha = time();
	$identificador = "COTIZACION";
	$accion = 2;

	if(isset($_POST['actualizar_cotizacion']) && $_POST['actualizar_cotizacion'] == 1){
		$updateSQL = sprintf("UPDATE cotizacion SET idcliente = %s, idusuario = %s, idservicio = %s, observaciones = %s WHERE idcotizacion = %s",
			GetSQLValueString($_POST['cliente'], "int"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($_POST['servicio'], "int"),
			GetSQLValueString($_POST['observaciones'], "text"),
			GetSQLValueString($idcotizacion, "int"));
		$actualizar = mysql_query($updateSQL,$eg_system) or die(mysql_error());

		$insertSQL = sprintf("INSERT INTO bitacora(idusuario, identificador, accion, idcotizacion, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idcotizacion, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());

		$mensaje = "Cotización Actualizada Correctamente";

	}

	$row_cotizacion = mysql_query("SELECT * FROM cotizacion WHERE idcotizacion = $idcotizacion", $eg_system) or die(mysql_error());
	$cotizacion = mysql_fetch_assoc($row_cotizacion);

	$row_cliente = mysql_query("SELECT idcliente, empresa FROM cliente ORDER BY empresa",$eg_system) or die(mysql_error());
	$row_servicio = mysql_query("SELECT idservicio, nombre FROM servicios ORDER BY nombre", $eg_system) or die(mysql_error());


?>
<h3>Detalle Cotización</h3>

<div class="row">
	<div class="col-md-12">
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
	</div>
	<div class="col-md-12">
		<form action="" method="POST" enctype="multipart/form-data">
			<label for="cliente">Cliente</label>
		    <select name="cliente" id="" class="form-control" required>
		    	<option value="">Seleccione un cliente</option>
		    	<?php
		    	while($clientes = mysql_fetch_assoc($row_cliente)){
		    		if($clientes['idcliente'] == $cotizacion['idcliente']){
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
		    		if($servicios['idservicio'] == $cotizacion['idservicio']){
		    			echo "<option value='$servicios[idservicio]' selected>$servicios[nombre]</option>";
		    		}else{
		    			echo "<option value='$servicios[idservicio]'>$servicios[nombre]</option>";
		    		}
		    	}
		    	 ?>
		    </select>
			
			<label for="observaciones">Observaciones</label>
		    <textarea name="observaciones" class="form-control"><?php echo $cotizacion['observaciones']; ?></textarea>
			
			<label for="fecha">Fecha de Registro</label>
		    <input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo date('d/m/Y', $cotizacion['fecha_registro']); ?>" readonly>
			<hr>
		    <input type="submit" class="btn btn-success form-control" value="Actualizar Cotización">
		    <input type="hidden" name="actualizar_cotizacion" value="1">
		</form>
		
	</div>
</div>