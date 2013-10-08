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
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Administración <small> Creación de Horarios y Profesores</small></h2>
</div>
<br />
<div  align='center'>    
<?
include("horario_normal.php");
include("horario_faltas.php");
?>
</div>
 <? include("../../../pie.php");?>
 