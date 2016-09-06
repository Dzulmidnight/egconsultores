<?php 
if(isset($_POST['agregar_formato']) && $_POST['agregar_formato'] == 1){
	$fecha_formato = $_POST['fecha'];
	$asunto_formato = $_POST['asunto_formato'];
	$descripcion_formato = $_POST['descripcion_formato'];
	$costo_formato = $_POST['costo_formato'];
	$atentamente = $_POST['atentamente'];

	$query_insert = "INSERT INTO formato_cliente (idcliente, idusuario, fecha, asunto_formato, descripcion_formato, costo_formato, atentamente) VALUES(".$cliente['idcliente'].", $sesion_idusuario, '$fecha_formato', '$asunto_formato', '$descripcion_formato', '$costo_formato', '$atentamente')";
	$insertar = mysql_query($query_insert,$eg_system) or die(mysql_error());
	$mensaje = "Formato Guardado Correctamente";

}
if(isset($_POST['actualizar_formato']) && $_POST['actualizar_formato'] == 1){
	$idformato_cliente = $_POST['idformato_cliente'];
	$fecha_formato = $_POST['fecha'];
	$asunto_formato = $_POST['asunto_formato'];
	$descripcion_formato = $_POST['descripcion_formato'];
	$costo_formato = $_POST['costo_formato'];
	$atentamente = $_POST['atentamente'];

	$query_update = "UPDATE formato_cliente SET idusuario = $sesion_idusuario, fecha = '$fecha_formato', asunto_formato = '$asunto_formato', descripcion_formato = '$descripcion_formato', costo_formato = '$costo_formato', atentamente = '$atentamente' WHERE idformato_cliente = $idformato_cliente";
	$actualizar = mysql_query($query_update,$eg_system) or die(mysql_error());

	$mensaje = "Formato Actualizado Correctamente";
}

 ?>


