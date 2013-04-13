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
include("../menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h1>Faltas de Asistencia <small> Justificar faltas</small></h1>
</div>
<br />
<form action="index.php" method="POST">
  
    <?php
// Se presenta la estructura de las tablas del formulario.
include("estructura.php");
?>
</form>
<? include("../../pie.php"); ?>
</body>
</html>
