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
if(stristr($_SESSION['cargo'],'1') == TRUE)
{
	$extra= " Profesor";
	
}
else{
	$extra= " Grupo";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
<style>
input{
	margin-left:0px;
	background-color:#FFe;
	}
.style1 {
	font-size: 11px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}

</style>
<title>Evaluación de Competencias</title>

</head>
<body>
<?
include("../../menu.php");
?>

<div align="center">
<span class="subtitulogeneral" style="margin-top:10px;margin-bottom:18px;line-height:24px;">
Evaluación de las competencias de los alumnos <br><span style=" color:brown;font-weight:bold;"><? echo $nivel."-".strtoupper($grupo);?></span> --> <span style=" color:green;font-weight:bold;"><? echo strtoupper($tutor);?></span></span>
<div align="center"><p style='font-size:10px;color:#888''>(Entre paréntesis aparece el número de profesores del equipo Educativo<br> que han evaluado esa competencia, y sobre el cual se hace la media.)</p></div>
<?
echo "<table class=tabla align=center style=margin:0px;>";
echo "<tr><td></td>";
$curso0 = "select distinct curso from alma where unidad = '$nivel-$grupo'";
$curso1 = mysql_query($curso0);
$curso2 = mysql_fetch_array($curso1);
$curso = $curso2[0];
$asignaturas0 = "select distinct nombre, id, abreviatura from competencias_lista order by id";
$asignaturas1 = mysql_query($asignaturas0);
$num_asig = mysql_num_rows($asignaturas1);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	

	echo "<td id=filaprincipal align=center>$asignaturas[2]</td>";
}
$alumnos0 = "select nc, FALUMNOS.apellidos, FALUMNOS.nombre, combasi, FALUMNOS.claveal, unidad from FALUMNOS, alma where alma.claveal = FALUMNOS.claveal and FALUMNOS.nivel = '$nivel' and FALUMNOS.grupo = '$grupo' order by FALUMNOS.apellidos, FALUMNOS.nombre, nc"; 

$alumnos1 = mysql_query($alumnos0);
while ($alumnos = mysql_fetch_array($alumnos1)) {
	$nc="$alumnos[0]. $alumnos[1], $alumnos[2]";
	$fila_asig = $alumnos[0];

	echo "<tr><td id=filasecundaria valign=middle>$nc</td>";
	for ($i=1;$i<9;$i++){

		echo "<td nowrap style='padding:0px;margin:0px;'>";
		$claveal = $alumnos[4];
		$asignatura = $alumnos[0];
		$r_nombre = $claveal."-".$codigo."-".$i;
		$query = "select nota from competencias where claveal = '$claveal' and curso = '$curso_actual' and idc = '$i' and grupo = '$nivel-$grupo'";
		//echo $query;
		$edit = mysql_query($query);
		$asig = mysql_num_rows($edit);
		$nota = "";
		while($estado0 = mysql_fetch_array($edit))
		{
			$nota+=$estado0[0];
		}
		$r_nota=$nota/$asig;
		//echo "$nota/$asig<br>";
		$r_nota =  substr($r_nota,0,4);
		//echo substr($r_nota,0,4)."<br>";
//		echo "<span style=color:#281;>$r_nota<span style=color:#aaa>($asig)</span>";
		

		if (strstr($r_nota,".") == TRUE) {
			$nota=substr($r_nota,0,4);
		}
		if ($r_nota >= '2.5') {
			echo "<span style=color:#281;>$r_nota<span style=color:#999>($asig)</span>";
		}
if($r_nota < '2.5' and $asig > '0'){
			echo "<span style=color:brown;>$r_nota<span style=color:#999>($asig)</span>";
}
		echo "</td>";	
	}
		
	$nota = "";
	$estado0[0] = "";	
	
echo "</tr>";
	}
echo "</table>";
?>
<br />
<div class="subtitulogeneral" align = 'center' style="margin-top:10px;margin-bottom:18px;line-height:24px;">Profesores y Competencias evaluadas</div>
<table class=tabla align="center" width=650>
<tr><td id="filaprincipal">Profesor</td><td id="filaprincipal">Materia</td><td id="filaprincipal">Competencias</td></tr><tr><td></tr>
<?
$niv = substr($nivel,0,1)."º de E";
$pr=mysql_query("Select distinct profesor, materia from profesores where grupo='$nivel-$grupo' and profesores.nivel = '$curso'");
//$pr=mysql_query("Select distinct profesor, materia, codigo from profesores, asignaturas where materia = nombre and grupo='$nivel-$grupo' and abrev not like '%\_%' and profesores.nivel = '$curso'");
//echo "Select distinct profesor, materia, codigo from profesores, asignaturas where materia = nombre and grupo='$nivel-$grupo' and abrev not like '%\_%' and profesores.nivel = '$niv%'";
while ($profesores = mysql_fetch_array($pr)) {
	$cod = mysql_query("select distinct codigo from asignaturas where nombre = '$profesores[1]' and abrev not like '%\_%' and curso = '$curso'");
	//echo "select distinct codigo from asignaturas where nombre = '$profesores[1]' and abrev not like '%\_%' and curso = '$curso'";
	$cod1 = mysql_fetch_array($cod);
	$codasi = $cod1[0];
	echo "<tr><td style=background-color:#eee;>$profesores[0]</td><td style=background-color:#efffef;>$profesores[1]</td><td style=background-color:#effeff;>";
	$comp = mysql_query("select distinct idc, materia, abreviatura from competencias, competencias_lista, alma where alma.claveal = competencias.claveal and competencias_lista.id = idc and profesor = '$profesores[0]' and materia = '$codasi' and unidad = '$nivel-$grupo'");
	// echo "select distinct idc, materia, abreviatura from competencias, competencias_lista, alma where alma.claveal = competencias.claveal and competencias_lista.id = idc and profesor = '$profesores[0]' and materia = '$profesores[2]' and unidad = '$nivel-$grupo'";
	$competencia = "";
	while ($compet = mysql_fetch_array($comp)) {
		$competencia.="$compet[2], ";
	}
	$competencias = substr($competencia, 0, -2);
	echo "$competencias</td></tr>";
}
?>

</table>

</body>
</html>