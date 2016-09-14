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
	if(isset($_GET['add_manual'])){
		$clase2 = "btn btn-primary";
	}else{
		$clase2 = "btn btn-default";
	}


 ?>
<div class="row">
	<div class="col-lg-12">
		<a class="<?php echo $clase1; ?>" href="?menu=manuales&listado">Listado Manuales</a>
		<?php 
		if($row_usuario['crear']){
		?>
			<a class="<?php echo $clase2; ?>" href="?menu=manuales&add_manual">Agregar Manual</a>
		<?php
		}
		?>
	
		<?php 
		if(isset($_GET['idmanual'])){
		?>
		<a class="btn btn-primary" href="?menu=manuales&idmanual=<?php echo $_GET['idmanual']; ?>">Detalle Manual</a>
		<?php
		}
		 ?>
	</div>

	<div class="col-md-12">
		<?php 
		if(isset($_GET['add_manual'])){
			include("add_manual.php");
		}else if(isset($_GET['idmanual']) && $_GET['idmanual'] != 0){
			include("detalle_manual.php");
		}else{
			include("listado_manuales.php");
		}
		 ?>
	</div>

</div>