<?php
if ($submit1)
{
include("cursos.php");
}
elseif ($submit2)
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
  <h2>Listas de Alumnos <small> Listas de grupo y partes de faltas</small></h2>
</div>
</div>
<div class="row-fluid">
<div class="span2"></div>
<div class="span4">
<form class="well well-large form-inline" action="ccursos.php" method="POST" name="listas">
<legend>Lista de Alumnos</legend>
<label>Nivel: </label><br />
<SELECT  name="nivel" onChange="submit()" class="span2">
            <option><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT>
          &nbsp;&nbsp;&nbsp;
<label>Grupo: </label><select  name="grupo" class="span2" style="display:inline">
          <option></option>
          <? grupo($nivel);?>
        </select>
        <br /><br />
         <label class="checkbox"> 
    <input type="checkbox" name="asignaturas" value="1" class="checkbox"> Con Asignaturas
  </label>
  <br /><br />
  <button class="btn btn-success" type="submit" name="submit1" value="Lista del Curso">Lista del Curso</button>
</form>

</div>
<div class="span4">
<FORM action="ccursos.php" method="POST" name="listas2" class="well well-large form-inline">
<legend>Partes de Faltas de Aula</legend> <br />     
Nivel: <SELECT  name="nivel" onChange="submit()" class="span2" style="display:inline;margin-right:15px;">
            <option><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT>
<label>Grupo: </label>
<select  name="grupo" class="span2" style="display:inline">
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
<div class="span2"></div>
</div>
   

<?  
}
	include("../../pie.php");
?>
</BODY>
</HTML>
