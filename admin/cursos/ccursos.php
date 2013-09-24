<?php
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];} else{$nivel="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="$nivel-$grupo";}

if ($_POST['submit1'] or $_GET['submit1'])
{
	include("cursos.php");
}
else
{
?>
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
$profesor = $_SESSION['profi'];
?>
<?
include("../../menu.php");
?>
<br />
<div align=center>
<div class="page-header" align="center">
  <h2>Listas de Alumnos <small> Listas de Grupo</small></h2>
</div>
</div>
<div class="container">
<div class="row-fluid">
<?
if(stristr($_SESSION['cargo'],'1') == TRUE){
 echo '<div class="span4 offset4">';
}
else{
echo '<div class="span6 offset3">';
}
?>

<form class="well well-large form-inline" action="ccursos.php" method="POST" name="listas">
<legend>Lista de Alumnos por Grupo</legend>
<SELECT  name="unidad[]" multiple class="input-block-level">
<?
if(stristr($_SESSION['cargo'],'1') == TRUE){
 unidad();
}
else{
$SQLcurso = "select distinct grupo, materia, nivel from profesores where profesor = '$profesor'";
$resultcurso = mysql_query($SQLcurso);
	while($rowcurso = mysql_fetch_array($resultcurso))
	{
	$curso = $rowcurso[0];
	$asignatura = $rowcurso[1];
	$asigna0 = "select codigo from asignaturas where nombre = '$asignatura' and curso = '$rowcurso[2]' and abrev not like '%\_%'";

	$asigna1 = mysql_query($asigna0);
	$asigna2 = mysql_fetch_array($asigna1);
	$codasi = $asigna2[0];	
	echo "<option>$curso -> $asignatura -> $codasi</option>";
 }
}
?>
          </SELECT>
        <br /><br />
         <label class="checkbox"> 
    <input type="checkbox" name="asignaturas" value="1"> &nbsp; Mostrar asignaturas
  </label>
  <br /><br />
  <button class="btn btn-primary btn-block" type="submit" name="submit1" value="Lista del Curso">Lista del curso</button>
</form>
</div>
</div>
  </div> 

<?  
}
	include("../../pie.php");
?>
</BODY>
</HTML>
