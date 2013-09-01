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
<? 
include("../../menu.php");
include("menu.php");

if((stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE) and strstr($tutor," ==> ")==TRUE){
$tr = explode(" ==> ",$tutor);
$tutor = $tr[0];
$tr1 = explode("-",$tr[1]);
$nivel = $tr1[0];
$grupo = $tr1[1];
	}
else{
$SQL = "select nivel, grupo from FTUTORES where tutor = '$tutor'";
	$result = mysql_query($SQL);
	$row = mysql_fetch_array($result);
	$nivel = $row[0];
	$grupo = $row[1];
}
?>
<div align="center">
<div class="page-header" align="center">
  <h2 style="display:inline">Página del tutor <small> <? echo "$nivel-$grupo";?>  ( <? echo $tutor; ?> )</small></h2> 
</div>
</div>
<? 
?>
<div class="container-fluid">
<div class="row-fluid">
<div class="span4">
<?  include("faltas.php");?>
<hr>
<br />
<?  include("mensajes.php");?>
<hr>
<br />
<? include("tareas.php");?>
<hr>
<br />
</div>
<div class="span4">
<?
include("control.php");
include("fechorias.php");?>
<hr>
<br />
<p class='lead'>Actividades Extraescolares</p>
<?  include("actividades.php");?>
</div>
<div class="span4">
<? include("informes.php");?>
<hr>
<br />
<p class='lead' >Intervenciones del Tutor</p>
<?  include("ultimos.php");?>
</div>
</div>
<? include("../../pie.php");?>		
</body>
</html>
