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
include("../../menu.php");
$profe = explode(", ",$profeso);
?>
<div align=center>
  <div class="page-header" align="center" style="margin-top:-15px">
  <h1>Horario del Profesor <small><br /> <? echo "$profe[1] $profe[0]";?></small></h1>
</div>
</div>

<table class="table table-striped table-bordered" align="center" style="width:auto">
    <tr> 
	<th> </th>
    <th valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">L</span></div>
</th>
<th valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">M</span></div>
</th>
<th valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">X</span></div>
</th>
<th valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">J</span></div>
</th>
<th valign="middle" align="center">
<div align="center"><span align="center" class="badge badge-info">V</span></div>
</div></th>
  </tr>
<?php
   
  

// Días de la semana 
$a=array(1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
foreach($a as $hora => $nombre) 
{
echo "<tr><th>$nombre</th>";
for($i=1;$i<6;$i++) 
{
// Asignaturas del Curso en un día
$asignaturas1 = mysql_query("SELECT distinct  a_asig, a_grupo, n_aula FROM  horw where prof = '$profeso' and dia = '$i' and hora = '$hora'");
 echo  "<td >";  
?> 
  
<?  while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
{ 
echo "<b>$rowasignaturas1[1] ";
if(!($rowasignaturas1[1] == "")){ echo "";}
echo "</b> "; 
if(!($rowasignaturas1[1] == "")){ echo " --> ";} 
echo "<span style='color:#46a546'>$rowasignaturas1[0]</span><br />";}
$asignaturas0 = mysql_query("SELECT distinct  a_asig, a_grupo, n_aula FROM  horw where prof = '$profeso' and dia = '$dia' and hora = '$i'");
$asignaturas01=mysql_fetch_array($asignaturas0);
if (!($asignaturas01[2]=='Sin asignar o sin aula') and !($asignaturas01[2] == "")) {
echo "<br><span style='color:#08c'>($asignaturas01[2])</span>";	
}

echo "</td>";
}echo "<tr>";}
?>
</table>
</div>
</body>
  </html>
