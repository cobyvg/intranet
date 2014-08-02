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

<?php
include("../../menu.php");
include("menu.php");
?>
<div align="center">
<div class="page-header">
  <h2>Informes de Tutoría <small> Borrar Informe</small></h2>
</div>
<br />
<?
if ($del=='1') {
	mysql_query("delete from infotut_alumno where id = '$id'");
	if (mysql_affected_rows()>'0') {
		echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Informe ha sido borrado sin problemas.
		</div></div>';
	}
	else {
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
El Informe no ha podido ser eliminado. Consulta con alguien que pueda ayudarte.
		</div></div>';
	}
}
?>
</div>
<? include("../../pie.php");?>
</body>
</html>
