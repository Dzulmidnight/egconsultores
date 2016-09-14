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
	$identificador = "CLIENTE";
	/***** TERMIAN VARIABLES DE BITACORA *****/

	if(isset($_POST['eliminar_cliente']) && $_POST['eliminar_cliente'] == 1){
		$idcliente = $_POST['idcliente'];

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idcliente, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idcliente, "int"),
			GetSQLValueString($fecha, "int"));
		$delete = mysql_query($insertSQL,$eg_system) or die(mysql_error());

		$deleteSQL = "DELETE FROM cliente WHERE idcliente = $idcliente";

		$eliminar = mysql_query($deleteSQL,$eg_system) or die(mysql_error());

		$mensaje = "Cliente Eliminado Correctamente";

	}

	$row_cliente = "SELECT * FROM cliente ORDER BY empresa";
	$consultar = mysql_query($row_cliente,$eg_system);
	$total = mysql_num_rows($consultar);



?>


<h3>Listado de Clientes | Total: <span style="color:#c0392b"><?php echo $total; ?></span></h3>

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
 	<div class="col-md-12">
 		<table class="table table-bordered table-condensed table-hover" style="font-size:12px;">
 			<thead>
				<tr class="alert alert-info">
					<th class="text-center">Nº</th>
					<th>ID</th>
					<th class="text-center">Empresa</th>
					<th class="text-center">RFC</th>
					<th class="text-center hidden-xs">Cont Emp1</th>
					<th class="text-center hidden-xs">Teléfono</th>
					<th class="text-center hidden-xs">Colonia</th>
					<th class="text-center">Ciudad</th>
					<th class="text-center hidden-xs">Cotizaciones</th>
					<th class="text-center hidden-xs">Facturas</th>
				</tr>
 			</thead>
 			<tbody>
 				<?php 
 				$contador = 1;
 				while($cliente = mysql_fetch_assoc($consultar)){
 				?>
 				<tr>
 					<td class="info"><?php echo $contador; ?></td>
 					<td><?php echo $cliente['idcliente']; ?></td>
 					<td><?php echo $cliente['empresa']; ?></td>
 					<td><?php echo $cliente['rfc']; ?></td>
 					<td><?php echo $cliente['cont_emp1']; ?></td>
 					<td><?php echo $cliente['telefono']; ?></td>
 					<td><?php echo $cliente['colonia']; ?></td>
 					<td><?php echo $cliente['ciudad']; ?></td>
 					<td>
 						<a href="?menu=cotizaciones&add_cotizacion&cliente=<?php echo $cliente['idcliente']; ?>" data-toggle="tooltip" title="Agregar Cotización">
 							<span class="btn btn-xs btn-default glyphicon glyphicon-plus" aria-hidden="true"></span>
 						</a>
					<?php 
						$row_cotizaciones = mysql_query("SELECT idcotizacion FROM cotizacion WHERE idcliente = $cliente[idcliente]");
						$total_cotizaciones = mysql_num_rows($row_cotizaciones);
						
					 ?>
 					</td>
 					<td>
 						<a href="?menu=facturas&add_factura&factura_cliente=<?php echo $cliente['idcliente']; ?>" data-toggle="tooltip" title="Agregar Factura">
 							<span class="btn btn-xs btn-default glyphicon glyphicon-plus" aria-hidden="true"></span>
 						</a>
					<?php 
						$row_facturas = mysql_query("SELECT idfactura FROM facturas WHERE idcliente = $cliente[idcliente]");
						$total_facturas = mysql_num_rows($row_facturas);

					 ?>
 					</td>

					<td style="border:hidden;border-left:1px;">
						<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=clientes&idcliente=<?php echo $cliente['idcliente']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
					</td>
					<?php 
					if($row_usuario['eliminar']){
					?>
					<form action="" method="POST">
						<td style="border:hidden;border-left:1px;">
							<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
							<input type="hidden" name="idcliente" value="<?php echo $cliente['idcliente']; ?>">
							<input type="hidden" name="eliminar_cliente" value="1">
						</td>
					</form>
					<?php 
					}
					 ?>
 				</tr>
				<?php
				$contador++;
 				}
 				 ?> 				
 			</tbody>
 		</table>
 	</div>
 </div>