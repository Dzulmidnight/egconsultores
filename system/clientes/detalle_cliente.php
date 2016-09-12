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

	/***** INICIAN VARIABLES DE BITACORA *****/
	$idusuario = $_SESSION['idusuario'];
	$idcliente = $_GET['idcliente'];
	$fecha = time();
	$identificador = "CLIENTE";
	$accion = 2;

	/***** TERMIAN VARIABLES DE BITACORA *****/



	if(isset($_POST['actualizar_cliente']) && $_POST['actualizar_cliente'] == 1){
		$updateSQL = sprintf("UPDATE cliente SET empresa=%s, rfc=%s, cont_emp1=%s, cont_emp2=%s, direccion=%s, cp=%s, numero=%s, colonia=%s, ciudad=%s, delegacion=%s, telefono=%s, fax=%s, imss=%s, clase=%s, prima_riesgo=%s, turnos=%s, num_trabajador=%s, actividad=%s, primero_horario=%s, primero_jornada=%s, segundo_horario=%s, segundo_jornada=%s, tercero_horario=%s, tercero_jornada=%s, deptos=%s, sindicato=%s, inicio_actividades=%s, c_cap_ad=%s, vigencia=%s, plan_cap=%s, periodo=%s ,etapas=%s, primera=%s, segunda=%s, tercera=%s, cuarta=%s, rep_trab1=%s, rep_trab2=%s, rep_trab3=%s, rep_trab4=%s, rep_trab5=%s, rep_trab6=%s, rep_pat1=%s, rep_pat2=%s, rep_pat3=%s, rep_pat4=%s ,rep_pat5=%s, rep_pat6=%s, honorarios=%s, pago_iva=%s, total=%s, honorarios_letra=%s, inicio=%s, final=%s, campo1=%s, campo2=%s, modificado=%s WHERE idcliente=%s",
			GetSQLValueString($_POST['empresa'], "text"),
			GetSQLValueString($_POST['rfc'], "text"),
			GetSQLValueString($_POST['cont_emp1'], "text"),
			GetSQLValueString($_POST['cont_emp2'], "text"),
			GetSQLValueString($_POST['direccion'], "text"),
			GetSQLValueString($_POST['cp'], "text"),
			GetSQLValueString($_POST['numero'], "text"),
			GetSQLValueString($_POST['colonia'], "text"),
			GetSQLValueString($_POST['ciudad'], "text"),
			GetSQLValueString($_POST['delegacion'], "text"),
			GetSQLValueString($_POST['telefono'], "text"),
			GetSQLValueString($_POST['fax'], "text"),
			GetSQLValueString($_POST['imss'], "text"),
			GetSQLValueString($_POST['clase'], "text"),
			GetSQLValueString($_POST['prima_riesgo'], "text"),
			GetSQLValueString($_POST['turnos'], "int"),
			GetSQLValueString($_POST['num_trabajador'], "int"),
			GetSQLValueString($_POST['actividad'], "text"),
			GetSQLValueString($_POST['primero_horario'], "text"),
			GetSQLValueString($_POST['primero_jornada'], "text"),
			GetSQLValueString($_POST['segundo_horario'], "text"),
			GetSQLValueString($_POST['segundo_jornada'], "text"),
			GetSQLValueString($_POST['tercero_horario'], "text"),
			GetSQLValueString($_POST['tercero_jornada'], "text"),
			GetSQLValueString($_POST['deptos'], "text"),
			GetSQLValueString($_POST['sindicato'], "text"),
			GetSQLValueString($_POST['inicio_actividades'], "text"),
			GetSQLValueString($_POST['c_cap_ad'], "text"),
			GetSQLValueString($_POST['vigencia'], "text"),
			GetSQLValueString($_POST['plan_cap'], "text"),
			GetSQLValueString($_POST['periodo'], "text"),
			GetSQLValueString($_POST['etapas'], "int"),
			GetSQLValueString($_POST['primera'], "text"),
			GetSQLValueString($_POST['segunda'], "text"),
			GetSQLValueString($_POST['tercera'], "text"),
			GetSQLValueString($_POST['cuarta'], "text"),
			GetSQLValueString($_POST['rep_trab1'], "text"),
			GetSQLValueString($_POST['rep_trab2'], "text"),
			GetSQLValueString($_POST['rep_trab3'], "text"),
			GetSQLValueString($_POST['rep_trab4'], "text"),
			GetSQLValueString($_POST['rep_trab5'], "text"),
			GetSQLValueString($_POST['rep_trab6'], "text"),
			GetSQLValueString($_POST['rep_pat1'], "text"),
			GetSQLValueString($_POST['rep_pat2'], "text"),
			GetSQLValueString($_POST['rep_pat3'], "text"),
			GetSQLValueString($_POST['rep_pat4'], "text"),
			GetSQLValueString($_POST['rep_pat5'], "text"),
			GetSQLValueString($_POST['rep_pat6'], "text"),
			GetSQLValueString($_POST['honorarios'], "text"),
			GetSQLValueString($_POST['pago_iva'], "text"),
			GetSQLValueString($_POST['total'], "text"),
			GetSQLValueString($_POST['honorarios_letra'], "text"),
			GetSQLValueString($_POST['inicio'], "text"),
			GetSQLValueString($_POST['final'], "text"),
			GetSQLValueString($_POST['campo1'], "text"),
			GetSQLValueString($_POST['campo2'], "text"),
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($idcliente, "int"));

		$actualizar = mysql_query($updateSQL, $eg_system) or die(mysql_error());

		$insertSQL = sprintf("INSERT INTO bitacora (idusuario, identificador, accion, idcliente, fecha_registro) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($idusuario, "int"),
			GetSQLValueString($identificador, "text"),
			GetSQLValueString($accion, "int"),
			GetSQLValueString($idcliente, "int"),
			GetSQLValueString($fecha, "int"));
		$insertar = mysql_query($insertSQL,$eg_system) or die(mysql_error());
		
		$mensaje = "Cliente Actualizado Correctamente";


	}


	$query = "SELECT * FROM cliente WHERE idcliente = $idcliente";
	$row_cliente = mysql_query($query,$eg_system) or die(mysql_error());
	$cliente = mysql_fetch_assoc($row_cliente);

	if(empty($cliente['idusuario'])){
		$creado_por = "";
	}else{
		$queryUsuario = "SELECT username, nombre FROM usuario WHERE idusuario = $cliente[idusuario]";
		$ejecutar = mysql_query($queryUsuario,$eg_system) or die(mysql_error());
		$creado = mysql_fetch_assoc($ejecutar);
		$creado_por = $creado['username'];
	}
	if(empty($cliente['modificado'])){
		$modificado_por = "";
	}else{
		$queryModificado = "SELECT username, nombre FROM usuario WHERE idusuario = $cliente[modificado]";
		$ejecutar = mysql_query($queryModificado,$eg_system) or die(mysql_error());
		$modificado = mysql_fetch_assoc($ejecutar);
		$modificado_por = $modificado['username'];
	}


		    $query_formato_cliente = "SELECT * FROM formato_cliente WHERE idcliente = $idcliente";
		    $consultar_formato_cliente = mysql_query($query_formato_cliente,$eg_system) or die(mysql_error());

 ?>

