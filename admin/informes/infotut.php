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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
<title>Selecciona alumno</title>
</head>
<?php

include("../../menu.php");
$prof=mysql_query("SELECT TUTOR FROM FTUTORES WHERE NIVEL like '$nivel%' and GRUPO like '$grupo%'");
$fprof = mysql_fetch_array($prof);
?>
<body>
<div class="titulogeneral" style="margin-top:20px;">Informes de Tutor&iacute;a</div>
 <div class="titulogeneral" style="width:500px;text-align:center;color:#281;margin:auto; margin-bottom:18px;">Nuevo Informe de Tutor&iacute;a  
<?
if(strlen($nivel) > '1' and strlen($grupo) > '0')
{
echo '<br><br>Grupo: ';
echo '<span style="color:brown;font-weight:bold;font-size:12px;">';
echo $nivel."-".$grupo;
echo '</span> Tutor: ';
echo '<span style="color:brown;font-weight:bold;font-size:12px;">'.$fprof[0].'</span>';
echo '</div>';
}
else
{
?> 
</div>
<form name="curso" action="infotut.php">
    <TABLE class="tabla" width="400" align="center">
      <TR>
        <TD colspan="4" id="filaprincipal" align="center">Seleccciona el Grupo</TD>
      </TR>
      <TR>
        <TD id="filasecundaria">Nivel:</TD>
        <TD style='vertical-align:middle;text-align:center'><SELECT name="nivel" onChange="submit()">
            <option style="width:30px;"><? echo $nivel;?></option>
            <? nivel();?>
          </SELECT></TD>
        <TD id="filasecundaria">Grupo:</TD>
        <TD style='vertical-align:middle;text-align:center'><select  name="grupo" onChange="submit()">
          <option style="width:30px;"><? echo $grupo;?></option>
          <? grupo($nivel);?>
        </select></TD>
      </TR>
                  </table>
                </FORM>
<?
}
?>  
<?php

echo"<form name='alumno' method='POST' action='activar.php'>
<div align='center'><table class=tabla style='width:540px'>";
echo '<TR> 
      <TD valign="middle" colspan="2" id="filaprincipal" align="center"> 
        Seleccion del Alumno.</td>
    </tr>';
echo " <td id=filasecundaria> Nombre del Alumno </td>";
echo "<td style='vertical-align:middle;'>";
echo"<select name='alumno'>";
echo "<OPTION></OPTION>";
if ($nivel == "" and $grupo == ""){ echo "<OPTION></OPTION>";} 
else
{
$alumno=mysql_query("SELECT CLAVEAL, APELLIDOS, NOMBRE, NIVEL, GRUPO FROM alma WHERE NIVEL like '$nivel%' and GRUPO like '$grupo%' ORDER BY APELLIDOS ASC, NOMBRE ASC");
 while($falumno = mysql_fetch_array($alumno))
 {
	 echo "<OPTION>$falumno[1], $falumno[2]</OPTION>";
	}
	}
echo "</td>";
echo "</select>";

echo"<tr>";
echo"<td id=filasecundaria>Tutor o tutora del grupo</td>";
echo"<td style='vertical-align:middle;'>";
if ($nivel == "" or $grupo == ""){ echo "";} 
else
{

echo "<span><input size=35 type='text' value ='$fprof[0]' name='tutor' style='color:brown; '></span>";
}
echo"</td>";

echo "<tr>";
echo "<td id=filasecundaria>Fecha (dd/mm/aa) prevista para la
 entrevista con los padres: </td>";
echo "<td style='vertical-align:middle;' nowrap>";
$today = date("j, n, Y");
$hoy = explode(",", $today);
$dia = $hoy[0];
$mes = $hoy[1];
$año = $hoy[2];
echo "<select name='fecha[2]'>";
echo "<option>$dia</option>";
for ($i=1;$i<32;$i++){echo "<option>$i</option>";}
echo "</select> de ";
echo "<select name='fecha[1]'>";
echo "<option>$mes</option>";
for ($i=1;$i<13;$i++){echo "<option>$i</option>";}
echo "</select> de ";
echo "<select name='fecha[0]'>";
echo "<option>$año</option>";
for ($i=2005;$i<2010;$i++){echo "<option>$i</option>";}
echo "</select> ";
echo"</td>";
echo '<tr><td colspan="2" align="center" style="padding:6px;"><input type=submit value="ACTIVAR INFORME"></TD></TR>';
echo "</table></div>";
?>
 </form>
		  </body>
</html>
