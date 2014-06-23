<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<script>
function confirmacion() {
	var answer = confirm("ATENCIÓN:\n ¿Estás seguro de que quieres borrar los datos? Esta acción es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?
include("../../menu.php");
$datatables_activado = true;

if (isset($_GET['borrar'])) {$borrar = $_GET['borrar'];}elseif (isset($_POST['borrar'])) {$borrar = $_POST['borrar'];}else{$borrar="";}
if (isset($_GET['submit2'])) {$submit2 = $_GET['submit2'];}elseif (isset($_POST['submit2'])) {$submit2 = $_POST['submit2'];}else{$submit2="";}
if (isset($_GET['inicio'])) {$inicio = $_GET['inicio'];}elseif (isset($_POST['inicio'])) {$inicio = $_POST['inicio'];}else{$inicio="";}
if (isset($_GET['fin'])) {$fin = $_GET['fin'];}elseif (isset($_POST['fin'])) {$fin = $_POST['fin'];}else{$fin="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['tareas'])) {$tareas = $_GET['tareas'];}elseif (isset($_POST['tareas'])) {$tareas = $_POST['tareas'];}else{$tareas="";}
if (isset($_GET['horas'])) {$horas = $_GET['horas'];}elseif (isset($_POST['horas'])) {$horas = $_POST['horas'];}else{$horas="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['pra'])) {$pra = $_GET['pra'];}elseif (isset($_POST['pra'])) {$pra = $_POST['pra'];}else{$pra="";}

?>
<br />
<div align=center>
<div class="page-header" align="center">
<h2>Ausencias del profesorado <small> Registro de bajas <? echo $profesor;?></small></h2>
</div>

<?
     $result = mysql_query("SHOW COLUMNS FROM ausencias"); 
   
      $fieldnames=array(); 
      if (mysql_num_rows($result) > 0) { 
        while ($row = mysql_fetch_assoc($result)) { 
          $fieldnames[] = $row['Field']; 
        } 
           if ($fieldnames[7] == "archivo") {  }
           else{
           	mysql_query("ALTER TABLE  `ausencias` ADD  `archivo` VARCHAR( 186 ) NOT NULL");
           } 
      } 

      
if ($borrar == '1') {
	$del = mysql_query("delete from ausencias where id = '$id'");
	echo '
<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han borrado correctamente.
          </div></div>';
}
if ($submit2) {
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
			echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente.
          </div></div>';			
		}
			else{
			if ($HTTP_POST_FILES['userfile']['name']<>''){
				$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
				$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
				$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];
				#esta es la extension
				if (move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], "./archivos/".$nombre_archivo)){}
				else{
					echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Atención:</strong><br />Ha ocurrido un error al subir el aechivo. Busca ayuda.
          </div></div>';
				}
				}
				$inserta = mysql_query("insert into ausencias VALUES ('', '$profesor', '$inicio1', '$fin1', '$horas', '$tareas', NOW(), '$nombre_archivo')");
				echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han registrado correctamente.
          </div></div>';		
			}
			
	}
	else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<legend>ATENCIÓN:</legend>
No se pueden procesar los datos. Has dejado campos vacíos en el formulario que es necesario rellenar. Vuelve atrás e inténtalo de nuevo.
          </div></div>';

		exit();
	}
}
?>
<div class='container'>
<div class="row-fluid">
<div class="span5">
<div align='center'>
<legend>Registro de Bajas</legend>
</div>
<br />
<div class="well well-large">
<form enctype='multipart/form-data' action='index.php' method='post'
	name='f1' class="form-vertical">
<div align='left'><label>Profesor:<br />
<?
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
	echo "<SELECT class='input-xlarge' name='profesor' id='idprofe'>";
	if ($profesor) {
		echo "<OPTION>$profesor</OPTION>";
	}
	else{
		echo "<OPTION></OPTION>";
	}
	$profe = mysql_query("SELECT distinct profesor FROM profesores order by profesor asc");
	while($filaprofe = mysql_fetch_array($profe)) {
		echo "<OPTION id='idopcion'>$filaprofe[0]</OPTION>";
	}
	echo "</select>";

	$fecha = (date("d").-date("m").-date("Y"));
	$comienzo=explode("-",$inicio_curso);
	$comienzo_curso=$comienzo[2]."-".$comienzo[1]."-".$comienzo[0];
	$fecha2 = date("m");
	?> </select> </label> <?
}
else{
	$profesor = $_SESSION['profi'];
	echo "<input name='profesor' value='$profesor' readonly type='text' class='input-xlarge' class='disabled' />";
	echo "</label>";
}
?>
<hr>
<label>Comienzo de la ausencia<br />
<div class="input-append" style="display: inline;"><input name="inicio"
	type="text" class="input input-small"
	<? if($inicio){echo "value=$inicio";}?> data-date-format="dd-mm-yyyy"
	id="inicio"> <span class="add-on"><i class="fa fa-calendar"></i></span>
</div>
</label> 
<br />
<label>Final de la ausencia<br />
<div class="input-append" style="display: inline;"><input name="fin"
	type="text" class="input input-small" <? if($fin){echo "value=$fin";}?>
	data-date-format="dd-mm-yyyy" id="fin"> <span class="add-on"><i
	class="fa fa-calendar"></i></span></div>
