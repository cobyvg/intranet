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
<SCRIPT LANGUAGE=javascript>

function wait(){
string="document.forms.libros.submit();";
setInterval(string,540000);
}

</SCRIPT>
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
<body onload=wait()>
<?
include("../../menu.php");
if ($datos) {
$partes = explode("-->",$datos);
$materia = $partes[1];
$grupo0 = explode("-",$partes[0]);
$nivel = $grupo0[0];
$grupo = $grupo0[1];
$codigo = $partes[3];
$curso = $partes[2];
}
?>

<div align="center">
<span class="subtitulogeneral" style="margin-top:10px;margin-bottom:18px;line-height:24px;">
Evaluación de las competencias de los alumnos <br><span style=" color:brown;font-weight:bold;"><? echo $nivel."-".strtoupper($grupo);?></span> --> <span style=" color:green;font-weight:bold;"><? echo strtoupper($materia);?></span></span>
<?

foreach($_POST as $key0 => $val0)
{

if(strlen($val0) > "0"){$tarari=$tarari+1;}
}
if($tarari>"0"){
foreach($_POST as $key => $val)
{

$trozos = explode("-",$key);
$claveal = $trozos[0];
$idc = $trozos[2];
if($val == "1" or $val == "2" or $val == "3" or $val == "4" or $val == "5"){$asignatura = $trozos[1];$fila_asig = $fila_asig + "1";}

if(is_numeric($claveal) and strlen($val)>0)
{
		//echo "$key --> $val <br>";
		$query = "select nota from competencias where claveal = '$claveal' and materia = '$asignatura' and curso = '$curso_actual' and idc = '$idc'";
		//echo $query;
		$edit = mysql_query($query);
		$estado0 = mysql_fetch_array($edit);
		$estado = $estado0[0];
		$prof_reg = $_SESSION['profi'];
		if(strlen($estado) > 0){
		mysql_query("update competencias set nota = '$val' where claveal = '$claveal' and materia = '$asignatura' and idc = '$idc'");		
		}
		else{
		mysql_query("insert into competencias (idc, claveal, materia, nota, fecha, curso, profesor, grupo) values ('$idc', '$claveal','$asignatura','$val',now(),'$curso_actual', '$prof_reg', '$nivel-$grupo')");
		}
}
//else{
//	echo "<p id='texto_en_marco' style='background-color:#eff;'>Alguno de los datos que has escrito no es correcto. Recuerda que sólo se admite como nota un número entre 1 y 5.</p>";
//}
}
if($procesar == "Enviar datos"){
	
echo "<p id='texto_en_marco' style='margin-bottom:10px;'>Los datos de la evaluación de competencias se han actualizado correctamente en la base de datos.</p>";}
// echo "<div align=center><input type=button value='Volver atrás' onClick='history.back(-1)'></div>";
}
$claveal = "";
?>
<table align="center" style="margin-top:25px;min-width:940px;"><tr><td valign="top">


<form action="competencias.php" method="post" name="libros" class="formu">

<?
echo "<table class=tabla align=center style=margin:0px;>";
echo "<tr><td></td>";
$asignaturas0 = "select distinct nombre, id, abreviatura from competencias_lista order by id";

$asignaturas1 = mysql_query($asignaturas0);
$num_asig = mysql_num_rows($asignaturas1);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	

	echo "<td id=filaprincipal align=center>$asignaturas[2]</td>";
}
$alumnos0 = "select nc, FALUMNOS.apellidos, FALUMNOS.nombre, combasi, FALUMNOS.claveal, unidad from FALUMNOS, alma where alma.claveal = FALUMNOS.claveal and FALUMNOS.nivel = '$nivel' and FALUMNOS.grupo = '$grupo' and combasi like '%$codigo%' order by FALUMNOS.apellidos, FALUMNOS.nombre, nc"; 

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
		$query = "select nota from competencias where claveal = '$claveal' and materia = '$codigo' and curso = '$curso_actual' and idc = '$i'";
		//echo $query;
		$edit = mysql_query($query);
		$estado0 = mysql_fetch_array($edit);
		$nota = $estado0[0];
?>
    <input type="text" name="<? echo $r_nombre;?>" <? if($nota > "0"){echo "value='$nota'";} ?> maxlength="1" size="5" onKeypress="if ((event.which > 32 && event.which < 49) || (event.which > 53 && event.which < 256) || (event.which > 90 && event.which < 97)) return false;" /><br /> 
<?
	echo "</td>";		
	$nota = "";
	$estado0[0] = "";	
	}
echo "</tr>";
	}
echo "</table>";
$datos0="$nivel-$grupo-->$materia-->$curso-->$codigo";
?>
<div align="center">

<input type="hidden" name="datos" value="<? echo $datos0;?>" /><br>
<input type="submit" name="procesar" value="Enviar datos" style = 'background-color:#CCC;font-size:12px;padding:3px;margin-left:480px;'/>
</div>
</form>
<br />
</td>
<td valign="top">

<div align=center>
<div style="border:1px solid #bbb;padding:4px 8px;width:180px;background-color:#eee">
<a href="index.php" style="font-size:100%;font-weight:normal;">Seleccionar otro <? echo $extra; ?></a>
</div>
<div class="subtitulogeneral" style="width:220px;">LEYENDA</div><p style='text-align:left;'><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.L.</span> = C. Linguística, <br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.M.</span> = C. Matemática, <br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.M.F.N.</span> = C. Conocimiento del Medio Natural, <br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.D.</span> = C. Digital, <br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.S.</span> = C. Social y Ciudadana.<br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.C.A.</span> = C. Cultural y Artística.<br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.A.</span> = C. Aprender a Aprender.<br /><span style="padding-left:25px;color:green;font-weight:bold;font-size:12px;">C.I.P.</span> = C. Iniciativa Personal.</p>
<div class="subtitulogeneral" style="width:220px;">Instrucciones de uso</div>
<p style="width:250px;text-align:left;">
- Para rellenar las notas de la evaluación de competencias, hacer click con el ratón sobre la casilla de una competencia e introducir un número entre el 1 (nota más baja) y el 5 (nota más alta).<br /> 
- Para mayor rapidez en el registro de los datos, es una buena idea utilizar la tecla Tab para moverse hacia adelante en las casillas, en vez de hacer click con el ratón. Así, después de escribir una nota apretamos la tecla tab y saltamos a la siguiente.<br />
- En el caso de desdobles, los distintos profesores de la asignatura en un grupo introducirán las notas de sus alumnos, dejando al resto de los profesres de la asignatura rellenar las notas de sus alumnos.
</p>
</div>
</td></tr></table>
</body>
</html>