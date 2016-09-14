<?php 
	if($_SESSION["autentificado"] == false){
		header("Location: ../../login.php");
	}
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
	/***** INICIAN VARIABLES DE BITACORA *****/
	$fecha = time();
	$accion = 3; //ELIMINAR
	$idusuario = $_SESSION['idusuario'];
	$identificador = "FACTURA";
	/***** TERMIAN VARIABLES DE BITACORA *****/
	if(isset($_POST['eliminar_factura']) && $_POST['eliminar_factura'] == 1){
		$idfactura = $_POST['idfactura'];
		

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idfactura, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idfactura, "int"),
			GetSQLValueString($fecha, "int"));
		$delete = mysql_query($insertSQL,$eg_system) or die(mysql_error());

		unlink($_POST['xml']);
		unlink($_POST['pdf']);

		$deleteSQL = "DELETE FROM facturas WHERE idfactura = $idfactura";
		$eliminar = mysql_query($deleteSQL,$eg_system) or die(mysql_error());

		$mensaje = "Factura Eliminada Correctamente";
	}


	if(isset($_POST['estatus_factura'])){
		$accion = 2; //ACTUALIZAR
		$idfactura = $_POST['idfactura'];
		$estatus = $_POST['estatus_factura'];

		$updateSQL = sprintf("UPDATE facturas SET estatus_factura = %s WHERE idfactura = %s",
			GetSQLValueString($estatus, "text"),
			GetSQLValueString($idfactura, "int"));
		$actualizar = mysql_query($updateSQL, $eg_system) or die(mysql_error());


		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idfactura, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idfactura, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL, $eg_system) or die(mysql_error());

		$mensaje = "Factura Actualizada Correctamente";


	}

	$row_facturas = mysql_query("SELECT facturas.*, cliente.empresa, servicios.nombre AS 'nombre_servicio', usuario.username FROM facturas LEFT JOIN cliente ON facturas.idcliente = cliente.idcliente LEFT JOIN servicios ON facturas.idservicio = servicios.idservicio LEFT JOIN usuario ON facturas.responsable = usuario.idusuario", $eg_system) or die(mysql_error());
	$total_facturas = mysql_num_rows($row_facturas);


?>
<div class="row">
	<div class="col-md-12">
		<h3>Listado Facturas (<span style="color:red"><?php echo $total_facturas; ?></span>)</h3>
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

		<table class="table table-condensed table-bordered table-hover" style="font-size:12px;">
			<thead>
				<tr class="info">
					<th class="text-center">Nº</th>
					<th class="text-center">Cliente</th>
					<th class="text-center">Cotización</th>
					<th class="text-center">Servicio</th>
					<th class="text-center">XML</th>
					<th class="text-center">PDF</th>
					<th class="text-center">Responsable</th>
					<th class="text-center">Estatus Factura</th>
					<th class="text-center">Fecha Registro</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$contador = 1; 
				while($facturas = mysql_fetch_assoc($row_facturas)){
				?>
					<tr>
						<td><?php echo $contador; ?></td>
						<td><?php echo $facturas['empresa']; ?></td>
						<td><a href="?menu=cotizaciones&idcotizacion=<?php echo $facturas['idcotizacion']; ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>Consultar</a></td>
						<td><a href="?menu=servicios&idservicio=<?php echo $facturas['idservicio']; ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo $facturas['nombre_servicio']; ?></a></td>
						<td><a href="<?php echo $facturas['xml']; ?>" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descargar</a></td>
						<td><a href="<?php echo $facturas['pdf']; ?>" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descargar</a></td>
						<td><?php echo $facturas['username']; ?></td>
						<td>
							<?php
							if($facturas['estatus_factura'] == "POR PAGAR"){
								
							?>
							<form action="" method="POST">
								<?php echo "<b class='alert alert-info' style='padding:7px;'>".$facturas['estatus_factura']."</b>"; ?>
								<button class="btn btn-sm btn-success" type="submit" name="estatus_factura" data-toggle="tooltip" title="PAGADO" value="PAGADO"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
								<button class="btn btn-sm btn-danger" type="submit" name="estatus_factura" data-toggle="tooltip" title="CANCELADO" value="CANCELADO"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
								<input type="hidden" name="idfactura" value="<?php echo $facturas['idfactura']; ?>">

							</form>
							<?php
							}else{
								echo $facturas['estatus_factura'];
							}
							?>
						</td>
						<td><?php echo date('d/m/Y', $facturas['fecha_registro']); ?></td>
		
						<td style="border:hidden;border-left:1px;width:40px;">
							<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=facturas&idfactura=<?php echo $facturas['idfactura']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
						</td>
						<form action="" method="POST">
							<td style="border:hidden;border-left:1px;width:40px;">
								<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
								<input type="hidden" name="idfactura" value="<?php echo $facturas['idfactura']; ?>">
								<input type="hidden" name="xml" value="<?php echo $facturas['xml']; ?>">
								<input type="hidden" name="pdf" value="<?php echo $facturas['pdf']; ?>">
								<input type="hidden" name="eliminar_factura" value="1">
							</td>
						</form>

					</tr>
				<?php
				}
				$contador++;
				 ?>
			</tbody>
		</table>
	</div>
</div>