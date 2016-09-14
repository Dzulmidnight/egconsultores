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
	if(isset($_GET['add_cotizacion'])){
		$clase2 = "btn btn-primary";
	}else{
		$clase2 = "btn btn-default";
	}


 ?>
<div class="row">
	<div class="col-lg-12">
		<a class="<?php echo $clase1; ?>" href="?menu=cotizaciones&listado">Listado Cotizaciones</a>
		<?php 
		if($row_usuario['crear']){
		?>
			<a class="<?php echo $clase2; ?>" href="?menu=cotizaciones&add_cotizacion">Agregar Cotización</a>
		<?php
		}
		?>
	
		<?php 
		if(isset($_GET['idcotizacion'])){
		?>
		<a class="btn btn-primary" href="?menu=cotizaciones&idcotizacion=<?php echo $_GET['idcotizacion']; ?>">Detalle Manual</a>
		<?php
		}
		 ?>
	</div>

	<div class="col-md-12">
		<?php 
		if(isset($_GET['add_cotizacion'])){
			include("add_cotizacion.php");
		}else if(isset($_GET['idcotizacion']) && $_GET['idcotizacion'] != 0){
			include("detalle_cotizacion.php");
		}else{
			include("listado_cotizaciones.php");
		}
		 ?>
	</div>

</div>