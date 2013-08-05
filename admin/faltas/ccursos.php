<?php
if (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];} elseif (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];} else{$nivel="";}
if (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];} elseif (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}

if ($_POST['submit2'])
{
include("horariofaltas_cursos.php");
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
  <h2>Listas de Alumnos <small> Partes de faltas de Aula</small></h2>
</div>
</div>
<div class="container">
<div class="row-fluid">
<div class="span4 offset4">
<div align="center">
<FORM action="ccursos.php" method="POST" name="listas2" class="well well-large form-inline">
<legend>Partes de Faltas de Aula</legend> <br />     
Nivel: <SELECT  name="nivel" onChange="submit()" class="input-mini" style="display:inline;margin-right:15px;">
            <option><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT>
<label>Grupo: </label>
<select  name="grupo" class="input-mini" style="display:inline">
          <option></option>
          <? grupo($nivel);?>
        </select>
        <br /><br />
          <label>Día de la semana:
          <select name="dia1" class="input-small">
            <option>Lunes</option>
            <option>Martes</option>
            <option>Miércoles</option>
            <option>Jueves</option>
            <option>Viernes</option>
          </select>
          </label>
          <br /><br />
          <INPUT class="btn btn-success" type="submit" name="submit2" value="Lista del Curso">
          </FORM>    
</div>
</div>
</div>
   

<?  
}
	include("../../pie.php");
?>
</BODY>
</HTML>
