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
	if(isset($_GET['add_factura'])){
		$clase2 = "btn btn-primary";
	}else{
		$clase2 = "btn btn-default";
	}


 ?>
<div class="row">
	<div class="col-lg-12">
		<a class="<?php echo $clase1; ?>" href="?menu=facturas&listado">Listado Facturas</a>
		<?php 
		if($row_usuario['crear']){
		?>
			<a class="<?php echo $clase2; ?>" href="?menu=facturas&add_factura">Agregar Factura</a>
		<?php
		}
		?>
	
		<?php 
		if(isset($_GET['idfactura'])){
		?>
		<a class="btn btn-primary" href="?menu=facturas&idfactura=<?php echo $_GET['idfactura']; ?>">Detalle Factura</a>
		<?php
		}
		 ?>
	</div>

	<div class="col-md-12">
		<?php 
		if(isset($_GET['add_factura'])){
			include("add_factura.php");
		}else if(isset($_GET['idfactura']) && $_GET['idfactura'] != 0){
			include("detalle_factura.php");
		}else{
			include("listado_facturas.php");
		}
		 ?>
	</div>

</div>