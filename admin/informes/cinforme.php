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

if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
} 
elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
} 
else
{
$unidad="";
}
if (isset($_GET['nombre_al'])) {
	$nombre = $_GET['nombre_al'];
}
else{
	$nombre = $nombre_al;
}

?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Informe del Alumno <small> Selecciona alumno</small></h2>
</div>
<br />
</div>
<div class="row-fluid">
  <div class="span3"> </div>
  <div class="span6">
    <div class="well well-large">
      <div class="row-fluid">
      <div class="span6" align="left">
      <legend>Datos del alumno</legend>
      <form class="form-inline">
        <label>Grupo<br>
          <select  name="unidad" onChange="submit()" class="input">
            <option  class="opcion"><? echo $unidad;?></option>
            <? unidad();?>
          </select>
        </label>
      </form>
      <hr />
      <form enctype='multipart/form-data' action='index.php' method='post'>
        <label>Alumno<br />
          <select  name="nombre" class="span10">
            <?
echo "<option>$nombre</option>";
 
  
  $fecha1 = (date("d").-date("m").-date("Y"));
  // Datos del alumno que hace la consulta. No aparece el nombre del año de la nota. Se podría incluir.
//  echo "<option>$nombre</option>";
  $alumno = mysql_query(" SELECT distinct APELLIDOS, NOMBRE, CLAVEAL FROM FALUMNOS WHERE unidad = '$unidad' order by APELLIDOS asc");

  if ($falumno = mysql_fetch_array($alumno))
        {
	$claveal = $falumno[2];
	
        do {
      $nombre = printf ("<OPTION>$falumno[0], $falumno[1] --> $falumno[2]</OPTION>");
	      //echo "$nombre";

	}while($falumno = mysql_fetch_array($alumno));
        }
	
	?>
          </select>
        </label>
        <label>Curso Escolar</label>
        <div class="control-group warning">
          <div class="controls">
            <select name="c_escolar" class="inputwarning input-small">
              <?
$ano=explode("/",$curso_actual);
for ($i=0;$i<5;$i++)
{
${b.$i}=$ano[0]-$i;
${c.$i}=$ano[1]-$i;
${a.$i}=${b.$i}."/".${c.$i};
echo "<option>${a.$i}</option>";	
}

?>
            </select>
          </div>
        </div>
        </div>
        <div class="span6" align="left">
          <legend>Opciones del Informe</legend>
          <br />
          <?    if ($mod_faltas) {?>
          <label class="checkbox">
            <input type="checkbox" checked name="faltas" value="faltas">
            Resumen de Faltas de Asistencia</label>
          <label class="checkbox">
            <input type="checkbox" unchecked name="faltasd" value="faltasd">
            Faltas de Asistencia Detalladas</label>
          <? }?>
          <label class="checkbox">
          <input type="checkbox" checked name="fechorias" value="fechorias">
          Problemas de Convivencia
          </label>
          <label class="checkbox">
            <input type="checkbox" unchecked name="tutoria" value="tutoria">
            Informes de Tutoría</label>
          <label class="checkbox">
            <input type="checkbox" unchecked name="notas" value="notas">
            Notas de Evaluación</label>
          <label class="checkbox">
            <input type="checkbox" unchecked name="act_tutoria" value="act_tutoria">
            Acciones de Tutoría</label>
          <?    if ($mod_horario) {?>
          <label class="checkbox">
            <input type="checkbox" unchecked name="horarios" value="horarios">
            Horario del Alumno</label>
          <?}?>
        </div>
        </div>
	<input type="hidden" name="unidad" value="<? echo $unidad;?>">
        <div align="center"><input name='submit1' type='submit' value='Ver informe del alumno' class="btn btn-primary"></div>
      </form>
    </div>
  </div>
</div>
<? include("../../pie.php");?>
</BODY></HTML>