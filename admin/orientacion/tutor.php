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


?>
<?php
include("../../menu.php");
$PLUGIN_DATATABLES = 1;
?>
<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
  <h2>Orientación <small>Intervenciones sobre los alumnos</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
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
} else{$unidad="";}

if (isset($_POST['alumno'])) {
	$alumno = $_POST['alumno'];
}   else{$alumno="";}
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
if (isset($_POST['unidad0'])) {
	$unidad0 = $_POST['unidad0'];
} else{$unidad0="";}
if (isset($_POST['prohibido'])) {
	$prohibido = $_POST['prohibido'];
}else{$prohibido="";}

if (isset($_POST['submit1'])) {
	$submit1 = $_POST['submit1'];
		include("insertar.php");
}

if ($id) {
	$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido, claveal from tutoria where id = '$id'");
	$row = mysql_fetch_array($result);
	$alumno = $row[0].", ".$row[1]." --> ".$row[10];
	$fecha0 = $row[2];
	$dia = explode("-",$fecha0);
	$fecha = "$dia[2]-$dia[1]-$dia[0]";
	$accion0 = $row[3];
	$causa = $row[4];
	$observaciones = $row[5];
	$unidad = $row[6];
	$tutor = $row[7];
	$id = $row[8];
	$prohibido = $row[9];
	$clave = $row[10];
}

if ($eliminar=="1") {
	mysql_query("delete from tutoria where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';	
}

if (isset($_POST['submit2'])) {  
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
if (isset($_POST['submit3'])) {
	$actualizar ="delete from tutoria WHERE  id = '$id2'";
	mysql_query($actualizar);
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido actualizado en la Base de datos.
</div></div><br />';	
}

?>
<div class="col-sm-7">
<legend>Registro de datos</legend>
<div class="well well-large">

<FORM action="tutor.php" method="POST" name="Tutor">

<fieldset>
<div class="row">
<div class="form-group col-md-10">
<label> Grupo </label>
<SELECT name="unidad"
	onChange="submit()" class="form-control">
	<option><? echo $unidad;?></option>
	<? unidad();?>
</SELECT> 
</div>

<div class="col-md-2">
<?    
if ($alumno) {
	$tr = explode(" --> ",$alumno);
	$al = $tr[0];
	$clave = $tr[1];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../../xml/fotos/$clave.jpg' width='120' height='145' class='img-thumbnail pull-right'  />";
	}
	else{
		echo "<i class='fa fa-user fa-5x fa-fw'></i>";
	}
}
?> 
</div>

</div>

<div class="row">
<div class="form-group col-md-7">
<label> Alumno </label>
<SELECT name=alumno onChange="submit()" class="form-control">

<?

$alumno0 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS where unidad = '$unidad' order by NC asc");
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
</select> 
</div>

<div class="form-group col-md-5" id="datetimepicker1">
<label>Fecha</label>
<?  $fecha1 = (date("d").-date("m").-date("Y")); 
if ($fecha)
{
	echo '
  <div class="input-group">
            <input name="fecha" type="text" class="form-control" value="'.$fecha.'" data-date-format="DD-MM-YYYY" id="fecha" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> ';
}
else{
	echo '
  <div class="input-group">
            <input name="fecha" type="text" class="form-control" value="" data-date-format="DD-MM-YYYY" id="fecha" >
  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div> ';
}
?>
</div>
</div>

<div class="form-group">
<label> Observaciones </label>
<textarea name='observaciones' rows='8' class='form-control'><? echo $observaciones; ?></textarea>
</div>

<div class="checkbox">
  <label class="text-danger">
    <input name="prohibido" type="checkbox" <? if ($prohibido == "1"){echo "checked";}
 ?> id="prohibido" value="1"> Informe privado </label>
</div>

  <div class="row">
  <div class="col-sm-6">
  
<div class="form-group">  
<label>Causa </label>
<select name="causa" class='form-control'>
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
</select> 
</div> 
</div>
  <div class="col-sm-6">
  
<div class="form-group">  
<label>Tipo</label>
<select name="accion[]" multiple class='form-control'>


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
</select>
</label>
</div>
</div>
</div>
</div>

<input name="id2" type="hidden" value="<? echo $id; ?>" /> <input
	name='submit1' type='submit'
	value='Registrar intervención' class='btn btn-primary'>
&nbsp; <input name='submit2' type='submit'
	value='Actualizar datos' class='btn btn-warning'>
&nbsp;<input name=submit3 type=submit
	value='Eliminar' class='btn btn-danger'>
</form>

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
<div class="well">
<h4>Historial de Intervenciones sobre <? echo $nombre." ".$apellidos." (".$unidad.")"; ?></h4><br>
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
<a href='tutor.php?id=$row[6]'><i class='fa fa-search' title='Detalles'> </i> </a>
<a href='tutor.php?id=$row[6]&eliminar=1'><i class='fa fa-trash-o </i> ' title='Borrar'></a></td></tr>";
		}while($row = mysql_fetch_array($result));
		echo "</tbody></table>";
	}
}
?>
</div>
</div>

<div class="col-sm-5">
<legend>Intervenciones del Tutor</legend>
<? include("ultimos.php");?></div>
</div>
<? include("../../pie.php");?>
	<script>  
	$(function ()  
	{ 
		$('#datetimepicker1').datetimepicker({
			language: 'es',
			pickTime: false
		})
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
