<?php 
// Control de errores
if (!$fecha or !$observaciones or !$causa or !$accion)
{
echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has introducido datos en alguno de los campos , y <strong> todos son obligatorios</strong>.<br> Vuelve atrás e inténtalo de nuevo.
</div></div><br />';exit();
}

$tutor0 = "select tutor from FTUTORES where nivel = '$nivel' and grupo = '$grupo'";
$tutor1 = mysql_query($tutor0);
$tutor2 = mysql_fetch_array($tutor1);
$tutor = $tutor2[0];
if ($alumno=="Todos, todos") {
$dia = explode("-",$fecha);
$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
	$td0=mysql_query("select apellidos, nombre, claveal from FALUMNOS where nivel='$nivel' and grupo='$grupo'");
	while ($td=mysql_fetch_array($td0)) {
$clave = $td[2];
$apellidos = $td[0];
$nombre = $td[1];
$query="insert into tutoria (apellidos, nombre, tutor,nivel,grupo,observaciones,causa,accion,fecha,claveal) values ('".$apellidos."','".$nombre."','".$tutor."','".$nivel."','".$grupo."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$clave."')";
mysql_query($query) or die("<p id='texto_en_marco'>Hay un problema para registrar los datos. Pide ayuda.</p>");
	}
}
else {
$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];
$dia = explode("-",$fecha);
$fecha2 = "$dia[2]-$dia[1]-$dia[0]";
		$query="insert into tutoria (apellidos, nombre, tutor,nivel,grupo,observaciones,causa,accion,fecha,claveal) values 
		('".$apellidos."','".$nombre."','".$tutor."','".$nivel."','".$grupo."','".$observaciones."','".$causa."','".$accion."','".$fecha2."','".$clave."')";
mysql_query($query) or die("<p id='texto_en_marco'>Hay un problema para registrar los datos. Pide ayuda.</p>");	
}

echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han introducido correctamente.
</div></div><br />';?>