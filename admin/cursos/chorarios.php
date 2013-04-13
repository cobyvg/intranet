<?php
if ($submit1)
{
include("horarios.php");
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
  <h1>Horarios <small> Grupos, Profesores y Aulas</small></h1>
</div>
<br />
</div>
<div class="row-fluid">
<div class="span2"></div>
<div class="span4">
<? if ($mod_horario) {?>

<FORM action="chorarios.php" method="POST" class="well-2 well-large form-inline">
 <h3> Horario de un Grupo</h3><br />
  <select name="curso">
    <?
  $tipo = "select distinct a_grupo from horw where a_grupo not like 'G%' order by a_grupo";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }				
					?>
  </select>
  <button class="btn btn-primary" type="submit" name="submit1" value="Enviar datos">Enviar datos</button>
</FORM>

</div>
<div class="span4">
<FORM action="profes.php" method="POST" name="Cursos" class="well-2 well-large form-inline">
<h3>Horario de un Profesor</h3><br />
  <SELECT  name=profeso onChange="submit()">
    <option></option>
    <?
  $profe = mysql_query(" SELECT distinct prof FROM horw order by prof asc");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
  </select>
  <button class="btn btn-primary" type="submit" name="Listar" value="Enviar datos">Consultar horario</button>
</FORM>
</div>
<div class="span2"></div>
</div>
<div class="row-fluid">
<div class="span2"></div>
<div class="span4">
<form action="hor_aulas.php" method="post" class="well-2 well-large form-inline">
 <h3> Horario de un Aula</h3><br />
  <SELECT  name=aula onChange="submit()">
    <option></option>
    <?
  $profe = mysql_query(" SELECT DISTINCT n_aula FROM horw where n_aula not like 'G%' ORDER BY n_aula ASC");
  if ($filaprofe = mysql_fetch_array($profe))
        {
        do {

	      $opcion1 = printf ("<OPTION>$filaprofe[0]</OPTION>");
	      echo "$opcion1";

	} while($filaprofe = mysql_fetch_array($profe));
        }
	?>
  </select>
  <button class="btn btn-primary" type="submit" name="Ver horarios" value="Ver Horarios">Ver Horarios</button>
</FORM>

</div>
<div class="span4">
<form action="aulas_libres.php" method="post" class="well-2 well-large form-inline">
  <h3>Aulas libres por día
  de la Semana</h3><br />
  <select name="n_dia">
    <option>Lunes</option>
    <option>Martes</option>
    <option>Miércoles</option>
    <option>Jueves</option>
    <option>Viernes</option>
  </select>
  <button class="btn btn-primary" type="submit" name="Aulas" value="Ver Aulas libres">Ver Aulas libres</button>
</FORM>
</div>
<div class="span2"></div>
</div>
<? }
 else {
 	echo '<div class="alert alert-success alert-block fade in" style="max-width:500px;" align="center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            El módulo de Horarios debe ser activado en la Configuración general de la Intranet para poder acceder a estas páginas, y ahora mismo está desactivado. Consulta con quien pueda ayudarte.
          </div>';
 }
}
include("../../pie.php");
?>
</BODY>
</HTML>
