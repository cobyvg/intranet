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
    <link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css">    
<?php
include("../../../menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h1>Administración <small> Creación de Horarios y Profesores</small></h1>
</div>
<br />
<div  align='center'>    
 <div class="well well-large well-transparent lead" id="t_larga_barra" style="width:320px">
        <i class="icon-spinner icon-spin icon-2x pull-left"></i> Cargando los datos...
      </div>
</div>
<div id='t_larga' style='display:none' >

<?
include("horario_normal.php");
include("horario_faltas.php");
?>
</div>
 <? include("../../../pie.php");?>
  <script>
function espera( ) {
        document.getElementById("t_larga").style.display = '';
        document.getElementById("t_larga_barra").style.display = 'none';        
}
window.onload = espera;
</script>  