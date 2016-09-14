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
	$idservicio = $_GET['idservicio'];
	$fecha = time();
	$identificador = "SERVICIO";
	$accion = 2;

	if(isset($_POST['actualizar_servicio']) && $_POST['actualizar_servicio'] == 1){
		$updateSQL = sprintf("UPDATE servicio SET nombre = %s, descripcion = %s, costo = %s WHERE idservicio = %s",
			GetSQLValueString($_POST['nombre'], "int"),
			GetSQLValueString($$_POST['descripcion'], "int"),
			GetSQLValueString($_POST['costo'], "int"),
			GetSQLValueString($idservicio, "int"));
		$actualizar = mysql_query($updateSQL,$eg_system) or die(mysql_error());

		$insertSQL = sprintf("INSERT INTO bitacora(idusuario, identificador, accion, idservicio, fecha_registro) VALUES(%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idservicio, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());

		$mensaje = "Servicio Actualizado Correctamente";

	}

	$row_servicio = mysql_query("SELECT * FROM servicios WHERE idservicio = $idservicio", $eg_system) or die(mysql_error());
	$servicio = mysql_fetch_assoc($row_servicio);


?>
<h3>Detalle Servicio</h3>

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
		<form action="" method="POST" enctype="multipart/form-data">
			<label for="nombre">Nombre</label>
			<input type="text" class="form-control" name="nombre" value="<?php echo $servicio['nombre']; ?>">
			
			<label for="descripcion">Descripción</label>
			<textarea name="descripcion" class="form-control"><?php echo $servicio['descripcion']; ?></textarea>
			
			<label for="costo">Costo</label>
			<input type="text" class="form-control" name="costo" value="<?php echo $servicio['costo']; ?>">
			
			<label for="fecha_registro">Fecha Registro</label>
			<input type="text" class="form-control" name="fecha_registro" value="<?php echo $servicio['fecha_registro']; ?>" readonly>

			<hr>
			<input type="submit" class="btn btn-warning form-control" value="Actualizar Servicio">
			<input type="hidden" name="actualizar_servicio" value="1">
		</form>
		
	</div>
</div>