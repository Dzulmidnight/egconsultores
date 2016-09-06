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

	if(isset($_POST['agregar_cliente']) && $_POST['agregar_cliente'] == 1){
		$query = sprintf("INSERT INTO cliente (empresa, rfc, cont_emp1, cont_emp2, direccion, cp, numero, colonia, ciudad, delegacion, telefono, fax, imss, clase, prima_riesgo, turnos, num_trabajador, actividad, primero_horario, primero_jornada, segundo_horario, segundo_jornada, tercero_horario, tercero_jornada, deptos, sindicato, inicio_actividades, c_cap_ad, vigencia, plan_cap, periodo, etapas, primera, segunda, tercera, cuarta, rep_trab1, rep_trab2, rep_trab3, rep_trab4, rep_trab5, rep_trab6, rep_pat1, rep_pat2, rep_pat3, rep_pat4, rep_pat5, rep_pat6, honorarios, pago_iva, total, honorarios_letra, inicio, final, campo1, campo2, idusuario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", 
			GetSQLValueString($_POST['empresa'], "text"),
			GetSQLValueString($_POST['RFC'], "text"),
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
			GetSQLValueString($_POST['idusuario'], "int"));

		  $insetar = mysql_query($query, $eg_system) or die(mysql_error());
		  $mensaje = "Cliente Agregado Correctamente";

	}
 ?>

