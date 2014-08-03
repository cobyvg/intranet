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
?>
  <br />
  <div class="page-header">
<h2>CALENDARIO ESCOLAR <? echo $curso_actual;?></h2> 
</div>
<br />
<?
include("calendario2.php");
?>
  
</BODY>
</HTML>