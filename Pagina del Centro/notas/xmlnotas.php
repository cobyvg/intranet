<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$claveal = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];

	$curso = $unidad;
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	
<?
 $rown1[]="";
 $rown2[]="";
 $rown3[]="";
 $rown4[]="";
   	echo "<h3 align='center'>$todosdatos<br /></h3>";   	
   	echo "<p class='lead muted' align='center'><i class='icon icon-gears'> </i> Resultados de la Evaluación del Alumno</p><hr />";
?>
<?

echo "<br><table class='table table-bordered table-striped table-hover' style='margin:auto;width:auto'>
		<tr class='text-info'><th>Asignatura / Materia</th><th>1Ev.</th><th>2Ev.</th><th>Ord.</th><th>Ext.</th></tr>";

// Evaluaciones
$notas1 = "select notas1, notas2, notas3, notas4, unidad from alma, notas where alma.CLAVEAL1 = notas.claveal and alma.CLAVEAL = '$clave_al'";
//echo $notas1;
$result1 = mysql_query($notas1);
$row1 = mysql_fetch_array($result1);
$asignatura1 = substr($row1[0], 0, strlen($row1[0])-1);
$trozos1 = explode(";", $asignatura1);
$num = count($trozos1);
 for ($i=0;$i<$num; $i++)
  {
$nombre_asig ="";
$bloque = explode(":", $trozos1[$i]);
$nombreasig = "select NOMBRE, ABREV, CURSO, CODIGO from asignaturas where CODIGO = '" . $bloque[0] . "'  order by CURSO";
$asig = mysql_query($nombreasig);
if(mysql_num_rows($asig) < 1)	{$nombre_asig = "Asignatura sin código"; }
while($rowasig = mysql_fetch_array($asig))	{
  if ($rowasig[3] == "")
  {$nombre_asig = "Asignatura sin código"; }
else{
$nombre_asig = $rowasig[0];
}	
	if(strlen(strstr($rowasig[1],'_')) > 0)	{	}

	else 	{	$asig_pend = $rowasig[2];	}	
	}
$califica1 = "select nombre from calificaciones where codigo = '" . $bloque[1] . "'";

$numero1 = mysql_query($califica1);
$rown1 = mysql_fetch_array($numero1);




$asignatura2 = substr($row1[1], 0, strlen($row1[1])-1);
$trozos2 = explode(";", $asignatura2);
	if (strstr($row1[1],$bloque[0])) {
	foreach($trozos2 as $codi2)
	{
	$bloque2 = explode(":", $codi2);
	if($bloque2[0] == $bloque[0])
	{
$califica2 = "select nombre from calificaciones where codigo = '" . $bloque2[1]. "'";
$numero2 = mysql_query($califica2);
$rown2 = mysql_fetch_array($numero2);
	}
	}	
	}
	else{
		$rown2[0]=" ";
	}
	
	
	
$asignatura3 = substr($row1[2], 0, strlen($row1[2])-1);
$trozos3 = explode(";", $asignatura3);
	if (strstr($row1[2],$bloque[0])) {
	foreach($trozos3 as $codi3)
	{
	$bloque3 = explode(":", $codi3);
	if($bloque3[0] == $bloque[0])
	{
$califica3 = "select nombre from calificaciones where codigo = '" . $bloque3[1]. "'";
$numero3 = mysql_query($califica3);
$rown3 = mysql_fetch_array($numero3);
//if($rown3[0] == "No Presentado"){
//	$rown3[0] = "NP";
//}
	}
	}
	}
	else{
		$rown3[0]=" ";
	}
	
	
	
$asignatura4 = substr($row1[3], 0, strlen($row1[3])-1);
$trozos4 = explode(";", $asignatura4);
	if (strstr($row1[3],$bloque[0])) {
		foreach($trozos4 as $codi4)
	{
	$bloque4 = explode(":", $codi4);
	
	if($bloque[0] == $bloque4[0])
	{
$califica4 = "select nombre from calificaciones where codigo = '" . $bloque4[1]. "'";
$numero4 = mysql_query($califica4);
$rown4 = mysql_fetch_array($numero4);
	}
	}
	}
	else{
		$rown4[0]=" ";
	}


	
	
	
	
if($rown1[0] == "" and $rown2[0] == "" and $rown3[0] == "" and $rown4[0] == "")
	{
			}
	else
		{
	echo "<tr><td>";
	if ($nombre_asig == "Asignatura sin código")  $asig_pend = "Consultar con Administración";
	$trozo_curso=explode("(",$asig_pend);
	$asig_curso=$trozo_curso[0];
	echo $nombre_asig . " <span  class='small'>(" . $asig_curso . ")</span></td>";
		if ($rown1[0]<5) {		$e1=" class='text-error'";	} else{$e1="";}
		if ($rown2[0]<5) {		$e2=" class='text-error'";	}else{$e2="";}
		if ($rown3[0]<5) {		$e3=" class='text-error'";	}else{$e3="";}
		if ($rown4[0]<5) {		$e4=" class='text-error'";	}else{$e4="";}

	echo "<td $e1>";
	echo $rown1[0] ."</td>";
		echo "<td $e2>";
	echo $rown2[0] ." </td>";
		echo "<td $e3>";
	echo $rown3[0] . " </td>";
		echo "<td $e4>";
	 echo $rown4[0] . "</td></tr>";

			}
	}
	echo "</table>";


?>
<br>
</div>
</div>
 <? include "../pie.php"; ?>
