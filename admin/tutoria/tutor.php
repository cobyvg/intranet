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
<?php
include("../../menu.php");
include("menu.php");
$datatables_activado = true;

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
if (isset($_POST['unidad0'])) {
	$unidad0 = $_POST['unidad0'];
} else{$unidad0="";}

if (isset($_POST['prohibido'])) {
	$prohibido = $_POST['prohibido'];
}else{$prohibido="";}

if ($id) {
$alumno = "";
$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, tutoria.unidad, FTUTORES.tutor, id, prohibido, orienta, jefatura, claveal from tutoria, FTUTORES where tutoria.unidad = FTUTORES.unidad and id = '$id'");
$row = mysql_fetch_array($result);
$alumno = $row[0].", ".$row[1]." --> ".$row[12];
$apellidos = $row[0];
$nombre = $row[1];
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
$orientacion = $row[10];
$jefatura = $row[11];
$clave = $row[12];
  }
?>
<div align="center">
<div class="page-header" align="center">
  <h2>Página del tutor <small> Diario del Tutor ( <?  echo $unidad; ?> )</small></h2>
</div>
<? 

if ($eliminar=="1") {
	mysql_query("delete from tutoria where id='$id'");
echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El registro ha sido borrado en la Base de datos.
</div></div><br />';		
}

if (isset($_POST['submit1'])) {
		include("insertar.php");
}
  if (isset($_POST['submit2'])) {
  $dia = explode("-",$fecha);
  $fecha2 = "$dia[2]-$dia[1]-$dia[0]";
  	$actualizar ="UPDATE  tutoria SET observaciones = '$observaciones', causa = '$causa', accion = '$accion', fecha = '$fecha2' WHERE  id = '$id2'"; 
	//echo $actualizar;
	mysql_query($actualizar);
  }
  if($orientacion == '1')
{
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El Departamento de Orientacion ha registrado esta Acción Tutorial
</div></div><br />';
} 
if ($accion == "Registro de Jefatura de Estudios") {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
La Jefatura de Estudios ha registrado esta Acción Tutorial
</div></div><br />';
}
if ($jefatura == '1') {
echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
La Jefatura de Estudios ha registrado esta Acción Tutorial
</div></div><br />';
}
?>
<div class="container-fluid">
<div class="row-fluid">
  <div class="span1"></div>
  <div class="span6">
    <legend align="center">Registro de datos</legend>
    <div class="well well-large" align="left">
      <form action="tutor.php" method="POST" name="Tutor">
           <?    
          if ($alumno and !($alumno == "Todos los Alumnos")) {
$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<img src='../../xml/fotos/$clave.jpg' width='100' height='125' class='img-polaroid pull-right'  />";

	}           	
           } 
		   else{ echo "<br /><br />";}   	 
?>
        <label>Alumno<br />
          <select name="alumno" onChange="submit()"  class='input-xlarge'>
            <option><? echo $alumno; ?></option>
            <option>Todos, todos</option>
            <?

  $alumno0 = mysql_query("SELECT distinct APELLIDOS, NOMBRE, claveal FROM FALUMNOS where unidad = '$unidad' order by NC asc");
  if ($falumno = mysql_fetch_array($alumno0))
        {
        	
        do {
	      echo "<OPTION>$falumno[0], $falumno[1] -->  $falumno[2]</OPTION>";

	} while($falumno = mysql_fetch_array($alumno0));
 }
	?>
          </select>
        </label>
        <label>Fecha <br />
          <?  $fecha1 = (date("d").-date("m").-date("Y")); 
if ($fecha)
  {
 ?>

 <? 	
  echo '     
  <div class="input-append">
            <input name="fecha" type="text" class="input input-small input-block-level" value="'.$fecha.'" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="fa fa-calendar"></i></span>
</div> ';
  }
  else{
  	echo '     
  <div class="input-append" >
            <input name="fecha" type="text" class="input input-small input-block-level" value="" data-date-format="dd-mm-yyyy" id="fecha" >
  <span class="add-on"><i class="fa fa-calendar"></i></span>
</div> ';
  }
?>
 </label>      
        <hr>

        <label> Observaciones<br />
          <textarea name='observaciones' rows='8'  class='input-xxlarge'><? echo $observaciones; ?></textarea>
        </label>
        <hr>
          <div class="row-fluid">
  <div class="span6">
        <label style='display:inline'>Causa<br />
          <select name="causa"  class="input-xlarge" style='display:inline'>
            <option><? echo $causa; ?></option>
            <option>Estado general del Alumno</option>
            <option>Evoluci&oacute;n acad&eacute;mica</option>
            <option>Faltas de Asistencia</option>
            <option>Problemas de convivencia</option>
            <option>Otras</option>
          </select>
        </label>
</div>
  <div class="span6">
        <label style='display:inline'> Tipo<br />
          <select name="accion" class="input-large" style='display:inline'>
            <option><? echo $accion; ?></option>
            <option>Entrevista telef&oacute;nica</option>
            <option>Entrevista personal</option>
            <option>Comunicaci&oacute;n por escrito</option>
          </select>
        </label>
        </div>
        </div>
       <hr>
        <input name="unidad" type="hidden" value="<? echo $unidad; ?>" />
        <input name="tutor" type="hidden" value="<? echo $tutor; ?>" />
        <input name="id2" type="hidden" value="<? echo $id; ?>" />
        <center><input name='submit1' type='submit' value='Registrar intervencion de tutoria' class='btn btn-primary'>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name='submit2' type='submit' value='Actualizar datos'  class='btn btn-warning'>
        </center>
      </form>
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
    <h4 align="center">Intervenciones sobre <br /> <? echo $nombre." ".$apellidos." (".$unidad.")"; ?></h4>
    <br />
    <?
 
$result = mysql_query ("select apellidos, nombre, fecha, accion, causa, observaciones, id from tutoria where claveal='$clave' and prohibido = '0' and
 unidad = '$unidad' order by fecha");
  if ($row = mysql_fetch_array($result))
{
echo "<table class='table table-striped' style='width:100%'><thead>";  	
echo "<tr><th>Fecha</th><th>Clase</th><th>Causa</th><th></th></tr></thead><tbody>";
do{
  $obs=substr($row[5],0,80)."...";
  $dia3 = explode("-",$row[2]);
  $fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
echo "<tr><td>$fecha3</td><td>$row[3]</td><td>$row[4]</a></td><td>
<a href='tutor.php?id=$row[6]'><i class='fa fa-search' title='Detalles'> </i> </a>
<a href='tutor.php?id=$row[6]&eliminar=1'><i class='fa fa-trash-o' title='Borrar' onClick='return confirmacion();'> </i></a></td></tr>";
}while($row = mysql_fetch_array($result));
echo "</tbody></table>";
}
}
	?>
  </div>
  <div class="span4">
    <legend align="center">Intervenciones del Tutor</legend>
    <? include("ultimos.php");?>
  </div>
</div>
</div>
<? 
 include("../../pie.php");
?>

<script>  
	$(function ()  
	{ 
		$('#fecha').datepicker()
		.on('changeDate', function(ev){
			$('#fecha').datepicker('hide');
		});
		});  
	</script>
</BODY></HTML>