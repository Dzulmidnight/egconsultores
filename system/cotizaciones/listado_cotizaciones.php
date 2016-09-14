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
	$accion = 3;
	$idusuario = $_SESSION['idusuario'];
	$identificador = "MANUAL";
	/***** TERMIAN VARIABLES DE BITACORA *****/
	$row_cotizacion = mysql_query("SELECT cotizacion.*, usuario.username, cliente.empresa, servicios.nombre AS 'nombre_servicio' FROM cotizacion INNER JOIN usuario ON cotizacion.idusuario = usuario.idusuario INNER JOIN cliente ON cotizacion.idcliente = cliente.idcliente INNER JOIN servicios ON cotizacion.idservicio = servicios.idservicio", $eg_system) or die(mysql_error());
	$total_cotizacion = mysql_num_rows($row_cotizacion);

?>

<div class="row">
	<div class="col-md-12">
		<h3>Listado Cotizaciones (<span style="color:red"><?php echo $total_cotizacion; ?></span>)</h3>

		<table class="table table-hover table-bordered" style="font-size:12px;">
			<thead>
				<tr class="info">
					<th class="text-center">Nº</th>
					<th class="text-center">Cliente</th>
					<th class="text-center">Usuario</th>
					<th class="text-center">Servicio</th>
					<th class="text-center">Observaciones</th>
					<th class="text-center">Factura</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$contador = 1;
			while($cotizacion = mysql_fetch_assoc($row_cotizacion)){
			?>
				<tr>
					<td><?php echo $contador; ?></td>
					<td><a class="" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=clientes&idcliente=<?php echo $cotizacion['idcliente']; ?>"><?php echo $cotizacion['empresa']; ?></a></td>
					<td><a class="" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=usuarios&idusuario=<?php echo $cotizacion['idusuario']; ?>"><?php echo $cotizacion['username']; ?></a></td>
					<td><a class="" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=servicios&idservicio=<?php echo $cotizacion['idservicio']; ?>"><?php echo $cotizacion['nombre_servicio']; ?></a></td>
					<td><?php echo $cotizacion['observaciones']; ?></td>
 					<td>
 						<a href="?menu=facturas&add_factura&cotizacion_cliente=<?php echo $cotizacion['idcotizacion']; ?>" data-toggle="tooltip" title="Agregar Factura">
 							<span class="btn btn-xs btn-default glyphicon glyphicon-plus" aria-hidden="true"></span>
 						</a>
 					</td>

					<td style="border:hidden;border-left:1px;width:40px;">
						<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=cotizaciones&idcotizacion=<?php echo $cotizacion['idcotizacion']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
					</td>
					<form action="" method="POST">
						<td style="border:hidden;border-left:1px;width:40px;">
							<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
							<input type="hidden" name="idcotizacion" value="<?php echo $cotizacion['idcotizacion']; ?>">
							<input type="hidden" name="eliminar_manual" value="1">
						</td>
					</form>

				</tr>
			<?php
			$contador++;
			}
			 ?>
			</tbody>
		</table>
	</div>
</div>