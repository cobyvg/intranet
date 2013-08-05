<?
session_start ();
include ("../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );

$profesor = $_SESSION ['profi'];
$cargo = $_SESSION ['cargo'];
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
  
if (isset($_POST['id'])) {
	$id = $_POST['id'];
} 
elseif (isset($_GET['id'])) {
	$id = $_GET['id'];
} 
else
{
$id="";
}
?>
<div class="page-header" align="center">
  <h2>Informes de Tareas <small> Informe por asignaturas</small></h2>
</div>
<br />
<?php
echo "<div align='center'>";

  if (isset($_POST['llenar'])) {
	$llenar = $_POST['llenar'];
} 
elseif (isset($_GET['llenar'])) {
	$llenar = $_GET['llenar'];
} 
else
{
$llenar="";
}

if(empty($llenar)){}else{$id = $llenar;}

$c = mysql_connect ( $db_host, $db_user, $db_pass );
echo "<div align='center'>";
$alumno = mysql_query ( "SELECT APELLIDOS,NOMBRE,tareas_alumnos.NIVEL,tareas_alumnos.GRUPO,tutor, FECHA, duracion, claveal FROM tareas_alumnos, FTUTORES WHERE FTUTORES.nivel = tareas_alumnos.nivel and FTUTORES.grupo = tareas_alumnos.grupo and ID='$id'", $c );
$dalumno = mysql_fetch_array ( $alumno );
$claveal = $dalumno [7];
$fecha_t = $dalumno[5];
   	$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto) and !(empty($dalumno[0]))) {
	echo "<div style='width:150px;margin:auto;'>";
	echo "<img src='../../xml/fotos/$claveal.jpg' border='2' width='100' height='119' style='margin-top:10px;border:1px solid #bbb;''  />";
	echo "</div><br />";
}
if (empty ( $dalumno [0] )) {
	echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Debes seleccionar un alumno en primer lugar.<br>Vuelve atrás e inténtalo de nuevo<br><br />
<input type="button" onClick="history.back(1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
	exit();
}

echo "<h4>$dalumno[1] $dalumno[0] <span>($dalumno[2]-$dalumno[3])</span><br><br /> <span>Fecha de Expulsión:</span> $dalumno[5] ($dalumno[6] días)<br><span>Tutor:</span> $dalumno[4]</h4><br />";

$datos = mysql_query ( "SELECT asignatura, tarea, confirmado, profesor FROM tareas_profesor WHERE id_alumno='$id'", $c );
if (mysql_num_rows ( $datos ) > 0) {
echo "<table class='table table-striped table-bordered' align='center' style='width:900px'>";
	while ( $informe = mysql_fetch_array ( $datos ) ) {
		echo "<tr><td style='width:160px;'><strong>$informe[0]</strong></td>
		<td style='width:220px;'>$informe[3]</td>
		  <td>$informe[1]</td>";
		echo "<td>$informe[2]</td>";
		echo "</tr>";
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

$datos1 = mysql_query("SELECT distinct materia, profesor from profesores, asignaturas WHERE materia = nombre and profesores.grupo = '$dalumno[2]-$dalumno[3]' and profesor not in (SELECT profesor FROM tareas_profesor WHERE id_alumno='$id') and materia not in (SELECT asignatura FROM tareas_profesor WHERE id_alumno='$id')  and abrev not like '%\_%' $frase");
while($informe1 = mysql_fetch_array($datos1))
{
	echo "<tr><td style='width:160px;'><strong>$informe1[0]</strong></td>
		<td style='width:220px;'>$informe1[1]</td>
		  <td></td><td></td>";
	echo"</tr>";
}

	
	echo "</table>";
} else {
	echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
Los Profesores no han rellenado aún su Informe de tareas.<br /><br />
<input name="volver" type="button" onClick="history.go(-1)" value="Volver" class="btn btn-danger">
</div></div><hr>';
}
mysql_close ( $c );
?>
</div>
	<? include("../../pie.php");?>								
</body>
</html>
