<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);



?>
<? 
include("../../menu.php");
include("menu.php");

if((stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE) and strstr($tutor," ==> ")==TRUE){
$tr = explode(" ==> ",$tutor);
$tutor = $tr[0];
$unidad = $tr[1];
	}
else{
$SQL = "select unidad from FTUTORES where tutor = '$tutor'";
	$result = mysql_query($SQL);
	$row = mysql_fetch_array($result);
	$unidad = $row[0];
	
}
?>
<div align="center">
<div class="page-header">
  <h2 style="display:inline">Página del tutor <small> <? echo $unidad;?>  ( <? echo $tutor; ?> )</small></h2> 
</div>
</div>
<? 
?>
<div class="container-fluid">
<div class="row">
<div class="col-sm-4">
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
<div class="col-sm-4">
<?
include("control.php");
include("fechorias.php");?>
<hr>
<br />
<p class='lead'>Actividades Extraescolares</p>
<?  include("actividades.php");?>
</div>
<div class="col-sm-4">
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
