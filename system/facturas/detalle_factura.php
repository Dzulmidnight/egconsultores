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
	$idfactura = $_GET['idfactura'];
	$fecha = time();
	$identificador = "COTIZACION";
	$accion = 2; // ACTUALIZAR

	if(isset($_POST['actualizar_factura']) && $_POST['actualizar_factura'] == 1){

		if(!empty($_FILES['xml']['name'])){
			unlink($_POST['xml_actual']);
			$ruta_xml = "archivos/facturas/xml/";
			$ruta_xml = $ruta_xml.basename( $_FILES['xml']['name']); 
			if(move_uploaded_file($_FILES['xml']['tmp_name'], $ruta_xml)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_xml = $_POST['xml_actual'];
		}
		if(!empty($_FILES['pdf']['name'])){
			unlink($_POST['pdf_actual']);
			$ruta_pdf = "archivos/facturas/pdf/";
			$ruta_pdf = $ruta_pdf.basename( $_FILES['pdf']['name']); 
			if(move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_pdf)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_pdf = $_POST['pdf_actual'];
		}

		$updateSQL = sprintf("UPDATE facturas SET idcliente = %s, idservicio = %s, xml = %s, pdf = %s WHERE idfactura = %s",
			GetSQLValueString($_POST['idcliente'], "int"),
			GetSQLValueString($_POST['idservicio'], "int"),
			GetSQLValueString($ruta_xml, "text"),
			GetSQLValueString($ruta_pdf, "text"),
			GetSQLValueString($idfactura, "int"));
		$actualizar = mysql_query($updateSQL, $eg_system) or die(mysql_error());

		$insertSQL = sprintf("INSERT INTO bitacora(idusuario, identificador, accion, idfactura, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idfactura, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());

		$mensaje = "Factura Actualizada Correctamente";

	}

	$row_factura = mysql_query("SELECT * FROM facturas WHERE idfactura = $idfactura", $eg_system) or die(mysql_error());
	$factura = mysql_fetch_assoc($row_factura);

	$row_cliente = mysql_query("SELECT idcliente, empresa FROM cliente ORDER BY empresa",$eg_system) or die(mysql_error());
	$row_servicio = mysql_query("SELECT idservicio, nombre FROM servicios ORDER BY nombre", $eg_system) or die(mysql_error());


?>

<h3>Detalle Factura</h3>
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
	<form action="" method="POST" enctype="multipart/form-data">
		<div class="col-md-6">
			<h4>Clientes</h4>
			<select name="idcliente" id="" class="form-control">
				<option value="">Seleccione un Cliente</option>
				<?php 
				while($clientes = mysql_fetch_assoc($row_cliente)){
					if($clientes['idcliente'] == $factura['idcliente']){
						echo "<option value='$clientes[idcliente]' selected>$clientes[empresa]</option>";
					}else{
						echo "<option value='$clientes[idcliente]'>$clientes[empresa]</option>";
					}
				}
				 ?>
			</select>
		</div>
		<div class="col-md-6">
			<h4>Servicios</h4>
			<select name="idservicio" id="" class="form-control">
				<option value="">Seleccione un Servicio</option>
				<?php 
				while($servicios = mysql_fetch_assoc($row_servicio)){
					if($servicios['idservicio'] == $factura['idservicio']){
						echo "<option value='$servicios[idservicio]' selected>$servicios[nombre]</option>";
					}else{
						echo "<option value='$servicios[idservicio]'>$servicios[nombre]</option>";
					}
				}
				 ?>
			</select>
		</div>
		<div class="col-md-3">
			<h4>XML Actual</h4>
			<a href="<?php echo $factura['xml']; ?>" target="_blank" class="btn btn-info form-control"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descagar</a>
			<input type="hidden" name="xml_actual" value="<?php echo $factura['xml']; ?>">
		</div>
		<div class="col-md-3">
			<h4>Nuevo XML</h4>
			<input type="file" class="form-control" name="xml">
		</div>

		<div class="col-md-3">
			<h4>PDF Actual</h4>
			<a href="<?php echo $factura['pdf']; ?>" target="_blank" class="btn btn-info form-control"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descagar</a>
			<input type="hidden" name="pdf_actual" value="<?php echo $factura['pdf']; ?>">
		</div>
		<div class="col-md-3">
			<h4>Nuevo PDF</h4>
			<input type="file" class="form-control" name="pdf">
		</div>
		<div class="col-md-12">
			<hr>
			<input type="submit" class="form-control btn btn-success" value="Actualizar Factura">
			<input type="hidden" name="actualizar_factura" value="1">
		</div>
	</form>

</div>