</label>
<hr>
<label>Horas sueltas <i class="fa fa-question-circle"
	style="margin-left: 2px;" rel='tooltip'
	title='Escribe las horas concretas en las que vas a estar ausente y una detrás de otra. De este modo, si escribes "456" quieres decir que vas a faltas a 4ª, 5ª y 6ª hora del día.'></i><br />
<input type="text" name="horas" value="" class="input-small" /> </label>
<label>Tareas para los alumnos<br />
<textarea name='tareas'style="width:95%; height:100px"></textarea>
</label>
<hr>
<label class="file">Adjuntar archivo con tareas<br />
<input name="userfile" type="file"> </label>
<p class="block-help text-warning">* Sólo se puede adjuntar un archivo. Si queréis adjuntar múltiples archivos, debéis comprimirlos en uno sólo. El tamaño máximo permitido es de <?php echo ini_get('post_max_size'); ?>b.</p>
<hr>
<button name="submit2" type="submit" id="submit2"
	value='Registrar datos' class="btn btn-primary">Registrar datos</button>
</div>

</div>
</div>
<div class="span7"><?
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
			echo "<td><a href='index.php?borrar=1&id=$row[3]&profesor=$profesor'><i class='fa fa-trash-o' title='Borrar baja' onClick='return confirmacion();' /> </i> </a></td>";
		}
		echo "</tr>";
	}
	echo "</tbody></table><hr><br />";
}
?>
</form>
<?
if (empty($pra)) {}else{
	echo '<a name="aqui" id="aqui"></a>';
	$pr_trozos=explode(", ",$pra);
	echo "
<div align='center'><legend>Bajas del Profesor/a $pr_trozos[1] $pr_trozos[0]</legend></div><br />";
	echo "<table class='table table-striped' style='width:100%;' align='center'>";
	echo "<thead><tr>
		<th>Profesor</th>
		<th>Inicio</th>
		<th>Fin</th>
		<th>Horas</th>
		<th>Tareas</th>
		<th></th>";
	echo "</tr></thead><tbody>";
	// Consulta de datos del alumno.
	$result = mysql_query ( "select inicio, fin, tareas, id, profesor, horas from ausencias  where profesor = '$pra' order by fin asc" );

	while ( $row = mysql_fetch_array ( $result ) ) {
		$tr='';
		if ($row[5] == '0') {$horas2 = '';}else{$horas2 = $row[5];}
		if (strlen($row[2]) > '0') {
			$tr = 'Sí';
		}
		echo "<tr>
	<td nowrap><a href='#'>$row[4]</a></td>
	<td nowrap>$row[0]</td>
	<td>$row[1]</td>
	<td>$horas2</td>
	<td>$tr</td>";		
		if(stristr($_SESSION['cargo'],'1') == TRUE)
		{
			echo "<td><a href='index.php?borrar=1&id=$row[3]&profesor=$profesor'><i class='fa fa-trash-o' title='Borrar' onClick='return confirmacion();' /> </i> </a></td>";
		}
		echo "</tr>";
	}
	echo "</tbody></table><hr><br />";
}
?> <?
echo "<div align='center'><legend>Últimas Bajas de Profesores</legend></div><br />";
echo "<table class='table table-striped tabladatos' style='width:100%;' align='center'>";
echo "<thead><tr>
		<th>Profesor</td>
		<th>Inicio</td>
		<th>Fin</td>
		<th>Horas</td>
		<th>Tareas</td>";
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
	echo "<th></th>";
}
echo "</tr></thead><tbody>";
// Consulta de datos del profesor.
$result = mysql_query ( "select  inicio, fin, tareas, id, profesor, horas from ausencias order by fin desc limit 50" );

while ( $row = mysql_fetch_array ( $result ) ) {
	$tr='';
	if ($row[5] == '0') {$horas2 = '';}else{$horas2 = $row[5];}
	if (strlen($row[2]) > '0') {
		$tr = 'Sí';
	}
	echo "<tr>
	<td nowrap><a href='index.php?pra=$row[4]#aqui'>$row[4]</a></td>
	<td nowrap>$row[0]</td>
	<td nowrap>$row[1]</td>
	<td width='55'>$horas2</td>
	<td width='60'>$tr</td>";		
	if(stristr($_SESSION['cargo'],'1') == TRUE)
	{
		echo "<td><a href='index.php?borrar=1&id=$row[3]&profesor=$profesor'><i class='fa fa-trash-o' title='Borrar' onClick='return confirmacion();' /> </i> </a></td>";
	}
	echo "</tr>";
}
echo "</tbody></table>";

echo "<br /><br /><div align='center'><p class='help-block' style='width:60%;text-align:left'>* Si quieres ver las ausencias de un profesor a lo largo del Curso Escolar, haz click sobre su nombre y sus ausencias aparecerán en una tabla más abajo.</p></div>"
;	?></div>
</div>
</div>

<?php
include("../../pie.php");
?> <script>
	$(function ()  
	{ 
		$('#inicio').datepicker()
		.on('changeDate', function(ev){
			$('#inicio').datepicker('hide');
		});
		});  
	</script> <script>  
	$(function ()  
	{ 
		$('#fin').datepicker()
		.on('changeDate', function(ev){
			$('#fin').datepicker('hide');
		});
		});  
	</script>
</body>
</html>