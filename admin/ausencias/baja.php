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

<?php
include("../../menu.php");
$pr_trozos=explode(", ",$profe_baja);		
?>
<br />
<div align="center">
<div class="page-header" align="center">
<h2>Ausencias del profesorado <small> Profesores ausentes</small></h1>
<h3 class="muted"><? echo "$pr_trozos[1] $pr_trozos[0]";?></h3>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class="span5 offset1">
<div align="left">
<?
echo "<h3 align=center>Datos de la ausencia</h3><br />";
echo "<div class='well well-large'>";
echo '<table class="table table-striped" style="width:100$;">';
	echo "<tr>
		<th>Inicio</hd>
		<th>Fin</hd>
		<th>Horas</th>
		<th>Archivo adjunto</th>";
	echo "</tr><tr>";
	// Consulta de datos del alumno.
	$result = mysql_query ( "select inicio, fin, tareas, id, profesor, horas, archivo from ausencias  where id = '$id' order by inicio" );
	$row = mysql_fetch_array ( $result );
	$tar = $row[2];
	if ($row[5] > "0") {
		$hora = $row[5];
	}
	else{
		$hora = "Todas";
	}
	echo "
	<td nowrap>$row[0]</td>
	<td nowrap>$row[1]</td>
	<td>$hora</td>
	<td><a href='archivos/$row[6]'>$row[6]</a></td>";		
	echo "</tr></table>";
	echo "<hr>";
	if (strlen($tar) > '1'){
	echo "<legend class='text-warning'>Tareas para los Alumnos durante la Baja</legend>";
	echo "<p class='text-info'>$tar</p>";
	}
?>
</div>
</div>
</div>
<div class="span5">
<?	

	echo "<h3>Horario del Profesor hoy</h3><br />";
	echo "<table class='table table-striped table-bordered' style='width:auto'>
	<tr>
	<th>1ª Hora</th>
	<th>2ª Hora</th>
	<th>3ª Hora</th>
	<th>4ª Hora</th>
	<th>5ª Hora</th>
	<th>6ª Hora</th>
	</tr>";
	echo "<tr>";
	
	$ndia = date ( "w" );
	for ($i=1;$i<7;$i++){
	echo "<td align='center'>";	
	$hor = mysql_query("select a_asig, a_grupo, a_aula from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'");
	//echo "select a_asig, a_grupo, a_aula from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'<br>";
	$hor_asig=mysql_fetch_array($hor);
	if (mysql_num_rows($hor) > '0'){
	echo "Actividad<div style='color:#46a546;'><span style='font-weight:normal;'>$hor_asig[0]</div><br/>";
	if (strlen($hor_asig[2] > '1')){
	echo "Aula<div style='color:#9d261d'><span style='font-weight:normal;'>$hor_asig[2]</div><br />";
	}
	if (strlen($hor_asig[1]) > '1' and strstr($hor_asig[0], 'GU') == FALSE){
		$hor2 = mysql_query("select a_grupo from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'");
		echo "Grupos<div style='color:#08c'>";
	while($hor_bj = mysql_fetch_array($hor2)){
	echo "<span style='font-weight:normal;'>".$hor_bj[0]."</div><br /> ";
			}
	}
	}
	echo "</td>";
	}
	echo "</tr>";
	echo "</table>";
	
?>
</div>
</div>
</div>

</body>
</html>
