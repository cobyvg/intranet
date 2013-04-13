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
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
?>
<?php
include("../../menu.php");
include("../menu.php");
?>
<br />
<div align="center">
<div class="page-header" align="center" style="margin-top:-15px">
  <h1>Faltas de Asistencia <small> Actualización de Días Festivos en la localidad</small></h1>
</div>
<br />
<FORM ENCTYPE="multipart/form-data" ACTION="festivos.php" METHOD="post">
<Table align='center' class="table table-striped table-bordered" style="width:600px">
<tr>
  <td align='justify'>Si has descargado el archivo <strong>200CalEscCent</strong> de Séneca (desde Séneca --> Centro --> Días festivos), puedes continuar con el segundo paso.</td></tr>
<tr><td align="center"><p class="lead" align="center">Selecciona el
    archivo con los datos de las Fiestas</p>
    </td></tr> 
<tr>
  <td align="center" ><input type="file" name="archivo" class="input-file">
    <br></td></tr>
<tr><td align="center" ><div align="center"><INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary"></div></td></tr>
</table>
</FORM>
<br />
</div>
</body>
</html>
