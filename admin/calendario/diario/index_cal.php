<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
  	include("../../../menu.php");
  	include("menu.php");
  	if (isset($_POST['curso'])) {$curso = $_POST['curso'];} elseif (isset($_GET['curso'])) { $curso = $_GET['curso'];}
  ?>
 <br />
  <div align=center>
  <div class="page-header" align="center">
  <h2>Registro de Exámenes y Actividades <small> Calendario de los Grupos</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class="span4 offset4" align="center">
<FORM action="index_cal.php" method="POST" class="well well-large form-inline">
 <legend> Calendario de un Grupo</legend><br />
  <select name="curso" class="input-small">
<?

if (isset($curso)) {
	echo "<option>".$curso."</option>";
}
unidad();				
?>					
  </select>
  <hr />
  <button class="btn btn-primary btn-block" type="submit" name="submit1" value="Enviar datos">Ver Calendario</button>
</FORM>
</div>
</div>
<?
if(isset($curso)){
?>
<div class="row-fluid">
<div align="center"><hr><legend class='text-warning'>Registro de pruebas y actividades: <br /><span class="text-success"><? echo $curso; ?></span></legend></div>
<div class="span6 offset1">

<?
$eventQuery = mysql_query("SELECT id, fecha, grupo, materia, tipo, titulo FROM diario WHERE grupo like '%".$curso."%'");
echo "<table class='table table-striped' align='center'><thead><th>Fecha</th><th>Grupo</th><th>Materia</th><th>Título</th></thead><tbody>";
while ($reg=mysql_fetch_array($eventQuery)) {
	echo "<tr>
	<td nowrap>$reg[1]</td>
	<td>$reg[2]</td>
	<td>$reg[3]</td>
	<td>$reg[5]</td>
	</tr>";
}
echo "</tbody></table>";
?>
</div>
<div class="span3">
<?
include("calendario_grupos.php");
?>
</div>
</div>
</div>
<?
}
?>
<?
include("../../pie.php");
?>
</BODY>
</HTML>
