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
	/*
	ACCIONES
	1 = AGREGAR
	2 = MODIFICAR
	3 = ELIMINAR
	*/

	$row_bitacora = mysql_query("SELECT bitacora.*, acciones.nombre AS 'nombre_accion', usuario.username, cliente.empresa, manuales.nombre AS 'nombre_manual' FROM bitacora INNER JOIN acciones ON bitacora.accion = acciones.idaccion INNER JOIN usuario ON bitacora.idusuario = usuario.idusuario LEFT JOIN cliente ON bitacora.idcliente = cliente.idcliente LEFT JOIN manuales ON bitacora.idmanual = manuales.idmanual ORDER BY bitacora.fecha_registro ", $eg_system) or die(mysql_error());

	$row_accion = mysql_query("SELECT * FROM acciones", $eg_system) or die(mysql_error());
	$row_identificador = mysql_query("SELECT identificador FROM bitacora GROUP BY identificador", $eg_system) or die(mysql_error());
	$row_usuario = mysql_query("SELECT idusuario, username FROM usuario", $eg_system) or die(mysql_error());

?>


<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-3">
				<h3>Bitacora | Buscar por: </h3>		
			</div>
			<!--<div class="col-md-2">
				<div class="input-group">
			      <input type="text" class="form-control" placeholder="Search for...">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="button">Buscar!</button>
			      </span>
			    </div>
			</div>-->
			<div class="col-md-2">
				<select name="buscar_accion" id="" class="form-control">
					<option value="">Buscar por Acción</option>
					<?php 
					while($acciones = mysql_fetch_assoc($row_accion)){
						echo "<option value='$acciones[idaccion]'>$acciones[nombre]</option>";
					}
					 ?>

				</select>
			</div>
			<div class="col-md-2">
				<select name="buscar_accion" id="" class="form-control">
					<option value="">Buscar por Identificador</option>
					<?php 
					while($identificador = mysql_fetch_assoc($row_identificador)){
						echo "<option value='$identificador[identificador]'>$identificador[identificador]</option>";
					}
					 ?>

				</select>
			</div>
			<div class="col-md-2">
				<select name="buscar_accion" id="" class="form-control">
					<option value="">Buscar por Usuario</option>
					<?php 
					while($usuario = mysql_fetch_assoc($row_usuario)){
						echo "<option value='$usuario[idusuario]'>$usuario[username]</option>";
					}
					 ?>

				</select>
			</div>

			<div class="col-md-3">
				<div class="input-group">
					<p>Intervalo de Fecha</p>
			      <input type="date" class="" name="fecha_inicio"> - <input type="date" class="" name="fecha_fin">
			    </div><!-- /input-group -->
			</div>



		</div>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered table-hover" style="font-size:12px;">
			<thead>
				<tr>
					<th>Nº</th>
					<th>Fecha Registro</th>
					<th>Usuario</th>
					<th>Identificador</th>
					<th>Acción</th>
					<th>Involucrado</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$contador = 1;
			while($bitacora = mysql_fetch_assoc($row_bitacora)){
				switch ($bitacora['accion']) {
					case '1':
						$color_accion = "alert alert-success";
						break;
					case '2':
						$color_accion = "alert alert-warning";
						break;
					case '3':
						$color_accion = "alert alert-danger";
						break;
					default:
						# code...
						break;
				}
			?>
				<tr>
					<td><?php echo $contador; ?></td>
					<td><?php echo date('d/m/Y', $bitacora['fecha_registro']); ?></td>
					<td><?php echo $bitacora['username']; ?></td>
					<td><?php echo $bitacora['identificador']; ?></td>
					<td><?php echo "<span class='$color_accion' style='padding:7px;'>".$bitacora['nombre_accion']."</span>"; ?></td>
					<td>
						<?php 
						if(isset($bitacora['idmanual'])){
							if(empty($bitacora['nombre_manual'])){
								echo "<span style='color:red'>No Disponible</span>";
							}else{
								echo $bitacora['nombre_manual'];
							}
						}else if(isset($bitacora['idfactura'])){
							echo $bitacora['idfactura'];
						}else if(isset($bitacora['idcotizacion'])){
							echo $bitacora['idcotizacion'];
						}else if(isset($bitacora['idservicio'])){
							echo $bitacora['idservicio'];
						}else if(isset($bitacora['idformato_cliente'])){
							echo $bitacora['idformato_cliente'];
						}else if(isset($bitacora['idcliente'])){
							if(empty($bitacora['empresa'])){
								echo "<span style='color:red'>No Disponible</span>";
							}else{
								echo $bitacora['empresa'];
							}
						}
						 ?>
					</td>
				</tr>
			<?php
			$contador++;
			}
			 ?>
				
			</tbody>
		</table>
	</div>
</div>