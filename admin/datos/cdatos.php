<?
if ($_POST['submit1']=="Ver datos") {
	include 'datos.php';
	exit();
}
elseif ($_POST['submit2']=="PDF para imprimir") {
	include 'lista_grupo.php';
	exit();
}
elseif ($_POST['submit0']=="Buscar alumnos") {
	include 'datos.php';
	exit();
}
?>
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
<div class="container-fluid">
<div class="row-fluid">
<div class=" span4 offset2 well well-large">
<FORM name="form0" id="form1" action="cdatos.php" method="POST">
  <legend>Datos de los alumnos</legend>
  <br />
  <label> Apellidos<br />
    <INPUT type="text" name="apellidos" size="30" maxlength="32" alt="Apellidos" class="input-block-level" />
  </label>
  <label>Nombre<br />
    <INPUT type="text" name="nombre" size="30" maxlength="25" alt="Nombre" class="input-block-level" />
  </label>
  <p class="help-block">No es necesario excribir el nombre o los apellidos completos de los alumnos.</p>
 <div align="center"> <button type="submit" name="submit0" value="Buscar alumnos" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Buscar alumnos</button></div> 
</div>
</form>
<div class="span4 well well-large" >
<FORM name="form1" id="form1" action="cdatos.php" method="POST">
  <legend>Datos de los Grupos</legend>
  <label>
    <SELECT name="unidad[]" class="input-block-level" multiple style="height:140px" required>
      <? unidad();?>
    </SELECT>
  </label>
  <p class="help-block">Mantén apretada la tecla Ctrl mientras haces click con el ratón para seleccionar múltiples grupos.</p>
 <div align="center"> <button type="submit" name="submit1" value="Ver datos" class="btn btn-primary"><i class="fa fa-search"></i> Ver datos</button>  <button type="submit" name="submit2" value="PDF para imprimir" class="btn btn-primary" ><i class="fa fa-print"></i> PDF para imprimir</button></div>
 </FORM>
 
  </div>
  </div>
  </div>
  
<? include("../../pie.php");?>
</BODY>
</HTML>
