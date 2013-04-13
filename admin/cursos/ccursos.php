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
<div align=center>
<div class="page-header" style="margin-top:-15px;" align="center">
  <h1>Listas de Alumnos <small> Listas de grupo y partes de faltas</small></h1>
</div>
<br />
</div>
<div class="row-fluid">
<div class="span2"></div>
<div class="span4">
<form class="well-2 well-large form-inline" action="ccursos.php" method="POST" name="listas">
<h3>Lista de Alumnos</h3><br />
Nivel: <SELECT  name="nivel" onChange="submit()" class="span2" style="display:inline;margin-right:15px;">
            <option><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT>
Grupo: <select  name="grupo" class="span2" style="display:inline">
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
<FORM action="ccursos.php" method="POST" name="listas2" class="well-2 well-large form-inline">
<h3>Partes de Faltas de Aula</h3> <br />     
Nivel: <SELECT  name="nivel" onChange="submit()" class="span2" style="display:inline;margin-right:15px;">
            <option><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT>
Grupo: <select  name="grupo" class="span2" style="display:inline">
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
