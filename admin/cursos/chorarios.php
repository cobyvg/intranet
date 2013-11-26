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
  <h2>Horarios del Centro <small> Grupos, Profesores y Aulas</small></h2>
</div>
</div>
<div class="row-fluid">
<div class="span3"></div>
<div class="span3">
<? if ($mod_horario) {?>

<FORM action="horarios.php" method="POST" class="well well-large">
 <legend> Horario de un Grupo</legend><br />
  <select name="curso" class="span12">
    <?
  $tipo = "select distinct a_grupo from horw where a_grupo not like 'G%' order by a_grupo";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
echo "<option>".$tipo2[0]."</option>";
        }				
					?>
  </select>
   <hr />
  <button class="btn btn-primary btn-block" type="submit" name="submit1" value="Enviar datos">Enviar datos</button>
</FORM>

</div>
<div class="span3">
<FORM action="profes.php" method="POST" name="Cursos" class="well well-large">
<legend>Horario de un Profesor</legend><br />
  <SELECT  name=profeso class="span12">
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
  <hr />
  <button class="btn btn-primary btn-block" type="submit" name="Listar" value="Enviar datos">Consultar horario</button>
</FORM>
</div>
<div class="span2"></div>
</div>
<div class="row-fluid">
<div class="span3"></div>
<div class="span3">
<form action="hor_aulas.php" method="post" class="well well-large">
 <legend> Horario de un Aula</legend><br />
  <SELECT  name=aula onChange="submit()" class="span12">
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
   <hr />
  <button class="btn btn-primary btn-block btn-block" type="submit" name="Ver horarios" value="Ver Horarios">Ver Horarios</button>
</FORM>

</div>
<div class="span3">
<form action="aulas_libres.php" method="post" class="well well-large">
  <legend>Aulas libres por día
  de la Semana</legend><br />
  <select name="n_dia" class="span12">
    <option>Lunes</option>
    <option>Martes</option>
    <option>Miércoles</option>
    <option>Jueves</option>
    <option>Viernes</option>
  </select>
   <hr />
  <button class="btn btn-primary btn-block" type="submit" name="Aulas" value="Ver Aulas libres">Ver Aulas libres</button>
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

include("../../pie.php");
?>
</BODY>
</HTML>
