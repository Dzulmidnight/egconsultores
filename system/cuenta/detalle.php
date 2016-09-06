<?php
// *** Validate request to login to this site.
	if($_SESSION["autentificado"] == false){
		header("Location: ../../login.php");
	}
	mysql_select_db($database_eg_system, $eg_system);
	


	if(isset($_POST['actualizar_cuenta']) && $_POST['actualizar_cuenta'] == 1){
		$idusuario = $_SESSION['idusuario'];
		$clase = $_POST['clase'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$query = "UPDATE usuario SET clase = '$clase', username = '$username', password = '$password', nombre = '$nombre', email = '$email' WHERE idusuario = $idusuario";
		$actualizar = mysql_query($query,$eg_system) or die(mysql_error());
		$mensaje = "Datos Actualizados Correctamente";

	}

	$query = "SELECT * FROM usuario WHERE idusuario = ".$_SESSION['idusuario']."";
	$row_usuario = mysql_query($query,$eg_system) or die(mysql_error());
	$usuario = mysql_fetch_assoc($row_usuario);

?>
<h3>Mi Cuenta</h3>
<hr>

<div class="row">
	<div class="col-xs-12">
		<form action="" method="POST">
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
			<div class="form-group has-success has-feedback">
				<label for="clase">Clase</label>
				<?php 
				if($usuario['clase'] == 'adm'){
				?>
					<select class="form-control" name="clase" id="clase">
						<option value="">...</option>
						<option value="adm" <?php if($usuario['clase'] == 'adm'){ echo "selected"; } ?>>Adm</option>
						<option value="user" <?php if($usuario['clase'] == 'user'){ echo "selected"; } ?>>User</option>
					</select>
				<?php
				}else{
				?>
					<input type="text" class="form-control" id="clase" name="clase" value="<?php echo $usuario['clase']; ?>" <?php if($usuario['clase'] == 'user'){ echo 'readonly'; } ?>>
					<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				<?php
				}
				 ?>
			</div>
			<div class="form-group has-success has-feedback">

				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" value="<?php echo $usuario['username']; ?>">
				<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
			</div>
			<div class="form-group has-success has-feedback">
				<label for="password">Password</label>
				<input type="text" class="form-control" id="password" name="password" value="<?php echo $usuario['password']; ?>">
				<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
			</div>
			<div class="form-group has-success has-feedback">
				<label for="nombre">Nombre</label>
				<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">
				<span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
			</div>
			<div class="form-group has-success has-feedback">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>">
				<span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
				<input type="hidden" name="actualizar_cuenta" value="1">
			</div>
			<input type="submit" class="btn btn-success" value="Actualizar">
		</form>
	</div>
</div>