<div class="row">
	<h3>Agregar Cliente(s)</h3>
	<hr>
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
	 	 	

	<div class="col-lg-4 visible-lg" style="padding:0px;">
		<p>Listado Clientes</p>
		<table class="table table-bordered table-condensed table-hover" style="font-size:11px;">
			<thead>
				<tr>
					<th></th>
					<th>Id</th>
					<th>Empresa</th>
					<th>RFC</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$query = "SELECT idcliente, empresa, rfc FROM cliente ORDER BY 'empresa'";
			$row_cliente = mysql_query($query,$eg_system) or die(mysql_error());

			while($cliente = mysql_fetch_assoc($row_cliente)){
			?>
				<tr>
					<td>
						<a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Visualizar | Editar" href="?menu=clientes&idcliente=<?php echo $cliente['idcliente'];?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
					</td>
					<td><?php echo $cliente['idcliente']; ?></td>
					<td><?php echo $cliente['empresa']; ?></td>
					<td><?php echo $cliente['rfc']; ?></td>
				</tr>
			<?php
			}
			 ?>		
			</tbody>
		</table>
	</div>
	<div class="col-lg-8 col-md-12" style="padding:0px;">
		<form action="" name="" method="POST" style="font-size:12px;">
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="empresa">Empresa</label>
				<input type="text" class="form-control" id="empresa" name="empresa" required>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="RFC">RFC</label>
				<input type="text" class="form-control" id="RFC" name="RFC">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="cont_emp1">Cont emp1</label>
				<input type="text" class="form-control" id="cont_emp1" name="cont_emp1">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="cont_emp2">Cont emp2</label>
				<input type="text" class="form-control" id="cont_emp2" name="cont_emp2">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="direccion">Dirección</label>
				<input type="text" class="form-control" id="direccion" name="direccion">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="cp">C.P</label>
				<input type="text" class="form-control" id="cp" name="cp">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="numero">Numero</label>
				<input type="text" class="form-control" id="numero" name="numero">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="colonia">Colonia</label>
				<input type="text" class="form-control" id="colonia" name="colonia">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="ciudad">Ciudad</label>
				<input type="text" class="form-control" id="ciudad" name="ciudad">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="delegacion">Delegación</label>
				<input type="text" class="form-control" id="delegacion" name="delegacion">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="telefono">Teléfono</label>
				<input type="text" class="form-control" id="telefono" name="telefono">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="fax">Fax</label>
				<input type="text" class="form-control" id="fax" name="fax">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="imss">IMSS</label>
				<input type="text" class="form-control" id="imss" name="imss">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="clase">Clase</label>
				<input type="text" class="form-control" id="clase" name="clase">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="prima_riesgo">Prima riesgo</label>
				<input type="text" class="form-control" id="prima_riesgo" name="prima_riesgo">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="turnos">Turnos</label>
				<input type="number" class="form-control" id="turnos" name="turnos">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="num_trabajador">Num Trabajador</label>
				<input type="text" class="form-control" id="num_trabajador" name="num_trabajador">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="actividad">Actividad</label>
				<input type="text" class="form-control" id="actividad" name="actividad">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="primero_horario">Primero Horario</label>
				<input type="text" class="form-control" id="primero_horario" name="primero_horario">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="primero_jornada">Primero Jornada</label>
				<input type="text" class="form-control" id="primero_jornada" name="primero_jornada">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="segundo_horario">Segundo Horario</label>
				<input type="text" class="form-control" id="segundo_horario" name="segundo_horario">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="segundo_jornada">Segundo Jornada</label>
				<input type="text" class="form-control" id="segundo_jornada" name="segundo_jornada">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="tercero_horario">Tercero Horario</label>
				<input type="text" class="form-control" id="tercero_horario" name="tercero_horario">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="tercero_jornada">Tercero Jornada</label>
				<input type="text" class="form-control" id="tercero_jornada" name="tercero_jornada">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="deptos">Deptos</label>
				<input type="text" class="form-control" id="deptos" name="deptos">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="sindicato">Sindicato</label>
				<input type="text" class="form-control" id="sindicato" name="sindicato">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="inicio_actividades">Inicio Actividades</label>
				<input type="text" class="form-control" id="inicio_actividades" name="inicio_actividades">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="c_cap_ad">C Cap y Ad</label>
				<input type="text" class="form-control" id="c_cap_ad" name="c_cap_ad">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="vigencia">Vigencia</label>
				<input type="text" class="form-control" id="vigencia" name="vigencia">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="plan_cap">Plan Cap / Folio</label>
				<input type="text" class="form-control" id="plan_cap" name="plan_cap">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="periodo">Periodo</label>
				<input type="text" class="form-control" id="periodo" name="periodo">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="etapas">Etapas</label>
				<input type="text" class="form-control" id="etapas" name="etapas">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="primera">Primera</label>
				<input type="text" class="form-control" id="primera" name="primera">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="segunda">Segunda</label>
				<input type="text" class="form-control" id="segunda" name="segunda">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="tercera">Tercera</label>
				<input type="text" class="form-control" id="tercera" name="tercera">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="cuarta">Cuarta</label>
				<input type="text" class="form-control" id="cuarta" name="cuarta">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_trab1">Rep Trab1</label>
				<input type="text" class="form-control" id="rep_trab1" name="rep_trab1">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_trab2">Rep Trab2</label>
				<input type="text" class="form-control" id="rep_trab2" name="rep_trab2">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_trab3">Rep Trab3</label>
				<input type="text" class="form-control" id="rep_trab3" name="rep_trab3">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_trab4">Rep Trab4</label>
				<input type="text" class="form-control" id="rep_trab4" name="rep_trab4">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_trab5">Rep Trab5</label>
				<input type="text" class="form-control" id="rep_trab5" name="rep_trab5">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_trab6">Rep Trab6</label>
				<input type="text" class="form-control" id="rep_trab6" name="rep_trab6">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_pat1">Rep Pat1</label>
				<input type="text" class="form-control" id="rep_pat1" name="rep_pat1">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_pat2">Rep Pat2</label>
				<input type="text" class="form-control" id="rep_pat2" name="rep_pat2">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_pat">Rep Pat3</label>
				<input type="text" class="form-control" id="rep_pat3" name="rep_pat3">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_pat4">Rep Pat4</label>
				<input type="text" class="form-control" id="rep_pat4" name="rep_pat4">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_pat5">Rep Pat5</label>
				<input type="text" class="form-control" id="rep_pat5" name="rep_pat5">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="rep_pat6">Rep Pat6</label>
				<input type="text" class="form-control" id="rep_pat6" name="rep_pat6">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="honorarios">Honorarios</label>
				<input type="text" class="form-control" id="honorarios" name="honorarios">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="pago_iva">Pago IVA</label>
				<input type="text" class="form-control" id="pago_iva" name="pago_iva">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="total">Total</label>
				<input type="text" class="form-control" id="total" name="total">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="honorarios_letra">Honorarios Letra</label>
				<input type="text" class="form-control" id="honorarios_letra" name="honorarios_letra">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="inicio">Inicio</label>
				<input type="text" class="form-control" id="inicio" name="inicio">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="final">Final</label>
				<input type="text" class="form-control" id="final" name="final">
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="campo1">Campo1</label>
				<textarea id="campo1" name="campo1"></textarea>
				
			</div>
			<div class="col-lg-4 col-md-6 col-sm-12">
				<label for="campo2">Campo2</label>
				<textarea id="campo2" name="campo2"></textarea>
				
			</div>
			<div class="col-lg-12">
				<hr>
				<input type="hidden" class="form-control" id="idusuario" name="idusuario" value="<?php echo $_SESSION['idusuario']; ?>">
				<input type="hidden" name="agregar_cliente" value="1">
				<input style="width:200px;" class="btn btn-success" type="submit" value="Guardar">
			</div>
		</form>
	</div>
</div>