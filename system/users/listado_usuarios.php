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


	if(isset($_POST['eliminar_usuario']) && $_POST['eliminar_usuario'] == 1){
		$idusuario_eliminar = $_POST['idusuario'];
		$query = "DELETE FROM usuario WHERE idusuario = $idusuario_eliminar";
		$eliminar = mysql_query($query,$eg_system) or die(mysql_error());
		$mensaje = "Usuario Eliminado Correctamente";
	}

	if(isset($_POST['agregar_usuario2']) && $_POST['agregar_usuario2'] == 1){
		$clase_agregar = $_POST['clase'];
		$username_agregar = $_POST['username'];
		$password_agregar = $_POST['password'];
		$nombre_agregar = $_POST['nombre'];
		$email_agregar = $_POST['email'];
		if (isset($_POST['leer'])) {
			$leer = $_POST['leer'];
		} else {
			$leer = 0;
		}
		if (isset($_POST['crear'])) {
			$crear = $_POST['crear'];
		} else {
			$crear = 0;
		}
		if (isset($_POST['editar'])) {
			$editar = $_POST['editar'];
		} else {
			$editar = 0;
		}
		if (isset($_POST['eliminar'])) {
			$eliminar = $_POST['eliminar'];
		} else {
			$eliminar = 0;
		}

		$query = sprintf("INSERT INTO usuario (clase, username, password, nombre, email, leer, crear, editar, eliminar) VALUES (%s, %s, %s, %s, %s, %s, s, %s, %s)",
			GetSQLValueString($clase_agregar, "text"),
			GetSQLValueString($username_agregar, "text"),
			GetSQLValueString($password_agregar, "text"),
			GetSQLValueString($nombre_agregar, "text"),
			GetSQLValueString($email_agregar, "text"),
			GetSQLValueString($leer, "int"),
			GetSQLValueString($crear, "int"),
			GetSQLValueString($editar, "int"),
			GetSQLValueString($eliminar, "int"));

		$query = "INSERT INTO usuario(clase, username, password, nombre, email, leer, crear, editar, eliminar) VALUES('$clase_agregar', '$username_agregar', '$password_agregar', '$nombre_agregar', '$email_agregar', $leer, $crear, $editar, $eliminar)";
		$insertar = mysql_query($query,$eg_system) or die(mysql_error());
		$mensaje = "Usuario Agregado Correctamente";

	}



	if(isset($_POST['actualizar_usuario2']) && $_POST['actualizar_usuario2'] == 1){
		$clase_actualizar = $_POST['clase'];
		$username_actualizar = $_POST['username'];
		$password_actualizar = $_POST['password'];
		$nombre_actualizar = $_POST['nombre'];
		$email_actualizar = $_POST['email'];
		if (isset($_POST['leer'])) {
			$leer = $_POST['leer'];
		} else {
			$leer = 0;
		}
		if (isset($_POST['crear'])) {
			$crear = $_POST['crear'];
		} else {
			$crear = 0;
		}
		if (isset($_POST['editar'])) {
			$editar = $_POST['editar'];
		} else {
			$editar = 0;
		}
		if (isset($_POST['eliminar'])) {
			$eliminar = $_POST['eliminar'];
		} else {
			$eliminar = 0;
		}

		$idusuario = $_POST['idusuario2'];

		$query = sprintf("UPDATE usuario SET clase = %s, username = %s, password = %s, nombre = %s, email = %s, leer = %s, crear = %s, editar = %s, eliminar = %s WHERE idusuario = %s",
			GetSQLValueString($clase_actualizar, "text"),
			GetSQLValueString($username_actualizar, "text"),
			GetSQLValueString($password_actualizar, "text"),
			GetSQLValueString($nombre_actualizar, "text"),
			GetSQLValueString($email_actualizar, "text"),
			GetSQLValueString($leer, "int"),
			GetSQLValueString($crear, "int"),
			GetSQLValueString($editar, "int"),
			GetSQLValueString($eliminar, "int"),
			GetSQLValueString($idusuario, "int"));


		//$query = "UPDATE usuario SET clase = '$clase_actualizar', username = '$username_actualizar', password = '$password_actualizar', nombre = '$nombre_actualizar', email = '$email_actualizar', leer = $leer, crear = $crear, editar = $editar, eliminar = $eliminar WHERE idusuario = $idusuario_actualizar";
		$actualizar = mysql_query($query,$eg_system) or die(mysql_error());
		$mensaje = "Datos Actualizados Correctamente";

	}

	$query = "SELECT * FROM usuario";
	$row_usuario = mysql_query($query,$eg_system) or die(mysql_error());
	$total = mysql_num_rows($row_usuario);
		$row_usuario2 = mysql_query($query,$eg_system) or die(mysql_error());

 ?>
