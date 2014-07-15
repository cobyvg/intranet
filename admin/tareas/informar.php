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
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profesor = $_SESSION['profi'];
$cargo = $_SESSION['cargo'];
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
<body onload='alert("TAREAS POR EXPULSION O AUSENCIA DEL ALUMNO: Aquí se redactan las TAREAS de tu asignatura para un alumno que se va a ir del Centro.");'>
<?php
include("../../menu_solo.php");
include("menu.php");

?>
<div class="page-header" align="center">
  <h2>Informes de Tareas <small> Redactar Informe</small></h2>
</div>
<br />
<div align="center">
<div class="well well-large" style="width:600px;">
<form name="informar" method="POST" action="informar.php?id=<? echo $id;?>">         
<?php
 
  $c=mysql_connect ($db_host, $db_user, $db_pass);

echo "<input type='hidden'  name='ident' value='$id'>";
echo "<input type='hidden'  name='profesor' value='$profesor'>";
$alumno=mysql_query("SELECT tareas_alumnos.CLAVEAL, tareas_alumnos.APELLIDOS, tareas_alumnos.NOMBRE, tareas_alumnos.unidad, tareas_alumnos.id, tareas_alumnos.fecha, duracion, curso FROM tareas_alumnos, alma WHERE alma.claveal=tareas_alumnos.claveal and ID='$id'",$c);
$dalumno = mysql_fetch_array($alumno);
$n_cur=$dalumno[7];

if (empty($dalumno[0])) {
echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo.<br /><br /
><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	exit();	
}
$claveal=trim($dalumno[0]);
echo "<table align=center class='table table-striped'  style='margin-top:2px;width:320px'>";
echo "<tr><th>Alumno/a </th>
 <th>Grupo</th><th nowrap>Fecha Expulsión</th><th>Duración</th></tr>
<TR><td nowrap>$dalumno[1], $dalumno[2]</td>
<td>$dalumno[3]</td><td>$dalumno[5]</td><td>$dalumno[6]</td></tr></TABLE>";

   	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto) and !(empty($dalumno[0]))) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-top:10px;border:1px solid #bbb;''  />";
		echo "</div>";
	}
echo "<br /><table align=center class='table table-striped' width='560'>";
echo"<tr><th>";
echo "ASIGNATURA";
echo "</Th><Th>INFORME</Th></tr><TR>";
echo "<TD>";
$coinciden = mysql_query("SELECT materia FROM profesores WHERE profesor='$profesor' and grupo = '$dalumno[3]'", $c);
while($coinciden0 = mysql_fetch_row($coinciden)){
$asignatur = $coinciden0[0];
$asignatur = str_replace("nbsp;","",$asignatur);
$asignatur = str_replace("&","",$asignatur);
}

/*$as=mysql_query("SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ", $c);
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
}*/

$as=mysql_query("SELECT COMBASI FROM alma WHERE CLAVEAL='$claveal' ");
$asi=mysql_fetch_array($as);
$asi1 = substr($asi[0],0,strlen($asi[0]) -1);

$coinciden = mysql_query("SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]' and asignaturas.curso='$n_cur' and abrev not like '%\_%' and profesor = '$profesor'");
echo "<select name='asignatura' class='input-large'>";
if(mysql_num_rows($coinciden)<1 and stristr($_SESSION['cargo'],'1') == TRUE){
$coinciden = mysql_query("SELECT distinct materia, codigo FROM profesores, asignaturas WHERE asignaturas.nombre = profesores.materia and asignaturas.curso = profesores.nivel and grupo = '$dalumno[3]' and asignaturas.curso='$n_cur' and abrev not like '%\_%'");
}
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
$ya_hay=mysql_query("select tarea from tareas_profesor where asignatura = '$materia' and id_alumno = '$id'");
$ya_hay1=mysql_fetch_row($ya_hay);
$informe=$ya_hay1[0];
echo "<TD >";
echo "<textarea rows='6' cols='42' name='informe' class='span4'>$informe</textarea>";
echo "</TD>";
echo "</TABLE>";
mysql_close($c);
?>

<input name="submit1" type=submit value="Enviar Datos" class="btn btn-primary">
</form>
</div>
</div>
<? include("../../pie.php");?>		
</body>
</html>