<h3>Detalle Cliente</h3>

<div class="row">
	<div class="col-lg-12">
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
	</div>
	 
	<div class="col-lg-2 visible-lg">
		<p>Listado Documentos</p>
		<!--<a href="?menu=clientes&idcliente=1&doc=correspondencia" class="btn btn-info form-control">Documento 1</a>-->

		<div class="dropdown">
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    Cotización Simulacro
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		    <li><a href="?menu=clientes&idcliente=<?php echo $_GET['idcliente']; ?>&doc=1" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</a></li>
		    <?php 


		    while($row_formato_cliente = mysql_fetch_assoc($consultar_formato_cliente)){
		    ?>
		    	<li><a href="?menu=clientes&idcliente=<?php echo $_GET['idcliente']; ?>&doc=1&formato=<?php echo $row_formato_cliente['idformato_cliente']; ?>"><?php echo $row_formato_cliente['fecha']; ?></a></li>
		    <?php
		    }
		     ?>
		  </ul>
		</div>
	</div>

	<?php 
	switch (isset($_GET['doc'])) {
		//1 = COTIZACIÓN DE SIMULACRO
		case '1':
			?>
			<?php
			include('documentos/cotizacion_simulacro.php');
			break;
		
		default:
	
			?>
				<div class="col-lg-10 col-md-12">
					<form action="" name="" method="POST" style="font-size:12px;">
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="empresa">Empresa</label>
							<input type="text" class="form-control" id="empresa" name="empresa" value="<?php echo $cliente['empresa']; ?>" required>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rfc">RFC</label>
							<input type="text" class="form-control" id="rfc" name="rfc" value="<?php echo $cliente['rfc']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="cont_emp1">Cont emp1</label>
							<input type="text" class="form-control" id="cont_emp1" name="cont_emp1" value="<?php echo $cliente['cont_emp1']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="cont_emp2">Cont emp2</label>
							<input type="text" class="form-control" id="cont_emp2" name="cont_emp2" value="<?php echo $cliente['cont_emp2']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="direccion">Dirección</label>
							<input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="cp">C.P</label>
							<input type="text" class="form-control" id="cp" name="cp" value="<?php echo $cliente['cp']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="numero">Numero</label>
							<input type="text" class="form-control" id="numero" name="numero" value="<?php echo $cliente['numero']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="colonia">Colonia</label>
							<input type="text" class="form-control" id="colonia" name="colonia" value="<?php echo $cliente['colonia']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="ciudad">Ciudad</label>
							<input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo $cliente['ciudad']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="delegacion">Delegación</label>
							<input type="text" class="form-control" id="delegacion" name="delegacion" value="<?php echo $cliente['delegacion']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="telefono">Teléfono</label>
							<input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="fax">Fax</label>
							<input type="text" class="form-control" id="fax" name="fax" value="<?php echo $cliente['fax']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="imss">IMSS</label>
							<input type="text" class="form-control" id="imss" name="imss" value="<?php echo $cliente['imss']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="clase">Clase</label>
							<input type="text" class="form-control" id="clase" name="clase" value="<?php echo $cliente['clase']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="prima_riesgo">Prima riesgo</label>
							<input type="text" class="form-control" id="prima_riesgo" name="prima_riesgo" value="<?php echo $cliente['prima_riesgo']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="turnos">Turnos</label>
							<input type="number" class="form-control" id="turnos" name="turnos" value="<?php echo $cliente['turnos']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="num_trabajador">Num Trabajador</label>
							<input type="text" class="form-control" id="num_trabajador" name="num_trabajador" value="<?php echo $cliente['num_trabajador']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="actividad">Actividad</label>
							<input type="text" class="form-control" id="actividad" name="actividad" value="<?php echo $cliente['actividad']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="primero_horario">Primero Horario</label>
							<input type="text" class="form-control" id="primero_horario" name="primero_horario" value="<?php echo $cliente['primero_horario']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="primero_jornada">Primero Jornada</label>
							<input type="text" class="form-control" id="primero_jornada" name="primero_jornada" value="<?php echo $cliente['primero_jornada']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="segundo_horario">Segundo Horario</label>
							<input type="text" class="form-control" id="segundo_horario" name="segundo_horario" value="<?php echo $cliente['segundo_horario']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="segundo_jornada">Segundo Jornada</label>
							<input type="text" class="form-control" id="segundo_jornada" name="segundo_jornada" value="<?php echo $cliente['segundo_jornada']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="tercero_horario">Tercero Horario</label>
							<input type="text" class="form-control" id="tercero_horario" name="tercero_horario" value="<?php echo $cliente['tercero_horario']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="tercero_jornada">Tercero Jornada</label>
							<input type="text" class="form-control" id="tercero_jornada" name="tercero_jornada" value="<?php echo $cliente['tercero_jornada']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="deptos">Deptos</label>
							<input type="text" class="form-control" id="deptos" name="deptos" value="<?php echo $cliente['deptos']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="sindicato">Sindicato</label>
							<input type="text" class="form-control" id="sindicato" name="sindicato" value="<?php echo $cliente['sindicato']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="inicio_actividades">Inicio Actividades</label>
							<input type="text" class="form-control" id="inicio_actividades" name="inicio_actividades" value="<?php echo $cliente['inicio_actividades']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="c_cap_ad">C Cap y Ad</label>
							<input type="text" class="form-control" id="c_cap_ad" name="c_cap_ad" value="<?php echo $cliente['c_cap_ad']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="vigencia">Vigencia</label>
							<input type="text" class="form-control" id="vigencia" name="vigencia" value="<?php echo $cliente['vigencia']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="plan_cap">Plan Cap / Folio</label>
							<input type="text" class="form-control" id="plan_cap" name="plan_cap" value="<?php echo $cliente['plan_cap']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="periodo">Periodo</label>
							<input type="text" class="form-control" id="periodo" name="periodo" value="<?php echo $cliente['periodo']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="etapas">Etapas</label>
							<input type="text" class="form-control" id="etapas" name="etapas" value="<?php echo $cliente['etapas']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="primera">Primera</label>
							<input type="text" class="form-control" id="primera" name="primera" value="<?php echo $cliente['primera']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="segunda">Segunda</label>
							<input type="text" class="form-control" id="segunda" name="segunda" value="<?php echo $cliente['segunda']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="tercera">Tercera</label>
							<input type="text" class="form-control" id="tercera" name="tercera" value="<?php echo $cliente['tercera']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="cuarta">Cuarta</label>
							<input type="text" class="form-control" id="cuarta" name="cuarta" value="<?php echo $cliente['cuarta']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_trab1">Rep Trab1</label>
							<input type="text" class="form-control" id="rep_trab1" name="rep_trab1" value="<?php echo $cliente['rep_trab1']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_trab2">Rep Trab2</label>
							<input type="text" class="form-control" id="rep_trab2" name="rep_trab2" value="<?php echo $cliente['rep_trab2']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_trab3">Rep Trab3</label>
							<input type="text" class="form-control" id="rep_trab3" name="rep_trab3" value="<?php echo $cliente['rep_trab3']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_trab4">Rep Trab4</label>
							<input type="text" class="form-control" id="rep_trab4" name="rep_trab4" value="<?php echo $cliente['rep_trab4']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_trab5">Rep Trab5</label>
							<input type="text" class="form-control" id="rep_trab5" name="rep_trab5" value="<?php echo $cliente['rep_trab5']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_trab6">Rep Trab6</label>
							<input type="text" class="form-control" id="rep_trab6" name="rep_trab6" value="<?php echo $cliente['rep_trab6']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_pat1">Rep Pat1</label>
							<input type="text" class="form-control" id="rep_pat1" name="rep_pat1" value="<?php echo $cliente['rep_pat1']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_pat2">Rep Pat2</label>
							<input type="text" class="form-control" id="rep_pat2" name="rep_pat2" value="<?php echo $cliente['rep_pat2']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_pat">Rep Pat3</label>
							<input type="text" class="form-control" id="rep_pat3" name="rep_pat3" value="<?php echo $cliente['rep_pat3']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_pat4">Rep Pat4</label>
							<input type="text" class="form-control" id="rep_pat4" name="rep_pat4" value="<?php echo $cliente['rep_pat4']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_pat5">Rep Pat5</label>
							<input type="text" class="form-control" id="rep_pat5" name="rep_pat5" value="<?php echo $cliente['rep_pat5']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="rep_pat6">Rep Pat6</label>
							<input type="text" class="form-control" id="rep_pat6" name="rep_pat6" value="<?php echo $cliente['rep_pat6']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="honorarios">Honorarios</label>
							<input type="text" class="form-control" id="honorarios" name="honorarios" value="<?php echo $cliente['honorarios']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="pago_iva">Pago IVA</label>
							<input type="text" class="form-control" id="pago_iva" name="pago_iva" value="<?php echo $cliente['pago_iva']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="total">Total</label>
							<input type="text" class="form-control" id="total" name="total" value="<?php echo $cliente['total']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="honorarios_letra">Honorarios Letra</label>
							<input type="text" class="form-control" id="honorarios_letra" name="honorarios_letra" value="<?php echo $cliente['honorarios_letra']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="inicio">Inicio</label>
							<input type="text" class="form-control" id="inicio" name="inicio" value="<?php echo $cliente['inicio']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="final">Final</label>
							<input type="text" class="form-control" id="final" name="final" value="<?php echo $cliente['final']; ?>">
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="campo1">Campo1</label>
							<textarea class="form-control" name="campo1" id="campo1" rows="5"><?php echo $cliente['campo1']; ?></textarea>

						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="campo2">Campo2</label>
							<textarea class="form-control" name="campo2" id="campo2" rows="5"><?php echo $cliente['campo2']; ?></textarea>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="idusuario">Agregado Por:</label>
							<input class="form-control" type="text" id="idusuario" name="idusuario" value="<?php echo $creado_por; ?>" readonly>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<label for="modificado">Modificado Por:</label>
							<input class="form-control" type="text" id="modificado" name="modificado" value="<?php echo $modificado_por; ?>" readonly>
						</div>


						<div class="col-lg-12">
							<hr>
							<input type="hidden" class="form-control" id="idusuario" name="idusuario" value="<?php echo $_SESSION['idusuario']; ?>">
							<input type="hidden" name="actualizar_cliente" value="1">
							<input style="width:200px;" class="btn btn-success" type="submit" value="Actualizar Cliente">
						</div>
					</form>
				</div>
		

			<?php
			
			break;
	}
	?>
</div>