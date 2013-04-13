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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Generator" content="Dev-PHP 1.9.4">
<title>Nuevo Enlace</title>
<link href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css" media="screen" />
<style>
td {text-align:center;}
</style>
</head>

<body>
<?php
include("../../../menu.php");
include("../mrecursos.php");
?>
<form name="entrada" method="POST" action="grabadirec.php">
<div align="center">
<div class='titulogeneral' style='margin-top:0px'>Enlaces y Marcadores: Nuevo registro</div>
        <?php
$categoria=$_POST['categ'];
$apartado=$_POST['apartado'];
 $a=strlen($categoria);
$b=strlen($apartado);
if ($a==0 or $b==0){
 echo"<table width='300' class='tabla' align='center' >
<td if='filaprincipal'> MENSAJE DE ERROR</td></tr> <TR>
<td>Debes marcar y seleccionar primero una Categoría</td></tr>
</table>";
}
else{
echo "<input type='hidden' name='cat' value='$categoria'>";
echo "<input type='hidden' name='apart' value='$apartado'>";
echo"<table width='300' align=center  class='tabla' style='margin-top:0px'>
<tr><td id='filaprincipal'><center>CATEGORÍA  </td>
<td id='filaprincipal'> <center>APARTADO  </td></tr><tr>
<td > <center style='color:brown'>$categoria</center></td>
<td> <center style='color:green'>$apartado</center></td>
</table>";
?>
        <center>
          <span class="titulin" style="margin-top:10px;" >Rellena todos 
          los campos siguientes</span> <br>
        </center>

<table  align=center class="tabla" align="center" style="margin-top:0px;">
<tr><td id='filaprincipal' align="center">NOMBRE</td></tr><tr><td>
Designa con un nombre identificativo el enlace que vas a introducir: </TD>
 </tr>
<?
 ECHO"<TD bgcolor='#FFFFCC'>";
echo"<textarea rows='1' cols='60' name='nombre' wrap='virtud'> </textarea>";
ECHO"</TD></tr>";
echo"<tr><td id='filaprincipal'>DIRECCIÓN</td></td><tr><td>
Escribe completa la dirección de la página web (http://www.etc...)</TD>
 </tr>";
echo "<tr><TD bgcolor='#FFFFCC'>";
echo"<textarea rows='1' cols='60' name='http'> </textarea>";
echo "</TD></tr>";
?>
<tr><td id='filaprincipal' align="center">COMENTARIO</td></tr><tr><td>
 Escribe una breve descripción del contenido de la página</TD>
 </tr>
<?
echo "<tr><TD bgcolor='#FFFFCC'>";
echo"<textarea rows='6' cols='60' name='descripcion' wrap='virtud'> </textarea>";
echo "</TD></tr>";
echo"</table>";
echo"<table  align=center border='1'  >
<td  align=center height='21'  style='background-color: #C0C0C0'>
<input type=submit value='GUARDAR ENLACE' class='content'> </td>
</table></form>";
 }
 ?>
</body>
</html>
