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
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];
?>
<script>
function confirmacion() {
	var answer = confirm("ATENCI�N:\n �Est�s seguro de que quieres borrar los datos? Esta acci�n es irreversible. Para borrarlo, pulsa Aceptar; de lo contrario, pulsa Cancelar.")
	if (answer){
return true;
	}
	else{
return false;
	}
}
</script>
<?php
include("../../menu.php");
$datatables_min = true;
?>
<br />
<div align="center">
<div class="page-header">
<h2>Jefatura de Estudios <small>Intervenciones sobre los alumnos</small></h2>
</div>
</div>
<?
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
elseif(isset($_POST['id'])){
	$id = $_POST['id'];
}
else{
	$id = "";
}
if (isset($_GET['eliminar'])) {
	$eliminar = $_GET['eliminar'];
}

if (isset($_POST['fecha'])) {
	$fecha = $_POST['fecha'];
} else{$fecha="";}

if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
}
elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
}
else {
	$unidad = "";
}

if (isset($_POST['alumno'])) {
	$alumno = $_POST['alumno'];
}
elseif (isset($_GET['alumno'])) {
	$alumno = $_GET['alumno'];
}
else {
	$alumno = "";
}


if (isset($_POST['observaciones'])) {
	$observaciones = $_POST['observaciones'];
} else{$observaciones="";}
if (isset($_POST['accion'])) {
	$accion = $_POST['accion'];
} else{$accion="";}
if (isset($_POST['causa'])) {
	$causa = $_POST['causa'];
} else{$causa="";}
if (isset($_POST['id2'])) {
	$id2 = $_POST['id2'];
} else{$id2="";}
if (isset($_GET['id3'])) {
	$id2 = $_GET['id3'];
} else{$id3="";}
if (isset($_POST['prohibido'])) {
	$prohibido = $_POST['prohibido'];
}else{$prohibido="";}

if ($id) {
	$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido, claveal from tutoria where id = '$id'");
	$row = mysql_fetch_array($result);
	$alumno = $row[0].", ".$row[1]." --> ".$row[10];
	$fecha0 = $row[2];
	$dia = explode("-",$fecha0);
	$fecha = "$dia[2]-$dia[1]-$dia[0]";
	$accion = $row[3];
	$causa = $row[4];
	$observaciones = $row[5];
	$unidad = $row[6];
	$tutor = $row[7];
	$id = $row[8];
	$prohibido = $row[9];
	$clave = $row[10];
}
echo $alumno;
if (isset($_POST['submit1'])) {
	include("insertar.php");
}

