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
<div class="span4 offset4">
<form class="well well-large form-inline" action="ccursos.php" method="POST" name="listas">
<legend>Lista de Alumnos por Grupo</legend>
<label>Seleccion Grupo: </label><br />
<SELECT  name="unidad" class="input-block-level">
            <? unidad();?>
          </SELECT>
        <br /><br />
         <label class="checkbox"> 
    <input type="checkbox" name="asignaturas" value="1"> &nbsp; Mostrar asignaturas
  </label>
  <br /><br />
  <button class="btn btn-primary" type="submit" name="submit1" value="Lista del Curso">Lista del curso</button>
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
