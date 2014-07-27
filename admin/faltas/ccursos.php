<?php
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="";}
if (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];} elseif (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];} else{$grupo="";}

if ($_POST['submit2'])
{
	if ($_POST['dia1']!="Formato semanal") {
		include("horariofaltas_cursos.php");
	}
	else {
		include("horario_semanal.php");
	}
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
<div class="row">
<div class="col-sm-4 col-sm-offset-4">
<div align="center">
<FORM action="ccursos.php" method="POST" name="listas2" class="well well-large form-inline">
<legend>Partes de Faltas de Aula</legend> <br />     
<label>
Grupo: <SELECT  name="unidad" onChange="submit()" class="input-mini" style="display:inline;margin-right:15px;">
            <option><? echo $unidad;?></option>
            <? unidad();?>
          </SELECT>
</label>
        <br /><br />
          <label>Día de la semana:
          <select name="dia1" class="input-xsmall">
            <option>Lunes</option>
            <option>Martes</option>
            <option>Miércoles</option>
            <option>Jueves</option>
            <option>Viernes</option>
            <option>Formato semanal</option>
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
