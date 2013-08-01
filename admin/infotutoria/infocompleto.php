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
<!DOCTYPE html>  
<html lang="es">  
  <head>  
    <meta charset="iso-8859-1">  
    <title>Intranet</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
  
    <!-- Le styles -->  

    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.css" rel="stylesheet"> 
    <?
	if($_SERVER ['REQUEST_URI'] == "/intranet/index0.php"){
		?>
    <link href="http://<? echo $dominio;?>/intranet/css/otros_index.css" rel="stylesheet">  
        <?
	}
		else{
		?>
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">     
        <?	
		}
	?>
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->  
    <!--[if lt IE 9]>  
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>  
    <![endif]-->  
  
    <!-- Le fav and touch icons -->  
    <link rel="shortcut icon" href="http://<? echo $dominio;?>/intranet/img/favicon.ico">  
    <link rel="apple-touch-icon" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon.png">  
    <link rel="apple-touch-icon" sizes="72x72" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon-72x72.png">  
    <link rel="apple-touch-icon" sizes="114x114" href="http://<? echo $dominio;?>/intranet/img/apple-touch-icon-114x114.png"> 
    <script type="text/javascript"
	src="http://<? echo $dominio;?>/intranet/recursos/js/buscar_alumnos.js"></script>  
  </head>  
<body>
<?php 
include("../../menu_solo.php");
  include("menu.php");
?>
<div class="page-header" align="center">
  <h2>Informes de Tutoría <small> Informes por asignatura</small></h2>
</div>
<br />

<?php
if($llenar)
{
	$id = $llenar;}
echo "<div align='center'>";
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,NIVEL,GRUPO,TUTOR, F_ENTREV, CLAVEAL FROM infotut_alumno WHERE ID='$id'");

$dalumno = mysql_fetch_array($alumno);
$claveal=$dalumno[6];
   	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto)) {
		echo "<div style='width:150px;margin:auto;'>";
		echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-top:10px;border:1px solid #bbb;''  />";
		echo "</div><br />";
	}
	
if (empty($dalumno[0])) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo<br><br /><input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	exit;	
}
echo "<h3>$dalumno[1] $dalumno[0] ($dalumno[2]-$dalumno[3])</h3><h4><br>Visita: $dalumno[5]<br>Tutor: $dalumno[4]</h4><br />";

$datos=mysql_query("SELECT asignatura, informe, id, profesor FROM infotut_profesor WHERE id_alumno='$id'");
if(mysql_num_rows($datos) > 0)
{
echo "<table class='table table-striped table-bordered' align='center' style='width:900px'>";
while($informe = mysql_fetch_array($datos))
{
$fondo = "";
if($informe[0] == $c_asig){$fondo="background-color:#dff0d8;";}
	echo "<tr><td style='width:160px;'><strong>$informe[0]</strong></td>
			<td style='width:220px;'>$informe[3]</td>
		  <td>$informe[1]</td>";
		if (strlen($fondo) > '0') {
		echo "<td><a href='borrar.php?del=1&id_del=$informe[2]&id_alumno=$id&asignatura=$asignatura&profesor=$informe[3]'><i
		class='icon icon-trash' title='Borrar'></a></td>";
	}
	echo"</tr>";
}

$combas = mysql_query("select combasi from alma where claveal = '$claveal'");
$combasi = mysql_fetch_array($combas);
$tr_comb = explode(":",$combasi[0]);
$frase=" and (";
foreach ($tr_comb as $codasi)
{
	$frase.="codigo = '$codasi' or ";
}
$frase = substr($frase,0,-19).")";

$datos1 = mysql_query("SELECT distinct materia, profesor from profesores, asignaturas WHERE materia = nombre and profesores.grupo = '$dalumno[2]-$dalumno[3]' and profesor not in (SELECT profesor FROM infotut_profesor WHERE id_alumno='$id') and materia not in (SELECT asignatura FROM infotut_profesor WHERE id_alumno='$id')  and abrev not like '%\_%' $frase");
while($informe1 = mysql_fetch_array($datos1))
{
	echo "<tr><td style='width:160px;'><strong>$informe1[0]</strong></td>
		<td style='width:220px;'>$informe1[1]</td>
		  <td></td>";
	echo"</tr>";
}


echo"</table>";
}
else
{
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Los Profesores no han rellenado aún su Informe.<br />
<input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	}
?>
</div>
	<? include("../../pie.php");?>								
</body>
</html>