if (isset($_POST['submit2'])) {
	$dia = explode("-",$fecha);
	$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	$actualizar ="UPDATE  tutoria SET observaciones = '$observaciones', causa = '$causa', accion = '$accion', fecha = '$fecha2', prohibido = '$prohibido' WHERE  id = '$id2'";
	mysql_query($actualizar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido actualizado en la Base de datos.
</div></div><br />';
}

if (isset($_POST['submit3']) or $eliminar=="1") {
	$borrar ="delete from tutoria WHERE  id = '$id2' or id='$id'";
	mysql_query($borrar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';
}

?>
<div class="row-fluid">
<div class="span6 offset1"><legend align="center">Registro de datos</legend>
<div class="well well-large">
<FORM action="tutor.php" method="POST" name="Tutor"><?    
if ($alumno and !($alumno == "Todos los Alumnos")) {
	$tr = explode(" --> ",$alumno);
	$al = $tr[0];
	$clave = $tr[1];
	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../../xml/fotos/$clave.jpg' width='120' height='145' class='img-polaroid pull-right'  />";
	}
}
else{ echo "<br /><br />";}
?>
<center><label>Grupo:&nbsp; <SELECT name="unidad" onChange="submit()"
	class="input">
	<option><? echo $unidad;?></option>
	<? unidad();?>
</SELECT> </label></center>
<hr>

<label style='display: inline'>Alumno <br />
<select name="alumno" onChange="submit()" class='input-xlarge'>
<?
$alumno0 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS where unidad = '$unidad' order by NC asc");
if ($falumno = mysql_fetch_array($alumno0))
{
	?>
	<?
	echo "<OPTION>$alumno</OPTION>";
	echo "<option>Todos los Alumnos</option>";
	?>
	<?
	do {
		echo "<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>";

	} while($falumno = mysql_fetch_array($alumno0));
}
?>
</select> </label> <label>Fecha<br />
<?  $fecha1 = date("d-m-Y");
if ($fecha)
{
	echo '
  <div class="input-append" >
            <input name="fecha" type="text" class="input input-block-level" value="'.$fecha.'" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="fa fa-calendar"></i></span>
</div> ';
}
else{
	echo '
  <div class="input-append" >
            <input name="fecha" type="text" class="input input-block-level" value="'.$fecha1.'" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="fa fa-calendar"></i></span>
</div> ';
}
?> </label>


<hr>

<label> Observaciones<br />
<textarea name='observaciones' rows='8' class='input-block-level'><? echo $observaciones; ?></textarea>
</label> <br>
<label class="checkbox" style="color: #9d261d">Informe privado <input
	name="prohibido" type="checkbox"
	<? if ($prohibido == "1"){echo "checked";}
	?> id="prohibido" value="1"> </label>
<hr>
<div class="row-fluid">
<div class="span6"><label>Causa <br />
<select name="causa" class="input-xlarge">
	<option><? echo $causa; ?></option>
	<option>Estado general del Alumno</option>
	<option>Evoluci&oacute;n acad&eacute;mica</option>
	<option>Faltas de Asistencia</option>
	<option>Problemas de convivencia</option>
	<option>Llamada por Enfermedad</option>
	<option>Robo, hurto</option>
	<option>Otras</option>
</select> </label></div>
<div class="span6"><label> Tipo<br />
<select name="accion" class="input-xlarge">
	<option><? echo $accion; ?></option>
	<option>Entrevista telef&oacute;nica</option>
	<option>Entrevista personal</option>
	<option>Comunicaci&oacute;n por escrito</option>
</select> </label></div>
</div>
<br />
<input name="id2" type="hidden" value="<? echo $id; ?>" /> <input
	name="unidad0" type="hidden" value="<? echo $unidad; ?>" />
<div align="center"><input name='submit1' type='submit'
	value='Registrar intervenci�n' class='btn btn-primary'> &nbsp; <input
	name='submit2' type='submit' value='Actualizar datos'
	class='btn btn-warning'> &nbsp; <input name=submit3 type=submit
	value='Eliminar' class='btn btn-danger'></div>
</FORM>
</div>
	<?
	if($alumno){
		$tr = explode(" --> ",$alumno);
		$al = $tr[0];
		$clave = $tr[1];
		$trozos = explode (", ", $al);
		$apellidos = $trozos[0];
		$nombre = $trozos[1];
		?>
<hr>
<h4 align="center">Intervenciones sobre <br />
		<? echo $nombre." ".$apellidos." (".$unidad.")"; ?></h4>
<br />
		<?

		$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, id from tutoria where claveal = '$clave' order by fecha");
		if ($row = mysql_fetch_array($result))
		{
			echo '<table class="table table-striped">';
			echo "<thead><tr><th>Fecha</th><th>Clase</th><th>Causa</th><th></th></tr></thead><tbody>";
			do{
				$obs=substr($row[5],0,80)."...";
				$dia3 = explode("-",$row[2]);
				$fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
				echo "<tr><td>$fecha3</td><td>$row[3]</a></td><td>$row[4]</a></td><td >
<a href='tutor.php?id=$row[6]'><i class='fa fa-search' title='Detalles'> </i> </a>
<a href='tutor.php?id=$row[6]&eliminar=1' title='Borrar'><i class='fa fa-trash-o' onClick='return confirmacion();'> </i></a>
</td></tr>";
			}while($row = mysql_fetch_array($result));
			echo "</table>";
		}
	}
	?></div>
<div class="span4"><legend align="center">Registro de Intervenciones</legend>
	<? include("ultimos.php");?></div>
</div>
	<? include("../../pie.php");?>
<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});
</script>
</BODY>
</HTML>
