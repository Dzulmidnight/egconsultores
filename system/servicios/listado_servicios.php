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

	$row_servicios = mysql_query("SELECT servicios.*, usuario.username FROM servicios INNER JOIN usuario ON servicios.idusuario = usuario.idusuario",$eg_system) or die(mysql_error());
	$total_servicios = mysql_num_rows($row_servicios);


?>
<div class="row">
	<div class="col-md-12">
		<h3>Listado Servicios (<?php echo "<span style='color:red'>$total_servicios</span>"; ?>)</h3>
		<table class="table table-bordered table-hover" style="font-size:12px;">
			<thead>
				<tr class="info">
					<th class="text-center">Nº</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Descripción</th>
					<th class="text-center">Costo</th>
					<th class="text-center">Agredo Por:</th>
					<th class="text-center">Fecha</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$contador = 1;
				while($servicios = mysql_fetch_assoc($row_servicios)){
				?>
					<tr>
						<td><?php echo $contador; ?></td>
						<td><?php echo $servicios['nombre']; ?></td>
						<td><?php echo substr($servicios['descripcion'], 0,200)." ..."; ?></td>
						<td><?php echo $servicios['costo']; ?></td>
						<td><?php echo $servicios['username']; ?></td>
						<td><?php echo date('d/m/Y', $servicios['fecha_registro']); ?></td>

						<td style="border:hidden;border-left:1px;width:40px;">
							<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=servicios&idservicio=<?php echo $servicios['idservicio']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
						</td>
						<form action="" method="POST">
							<td style="border:hidden;border-left:1px;width:40px;">
								<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
								<input type="hidden" name="idservicio" value="<?php echo $servicios['idservicio']; ?>">
								<input type="hidden" name="archivo" value="<?php echo $servicios['archivo']; ?>">
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