<h3>Listado de Usuarios | Total: <span style="color:#c0392b"><?php echo $total; ?></span></h3> <?php if(isset($_GET['detalle'])){echo "<a class='btn btn-sm btn-success' href='?menu=usuarios'>Nuevo Usuario</a>"; }; ?>

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
	<div class="col-md-7">
		<table class="table table-bordered table-condensed" style="font-size:11px;">
			<thead>
				<tr class="alert alert-info">
					<!--<th>ID</th>-->
					<th>Clase</th>
					<th>Permisos</th>
					<th>Username</th>
					<th>Password</th>
					<th>Nombre</th>
					<th>Email</th>
				</tr>
			</thead>

			<form action="" method="POST">
				<tbody>
					<?php 
					while($usuario = mysql_fetch_assoc($row_usuario2)){
					?>
					<tr>
						<!--<td><?php echo $usuario['idusuario']; ?></td>-->
						<td><?php echo $usuario['clase']; ?></td>
						<td>
							<?php 
							if($usuario['leer']){
								echo "<span class='btn btn-xs btn-default glyphicon glyphicon-eye-open' data-toggle='tooltip' title='Leer'></span>";
							}
							if($usuario['crear']){
								echo "<span class='btn btn-xs btn-default glyphicon glyphicon-plus' data-toggle='tooltip' title='Agregar'></span>";
							}
							if($usuario['editar']){
								echo "<span class='btn btn-xs btn-default glyphicon glyphicon-pencil' data-toggle='tooltip' title='Editar'></span>";
							}
							if($usuario['eliminar']){
								echo "<span class='btn btn-xs btn-default glyphicon glyphicon-trash' data-toggle='tooltip' title='Eliminar'></span>";
							}
							 ?>
						</td>
						<td><?php echo $usuario['username']; ?></td>	
						<td><?php echo $usuario['password']; ?></td>	
						<td><?php echo $usuario['nombre']; ?></td>	
						<td><?php echo $usuario['email']; ?></td>	


						<td style="border:hidden;border-left:1px;">
							<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=usuarios&detalle=<?php echo $usuario['idusuario']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
							<?php 
							if($row_usuario['clase'] == 'adm'){
							?>
								<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
							<?php
							}
							 ?>
							<input type="hidden" name="idusuario" value="<?php echo $usuario['idusuario']; ?>" >
							<input type="hidden" name="eliminar_usuario" value="1">
						</td>

					</tr>
					<?php
					}
					 ?>
				</tbody>
			</form>
		</table>
	</div>
	<?php 
	if(isset($_GET['detalle'])){
	$query_detalle = "SELECT * FROM usuario WHERE idusuario = $_GET[detalle]";
	$consultar = mysql_query($query_detalle,$eg_system) or die(mysql_error());
	$detalle_usuario = mysql_fetch_assoc($consultar);
	?>
		<!---- INICIA DETALLE USUARIO ---->
		<div class="col-md-5 alert alert-success" style="font-size:12px;">
			<h4>Detalle Usuario</h4>
			<form action="" method="POST">
				<label for="clase">Clase</label>
				<select class="form-control" name="clase" id="clase" required>
					<option value="">...</option>
					<option value="adm" <?php if($detalle_usuario['clase'] == 'adm'){ echo 'selected'; } ?>>ADMINISTRADOR</option>
					<option value="user" <?php if($detalle_usuario['clase'] == 'user'){ echo 'selected'; } ?>>USUARIO</option>
				</select>

				<div class="checkbox">
					<p><b>Permisos de Usuario</b></p>
					<label style="margin-right:2em;">
						<input type="checkbox" name="leer" value="1" <?php if($detalle_usuario['leer']){ echo "checked"; } ?>> LEER
					</label>
					<label style="margin-right:2em;">
						<input type="checkbox" name="crear" value="1" <?php if($detalle_usuario['crear']){ echo "checked"; } ?>> AGREGAR
					</label>
					<label style="margin-right:2em;">
						<input type="checkbox" name="editar" value="1" <?php if($detalle_usuario['editar']){ echo "checked"; } ?>> EDITAR
					</label>
					<label style="margin-right:2em;">
						<input type="checkbox" name="eliminar" value="1" <?php if($detalle_usuario['eliminar']){ echo "checked"; } ?>> ELIMINAR
					</label>
				</div>

				<div class="form-group has-success has-feedback">
					<label for="username">* Username</label>
					<input type="text" class="form-control" id="username" name="username" value="<?php echo $detalle_usuario['username']; ?>" required>
					<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-success has-feedback">
					<label for="password">* Password</label>
					<input type="text" class="form-control" id="password" name="password" value="<?php echo $detalle_usuario['password']; ?>" required>
					<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-success has-feedback">
					<label for="nombre">* Nombre</label>
					<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $detalle_usuario['nombre']; ?>" required>
					<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-success has-feedback">
					<label for="email">* Email</label>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo $detalle_usuario['email']; ?>" required>
					<span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
				</div>
				<input type="hidden" class="form-control" name="actualizar_usuario2" value="1">
				<input type="hidden" name="idusuario2" value="<?php echo $detalle_usuario['idusuario']; ?>">
				<input type="submit" class="btn btn-sm btn-success" value="Actualizar Datos">
			</form>
		</div>


	<?php
	}else{
	?>
		<!---- INICIA AGREGAR USUARIO ---->
		<div class="col-md-5" style="font-size:12px;">
			<h4>Agregar Usuario</h4>
			<form action="" method="POST">
				<label for="clase">Clase</label>
				<select class="form-control" name="clase" id="clase" required>
					<option value="">...</option>
					<option value="adm">ADMINISTRADOR</option>
					<option value="user">USUARIO</option>
				</select>
					
				<div class="checkbox">
					<p><b>Permisos de Usuario</b></p>
					<label style="margin-right:2em;">
						<input type="checkbox" name="leer" value="1"> LEER
					</label>
					<label style="margin-right:2em;">
						<input type="checkbox" name="crear" value="1"> AGREGAR
					</label>
					<label style="margin-right:2em;">
						<input type="checkbox" name="editar" value="1"> EDITAR
					</label>
					<label style="margin-right:2em;">
						<input type="checkbox" name="eliminar" value="1"> ELIMINAR
					</label>
				</div>


				<div class="form-group has-success has-feedback">
					<label for="username">* Username</label>
					<input type="text" class="form-control" id="username" name="username" required>
					<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-success has-feedback">
					<label for="password">* Password</label>
					<input type="text" class="form-control" id="password" name="password" required>
					<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-success has-feedback">
					<label for="nombre">* Nombre</label>
					<input type="text" class="form-control" id="nombre" name="nombre" required>
					<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-success has-feedback">
					<label for="email">* Email</label>
					<input type="email" class="form-control" id="email" name="email" required>
					<span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
				</div>
				<input type="hidden" class="form-control" name="agregar_usuario2" value="1">
				<input type="submit" class="btn btn-success" value="Agregar">
			</form>
		</div>

	<?php
	}
	?>
</div>