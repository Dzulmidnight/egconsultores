<?php 
	if($_SESSION["autentificado"] == false){
		header("Location: ../../login.php");
	}
	mysql_select_db($database_eg_system, $eg_system);

	if(isset($_GET['listado'])){
		$clase1 = "btn btn-primary";
	}else{
		$clase1 = "btn btn-default";
	}
	if(isset($_GET['add_servicio'])){
		$clase2 = "btn btn-primary";
	}else{
		$clase2 = "btn btn-default";
	}


 ?>
<div class="row">
	<div class="col-lg-12">
		<a class="<?php echo $clase1; ?>" href="?menu=servicios&listado">Listado Servicios</a>
		<?php 
		if($row_usuario['crear']){
		?>
			<a class="<?php echo $clase2; ?>" href="?menu=servicios&add_servicio">Agregar Servicio</a>
		<?php
		}
		?>
	
		<?php 
		if(isset($_GET['idservicio'])){
		?>
		<a class="btn btn-primary" href="?menu=servicios&idservicio=<?php echo $_GET['idservicio']; ?>">Detalle Servicio</a>
		<?php
		}
		 ?>
	</div>

	<div class="col-md-12">
		<?php 
		if(isset($_GET['add_servicio'])){
			include("add_servicio.php");
		}else if(isset($_GET['idservicio']) && $_GET['idservicio'] != 0){
			include("detalle_servicio.php");
		}else{
			include("listado_servicios.php");
		}
		 ?>
	</div>

</div>