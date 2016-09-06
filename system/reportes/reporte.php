<?php 
	require_once('mpdf/mpdf.php');
	include("../../connections/eg_system.php");
	mysql_select_db($database_eg_system, $eg_system);

	$idformato_cliente = $_POST['idformato_cliente'];

	$query = "SELECT formato_cliente.*, cliente.* FROM formato_cliente INNER JOIN cliente ON formato_cliente.idcliente = cliente.idcliente WHERE idformato_cliente = $idformato_cliente";
	$consultar = mysql_query($query,$eg_system) or die(mysql_error());
	$row_formato = mysql_fetch_assoc($consultar);

	$html = '

    <header class="clearfix">
      <div id="logo">
        <img src="img/egconsultores.png">
      </div>
      <h5 style="text-align:center">
		Av. Uiversidad 1093 Despacho 302, Colonia del Valle; Delegación. Benito Juárez.  C.P. 03100. México D.F.
		<br>      
		Tels.: 56-61-50-75 y 56-61-60-78
      </h5>
      <!--<h1>INVOICE 3-2-1</h1>-->
      <div >
        <table style="padding:0px;margin:0px;">
			<tr>
				<td style="text-align:left;margin-bottom:0px;font-size:9px;">
			        <div>EFRÉN GODÍNEZ GARCÍA</div>
			        <div>EVA NAYELY GODÍNEZ MACIEL</div>
			        <div>FLORENTINO OLIVA HUERTA</div>
			        <div>EDUARDO ARENAS PONCE</div>
				</td>
				<td style="text-align:right;font-size:9px;">
			        <div>RAFAEL PÉREZ MUÑOZ</div>
			        <div>VICTOR HERNÁNDEZ MEJÍA</div>
			        <div>DAVID HERNÁNDEZ MEJÍA</div>
			        <div>DANIEL VITE ULIBARRI</div>
				</td>
			</tr>

        </table>
      </div>
      <h3 style="text-align:right">'.$row_formato['fecha'].'</h3>

      <div id="company" class="clearfix" style="text-align:left">
        <div><b>'.$row_formato['empresa'].'</b></div>
        <div>'.$row_formato['direccion'].' No. '.$row_formato['numero'].', Col. '.$row_formato['colonia'].'</div>
        <div>'. $row_formato['ciudad'].', Del. '.$row_formato['delegacion'].', C.P. '.$row_formato['cp'].'</div>
        <br>
        <div>Attn.: '.$row_formato['cont_emp1'].'</div>
      </div>


      <!--<div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>

      <div id="project">
        <div><span>PROJECT</span> Website development</div>
        <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> 796 Silver Harbour, TX 79273, US</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
        <div><span>DATE</span> August 17, 2015</div>
        <div><span>DUE DATE</span> September 17, 2015</div>
      </div>-->
    </header>
    <main>
		<div style="text-align:justify">
			<p>Estimado/a Licenciado/a</p>
			<p>
				Por medio de la presente, le entregamos  a su atenta consideración los resultados por la realización: '.$row_formato['asunto_formato'].'
				que comprendió la revisión de los puntos:
			</p>


			<blockquote>
				<ul>
					<li>
						<b>4.6 Brigada contra incendio:</b> El grupo de trabajadores organizados en una Unidad interna de protección civil, capacitados y adiestrados en operaciones básicas de prevención y protección contra incendio y atención de emergencias de incendio, tales como identificación de los riesgos de la situación de emergencia por incendio; manejo de equipos o sistemas contra incendio, al igual que en acciones de evacuación, comunicación y primeros auxilios, entre otras. 
					</li>
					<hr>
					<li>
						<b>4.18 Lugar seguro:</b> Es la zona o área seleccionada e identificada dentro o fuera del centro de trabajo, que los trabajadores y demás ocupantes del mismo deberán utilizar como zona de protección, en caso de alarma y evacuación por incendio, de acuerdo con lo establecido en el plan de atención a emergencias.
					</li>
					<hr>
					<li>
						<b>4.31 Ruta de evacuación:</b> Es el recorrido horizontal o vertical, o la combinación de ambos, continuo y sin obstrucciones, que va desde cualquier punto del centro de trabajo hasta un lugar seguro en el exterior, denominado punto de reunión, que incluye locales intermedios como salas, vestíbulos, balcones, patios y otros recintos; así como sus componentes, tales como puertas, escaleras, rampas y pasillos. Consta de las partes siguientes:
					</li>
				</ul>
				<blockquote>
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

				</blockquote>
			</blockquote>

			<p>
				Siguiendo la <b>Guía de Referencia II para Brigadas de Emergencia y Consideraciones Generales sobre la Planeación de los Simulacros de Incendio</b>, contenido lo anterior en la <b>NORMA Oficial Mexicana NOM-002-STPS-2010, Condiciones de seguridad-Prevención y protección contra incendios en los centros de trabajo.</b>
			</p>
			<p>
				<b>El costo de los trabajos descritos anteriormente es el siguiente :</b>
			</p>
			<hr>
			<p><b>Partida única</b></p>
		</div>
		

      <table>
        <thead>
          <tr>
            <th class="service">DESCRIPCIÓN</th>
            <th class="desc">COSTO  $ M.N.</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">'.$row_formato['descripcion_formato'].'</td>
            <td class="desc">'.$row_formato['costo_formato'].'</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div class="notice" style="font-size:12px;">Sin más por el momento y agradeciendo la atención a la presente, me despido.</div>
      </div>
      
      <h3 style="margin-top:10em;text-align:center">ATENTAMENTE</h3>
      <h4 style="text-align:center">'.$row_formato['atentamente'].'</h4>
      

    </main>
    <footer>
    <div>
    	www.egconsultores.com.mx
    </div>
    
    <div>
    	florentino.oliva@egconsultores.com.mx 
    </div>
  
    </footer>



	';

	$mpdf = new mPDF('c', 'A4');
	$css = file_get_contents('css/style.css');
	$mpdf->writeHTML($css,1);
	$mpdf->writeHTML($html);
	$mpdf->Output('reporte.pdf', 'I');
 ?>