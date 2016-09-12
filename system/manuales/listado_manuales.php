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

	if(isset($_POST['eliminar_manual']) && $_POST['eliminar_manual'] == 1){
		$idmanual = $_POST['idmanual'];
		$archivo = $_POST['archivo'];

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idmanual, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idmanual, "int"),
			GetSQLValueString($fecha, "int"));
		$delete = mysql_query($insertSQL,$eg_system) or die(mysql_error());

		unlink($archivo);

		$deleteSQL = "DELETE FROM manuales WHERE idmanual = $idmanual";
		$eliminar = mysql_query($deleteSQL,$eg_system) or die(mysql_error());

		$mensaje = "Cliente Eliminado Correctamente";
	}

	$row_manuales = mysql_query("SELECT * FROM manuales" ,$eg_system) or die(mysql_error());
	$total = mysql_num_rows($row_manuales);

?>


<h3>Listado de Manuales | Total: <span style="color:#c0392b"><?php echo $total; ?></span></h3>

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
				<tr class="info">
					<th class="text-center">Nº</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Descripción</th>
					<th class="text-center">Archivo</th>
					<th class="text-center">Agregado el:</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$contador = 1;
				while($manual = mysql_fetch_assoc($row_manuales)){
				?>
					<tr>
						<td><?php echo $contador; ?></td>
						<td><?php echo $manual['nombre']; ?></td>
						<td><?php echo $manual['descripcion']; ?></td>
						<td><a class="" href="<?php echo $manual['archivo']; ?>" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Descargar</a></td>
						<td><?php echo date('d/m/Y', $manual['fecha_registro']); ?></td>
						<td style="border:hidden;border-left:1px;">
							<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=manuales&idmanual=<?php echo $manual['idmanual']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
						</td>
						<form action="" method="POST">
							<td style="border:hidden;border-left:1px;">
								<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
								<input type="hidden" name="idmanual" value="<?php echo $manual['idmanual']; ?>">
								<input type="hidden" name="archivo" value="<?php echo $manual['archivo']; ?>">
								<input type="hidden" name="eliminar_manual" value="1">
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
