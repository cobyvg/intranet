<?php
session_start();
include("../config.php");
include_once('../config/version.php');

$GLOBALS['db_con'] = $db_con;

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


// CALENDARIO
$dia_actual = date('d');

$dia  = isset($_GET['dia'])  ? $_GET['dia']  : date('d');
$mes  = isset($_GET['mes'])  ? $_GET['mes']  : date('m');
$anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

$semana = 1;

for ($i = 1; $i <= date('t', strtotime($anio.'-'.$mes)); $i++) {
	
	$dia_semana = date('N', strtotime($anio.'-'.$mes.'-'.$i));
	
	$calendario[$semana][$dia_semana] = $i;
	if ($dia_semana == 7) $semana++;
	
}


// NAVEGACION
$mes_ant = $mes - 1;
$anio_ant = $anio;

if ($mes == 1) {
	$mes_ant = 12;
	$anio_ant = $anio - 1;
}


$mes_sig = $mes + 1;
$anio_sig = $anio;

if ($mes == 12) {
	$mes_sig = 1;
	$anio_sig = $anio + 1;
}

// HTML CALENDARIO MENSUAL
function vista_mes ($calendario, $dia, $mes, $anio) {
	
	// Corrección en mes
	($mes < 10) ? $mes = '0'.$mes : $mes = $mes;
	
	echo '<div class"table-responsive">';
	echo '<table id="calendar" class="table table-bordered">';
	echo '	<thead>';
	echo '		<tr>';
	echo '			<th class="text-center">Lunes</th>';
	echo '			<th class="text-center">Martes</th>';
	echo '			<th class="text-center">Miércoles</th>';
	echo '			<th class="text-center">Jueves</th>';
	echo '			<th class="text-center">Viernes</th>';
	echo '			<th class="text-center">Sábado</th>';
	echo '			<th class="text-center">Domingo</th>';
	echo '		</tr>';
	echo '	</thead>';
	echo '	<tbody>';
	
	foreach ($calendario as $dias) {
		echo '		<tr>';
	
		for ($i = 1; $i <= 7; $i++) {
			
			if ($i > 5) {
				if (isset($dias[$i]) && ($mes == date('m')) && ($dias[$i] == date('d'))) {
					echo '			<td class="text-muted today" width="14.28%">';
				}
				else {
					echo '			<td class="text-muted" width="14.28%">';
				}
			}
			else {
				if (isset($dias[$i]) && ($mes == date('m')) && ($dias[$i] == date('d'))) {
					echo '			<td class="today" width="14.28%">';
				}
				else {
					echo '			<td width="14.28%">';
				}
			}
			
			if (isset($dias[$i])) {

				echo '				<p class="lead text-right">'.$dias[$i].'</p>';
				
				// Corrección en día
				($dias[$i] < 10) ? $dia0 = '0'.$dias[$i] : $dia0 = $dias[$i];
				
				// CALENDARIO PERSONAL
				$result = mysqli_query($GLOBALS['db_con'], "SELECT id, fecha, titulo FROM diario WHERE profesor = '".$_SESSION['profi']."'");
				while ($diario = mysqli_fetch_assoc($result)) {
					
					if ($diario['fecha'] == $anio.'-'.$mes.'-'.$dia0) {
						echo '<a href="#" data-toggle="modal" data-target="#modalEventoDiario'.$diario['id'].'" class="label label-info">'.$diario['titulo'].'</a>';
					}
				}
				mysqli_free_result($result);
				unset($diario);
				
				// CALENDARIO DEL CENTRO
				$result = mysqli_query($GLOBALS['db_con'], "SELECT eventdate, title FROM cal");
				while ($centro = mysqli_fetch_assoc($result)) {
					
					if ($centro['eventdate'] == $anio.'-'.$mes.'-'.$dia0) {
						echo '<div class="label label-warning">'.$centro['title'].'</div>';
					}
				}
				mysqli_free_result($result);
				unset($centro);
				
				// ACTIVIDADES EXTRAESCOLARES
				$result = mysqli_query($GLOBALS['db_con'], "SELECT fecha, actividad FROM actividades WHERE confirmado = 1");
				while ($actividad = mysqli_fetch_assoc($result)) {
					
					if ($actividad['fecha'] == $anio.'-'.$mes.'-'.$dia0) {
						echo '<div class="label label-success">'.$actividad['actividad'].'</div>';
					}
				}
				mysqli_free_result($result);
				unset($actividad);
				
				// FESTIVOS
				$result = mysqli_query($GLOBALS['db_con'], "SELECT fecha, nombre FROM festivos");
				while ($festivo = mysqli_fetch_assoc($result)) {
					
					if ($festivo['fecha'] == $anio.'-'.$mes.'-'.$dia0) {
						echo '<div class="label label-danger">'.$festivo['nombre'].'</div>';
					}
				}
				mysqli_free_result($result);
				unset($festivo);
				
				
			}
			else {
				echo '&nbsp;';
			}
			
			echo '			</td>';
		}
		echo '		</tr>';
	}
	
	echo '	</tbody>';
	echo '</table>';
	echo '</div>';

}

