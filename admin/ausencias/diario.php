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
?>
<br />
<div align="center">
<div class="page-header">
<h2>Ausencias del profesorado <small> Profesores ausentes hoy</small></h2>
</div>
<?	
$hoy = date('Y-m-d');

	// Consulta de datos del alumno.
	$result = mysql_query ( "select inicio, fin, tareas, id, profesor, horas from ausencias  where  date(inicio) <= '$hoy' and date(fin) >= '$hoy' order by inicio" );
	echo '<br /><table class="table table-striped table-bordered" style="width:auto;">';	
	echo "
	<tr>
	<th>1ª Hora</th>
	<th>2ª Hora</th>
	<th>3ª Hora</th>
	<th>4ª Hora</th>
	<th>5ª Hora</th>
	<th>6ª Hora</th>
	</tr>";
	while($row = mysql_fetch_array ( $result )){
	
	$profe_baja=$row[4];
	$tar = $row[2];

	echo "<tr><td colspan='5' style='text-align:center'>";
		echo "<div style='color:#777;'><span style='font-weight:bold;'>$profe_baja</div>";
		echo "</td></tr><tr>";
	$ndia = date ( "w" );
	for ($i=1;$i<7;$i++){
	echo "<td align='center'>";	
	$hor = mysql_query("select a_asig, a_grupo, a_aula from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'");
	//echo "select a_asig, a_grupo, a_aula from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'<br>";
	$hor_asig=mysql_fetch_array($hor);
	if (mysql_num_rows($hor) > '0'){

	echo "<div style='color:#46a546;'>Horario: <span style='font-weight:normal;'>$hor_asig[0]</div>";
	if (strlen($hor_asig[1]) > '1' and strstr($hor_asig[0], 'GU') == FALSE){
		$hor2 = mysql_query("select a_grupo from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'");
		echo "<div style='color:#08c'>Grupos: ";
	while($hor_bj = mysql_fetch_array($hor2)){
	echo "<span style='font-weight:normal;'>".$hor_bj[0]."</div> ";
			}
	}
	if (strlen($hor_asig[2] > '1')){
	echo "<div style='color:#9d261d'>Aula: <span style='font-weight:normal;'>$hor_asig[2]</div>";
	}
	}
	echo "</td>";
	}
	echo "</tr>";

}
echo "</table>";
echo "<hr style='width:600px;'><br /><h3>Tareas para los Alumnos</h3>";
$result2 = mysql_query ( "select inicio, fin, tareas, id, profesor, horas, archivo from ausencias  where date(inicio) <= '$hoy' and date(fin) >= '$hoy' order by inicio" );
	while($row2 = mysql_fetch_array ( $result2 )){
	$profe_baja=$row2[4];
	$tar = $row2[2];
	if (strlen($tar) > '1'){
	echo '<br /><table class="table table-striped table-bordered" style="width:650px">';	
	echo "
	<tr><td><h5 align='center'><span style='color:#777'>$profe_baja</span</h5></td></tr>
	<tr><td>$tar</td></tr>
	";
	if (strlen($row2[6])>0) {
		echo "<tr class='info'><td>Archivo adjunto:&nbsp; <a href='archivos/$row2[6]'><i class='fa fa-file-o'> </i> $row2[6]</a></td></tr>";
	}
	echo "</table><br />";
	}
	}
	
?>
</body>
</html>
