<?php 
	if($_SESSION["autentificado"] == false){
		header("Location: ../../login.php");
	}
	mysql_select_db($database_eg_system, $eg_system);

	if(isset($_POST['eliminar_usuario']) && $_POST['eliminar_usuario'] == 1){
		$idcliente = $_POST['idcliente'];
		$query = "DELETE FROM cliente WHERE idcliente = $idcliente";
		$eliminar = mysql_query($query,$eg_system) or die(mysql_error());
		$mensaje = "Usuario Eliminado Correctamente";
	}


	$query = "SELECT * FROM cliente ORDER BY  empresa, rfc ASC";
	$row_cliente = mysql_query($query,$eg_system) or die(mysql_error());


	$total = mysql_num_rows($row_cliente);
	

 ?>
<h3>Listado de Clientes | Total: <span style="color:#c0392b"><?php echo $total; ?></span></h3>
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
	<div class="col-lg-12">
		<table class="table table-bordered table-condensed" style="font-size:12px;">
			<thead>
				<tr class="alert alert-info">
					<th>ID</th>
					<th>Empresa</th>
					<th>RFC</th>
					<th class="hidden-xs">Cont Emp1</th>
					<th class="hidden-xs">Teléfono</th>
					<th class="hidden-xs">Dirección</th>
					<th class="hidden-xs">Numero</th>
					<th class="hidden-xs">Colonia</th>
					<th>Ciudad</th>
				</tr>
			</thead>

			<form action="" method="POST">
				<tbody>
					<?php 
					while($cliente = mysql_fetch_assoc($row_cliente)){
					?>
					<tr>
						<td><?php echo $cliente['idcliente']; ?></td>	
						<td><?php echo $cliente['empresa']; ?></td>	
						<td><?php echo $cliente['rfc']; ?></td>	
						<td class="hidden-xs"><?php echo $cliente['cont_emp1']; ?></td>	
						<td class="hidden-xs"><?php echo $cliente['telefono']; ?></td>	
						<td class="hidden-xs"><?php echo $cliente['direccion']; ?></td>	
						<td class="hidden-xs"><?php echo $cliente['numero']; ?></td>
						<td class="hidden-xs"><?php echo $cliente['colonia']; ?></td>	
						<td class=""><?php echo $cliente['ciudad']; ?></td>

						<td style="border:hidden;border-left:1px;">
							<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=clientes&idcliente=<?php echo $cliente['idcliente']; ?>"><span aria-hidden="true" class="glyphicon glyphicon-search"></span></a>
						</td>
						<?php 
						if($sesion_clase == 'adm'){
						?>
						<td style="border:hidden;border-left:1px;">
							<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Está seguro ?, los datos se eliminaran permanentemente');"><span aria-hidden="true" class="glyphicon glyphicon-trash"></span></button>
							<input type="hidden" name="idcliente" value="<?php echo $cliente['idcliente']; ?>" >
							<input type="hidden" name="eliminar_usuario" value="1">
						</td>
						<?php
						}
						 ?>
					</tr>
					<?php
					}
					 ?>
				</tbody>
			</form>
		</table>
	</div>
</div>