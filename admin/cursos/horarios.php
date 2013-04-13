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

    <?
  	include("../../menu.php");
	$tr = explode("-",$curso);
	$nivel1 = $tr[0];
	$grupo1 = $tr[1];
  ?>
   <div align=center>
  <div class="page-header" style="margin-top:-15px;" align="center">
  <h1>Horario del Grupo <small>  <small> <br /><? echo $curso;?></small></h1>
</div>
</div>
<br />
<div class="container" style="width:880px">
<table class="table table-condensed table-striped table-bordered"  align="center">
   <tr> 
<th></th>
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
  
<?
// Días y horas de la semana 
$a=array(1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
foreach($a as $hora => $nombre) {
echo "<tr><th>$nombre</th>";
for($i=1;$i<6;$i++) {
echo "<td>";
$sqlasig0 = "SELECT distinct  asig, c_asig FROM  horw where a_grupo = '$curso' and dia = '$i' and hora = '$hora'";
$asignaturas1 = mysql_query($sqlasig0);
 while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
{ 
echo $rowasignaturas1[0];
}
echo "</td>";
}
echo "<tr>";
}
echo "</table>
";
?>
<br />
 <div align=center>
  <div class="page-header" align="center">
  <h1>Profesores del Grupo <small><br /> <?  echo "$curso";?></small></h1>
</div>
</div>
<br />
<?
 echo "<ul class='unstyled'>";
 $profe = "SELECT  distinct PROFESOR, MATERIA FROM profesores, horw where profesores.grupo = horw.a_grupo and a_grupo='$curso'";
 $profeq = mysql_query($profe);
 while($profer = mysql_fetch_array($profeq)){
 echo "<li><i class='icon icon-user icon-large'> </i> 
$profer[1] -->  <span style='color:#08c;');'>$profer[0]</span></li>";}
echo "</ul></div>";
?>