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

$profesor = $_SESSION['profi'];
?>

<?php
if ($n_dia == 'Lunes') {	$dia = '1';}
if ($n_dia == 'Martes') { $dia = '2';}
if ($n_dia == 'Miércoles') {	$dia = '3';}
if ($n_dia == 'Jueves') {	$dia = '4';}
if ($n_dia == 'Viernes') {	$dia = '5';}
include("../../menu.php");
  ?>
<br />
  <div align=center>
  <div class="page-header" align="center">
  <h2>Aulas libres <small><br /> <? echo $n_dia;?></small></h2>
</div>
</div>
<br />

<table class="table table-striped table-bordered " align="center" style="width:auto">
    <tr> 
    <th>  
      8.15-9.15</th>
    <th > 
      9.15-10.15</th>
    <th >
      10.15-11.15</th>
    <th >
      11.45-12.45</th>
    <th > 
      12.45-13.45</th>
    <th > 
      13.45-14.45</th>
  </tr>
  
<?
// Días de la semana 

echo "<tr>";
for($i=1;$i<7;$i++) {
echo "<td>";

$au = mysql_query("select distinct a_aula, n_aula from horw where a_aula not like 'B%' and a_aula not like 'G%' and a_aula not like '' and a_aula not like 'ACO%' and a_aula not like 'DI%'");
while ($aul = mysql_fetch_array($au)) {

$sqlasig0 = "SELECT a_grupo FROM  horw where a_aula = '$aul[0]' and dia = '$dia' and hora = '$i' and a_grupo not like 'B%' and a_grupo not like 'G%' order by a_grupo";

$asignaturas1 = mysql_query($sqlasig0);

$rowasignaturas1 = mysql_fetch_array($asignaturas1);
$aula_libre = strtolower($aul[1]);
if ($rowasignaturas1[0] == '') {

echo "<span style=''><a href='hor_aulas.php?aula=$aul[1]'>$aula_libre</a></span><br /><br />";

}
}
echo "</td>";	
}
echo "</tr></table>
<div style='color:brown'><br* Si quieres ver el horario de un aula, haz click sobre la misma.
";

?>

