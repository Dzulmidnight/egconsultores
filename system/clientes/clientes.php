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
	if(isset($_GET['add_cliente'])){
		$clase2 = "btn btn-primary";
	}else{
		$clase2 = "btn btn-default";
	}


 ?>
<div class="row">
	<div class="col-lg-12">
		<a class="<?php echo $clase1; ?>" href="?menu=clientes&listado">Listado Clientes</a>
		<a class="<?php echo $clase2; ?>" href="?menu=clientes&add_cliente">Agregar Cliente</a>
		<?php 
		if(isset($_GET['idcliente'])){
		?>
		<a class="btn btn-primary" href="?menu=clientes&idcliente=<?php echo $_GET['idcliente']; ?>">Detalle Cliente</a>
		<?php
		}
		 ?>
	</div>

	<div class="col-md-12">
		<?php 
		if(isset($_GET['add_cliente'])){
			include("add_cliente.php");
		}else if(isset($_GET['add_segmento'])){
			include("add_segmento.php");
		}else if(isset($_GET['idcliente']) && $_GET['idcliente'] != 0){
			include("detalle_cliente.php");
		}else{
			include("listado_clientes.php");
		}
		 ?>
	</div>

</div>