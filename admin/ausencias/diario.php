<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


?>

<?php
include("../../menu.php");
?>
<div class="container">
<div class="row">
<br />
<div class="page-header">
<h2>Ausencias del profesorado <small> Profesores ausentes hoy</small></h2>
</div>
<div class="col-md-8 col-md-offset-2">
<?	
$hoy = date('Y-m-d');

	// Consulta de datos del alumno.
	$result = mysqli_query($db_con, "select inicio, fin, tareas, id, profesor, horas from ausencias  where  date(inicio) <= '$hoy' and date(fin) >= '$hoy' order by inicio" );
	echo '<br /><table class="table table-striped table-bordered" style="width:100%;">';	
	echo "
	<thead>
	<th>1ª Hora</th>
	<th>2ª Hora</th>
	<th>3ª Hora</th>
	<th>4ª Hora</th>
	<th>5ª Hora</th>
	<th>6ª Hora</th>
	</thead><tbody>";
	while($row = mysqli_fetch_array ( $result )){
	
	$profe_baja=$row[4];
	$tar = $row[2];

	echo "<tr><th colspan='6' style='text-align:center'>";
		echo "$profe_baja";
		echo "</th></tr><tr>";
	$ndia = date ( "w" );
	for ($i=1;$i<7;$i++){
	echo "<td>";	
	$hor = mysqli_query($db_con, "select a_asig, a_grupo, a_aula from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'");
	//echo "select a_asig, a_grupo, a_aula from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'<br>";
	$hor_asig=mysqli_fetch_array($hor);
	if (mysqli_num_rows($hor) > '0'){

	echo "<p class='text-info'>Horario: $hor_asig[0]</p>";
	if (strlen($hor_asig[1]) > '1' and strstr($hor_asig[0], 'GU') == FALSE){
		$hor2 = mysqli_query($db_con, "select a_grupo from horw where prof = '$profe_baja' and dia = '$ndia' and hora = '$i'");
		echo "<p class='text-success'>Grupos: ";
	while($hor_bj = mysqli_fetch_array($hor2)){
	echo $hor_bj[0]." ";
			}
			echo "</p>";
	}
	if (strlen($hor_asig[2] > '1')){
	echo "<p class='text-warning'>Aula: <span style='font-weight:normal;'>$hor_asig[2]</p>";
	}
	}
	echo "</td>";
	}
	echo "</tr>";

}
echo "</table>";
echo "<br /><legend>Tareas para los Alumnos</legend>";
$result2 = mysqli_query($db_con, "select inicio, fin, tareas, id, profesor, horas, archivo from ausencias  where date(inicio) <= '$hoy' and date(fin) >= '$hoy' order by inicio" );
	while($row2 = mysqli_fetch_array ( $result2 )){
	$profe_baja=$row2[4];
	$tar = $row2[2];
	if (strlen($tar) > '1'){
	echo '<table class="table table-striped table-bordered">';	
	echo "
	<tr><th class='text-center'>$profe_baja</th></tr>
	<tr><td>$tar</td></tr>
	";
	if (strlen($row2[6])>0) {
		echo "<tr class='info'><td>Archivo adjunto:&nbsp; <a href='archivos/$row2[6]'><i class='fa fa-file-o'> </i> $row2[6]</a></td></tr>";
	}
	echo "</table><br />";
	}
	}
	
?>
</div>
</div>
</div>
<?
include("../../pie.php");
?>
</body>
</html>
