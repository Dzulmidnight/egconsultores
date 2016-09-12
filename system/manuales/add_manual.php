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

	if(isset($_POST['agregar_manual']) && $_POST['agregar_manual'] == 1){

		$idusuario = $_SESSION['idusuario'];
		$identificador = "MANUAL";
		$accion = 1;

		if(!empty($_FILES['archivo']['name'])){
			$ruta_img = "archivos/manuales/";
			$ruta_img = $ruta_img.basename( $_FILES['archivo']['name']); 
			if(move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = '';
		}

		$insertSQL = sprintf("INSERT INTO manuales (nombre, descripcion, archivo, idusuario, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($_POST['nombre'], "text"),
			GetSQLValueString($_POST['descripcion'], "text"),
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());
		$idmanual = mysql_insert_id($eg_system);

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idmanual, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idmanual, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL, $eg_system) or die(mysql_error());

		$mensaje = "Manual Agregado Correctamente";
	}

?>

<h3>Agregar Manual</h3>

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
			<label for="nombre">Nombre</label>
		    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Manual" required>
			
			<label for="descripcion">Descripción</label>
		    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
			
			<label for="archivo">Cargar Manual</label>
		    <input type="file" class="form-control" id="archivo" name="archivo" required>
			
			<label for="fecha">Fecha de Registro</label>
		    <input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo date('d/m/Y', time()); ?>" readonly>
			<hr>
		    <input type="submit" class="btn btn-success form-control" value="Agregar Manual">
		    <input type="hidden" name="agregar_manual" value="1">
		</form>
 	</div>
 </div>