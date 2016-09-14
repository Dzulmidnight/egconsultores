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

	if(isset($_POST['agregar_factura']) && $_POST['agregar_factura'] == 1){

		$idusuario = $_SESSION['idusuario'];
		$identificador = "FACTURA";
		$accion = 1;//AGREGAR
		$estatus = "POR PAGAR";

		if(isset($_GET['cotizacion_cliente'])){
			$idcotizacion = $_GET['cotizacion_cliente'];
		}else{
			$idcotizacion = "";
		}

		if(!empty($_FILES['xml']['name'])){
			$ruta_xml = "archivos/facturas/xml/";
			$ruta_xml = $ruta_xml.basename( $_FILES['xml']['name']); 
			if(move_uploaded_file($_FILES['xml']['tmp_name'], $ruta_xml)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_xml = '';
		}
		if(!empty($_FILES['pdf']['name'])){
			$ruta_pdf = "archivos/facturas/pdf/";
			$ruta_pdf = $ruta_pdf.basename( $_FILES['pdf']['name']); 
			if(move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_pdf)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_pdf = '';
		}


		$insertSQL = sprintf("INSERT INTO facturas (idcliente, idcotizacion, idservicio, xml, pdf, responsable, estatus_factura, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($_POST['idcliente'], "int"),
			GetSQLValueString($idcotizacion, "int"),
			GetSQLValueString($_POST['idservicio'], "int"),
			GetSQLValueString($ruta_xml, "text"),
			GetSQLValueString($ruta_pdf, "text"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($estatus, "text"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());
		$idfactura = mysql_insert_id($eg_system);

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idfactura, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idfactura, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL, $eg_system) or die(mysql_error());

		$mensaje = "Factura Agregada Correctamente";
	}

	$row_clientes = mysql_query("SELECT * FROM cliente", $eg_system) or die(mysql_error());
	//$clientes = mysql_fetch_assoc($row_clientes);

	$row_servicios = mysql_query("SELECT * FROM servicios", $eg_system) or die(mysql_error());

	
	if(isset($_GET['factura_cliente'])){
		$cliente_factura = $_GET['factura_cliente'];
	}
	if(isset($_GET['cotizacion_cliente'])){
		$cliente_cotizacion = $_GET['cotizacion_cliente'];
		$consultar = mysql_query("SELECT idcliente, idservicio FROM cotizacion WHERE idcotizacion = $cliente_cotizacion", $eg_system) or die(mysql_error());
		$cotizacion = mysql_fetch_assoc($consultar);
	}
	
?>

<h3>Agregar Factura</h3>

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
 	<form action="" method="POST" enctype="multipart/form-data">
 		<div class="col-md-6">
 			<h4>Cliente</h4>
 			<select name="idcliente" id="" class="form-control">
 				<option value="">Seleccione un Cliente</option>
 				<?php 
 				while($clientes = mysql_fetch_assoc($row_clientes)){
 					if(isset($cliente_factura) && $clientes['idcliente'] == $cliente_factura){
 						echo "<option value='$clientes[idcliente]' selected>$clientes[empresa]</option>";
 					}else if(isset($cotizacion['idcliente']) && $clientes['idcliente'] == $cotizacion['idcliente']){
 						echo "<option value='$clientes[idcliente]' selected>$clientes[empresa]</option>";
 					}else{
 						echo "<option value='$clientes[idcliente]'>$clientes[empresa]</option>";
 					}
 				}
 				 ?>
 			</select>
 		</div>
 		<div class="col-md-6">
 			<h4>Servicio</h4>
 			<select name="idservicio" id="" class="form-control">
 				<option value="">Seleccione un Servicio</option>
 				<?php 
 				while($servicios = mysql_fetch_assoc($row_servicios)){
 					if(isset($cotizacion['idservicio']) && $servicios['idservicio'] == $cotizacion['idservicio']){
 						echo "<option value='$servicios[idservicio]' selected>$servicios[nombre]</option>";
 					}else{
 						echo "<option value='$servicios[idservicio]'>$servicios[nombre]</option>";
 					}
 				}
 				 ?>
 			</select>
 		</div>
 		<div class="col-md-6">
 			<h4>Cargar XML</h4>
 			<input type="file" class="form-control" name="xml">
 		</div>
 		<div class="col-md-6">
 			<h4>Cargar PDF</h4>
 			<input type="file" class="form-control" name="pdf">
 		</div>
 		<div class="col-md-12">
	 		<hr>
	 		<input type="submit" class="btn btn-success form-control" value="Agregar Factura">
	 		<input type="hidden" name="agregar_factura" value="1">
 		</div>
 	</form>
 </div>