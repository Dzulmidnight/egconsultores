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
		$accion = 1; //AGREGAR

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


		$insertSQL = sprintf("INSERT INTO manuales (nombre, descripcion, archivo, idusuario, directorio_raiz, sub_directorio, fecha_registro) VALUES (%s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($_POST['nombre'], "text"),
			GetSQLValueString($_POST['descripcion'], "text"),
			GetSQLValueString($ruta_img, "text"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($directorio_raiz, "text"),
			GetSQLValueString($sub_directorio, "text"),
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

	$row_carpetas = mysql_query("SELECT directorio_raiz FROM manuales WHERE directorio_raiz IS NOT NULL GROUP BY directorio_raiz", $eg_system) or die(mysql_error());

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
	<form action="" method="POST" enctype="multipart/form-data">
	 	<div class="col-md-4">
	 			<div class="col-md-12 alert alert-warning">
					<div class="row">
						<div class="col-md-6">
						    <label for="directorio_raiz">Carpetas Existentes</label>
						    <select name="directorio_raiz" id="" class="form-control">
						    	<option value="">Seleccione una carpeta</option>
						    	<?php 
						    	while($carpetas = mysql_fetch_assoc($row_carpetas)){
						    		echo "<option value='$carpetas[directorio_raiz]'>$carpetas[directorio_raiz]</option>";
						    	}
						    	 ?>
						    </select>
						</div>
						<div class="col-md-6">
							<label for="nuevo_directorio">Nueva Carpeta</label>
							<input type="text" class="form-control" name="nuevo_directorio" id="fname" onblur="upperCase()" placeholder="NUEVA CARPETA">
						    
						</div>
						<div class="col-md-6">
						 	<label for="sub_directorio">Sub-Carpeta</label>
						    <input type="text" class="form-control" name="sub_directorio" placeholder="Sub-carpeta">
						</div>					
					</div>
				</div>
	 	</div>
	 	<div class="col-lg-8">
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
	 	</div>
	</form>
 </div>

 <script type="text/javascript">
function upperCase() {
   var x=document.getElementById("fname").value
   document.getElementById("fname").value=x.toUpperCase()
}
</script>