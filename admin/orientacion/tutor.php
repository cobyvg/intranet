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
<?php
include("../../menu.php");
$datatables_activado = true;
?>
<div align="center">
<div class="page-header" style="margin-top:-15px;">
  <h1>Orientación <small>Intervenciones sobre los alumnos</small></h1>
</div>
<br />
</div>
<?
$campo= mysql_query("select * from tutoria");
if (!(mysql_field_name($campo,1) == 'claveal')) {
	mysql_query(" ALTER TABLE `tutoria` ADD `claveal` VARCHAR( 12 ) NOT NULL AFTER `id`");
}

if ($id) {
	$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, nivel, grupo, tutor, id, prohibido, claveal from tutoria where id = '$id'");
	$row = mysql_fetch_array($result);
	$alumno = $row[0].", ".$row[1]." --> ".$row[11];
	$fecha0 = $row[2];
	$dia = explode("-",$fecha0);
	$fecha = "$dia[2]-$dia[1]-$dia[0]";
	$accion0 = $row[3];
	$causa = $row[4];
	$observaciones = $row[5];
	$nivel = $row[6];
	$grupo = $row[7];
	$tutor = $row[8];
	$id = $row[9];
	$prohibido = $row[10];
	$clave = $row[11];
}

if ($eliminar=="1") {
	mysql_query("delete from tutoria where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';	
}

if ($submit1 == "Registrar intervencion de Orientación") {
	include("insertar.php");
}
if($submit2){
	foreach($accion as $tipos)
	{
		$completo .= $tipos."; ";
	}
	$dia = explode("-",$fecha);
	$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	$actualizar ="UPDATE  tutoria SET observaciones = '$observaciones', causa = '$causa', accion = '$completo', fecha = '$fecha2', prohibido = '$prohibido' WHERE  id = '$id2'";
	//echo $actualizar;
	mysql_query($actualizar);
}
if($submit3){
	$actualizar ="delete from tutoria WHERE  id = '$id2'";
	mysql_query($actualizar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido actualizado en la Base de datos.
</div></div><br />';	
}

?>
<div class="row-fluid">
<div class="span1"></div>
<div class="span5">
<h3 align="center">Registro de datos</h3>
<br />
<div class="well-2 well-large">

<FORM action="tutor.php" method="POST" name="Tutor"><?    
if ($alumno) {
	$tr = explode(" --> ",$alumno);
	$al = $tr[0];
	$clave = $tr[1];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../../xml/fotos/$clave.jpg' border='2'
width='120' height='145' style='margin:4px;border:1px solid #bbb;float:right;' />";
	}
}
?> <label style="display: inline;"> Nivel <SELECT name="nivel"
	onChange="submit()" class="input-mini">
	<option><? echo $nivel;?></option>
	<? nivel();?>
</SELECT> </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label
	style="display: inline;"> Grupo <SELECT name="grupo"
	onChange="submit()" class="input-mini">
	<OPTION><? echo $grupo;?></OPTION>
	<? grupo($nivel);?>
</SELECT> </label>
<hr>

<label> Alumno:<br />
<SELECT name=alumno onChange="submit()" class="input-xlarge">

<?

$alumno0 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS where nivel = '$nivel' and grupo = '$grupo' order by NC asc");
if ($falumno = mysql_fetch_array($alumno0))
{
	?>
	<?
	echo "<OPTION>$alumno</OPTION>"; ?>
	<?
	do {
		echo "<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>";

	} while($falumno = mysql_fetch_array($alumno0));
}
?>
</select> </label>

<hr>

<label> Fecha <?  $fecha1 = (date("d").-date("m").-date("Y")); 
if ($fecha)
{
	echo '
  <div class="input-append" >
            <input name="fecha" type="text" class="input input-small" value="'.$fecha.'" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> ';
}
else{
	echo '
  <div class="input-append" >
            <input name="fecha" type="text" class="input input-small" value="" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="icon-calendar"></i></span>
</div> ';
}
?> </label>
<hr>
<label> Observaciones<br />
<textarea name='observaciones' rows='8' class='input-xxlarge'><? echo $observaciones; ?></textarea>
</label>

<div style="height: 18px; margin-top: 18px;"><span
	style="padding-bottom: 2px; vertical-align: top; color: brown; font-weight: bold;">Informe
Privado: </span> <input name="prohibido" type="checkbox"
<? if ($prohibido == "1"){echo "checked";}
?> id="prohibido" value="1"
	style="margin: 0px; margin-bottom: 10px; padding: 0px;"></div>
<hr>
<div class="span6"><label>Causa de la Intervenci&oacute;n:<br />
<select name="causa" class='input-large'>
	<option><? echo $causa; ?></option>
	<option>Orientación académica y profesional</option>
	<option>Evoluci&oacute;n acad&eacute;mica</option>
	<option>T&eacute;cnicas de estudio</option>
	<option>Problemas de convivencia</option>
	<option>Dificultades de integraci&oacute;n</option>
	<option>Problemas familiares, personales</option>
	<option>Dificultades de Aprendizaje</option>
	<option>Faltas de Asistencia</option>
	<option>Otras</option>
</select> </label> <label style='display: inline'></div>
<div style='display: inline'>Tipo de Intervenci&oacute;n: <br>
<select name="accion[]" multiple class='input-large'>


<?
$opcion = array(   'Entrevista con el Alumno',
		      'Entrevista personal con la Familia',
                          'Entrevista con el Equipo Educativo',
                          'Entrevista telefónica con la familia',
                          'Derivación a Servicios Sociales',
                          'Derivación a Asistencia médica',
                          'Derivación a Asistencia psicológica ',
                          'Contacto con Servicios Sociales',
                          'Contacto con Equipo de Tratamiento Familiar',
                          'Contacto con Del. de Juventud ',
                          'Contacto con EOE');
foreach ($opcion as $opc)
{
	$sel = "";
	if (!(strstr($accion0,$opc) == FALSE)) {
		$sel = "selected";
	}
	echo "<option $sel>$opc</option>";
}
?>
</select></div>
</label>
<hr>
<input name="id2" type="hidden" value="<? echo $id; ?>" /> <input
	name='submit1' type='submit'
	value='Registrar intervencion de Orientación' class='btn btn-primary'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name='submit2' type='submit'
	value='Actualizar datos' class='btn btn-warning'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name=submit3 type=submit
	value='Eliminar' class='btn btn-danger'></form>
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
	<? echo $nombre." ".$apellidos." (".$nivel."-".$grupo.")"; ?></h4>
<br />
	<?

	$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, id from tutoria where claveal='$clave' and accion not like '%SMS' order by fecha");
	if ($row = mysql_fetch_array($result))
	{
		echo '<table class="table table-striped">';
		echo "<thead><tr><th>Fecha</th><th>Clase</th><th>Causa</th><th></th></tr></thead><tbody>";
		do{
			$obs=substr($row[5],0,80)."...";
			$dia3 = explode("-",$row[2]);
			$fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
			echo "<tr><td>$fecha3</td><td>$row[3]</td><td>$row[4]</a></td><td >
<a href='tutor.php?id=$row[6]'><i class='icon icon-search' title='Detalles'> </i> </a>
<a href='tutor.php?id=$row[6]&eliminar=1'><i class='icon icon-trash </i> ' title='Borrar'></a></td></tr>";
		}while($row = mysql_fetch_array($result));
		echo "</tbody></table>";
	}
}
?></div>
<div class="span5">
<h3 align="center">Intervenciones del Tutor</h3>
<br />
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
