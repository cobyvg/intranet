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


if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['submit2'])) {$submit2 = $_GET['submit2'];}elseif (isset($_POST['submit2'])) {$submit2 = $_POST['submit2'];}else{$submit2="";}
if (isset($_GET['inicio'])) {$inicio = $_GET['inicio'];}elseif (isset($_POST['inicio'])) {$inicio = $_POST['inicio'];}else{$inicio="";}
if (isset($_GET['fin'])) {$fin = $_GET['fin'];}elseif (isset($_POST['fin'])) {$fin = $_POST['fin'];}else{$fin="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['tareas'])) {$tareas = $_GET['tareas'];}elseif (isset($_POST['tareas'])) {$tareas = $_POST['tareas'];}else{$tareas="";}
if (isset($_GET['horas'])) {$horas = $_GET['horas'];}elseif (isset($_POST['horas'])) {$horas = $_POST['horas'];}else{$horas="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['pra'])) {$pra = $_GET['pra'];}elseif (isset($_POST['pra'])) {$pra = $_POST['pra'];}else{$pra="";}



$result = mysql_query("SHOW COLUMNS FROM ausencias"); 

$fieldnames=array(); 
if (mysql_num_rows($result) > 0) { 
	while ($row = mysql_fetch_assoc($result)) { 
	 $fieldnames[] = $row['Field']; 
	} 
  if ($fieldnames[7] != "archivo") {
  	mysql_query("ALTER TABLE  `ausencias` ADD  `archivo` VARCHAR( 186 ) NOT NULL");
  } 
} 


$PLUGIN_DATATABLES = 1;

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Ausencias del profesorado <small>Registro de ausencias <?php echo (isset($profesor)) ? $profesor : ''; ?></small></h2>
	</div>

<?php 
if ($borrar == '1') {
	$del = mysql_query("delete from ausencias where id = '$id'");
	echo '
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	Los datos se han borrado correctamente.
</div>';
}
if (isset($_POST['submit2'])) {
	// Cambiamos fecha
	$fech1=explode("-",$inicio);
	$fech2=explode("-",$fin);
	$inicio1 = "$fech1[2]-$fech1[1]-$fech1[0]";
	$fin1 = "$fech2[2]-$fech2[1]-$fech2[0]";
	// Comprobamos datos enviados
	if ($profesor and $inicio and $fin) {
		$ya = mysql_query("select * from ausencias where profesor = '$profesor' and inicio = '$inicio1' and fin = '$fin1'");
		if (mysql_num_rows($ya) > '0') {
			$ya_hay = mysql_fetch_array($ya);
			$actualiza = mysql_query("update ausencias set tareas = '$tareas', horas = '$horas' where id = '$ya_hay[0]'");
			echo '<div align="center"><div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente.
          </div></div>';			
		}
			else{
			if ($_FILES['userfile']['name']<>''){
				$nombre_archivo = $_FILES['userfile']['name'];
				$tipo_archivo = $_FILES['userfile']['type'];
				$tamano_archivo = $_FILES['userfile']['size'];
				#esta es la extension
				if (move_uploaded_file($_FILES['userfile']['tmp_name'], "./archivos/".$nombre_archivo)){}
				else{
					echo '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />Ha ocurrido un error al subir el aechivo. Busca ayuda.
          </div>';
				}
				}
				$inserta = mysql_query("insert into ausencias VALUES ('', '$profesor', '$inicio1', '$fin1', '$horas', '$tareas', NOW(), '$nombre_archivo')");
				echo '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han registrado correctamente.
          </div>';		
			}
			
	}
	else{
		echo '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No se pueden procesar los datos. Has dejado campos vacíos en el formulario que es necesario rellenar. Vuelve atrás e inténtalo de nuevo.
          </div>';

		exit();
	}
}
?>
	
	<!-- SCAFFOLDING -->
	<div class="row">
		
		<div class="col-sm-5">
			
			<legend>Registro de ausencias</legend>
			
			<div class="well well-large">

			<form method="post" action="" enctype="multipart/form-data">
				
				<div class="form-group">
					<label for="profesor">Profesor/a</label>
					<?
					if(stristr($_SESSION['cargo'],'1') == TRUE)
					{
						echo "<select class='form-control' id='profesor' name='profesor'>";
						if ($profesor) {
							echo "<option>$profesor</option>";
						}
						else{
							echo "<option></option>";
						}
						$profe = mysql_query("SELECT distinct profesor FROM profesores order by profesor asc");
						while($filaprofe = mysql_fetch_array($profe)) {
							echo "<option>$filaprofe[0]</option>";
						}
						echo "</select>";
					
						$fecha = (date("d").-date("m").-date("Y"));
						$comienzo=explode("-",$inicio_curso);
						$comienzo_curso=$comienzo[2]."-".$comienzo[1]."-".$comienzo[0];
						$fecha2 = date("m");
						?> </select> <?
					}
					else{
						$profesor = $_SESSION['profi'];
						echo '<input type="text" class="form-control" name="profesor" value="'.$profesor.'" readonly>';
					}
					?>
				</div>
				
				<div class="row">
				
					<div class="col-sm-6">
					
						<div class="form-group" id="datimepicker1">
							<label for="inicio">Inicio de la ausencia</label>
							<div class="input-group">
								<input type="text" class="form-control" id="inicio" name="inicio" value="<? echo (isset($inicio) && $inicio) ? $inicio : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY">
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					
					</div>
					
					<div class="col-sm-6">
					
						<div class="form-group" id="datimepicker2">
							<label for="inicio">Fin de la ausencia</label>
							<div class="input-group">
								<input type="text" class="form-control" id="fin" name="fin" value="<? echo (isset($fin) && $fin) ? $fin : date('d-m-Y'); ?>" data-date-format="DD-MM-YYYY">
								<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
							</div>
						</div>
					
					</div>
					
				</div>
				
				<div class="form-group">
					<label for="horas">Horas sueltas <span class="fa fa-question-circle fa-fw" rel="tooltip" title="Escribe las horas concretas en las que vas a estar ausente y una detrás de otra. De este modo, si escribes '456' quieres decir que vas a faltas a 4ª, 5ª y 6ª hora del día."></span></label>
					<input type="text" class="form-control" id="horas" name="horas" value="<? echo (isset($horas) && $horas) ? $horas : ''; ?>">
				</div>
				
				<div class="form-group">
					<label for="tareas">Tareas para los alumnos</label>
					<textarea class="form-control" id="tareas" name="tareas" rows="6"></textarea>
				</div>
				
				<div class="form-group">
					<label for="userfile">Adjuntar archivo con tareas</label>
					<input type="file" id="userfile" name="userfile">
					<br>
					<p class="block-help">Para adjuntar múltiples archivos es necesario comprimirlos en uno solo. El tamaño máximo permitido es de <?php echo ini_get('post_max_size'); ?>b.</p>
				</div>

				<button type="submit" class="btn btn-primary" name="submit2">Registrar</button>
				<button type="reset" class="btn btn-default">Cancelar</button>
				
			</form>
			
			</div>

		</div>
		
		
		<div class="col-sm-7">
		<?
if ($profesor) {
	echo "<div align='center'><legend>Bajas del Profesor en este Curso.</legend></div><br />";
	echo "<table class='table table-striped' style='width:100%;' align='center'>
";
	echo "<thead><tr>
		<th>Inicio</td>
		<th>Fin</th>
		<th>Horas</th>
		<th>Tareas</th>
		";
	if(stristr($_SESSION['cargo'],'1') == TRUE)
	{
		echo "<th></th>";
	}
	echo "</tr></thead><tbody>";
	// Consulta de datos del alumno.
	$result = mysql_query ( "select inicio, fin, tareas, id, horas from ausencias where profesor = '$profesor' order by fin desc" );
	while ( $row = mysql_fetch_array ( $result ) ) {
		$tr='';
		if ($row[4] == '0') {$horas1 = '';}else{$horas1 = $row[4];}
		if (strlen($row[2]) > '0') {$tr = 'Sí';}
		echo "<tr>
	<td nowrap>$row[0]</td>
	<td>$row[1]</td>
	<td>$horas1</td>
	<td>$tr</td>";

		if(stristr($_SESSION['cargo'],'1') == TRUE)
		{
			echo "<td><a href='index.php?borrar=1&id=$row[3]&profesor=$profesor' data-bb='confirm-delete'><i class='fa fa-trash-o fa-fw fa-lg' title='Borrar baja'  /> </i> </a></td>";
		}
		echo "</tr>";
	}
	echo "</tbody></table><hr><br />";
}
?>
</form>

			<legend>Historial de ausencias</legend>
			
			<div class="table-responsive">
				<table class="table table-striped table-hover datatable">
					<thead>
						<tr>
							<th>Profesor</th>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Horas</th>
							<th>Tareas</th>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<th>&nbsp;</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysql_query("SELECT inicio, fin, tareas, id, profesor, horas FROM ausencias ORDER BY fin DESC LIMIT 50"); ?>
						<?php while ($row = mysql_fetch_array($result)): ?>
						<tr>
							<td nowrap><a href='index.php?pra=<?php echo $row['profesor']; ?>#history'><?php echo $row['profesor']; ?></a></td>
							<td nowrap><?php echo $row['inicio']; ?></td>
							<td nowrap><?php echo $row['fin']; ?></td>
							<td><?php echo ($row['horas'] != '0') ? $row['horas'] : ''; ?></td>
							<td><?php echo (strlen($row['tareas']) > 0) ? 'Sí' : 'No'; ?></td>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<td>
								<a href="index.php?borrar=1&id=<?php echo $row['id']; ?>&profesor=<?php echo $profesor; ?>" data-bb='confirm-delete'>
									<span class="fa fa-trash-o fa-fw fa-lg" rel="tooltip" title="Borrar"></span>
								</a>
							</td>
							<?php endif; ?>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

		</div><!-- /.col-sm-7 -->
		
	</div><!-- /.row -->
	
	
	<?php if (isset($profesor) && !empty($profesor)): ?>
	<div class="row">
		
		<div class="col-sm-12">
			<?php $exp_profesor = explode(", ", $profesor); ?>
			<?php $nomprof = $exp_profesor[1].' '.$exp_profesor[0]; ?>
			
			<a name="history"></a>
			<legend>Historial de ausencias de <?php echo $nomprof; ?></legend>
			
			<div class="table-responsive">
				<table class="table table-striped table-hover datatable">
					<thead>
						<tr>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Horas</th>
							<th>Tareas</th>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<th>&nbsp;</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysql_query("SELECT inicio, fin, tareas, id, profesor, horas FROM ausencias WHERE profesor = '$profesor' ORDER BY fin ASC"); ?>
						<?php while ($row = mysql_fetch_array($result)): ?>
						<tr>
							<td nowrap><?php echo $row['inicio']; ?></td>
							<td nowrap><?php echo $row['fin']; ?></td>
							<td><?php echo ($row['horas'] != '0') ? $row['horas'] : ''; ?></td>
							<td><?php echo (strlen($row['tareas']) > 0) ? 'Sí' : 'No'; ?></td>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<td>
								<a href="index.php?borrar=1&id=<?php echo $row['id']; ?>&profesor=<?php echo $profesor; ?>" data-bb='confirm-delete'>
									<span class="fa fa-trash-o fa-fw fa-lg" rel="tooltip" title="Borrar"></span>
								</a>
							</td>
							<?php endif; ?>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

		</div><!-- /.col-sm-12 -->
				
	</div><!-- /.row -->
	<?php endif; ?>
	
	<?php if (isset($pra) && !empty($pra)): ?>
	<div class="row">
		
		<div class="col-sm-12">
			<?php $exp_profesor = explode(", ", $pra); ?>
			<?php $nomprof = $exp_profesor[1].' '.$exp_profesor[0]; ?>
			
			<a name="history"></a>
			<legend>Historial de ausencias de <?php echo $nomprof; ?></legend>
			
			<div class="table-responsive">
				<table class="table table-striped table-hover datatable">
					<thead>
						<tr>
							<th>Inicio</th>
							<th>Fin</th>
							<th>Horas</th>
							<th>Tareas</th>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<th>&nbsp;</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $result = mysql_query("SELECT inicio, fin, tareas, id, profesor, horas FROM ausencias WHERE profesor = '$pra' ORDER BY fin ASC"); ?>
						<?php while ($row = mysql_fetch_array($result)): ?>
						<tr>
							<td nowrap><?php echo $row['inicio']; ?></td>
							<td nowrap><?php echo $row['fin']; ?></td>
							<td><?php echo ($row['horas'] != '0') ? $row['horas'] : ''; ?></td>
							<td><?php echo (strlen($row['tareas']) > 0) ? 'Sí' : 'No'; ?></td>
							<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
							<td>
								<a href="index.php?borrar=1&id=<?php echo $row['id']; ?>&profesor=<?php echo $profesor; ?>" data-bb='confirm-delete'>
									<span class="fa fa-trash-o fa-fw fa-lg" rel="tooltip" title="Borrar"></span>
								</a>
							</td>
							<?php endif; ?>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>

		</div><!-- /.col-sm-12 -->
				
	</div><!-- /.row -->
	<?php endif; ?>
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?> 

	<script>  
	$(function ()  
	{ 
		$('#datimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		});
		
		$('#datimepicker2').datetimepicker({
			language: 'es',
			pickTime: false
		});
	});  
	</script>
	
	<script>
	$(document).ready(function() {
	  var table = $('.datatable').DataTable({
	  		"paging":   true,
	      "ordering": true,
	      "info":     false,
	      
	  		"lengthMenu": [[15, 35, 50, -1], [15, 35, 50, "Todos"]],
	  		
	  		"order": [[ 1, "desc" ]],
	  		
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
