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
	$idmanual = $_GET['idmanual'];
	$fecha = time();
	$identificador = "MANUAL";
	$accion = 2;

	/***** TERMIAN VARIABLES DE BITACORA *****/
	if(isset($_POST['actualizar_manual']) && $_POST['actualizar_manual'] == 1){
		$idmanual = $_POST['idmanual'];

		if(!empty($_FILES['nuevo_archivo']['name'])){
			unlink($_POST['archivo']);

			$ruta_img = "archivos/manuales/";
			$ruta_img = $ruta_img.basename( $_FILES['nuevo_archivo']['name']); 
			if(move_uploaded_file($_FILES['nuevo_archivo']['tmp_name'], $ruta_img)){ 
				//echo "El archivo ". basename( $_FILES['archivo']['name']). " ha sido subido";
			} /*else{
				echo "Ha ocurrido un error, trate de nuevo!";
			}*/
		}else{
			$ruta_img = $_POST['archivo'];
		}

		if(!empty($_POST['directorio_raiz'])){
			$directorio_raiz = $_POST['directorio_raiz'];
		}else if(!empty($_POST['nuevo_directorio'])){
			$directorio_raiz  = $_POST['nuevo_directorio'];
		}else{
			$directorio_raiz = NULL;
		}

		if(!empty($_POST['sub_directorio'])){
			$sub_directorio = $_POST['sub_directorio'];
		}else{
			$sub_directorio = NULL;
		}


		$updateSQL = sprintf("UPDATE manuales SET nombre = %s, descripcion = %s, archivo = %s WHERE idmanual = %s",
			GetSQLValueString($_POST['nombre'], "text"),
			GetSQLValueString($_POST['descripcion'], "text"),
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($idmanual, "int"));
		$actualizar = mysql_query($updateSQL, $eg_system) or die(mysql_error());

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idmanual, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idmanual, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());
		
		$mensaje = "Manual Actualizado Correctamente";

	}
	$row_carpetas = mysql_query("SELECT directorio_raiz FROM manuales WHERE directorio_raiz IS NOT NULL GROUP BY directorio_raiz", $eg_system) or die(mysql_error());
	$row_manual = mysql_query("SELECT * FROM manuales WHERE idmanual = $idmanual", $eg_system) or die(mysql_error());
	$manual = mysql_fetch_assoc($row_manual);

?>
	
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
		<h3>Detalle Manual</h3>
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="col-md-3">
				<h4>Carpeta Actual</h4>
			    <select name="directorio_raiz" id="" class="form-control">
			    	<option value="">Seleccione una carpeta</option>
			    	<?php 
			    	while($carpetas = mysql_fetch_assoc($row_carpetas)){
			    		if($carpetas['directorio_raiz'] == $manual['directorio_raiz']){
			    			echo "<option value='$carpetas[directorio_raiz]' selected>$carpetas[directorio_raiz]</option>";
			    		}else{
			    			echo "<option value='$carpetas[directorio_raiz]'>$carpetas[directorio_raiz]</option>";
			    		}
			    	}
			    	 ?>
			    </select>
			</div>
			<div class="col-md-3">
				<h4>Nueva Carpeta</h4>
				<input type="text" class="form-control" name="directorio_raiz" id="fname" onblur="upperCase()" placeholder="NUEVA CARPETA">
			</div>

			<div class="col-md-6">
				<h5>Sub-Carpeta</h5>
				<input type="text" class="form-control" name="sub_directorio" value="<?php echo $manual['sub_directorio']; ?>" placeholder="Sub-Carpeta">
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for="nombre">Nombre</label>
					<input type="text" class="form-control" name="nombre" value="<?php echo $manual['nombre']; ?>">

					<label for="descripcion">Descripción</label>
					<textarea class="form-control" name="descripcion"><?php echo $manual['descripcion']; ?></textarea>

					<div class="col-md-6">
						<p><b>Manual Actual</b></p>
						<a href="<?php echo $manual['archivo']; ?>" target="_blank"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Descargar</a>
					</div>
					<div class="col-md-6">
						<label for="nombre">Modificar Manual</label>
						<input type="file" class="form-control" name="nuevo_archivo">
					</div>

					<label for="nombre">Fecha de Registro</label>
					<input type="text" class="form-control" name="fecha_registro" value="<?php echo date('d/m/Y', $manual['fecha_registro']); ?>" readonly>
					<hr>
					<input type="submit" class="btn btn-success form-control" value="Actualizar Manual">
					<input type="hidden" name="actualizar_manual" value="1">
					<input type="hidden" name="idmanual" value="<?php echo $manual['idmanual']; ?>">
					<input type="hidden" name="archivo" value="<?php echo $manual['archivo']; ?>">	
				</div>
			</div>
		</form>
	</div>
</div>


 <script type="text/javascript">
function upperCase() {
   var x=document.getElementById("fname").value
   document.getElementById("fname").value=x.toUpperCase()
}
</script>