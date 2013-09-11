<?
if (isset($_POST['submit1']) and $_POST['submit1']=="Enviar Datos") {
	include("rellenainf.php");
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
$pr = $_SESSION['profi'];
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">    
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
  </head>  
<body onload='alert("INFORMES DE TUTORIA: Aquí se rellenan los Informes para el Tutor ante la visita de los Padres de uno de tus Alumnos.");'>
<?php
include("../../menu_solo.php");
include("menu.php");
?>
<div class="page-header" align="center">
  <h2>Informes de Tutoría <small> Redactar Informe por asignatura</small></h2>
</div>
<br />
<div align="center">
        
<?php

$alumno=mysql_query("SELECT infotut_alumno.CLAVEAL, infotut_alumno.APELLIDOS, infotut_alumno.NOMBRE, infotut_alumno.NIVEL, infotut_alumno.GRUPO, curso FROM infotut_alumno, alma WHERE alma.claveal=infotut_alumno.claveal and ID='$id'");
$dalumno = mysql_fetch_array($alumno);
$n_cur=$dalumno[5];
if (empty($dalumno[0])) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo
<br><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-primary">
		</div></div>';
	exit;	
}
?>
<div class="well well-large" style="width:600px;">
 <form name="informar" method="POST" action="informar.php?id=<? echo $id;?>"> 
<?
echo "<input type='hidden'  name='ident' value='$id'>";
echo "<input type='hidden'  name='profesor' value='$pr'>";
$claveal=trim($dalumno[0]);
if (empty($dalumno[0])) {
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo.<br /><br /
><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	exit();	
}
echo "<table align=center class='table table-striped'  style='margin-top:2px;width:320px'>";
echo "<tr><th>ALUMNO/A </th>
 <th>CURSO</Th></tr>
<TR><td>$dalumno[1], $dalumno[2]</td>
<td>$dalumno[3] $dalumno[4]</td></tr></TABLE>";
   	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto) and !(empty($dalumno[0]))) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-top:10px;margin-bottom:10px;border:1px solid #bbb;'  />";
		echo "</div>";
	}
echo "<br /><table align=center class='table table-striped' width='560'>";
echo"<tr><th>";
echo "ASIGNATURA";
echo "</Th><Th>INFORME</Th></tr><TR>";
echo "<TD>";
$coinciden = mysql_query("SELECT materia FROM profesores WHERE profesor='$pr' and grupo = '$dalumno[3]-$dalumno[4]'");
while($coinciden0 = mysql_fetch_row($coinciden)){
$asignatur = $coinciden0[0];
$asignatur = str_replace("nbsp;","",$asignatur);
$asignatur = str_replace("&","",$asignatur);
}

$as=mysql_query("SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ");
$asi=mysql_fetch_array($as);
$asi1 = substr($asi[0],0,strlen($asi[0]) -1);
$coinciden = mysql_query("SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]-$dalumno[4]' and asignaturas.curso='$n_cur' and abrev not like '%\_%' and profesor = '$pr'");
if(mysql_num_rows($coinciden)<1 and stristr($_SESSION['cargo'],'1') == TRUE){
$coinciden = mysql_query("SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]-$dalumno[4]' and asignaturas.curso='$n_cur' and abrev not like '%\_%'");	
}
echo "<select name='asignatura' class='input-large'>";
echo"<OPTION></OPTION>";
while($coinciden0 = mysql_fetch_row($coinciden)){
$n_asig = $coinciden0[0];
$cod = $coinciden0[1];
if (strstr($asi1,$cod)==TRUE) {
				if($n_asig == $asignatur){
				$materia = $n_asig;
				echo "<OPTION selected='selected'>$n_asig </OPTION>";
				}
				else {echo"<OPTION>$n_asig</OPTION>";}
}
}

echo "</select>";

echo "</td>";
$ya_hay=mysql_query("select informe from infotut_profesor where asignatura = '$materia' and id_alumno = '$id'");
$ya_hay1=mysql_fetch_row($ya_hay);
$informe=$ya_hay1[0];
echo "<TD >";
echo "<textarea rows='6' cols='42' name='informe' class='span4'>$informe</textarea>";
echo "</TD>";
echo "</TABLE>";
?>
<input name="submit1" type=submit value="Enviar Datos" class="btn btn-primary">
</form>
</div>
</div>
<? include("../../pie.php");?>		
</body>
</html>
