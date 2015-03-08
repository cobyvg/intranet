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
   	echo "<p class='lead muted' align='center'><i class='icon icon-gears'> </i> Informes de Tutoría</p><hr />";
?>
<?php
$hoy = date('Y-m-d');
$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,unidad,TUTOR,CLAVEAL, F_ENTREV, ID FROM infotut_alumno WHERE CLAVEAL = '$claveal' and date(F_ENTREV) > '2015-01-31' and date(F_ENTREV) < '$hoy' and valido = '1'");

if (mysql_num_rows($alumno) < 1)
{ 
	
echo '	<div class="alert alert-info">El alumno/a no tiene informes de tutoría registrados en este curso escolar.</div>
<br>';
}
else 
{
$tuto = mysql_query("select tutor from FTUTORES where unidad = '$unidad'");
$tut = mysql_fetch_array($tuto);
$tutor = $tut[0];
echo "<br><h3 class=\"text-info\">Tutor/a: ".mb_convert_case($tutor, MB_CASE_TITLE, "iso-8859-1")."</h3>";

while ($dalumno = mysql_fetch_array($alumno))
{

$id = $dalumno[6];
echo "<br /><h4>Fecha: $dalumno[5]</h4><br />";
$datos=mysql_query("SELECT asignatura, informe FROM infotut_profesor WHERE id_alumno = '$id'");
echo "<table class='table table-striped' style='width:auto'>
		<tr><Th nowrap><h4 class='muted'>Asignatura</h4></th>
  <Th><h4 class='muted'>Informe del profesor</h4></th></tr><tbody>";
while($informe = mysql_fetch_array($datos))
{
			    echo "<tr><td class='text-error' width='250'>$informe[0]</td>
			      <td>$informe[1]</td>";
				echo"</tr>";
				
				  }
echo"</tbody></table>";

				  }
				  
}
?>
</div>
</div>
 <? include "../pie.php"; ?>