?>
<?php include("../menu.php"); ?>

	<div class="container">
		
		<style type="text/css">
		.label {
			display: block;
			white-space: normal;
			text-align: left;
			margin-top: 5px;
		}
		
		.today {
			background-color: #ecf0f1;
		}
		
		.today p.lead {
			font-weight: bold;
		}
		
		@media print {
			html, body {
				width: 100%;
			}
			.container, .col-md-9 {
				width: 100%;
			}
		}
		</style>
		
		<!-- MODAL NUEVO EVENTO -->
		<div id="modalNuevoEvento" class="modal fade">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Nuevo evento</h4>
		      </div>
		      <div class="modal-body">
		        <p>One fine body&hellip;</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="button" class="btn btn-primary">Crear</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- FIN MODAL NUEVO EVENTO -->
		
		<?php
		// CALENDARIO PERSONAL
		$result = mysqli_query($GLOBALS['db_con'], "SELECT id, fecha, titulo FROM diario WHERE profesor = '".$_SESSION['profi']."'");
		while ($diario = mysqli_fetch_assoc($result)) {
			
			echo '<div id="modalEventoDiario'.$diario['id'].'" class="modal fade">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Nuevo evento</h4>
			      </div>
			      <div class="modal-body">
			        <p>One fine body&hellip;</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button type="button" class="btn btn-primary">Crear</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->';
		}
		mysqli_free_result($result);
		unset($diario);
		
		?>
		
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			
			<!-- BUTTONS -->
			<div class="pull-right hidden-print">
			
				<a href="#" data-toggle="modal" data-target="#modalNuevoEvento" class="btn btn-primary">Nuevo</a>
				  
				<a href="#" onclick="javascrip:print()" class="btn btn-default">Imprimir</a>
				
				<div class="btn-group">
				  <a href="?mes=<?php echo $mes_ant; ?>&anio=<?php echo $anio_ant; ?>" class="btn btn-default">&laquo;</a>
				  <a href="?mes=<?php echo date('n'); ?>&anio=<?php echo date('Y'); ?>" class="btn btn-default">Hoy</a>
				  <a href="?mes=<?php echo $mes_sig; ?>&anio=<?php echo $anio_sig; ?>" class="btn btn-default">&raquo;</a>
				</div>
			</div>
			
			<h2>Calendario <small><?php echo strftime('%B, %Y', strtotime($anio.'-'.$mes)); ?></small></h2>
		</div>
		
		<!-- SCAFFOLDING -->
		<div class="row">
			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-md-3 hidden-print">
				
				<div class="row">
					<div class="col-xs-2 col-sm-3">
					  <span class="fa-stack fa-2x text-info">
					    <i class="fa fa-calendar-o fa-stack-2x"></i>
					    <strong class="fa-stack-1x" style="margin-top: .2em;"><?php echo strftime('%e', strtotime(date('Y-m-d'))); ?></strong>
					  </span>
					</div>
					<div class="col-xs-10 col-sm-9">
						<h4 style="margin-top: .2em; padding-top: 0; font-size: 1.5em;" class="text-info">
							<strong><?php echo strftime('%A', strtotime(date('Y-m-d'))); ?></strong><br>
							<?php echo strftime('%B, %Y', strtotime(date('Y-m-d'))); ?>
						</h4>
						
					</div> 
				</div>
				
				<hr>
				
				<h3>Mis calendarios</h3>
				
				<table>
					<tr>
						<td>
							<span class="fa fa-square fa-fw fa-lg" style="color: #3498db;"></span> Calendario personal
						</td>
					</tr>
					<tr>
						<td>
							
						</td>
					</tr>
				</table>
				
				<hr>
				
				<h3>Otros calendarios</h3>
				
				<table>
					<tr>
						<td>
							<span class="fa fa-square fa-fw fa-lg" style="color: #f29b12;"></span> Calendario del centro
						</td>
					</tr>
					<tr>
						<td>
							<span class="fa fa-square fa-fw fa-lg" style="color: #18bc9c;"></span> Actividades extraescolares
						</td>
					</tr>
					<tr>
						<td>
							<span class="fa fa-square fa-fw fa-lg" style="color: #e14939;"></span> Días festivos
						</td>
					</tr>
				</table>
	
			</div><!-- /.col-md-3 -->
			
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-md-9">
				
				<?php vista_mes($calendario, $dia, $mes, $anio); ?>
				
			</div><!-- /.col-md-9 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->

<?php include("../pie.php"); ?>
</body>
</html>
