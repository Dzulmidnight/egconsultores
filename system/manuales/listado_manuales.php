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
		<table class="table table-bordered table-hover" style="font-size:12px;">
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
						<td><a href="<?php echo $manual['archivo']; ?>" target="_blank"><?php echo $manual['archivo']; ?></a></td>
						<td><?php echo date('d/m/Y', $manual['fecha_registro']); ?></td>
					</tr>
				<?php
				}
				$contador++;
				 ?>
			</tbody>
		</table>
	</div>
</div>