<div class="col-lg-10 col-md-12" style="padding:0px;">
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

	<?php 
	if(isset($_GET['formato']) && $_GET['formato'] != 0){
		$idformato_cliente = $_GET['formato'];
		$query_formato = "SELECT * FROM formato_cliente WHERE idformato_cliente = $idformato_cliente";
		$ejecutar = mysql_query($query_formato,$eg_system) or die(mysql_error());
		$row_formato = mysql_fetch_assoc($ejecutar);
	?>
		<form action="reportes/reporte.php" method="POST" target="_new">
			<div class="col-sm-12">
				<p class="alert alert-info" style="padding:7px;"><button class="btn btn-default" target="_new" type="submit" ><img src="../imagenes/pdf.png" alt=""></button> <strong>Cotización Simulacro de Evacuación</strong></p>
			</div>
			<input type="hidden" name="idformato_cliente" value="<?php echo $idformato_cliente; ?>">
			<input type="hidden" name="generar_formato" value="1">

		</form>

		<form action="" method="POST">
	
			<div class="col-sm-6 col-sm-offset-6">
				<label for="fecha">Fecha</label>
				<input class="form-control" type="text" id="fecha" name="fecha" value="<?php echo $row_formato['fecha']; ?>" required>
			</div>
			<div class="col-sm-12">
				<p><b><?php echo $cliente['empresa']; ?></b></p>
				<p><?php echo $cliente['direccion']." No. ".$cliente['numero'].", Col. ".$cliente['colonia']; ?></p>
				<p><?php echo $cliente['ciudad'].", Del. ".$cliente['delegacion'].", C.P. ".$cliente['cp']; ?></p>
				<p><?php echo "Attn.: ".$cliente['cont_emp1']; ?></p>
				<p>Estimado/a Licenciado/a</p>
				<p>
					Por medio de la presente, le entregamos  a su atenta consideración los resultados por la realización:
					<input type="text" class="form-control" name="asunto_formato" value="<?php echo $row_formato['asunto_formato']; ?>" required>
					que comprendió la revisión de los puntos:
				</p>
				<ul>
					<li>
						<b>4.6 Brigada contra incendio:</b> El grupo de trabajadores organizados en una Unidad interna de protección civil, capacitados y adiestrados en operaciones básicas de prevención y protección contra incendio y atención de emergencias de incendio, tales como identificación de los riesgos de la situación de emergencia por incendio; manejo de equipos o sistemas contra incendio, al igual que en acciones de evacuación, comunicación y primeros auxilios, entre otras. 
					</li>
					<li>
						<b>4.18 Lugar seguro:</b> Es la zona o área seleccionada e identificada dentro o fuera del centro de trabajo, que los trabajadores y demás ocupantes del mismo deberán utilizar como zona de protección, en caso de alarma y evacuación por incendio, de acuerdo con lo establecido en el plan de atención a emergencias.
					</li>
					<li>
						<b>4.31 Ruta de evacuación:</b> Es el recorrido horizontal o vertical, o la combinación de ambos, continuo y sin obstrucciones, que va desde cualquier punto del centro de trabajo hasta un lugar seguro en el exterior, denominado punto de reunión, que incluye locales intermedios como salas, vestíbulos, balcones, patios y otros recintos; así como sus componentes, tales como puertas, escaleras, rampas y pasillos. Consta de las partes siguientes:
					</li>
				</ul>
				<ol>
					<li type="a">
						<b>Acceso a la ruta de salida:</b> Es la parte del recorrido que conduce desde cualquier lugar del centro de trabajo hasta la ruta de salida; 
					</li>
					<li type="a">
						<b>Ruta de salida:</b> Es la parte del recorrido que proviene del acceso a la ruta de salida, separada de otras áreas mediante elementos que proveen un trayecto protegido hacia la descarga de salida, y 
					</li>
					<li type="a">
						<b>Descarga de salida:</b> Es la parte final de la ruta de evacuación que lleva a una zona de seguridad en el exterior, denominada punto de reunión.
					</li>
				</ol>
				<p>
					Siguiendo la <b>Guía de Referencia II para Brigadas de Emergencia y Consideraciones Generales sobre la Planeación de los Simulacros de Incendio</b>, contenido lo anterior en la <b>NORMA Oficial Mexicana NOM-002-STPS-2010, Condiciones de seguridad-Prevención y protección contra incendios en los centros de trabajo.</b>
				</p>
				<p>
					<b>El costo de los trabajos descritos anteriormente es el siguiente :</b>
				</p>
				<hr>
				<p><b>Partida única</b></p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>DESCRIPCIÓN</th>
							<th>COSTO $ M.N</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<textarea name="descripcion_formato" class="textarea form-control"><?php echo $row_formato['descripcion_formato']; ?></textarea>
							</td>
							<td>
								<input type="text" name="costo_formato" class="form-control" value="<?php echo $row_formato['costo_formato']; ?>" required>	
							</td>
						</tr>
					</tbody>
				</table>
				<p>Sin más por el momento y agradeciendo la atención a la presente, me despido </p>
				<p class="text-center">ATENTAMENTE</p>
				<input type="text" name="atentamente" class="form-control" value="<?php echo $row_formato['atentamente']; ?>" required>

			</div>

			<div class="col-sm-12">
			<hr>
				<input type="hidden" name="idformato_cliente" value="<?php echo $idformato_cliente; ?>">
				<input type="hidden" name="actualizar_formato" value="1">
				<input type="submit" class="btn btn-success" value="Actualizar Formato">
			</div>
		</form>

	<?php
	}else{
	?>
		<form action="" method="POST">
			<div class="col-sm-12">
				<p class="alert alert-info" style="padding:7px;"><strong>Cotización Simulacro de Evacuación</strong></p>
			</div>
			<div class="col-sm-6 col-sm-offset-6">
				<label for="fecha">Fecha</label>
				<input class="form-control" type="text" id="fecha" name="fecha" placeholder="" required>
			</div>
			<div class="col-sm-12">
				<p><b><?php echo $cliente['empresa']; ?></b></p>
				<p><?php echo $cliente['direccion']." No. ".$cliente['numero'].", Col. ".$cliente['colonia']; ?></p>
				<p><?php echo $cliente['ciudad'].", Del. ".$cliente['delegacion'].", C.P. ".$cliente['cp']; ?></p>
				<p><?php echo "Attn.: ".$cliente['cont_emp1']; ?></p>
				<p>Estimado/a Licenciado/a</p>
				<p>
					Por medio de la presente, le entregamos  a su atenta consideración los resultados por la realización:
					<input type="text" class="form-control" name="asunto_formato" value="del simulacro de evacuación de centros de la clínica en situación de riesgo" required>
					que comprendió la revisión de los puntos:
				</p>
				<ul>
					<li>
						<b>4.6 Brigada contra incendio:</b> El grupo de trabajadores organizados en una Unidad interna de protección civil, capacitados y adiestrados en operaciones básicas de prevención y protección contra incendio y atención de emergencias de incendio, tales como identificación de los riesgos de la situación de emergencia por incendio; manejo de equipos o sistemas contra incendio, al igual que en acciones de evacuación, comunicación y primeros auxilios, entre otras. 
					</li>
					<li>
						<b>4.18 Lugar seguro:</b> Es la zona o área seleccionada e identificada dentro o fuera del centro de trabajo, que los trabajadores y demás ocupantes del mismo deberán utilizar como zona de protección, en caso de alarma y evacuación por incendio, de acuerdo con lo establecido en el plan de atención a emergencias.
					</li>
					<li>
						<b>4.31 Ruta de evacuación:</b> Es el recorrido horizontal o vertical, o la combinación de ambos, continuo y sin obstrucciones, que va desde cualquier punto del centro de trabajo hasta un lugar seguro en el exterior, denominado punto de reunión, que incluye locales intermedios como salas, vestíbulos, balcones, patios y otros recintos; así como sus componentes, tales como puertas, escaleras, rampas y pasillos. Consta de las partes siguientes:
					</li>
				</ul>
				<ol>
					<li type="a">
						<b>Acceso a la ruta de salida:</b> Es la parte del recorrido que conduce desde cualquier lugar del centro de trabajo hasta la ruta de salida; 
					</li>
					<li type="a">
						<b>Ruta de salida:</b> Es la parte del recorrido que proviene del acceso a la ruta de salida, separada de otras áreas mediante elementos que proveen un trayecto protegido hacia la descarga de salida, y 
					</li>
					<li type="a">
						<b>Descarga de salida:</b> Es la parte final de la ruta de evacuación que lleva a una zona de seguridad en el exterior, denominada punto de reunión.
					</li>
				</ol>
				<p>
					Siguiendo la <b>Guía de Referencia II para Brigadas de Emergencia y Consideraciones Generales sobre la Planeación de los Simulacros de Incendio</b>, contenido lo anterior en la <b>NORMA Oficial Mexicana NOM-002-STPS-2010, Condiciones de seguridad-Prevención y protección contra incendios en los centros de trabajo.</b>
				</p>
				<p>
					<b>El costo de los trabajos descritos anteriormente es el siguiente :</b>
				</p>
				<hr>
				<p><b>Partida única</b></p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>DESCRIPCIÓN (<small>Texto Modificable</small>)</th>
							<th>COSTO $ M.N</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<textarea name="descripcion_formato" class="textarea form-control"><strong>Realización de simulacro de evacuación en situaciones de incendio o movimiento sísmico, correspondiente a la norma NOM-002-STPS-2010</strong> con entrega del reporte de evaluación y observaciones de áreas de oportunidad.</textarea>
							</td>
							<td>
								<input type="text" name="costo_formato" class="form-control" required>	
							</td>
						</tr>
					</tbody>
				</table>
				<p>Sin más por el momento y agradeciendo la atención a la presente, me despido </p>
				<p class="text-center">ATENTAMENTE</p>
				<input type="text" name="atentamente" class="form-control" required>

			</div>

			<div class="col-sm-12">
			<hr>
				<input type="hidden" name="agregar_formato" value="1">
				<input type="submit" class="btn btn-success" value="Guardar Formato">
			</div>
		</form>
	<?php
	}
	 ?>
</div>
