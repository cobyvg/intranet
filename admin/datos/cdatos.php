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

?>
<br />
<div align="center">
<div class="page-header" align="center">
  <h2>Datos de los Alumnos <small> Consultas</small></h2>
</div>

</div>
<div align="center">
<div class="well well-large" style="width:360px;" align="left">
<FORM action="datos.php" method="POST">
  <legend>Selecciona criterios</legend>
  <br />
  <label> Apellidos<br />
    <INPUT type="text" name="apellidos" size="30" maxlength="32" alt="Apellidos" class="input-block-level">
  </label>
  <label>Nombre<br />
    <INPUT type="text" name="nombre" size="30" maxlength="25" alt="Nombre" class="input-block-level">
  </label>
  <label> Grupo<br />
    <SELECT name="unidad" class="input-block-level">
      <OPTION></OPTION>
      <? unidad();?>
    </SELECT>
  </label>
  <br />
  <INPUT type="submit" name="submit1" value="Buscar" class="btn btn-primary">
  </div>
  </div>
</FORM>
<? include("../../pie.php");?>
</BODY>
</HTML>
