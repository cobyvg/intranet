<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

     
if(isset($_GET['todos'])){$todos = $_GET['todos'];}
if(isset($_GET['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}
if(isset($_GET['unidad'])){$unidad = $_GET['unidad'];}else{$unidad = $_POST['unidad'];}
if(isset($_POST['c_escolar'])){$c_escolar = $_POST['c_escolar'];}else{ $c_escolar=""; }
if(isset($_POST['nombre'])){$nombre = $_POST['nombre'];}else{ $nombre=""; }
if(isset($_POST['fecha1'])){$fecha1 = $_POST['fecha1'];}else{ $fecha1=""; }
if(isset($_POST['fecha2'])){$fecha2 = $_POST['fecha2'];}else{ $fecha2=""; }
if(isset($_POST['faltas'])){$faltas = $_POST['faltas'];}else{ $faltas=""; }
if(isset($_POST['faltasd'])){$faltasd = $_POST['faltasd'];}else{ $faltasd=""; }
if(isset($_POST['fechorias'])){$fechorias = $_POST['fechorias'];}else{ $fechorias=""; }
if(isset($_POST['notas'])){$notas = $_POST['notas'];}else{ $notas=""; }
if(isset($_POST['tutoria'])){$tutoria = $_POST['tutoria'];}else{ $tutoria=""; }
if(isset($_POST['horarios'])){$horarios = $_POST['horarios'];}else{ $horarios=""; }
if(isset($_POST['act_tutoria'])){$act_tutoria = $_POST['act_tutoria'];}else{ $act_tutoria=""; }


if (!($c_escolar==$curso_actual)) {
	$an = explode("/",$c_escolar);
	$c_db = $an[0]+1;
	$base = $db.$c_db;	
	mysql_select_db($base);
}

if ($claveal) {
	 $SQL1 = "select distinct alma.apellidos, alma.nombre, alma.unidad, alma.claveal, claveal1, numeroexpediente from alma where claveal = '$claveal' order BY alma.apellidos";
  $result1= mysql_query($SQL1);
	if ($row1 = mysql_fetch_array($result1)) {
	  $claveal = $row1[3];
	  $unidad = $row1[2];
	  $claveal1 = $row1[4];
	  $apellido = $row1[0];
	  $nombrepil = $row1[1];
  } 
}

  
$clave = explode(" --> ", $nombre);

if (!$claveal) {
	$claveal = $clave[1];
	$nombrealumno = explode(",",$clave[0]);
	$apellidos = $nombrealumno[0];
	$nombrepila = $nombrealumno[1];
	$apellido = trim($apellidos);
	$nombrepil = trim($nombrepila);
} 

if (!($c_escolar == $curso_actual)) {
	mysql_select_db($db);
}


$PLUGIN_DATATABLES = 1;

include('../../menu.php');
?>


	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Expediente académico del alumno/a</h2>
			<h3 class="text-info"><?php echo $apellido.', '.$nombrepil; ?></h3>
		</div>
		
		<?php $result = mysql_query("SELECT correo FROM control WHERE claveal='$claveal' LIMIT 1"); ?>
		<?php $row2 = mysql_fetch_array($result); ?>
		<?php mysql_free_result($result); ?>
		
		<?php $result = mysql_query("select distinct alma.claveal, alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.padre, alma.matriculas, telefonourgencia, paisnacimiento, correo, nacionalidad, edad, curso, unidad, numeroexpediente from alma where alma.claveal= '$claveal' order BY alma.apellidos"); ?>
		
		<?php if ($row = mysql_fetch_array($result)): ?>
		<!-- SCAFFOLDING -->
		<div class="well">
		<div class="row">
			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-2 text-center hidden-xs">
				<?php $foto = '../../xml/fotos/'.$claveal.'.jpg'; ?>
				<?php if (file_exists($foto)): ?>
				<img class="img-thumbnail" src="../../xml/fotos/<?php echo $claveal; ?>.jpg" alt="<?php echo $apellido.', '.$nombrepil; ?>">
				<?php else: ?>
				<h2><span class="fa fa-user fa-fw fa-5x"></span></h2>
				<?php endif; ?>
				
			</div><!-- /.col-sm-2 -->
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-10">
				
				<div class="row">
				
					<div class="col-sm-6">
						
						<dl class="dl-horizontal">
						  <dt>DNI / Pasaporte</dt>
						  <dd><?php echo ($row['DNI'] != "") ? $row['DNI']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Fecha de nacimiento</dt>
						  <dd><?php echo ($row['fecha'] != "") ? $row['fecha']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Edad</dt>
						  <dd><?php echo ($row['edad'] != "") ? $row['edad'].' años': '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Domicilio</dt>
						  <dd><?php echo ($row['domicilio'] != "") ? $row['domicilio']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Nacionalidad</dt>
						  <dd><?php echo ($row['nacionalidad'] != "") ? $row['nacionalidad']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Teléfono</dt>
						  <dd><?php echo ($row['telefono'] != "") ? '<a href="tel:'.$row['telefono'].'">'.$row['telefono'].'</a>': '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Teléfono urgencias</dt>
						  <dd><?php echo ($row['telefonourgencia'] != "") ? '<a href="tel:'.$row['telefonourgencia'].'">'.$row['telefonourgencia'].'</a>': '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Correo electrónico</dt>
						  <dd><?php echo ($row['correo'] != "") ? '<a href="mailto:'.$row['correo'].'</a>"' : ($row2['correo'] != "") ? '<a href="mailto:'.$row2['correo'].'</a>"' : '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Representante legal</dt>
						  <dd><?php echo ($row['padre'] != "") ? $row['padre']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						</dl>
						
					</div><!-- /.col-sm-6 -->
					
					<div class="col-sm-6">

						<dl class="dl-horizontal">
						  <dt><abbr rel="tooltip" title="Número de Identificación Escolar">N.I.E.</abbr></dt>
						  <dd><?php echo ($row['claveal'] != "") ? $row['claveal']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Nº Expediente</dt>
						  <dd><?php echo ($row['numeroexpediente'] != "") ? $row['numeroexpediente']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Año académico</dt>
						  <dd><?php echo ($row['c_escolar'] != "") ? $row['c_escolar']: $curso_actual; ?></dd>
						  <dt>Curso</dt>
						  <dd><?php echo ($row['curso'] != "") ? $row['curso']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Unidad</dt>
						  <dd><?php echo ($row['unidad'] != "") ? $row['unidad']: '<span class="text-muted">Sin registrar</span>'; ?></dd>
						  <dt>Repetidor/a</dt>
						  <dd><?php echo ($row['matriculas'] > 1) ? 'Sí': 'No'; ?></dd>
						</dl>
						
					</div><!-- /.col-sm-6 -->
					
				</div><!-- /.row -->
				
			</div><!-- /.col-sm-10 -->
			
		</div><!-- /.row -->
		</div><!-- /.well -->
		
		
		<div class="row">
		
			<div class="col-sm-12">
				
				<ul class="nav nav-tabs nav-justified" role="tablist">
					<?php if (!(($faltas == "" || $faltasd == "") && $todos == "") && $mod_faltas): ?>
					<?php $tab1 = 1; ?>
				  <li <?php echo ($tab1) ? 'class="active"' : ''; ?>><a href="#asistencia" role="tab" data-toggle="tab">Faltas de asistencia</a></li>
				  <?php endif; ?>
				  <?php if (!($fechorias == "" && $todos == "")): ?>
				  <?php if(!isset($tab1)) $tab2 = 1; ?>
				  <li <?php echo ($tab2) ? 'class="active"' : ''; ?>><a href="#convivencia" role="tab" data-toggle="tab">Convivencia</a></li>
				  <?php endif; ?>
				  <?php if (!($notas == "" && $todos == "")): ?>
				  <?php if(!isset($tab1) && !isset($tab2)) $tab3 = 1; ?>
				  <li <?php echo ($tab3) ? 'class="active"' : ''; ?>><a href="#evaluaciones" role="tab" data-toggle="tab">Evaluaciones</a></li>
				  <?php endif; ?>
				  <?php if (!($tutoria == "" && $todos == "")): ?>
				  <?php if(!isset($tab1) && !isset($tab2) && !isset($tab3)) $tab4 = 1; ?>
				  <li <?php echo ($tab4) ? 'class="active"' : ''; ?>><a href="#tutoria" role="tab" data-toggle="tab">Informes de tutoría</a></li>
				  <?php endif; ?>
				  <?php if (!($horarios == "" && $todos == "")): ?>
				  <?php if(!isset($tab1) && !isset($tab2) && !isset($tab3) && !isset($tab4)) $tab5 = 1; ?>
				  <li <?php echo ($tab5) ? 'class="active"' : ''; ?>><a href="#horario" role="tab" data-toggle="tab">Horario y profesores</a></li>
				  <?php endif; ?>
				  <?php if (!($act_tutoria == "" && $todos == "")): ?>
				   <?php if(!isset($tab1) && !isset($tab2) && !isset($tab3) && !isset($tab4) && !isset($tab5)) $tab6 = 1; ?>
				  <li <?php echo ($tab6) ? 'class="active"' : ''; ?>><a href="#intervenciones" role="tab" data-toggle="tab">Intervenciones</a></li>
				  <?php endif; ?>
				</ul>
				
				<div class="tab-content">
				  <div class="tab-pane <?php echo ($tab1) ? 'active' : ''; ?>" id="asistencia">
				  <?php if (!($faltas == "" && $todos == "")) include("faltas.php"); ?>
				  <?php if (!($faltasd == "" && $todos == "")) include("faltasd.php"); ?>
				  </div>
				  <div class="tab-pane <?php echo ($tab2) ? 'active' : ''; ?>" id="convivencia">
				  <?php if (!($fechorias== "" and $todos == "")) include("fechorias.php"); ?>
				  </div>
				  <div class="tab-pane <?php echo ($tab3) ? 'active' : ''; ?>" id="evaluaciones">
				  <?php if (!($notas == "" and $todos == "")) include("notas.php"); ?>
				  </div>
				  <div class="tab-pane <?php echo ($tab4) ? 'active' : ''; ?>" id="tutoria">
				  <?php if (!($tutoria== "" and $todos == "")) include("tutoria.php"); ?>
				  </div>
				  <div class="tab-pane <?php echo ($tab5) ? 'active' : ''; ?>" id="horario">
				  <?php if (!($horarios== "" and $todos == "")) include("horarios.php"); ?>
				  </div>
				  <div class="tab-pane <?php echo ($tab6) ? 'active' : ''; ?>" id="intervenciones">
				  <?php 
				  if (!($act_tutoria== "" and $todos == "")) {
				  	$tutori = $_SESSION['profi'];
				    $activ = mysql_query("select * from FTUTORES where tutor='$tutori' and unidad = '$unidad' o'");
				    
				    if (mysql_num_rows($activ) > 0 || stristr($_SESSION['cargo'],'1') == TRUE) {
				    	include("act_tutoria.php");	
				    }
				  }
				  ?>
				  </div>
				 </div>
				
			</div>
			
		</div><!-- /.row -->
		
		<br>
		
		<div class="row hidden-print">
			
			<div class="col-sm-12">
			
				<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
				<a href="cinforme.php" class="btn btn-default">Consultar otro informe</a>
			
			</div>
			
		</div>
		<?php else: ?>
		
		<h3>No hay información sobre el alumno/a en el curso seleccionado.</h3>
		
		<?php endif; ?>
	
	</div><!-- /.container -->


<?php include("../../pie.php");?>

	<script>
	$(document).ready(function() {
		var table = $('.datatable1').DataTable({
			"paging":   true,
	    "ordering": true,
	    "info":     false,
	    
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
			"order": [[ 0, "desc" ],[ 1, "asc" ]],
			
			"language": {
			            "lengthMenu": "_MENU_",
			            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
			            "info": "Página _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay resultados disponibles.",
			            "infoFiltered": "(filtrado de _MAX_ resultados)",
			            "search": "Buscar: ",
			            "paginate": {
			                  "first": "Primera",
			                  "next": "Última",
			                  "next": "",
			                  "previous": ""
			                }
			        }
		});
		
		
		var table = $('.datatable2').DataTable({
			"paging":   true,
		  "ordering": true,
		  "info":     false,
		  
			"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
			
			"order": [[ 0, "desc" ]],
			
			"language": {
			            "lengthMenu": "_MENU_",
			            "zeroRecords": "No se ha encontrado ningún resultado con ese criterio.",
			            "info": "Página _PAGE_ de _PAGES_",
			            "infoEmpty": "No hay resultados disponibles.",
			            "infoFiltered": "(filtrado de _MAX_ resultados)",
			            "search": "Buscar: ",
			            "paginate": {
			                  "first": "Primera",
			                  "next": "Última",
			                  "next": "",
			                  "previous": ""
			                }
			        }
		});
	});
	</script>

</body>
</html>
