<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
$pr = $_SESSION['profi'];
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
<?php
include("../../menu.php");
?>
<div class="titulogeneral" style="margin-top:20px;">Informes de Tutor&iacute;a</div>
  
 <form name="informar" method="POST" action="rellenainf.php">         
<?php
 
if($llenar)
{$id=$_POST['llenar'];}

echo "<input type='hidden'  name='ident' value='$id'>";
echo "<input type='hidden'  name='profesor' value='$pr'>";
$alumno=mysql_query("SELECT CLAVEAL,APELLIDOS,NOMBRE,NIVEL,GRUPO FROM infotut_alumno WHERE ID='$id'");
$dalumno = mysql_fetch_array($alumno);
  echo "<div align=center>
  <div class=titulogeneral style='width:600px;margin:auto;margin-top:25px;margin-bottom:5px;color:#281'>Alumno: <span style='color:brown;'>$dalumno[2] $dalumno[1]</span> Grupo:<span style='color:brown;font-size:1.1em;'>$dalumno[3]-$dalumno[4] </span></div>
</div><br>";
if (empty($dalumno[0])) {
	echo "<p id='texto_en_marco'>Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo</p><div align=center style='margin-top:18'><br><input type='button' onClick='history.back(1)' value='Volver'></div>";
	exit;	
}
$claveal=trim($dalumno[0]);
echo "<table align=center class='tabla' width='320' style='margin-top:2px;'>";
echo "<td id='filaprincipal'>ALUMNO/A </td>
 <td id='filaprincipal'>CURSO</TD>
<TR><td>$dalumno[1], $dalumno[2]</td>
<td>$dalumno[3] $dalumno[4]</td></TABLE>";
$foto='../../imag/fotos/'.$claveal.'.jpg';
if (file_exists($foto)) {
	  	echo "<div style=padding:3px; align=center><img src='../../imag/fotos/$claveal.jpg' border='2' width='100' height='119' /></div>";
}
echo "<table align=center class='tabla' width='500'>";
echo"<td id='filasecundaria' align=center>";
echo "ASIGNATURA";
echo "</TD><TD  id='filasecundaria' align=center>INFORME</TD><TR>";
echo "<TD style='vertical-align:middle;'>";
$coinciden = mysql_query("SELECT materia FROM profesores WHERE profesor='$pr' and grupo = '$dalumno[3]-$dalumno[4]'");
while($coinciden0 = mysql_fetch_row($coinciden)){
$asignatur = $coinciden0[0];
$asignatur = str_replace("nbsp;","",$asignatur);
$asignatur = str_replace("&","",$asignatur);
}
echo "<select name='asignatura'>";
echo"<OPTION></OPTION>";
$as=mysql_query("SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ");
$asi=mysql_fetch_array($as);
$asi1 = substr($asi[0],0,strlen($asi[0]) -1);
$asig0 = explode(":",$asi1);
foreach($asig0 as $asignatura){			
$abrev = mysql_query("select distinct nombre from asignaturas where codigo = '$asignatura'  and abrev not like '%\_%' limit 1");
				while($abrev0 = mysql_fetch_row($abrev)){
				$nombre10 = $abrev0[0];
				if($nombre10 == $asignatur){
				echo "<OPTION selected='selected'>$nombre10 </OPTION>";
				}
				else {echo"<OPTION>$nombre10</OPTION>";}

}
}
echo "</select>";

echo "</td>";
echo "<TD >";
echo "<textarea rows='6' cols='42' name='informe'> </textarea>";
echo "</TD>";
echo "</TABLE>";
?>
<center>
<input type=submit value="Enviar Datos"></center><br>
</form>
</div>
</body>
</html>
