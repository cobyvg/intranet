<?
if($submit1 == "Buscar"){include("datos.php");
exit;
}
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
<FORM action="cdatos.php" method="POST">
  <legend>Selecciona criterios</legend>
  <br />
  <label> Apellidos<br />
    <INPUT type="text" name="APELLIDOS" size="30" maxlength="32" alt="Apellidos" class="input-xlarge">
  </label>
  <label>Nombre<br />
    <INPUT type="text" name="NOMBRE" size="30" maxlength="25" alt="Nombre" class="input-large">
  </label>
  <label> Nivel<br />
    <SELECT name="nivel" onChange="submit()" class="input-mini">
      <OPTION><? echo $nivel;?></OPTION>
      <? nivel();?>
    </SELECT>
  </label>
  <label>Grupo<br />
    <SELECT name="grupo" class="input-mini">
      <OPTION><? echo $grupo;?></OPTION>
      <? grupo($nivel);?>
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
