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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Generator" content="Dev-PHP 1.9.4">
<title>Nuevo Enlace</title>
<link rel="stylesheet" href="http://<? echo $dominio; ?>/<? echo $css1; ?>">
<link rel="stylesheet" href="http://<? echo $dominio; ?>/<? echo $css2; ?>">

</head>
<body bgcolor="#ffffff">
<?php
include("../../menu.php");
?>
<br>
<center>
  <img src="../../imag/enlaces1.gif" width="221" height="47"><br>
</center>
<form name="entrada" method="POST" action="grabadirec.php">


 <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#A7BFFE">
                                  <tr>
                                    <td><table width="100%" border="0" align="center" cellspacing="1" bgcolor="#E1ECFF">
                                        <tr>
                                          <td><br>
        <?php
$categoria=$_POST['categ'];
$apartado=$_POST['apartado'];
 $a=strlen($categoria);
$b=strlen($apartado);
if ($a==0 or $b==0){
 echo"<table width='150' align=center border=0 bgcolor='#99CC99' cellspacing='1'>
<td bgcolor='#FFFFCC'><font size='2'><B> <center> MENSAJE DE ERROR </B></font> </td> <TR>
<td bgcolor='#FFFFCC'> <font size='2'><b> <center>Debe marcar y seleccionar una categoría </b></font> </td>
</table>";
}
else{
echo "<input type='hidden' name='cat' value='$categoria'>";
echo "<input type='hidden' name='apart' value='$apartado'>";
echo"<table width='300' align=center border=0 bgcolor='#99CC99' cellspacing='1'>
<tr><td height='32' bgcolor='#FFFFCC'><font size='2'><B> <center>CATEGORÍA </B></font> </td>
<td bgcolor='#FFFFCC'> <font size='2'><b> <center>APARTADO </b></font> </td></tr><tr>
<td height='32' bgcolor='#FFFFFF'><font size='2' color='#CC3333'> <center><b>$categoria</b></font> </td>
<td bgcolor='#FFFFFF'> <font size='2' color='#CC3333'> <center><b>$apartado</b></font> </td>
</table> <br>";
?>
        <center>
          <strong><font face="Verdana, Arial, Helvetica, sans-serif">Rellena todos 
          los campos siguientes:</font></strong> 
        </center>
 <br>
</font>

<table  align=center bgcolor="#99CC99" border=0 cellspacing="1">
<td bgcolor='#FFFFCC'><br><font size="2" color="#CC3333"> <center><b>NOMBRE</b></font><BR>
<font size="2"> <center>Designa con un nombre identificativo el enlace que vas a introducir: </font><br><br> </TD>
 <tr>
<?
 ECHO"<TD bgcolor='#FFFFCC'>";
echo"<textarea rows='1' cols='60' name='nombre' wrap='virtud'> </textarea>";
ECHO"</TD><tr>";
echo"<TD bgcolor='#FFFFCC'><br><font size='2' color='#CC3333'> <center><b>DIRECCIÓN </b></font><BR>
<font size='2'><center>Escribe completa la dirección de la página web (http://www.etc...)
</font><br><br></TD> <tr>";
ECHO"<TD bgcolor='#FFFFCC'>";
echo"<textarea rows='1' cols='60' name='http' wrap='virtud'> </textarea>";
ECHO"</TD><tr>";
?>
<td bgcolor='#FFFFCC'> <br><font size="2" color="#CC3333"> <center><b>COMENTARIO</b></font>
<font size="2"> <BR> Escribe una breve descripción del contenido de la página</font><br><br><TR>
<?
ECHO"<TD bgcolor='#FFFFCC'>";
echo"<textarea rows='6' cols='60' name='descripcion' wrap='virtud'> </textarea>";
ECHO"</TD>";
echo"</table>";
echo"<br>";


echo"<table  align=center border='1'  >
<td  align=center height='21'  style='background-color: #C0C0C0'>
<input type=submit value='GUARDAR ENLACE' class='content'> </td>
</table></form>";
 }
 ?>
</body>
</html>
