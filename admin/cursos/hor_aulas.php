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
if (isset($_POST['aula'])) {$aula = $_POST['aula'];} elseif (isset($_GET['aula'])) {$aula = $_GET['aula'];} else{$aula="";}

  ?>
 <br />
  <div align=center>
  <div class="page-header" align="center">
  <h2>Horario del Aula <small><br /> <? echo $aula;?></small></h2>
</div>
</div>

<table class="table table-striped table-bordered" align="center" style="width:92%">
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
// Días de la semana 
$NIVEL1="";
$GRUPO1="";
$a=array(1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6" );
foreach($a as $hora => $nombre) {
echo "<tr><th><div class='badge badge-warning'>$nombre</div></th>";
for($i=1;$i<6;$i++) {
echo "<td>";
$curso = $NIVEL1."-".$GRUPO1;
$sqlasig0 = "SELECT distinct  asig, prof FROM  horw where n_aula = '$aula' and dia = '$i' and hora = '$hora'";
$asignaturas1 = mysql_query($sqlasig0);
 while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
{ 
echo "<span>$rowasignaturas1[0]</span><br>";
echo "<span style='color:#08c'>$rowasignaturas1[1]</span>";
}
echo "</td>";
}
echo "<tr>";
}
echo "</table>
</div>";

?>

