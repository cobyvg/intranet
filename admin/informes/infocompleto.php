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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Generator" content="Dev-PHP 1.9.4">
<title>Rellena informe tutorial</title>
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css"></head>
<body>
<div class="titulogeneral"> 
 INFORME TUTORIAL</div>

<?php
if($llenar)
{$id = $llenar;}
echo "<div align='center'>";
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,NIVEL,GRUPO,TUTOR, F_ENTREV, claveal FROM infotut_alumno WHERE ID='$id'");
$dalumno = mysql_fetch_array($alumno);
$foto='../../imag/fotos/'.$dalumno[6].'.jpg';
if (file_exists($foto)) {
	  	echo "<div style=padding:3px; align=center><img src='../../imag/fotos/$dalumno[6].jpg' border='2' width='100' height='119' /></div>";
}
if (empty($dalumno[0])) {
	echo "<p id='texto_en_marco'>Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo</p><div align=center style='margin-top:18'><br><input type='button' onClick='history.back(1)' value='Volver'></div>";
	exit;	
}
echo "<div class='titulin' style='background-color:white;'>$dalumno[1] $dalumno[0] <span style='color:#281'>($dalumno[2]-$dalumno[3])</span><br> <span style='color:brown'>Visita:</span> $dalumno[5]<br><span style='color:brown'>Tutor:</span> $dalumno[4]</div>";
$datos=mysql_query("SELECT asignatura, informe FROM infotut_profesor WHERE id_alumno='$id'");
if(mysql_num_rows($datos) > 0)
{
echo "<table class='tabla' align='center' width='750'>";
while($informe = mysql_fetch_array($datos))
{
	echo "<tr><td id='filasecundaria' style='color:black;' width='200'>$informe[0]</td>
		  <td style='padding:3px;line-height:16px;'>$informe[1]</td>";
	echo"</tr>";
}
echo"</table>";
}
else
{
echo '<p> Los Profesores no han rellenado aún su Informe</p>
<br>
<div align="center"><input name="volver" type="button" onClick="history.go(-1)" value="Volver"></div>';	}
?>
</div>
							
</body>
</html>
