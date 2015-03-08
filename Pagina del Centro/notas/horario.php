<? 
session_start();
if($_SESSION['aut']<>1)
{
header("location:http://iesmonterroso.org");
exit;	
}
	$clave_al = $_SESSION['clave_al'];
	$todosdatos = $_SESSION['todosdatos'];
	$unidad = $_SESSION['unidad'];
	include("../conf_principal.php");
	include("../funciones.php");
	mysql_connect ($host, $user, $pass);
	mysql_select_db ($db);
?>
<? include "../cabecera.php"; ?>
<? include('consultas.php'); ?>
<div class="span9">	
<?

   echo "<h3 align='center'>$todosdatos<br /></h3>";
       if(empty($unidad))
     { }
	 else{
   echo "<p class='lead muted' align='center'><i class='icon icon-calendar'> </i> Horario del Grupo $unidad</p><hr />";
  ?>
  <br><div class="span10 offset1">
<table class="table table-bordered table-striped">
    <tr class='text-info'> 
      <th></th>
      <th nowrap> 
        <div align="center">8.15-9.15</div></th>
      <th nowrap> 
        <div align="center">9.15-10.15</div></th>
      <th nowrap> 
        <div align="center">10.15-11.15</div></th>
      <th nowrap> 
        <div align="center">11.45-12.45</div></th>
      <th nowrap> 
        <div align="center">12.45-13.45</div></th>
      <th nowrap> 
        <div align="center">13.45-14.45</div></th>
    </tr>
  
<?
// Asignaturas
mysql_query("CREATE TABLE IF NOT EXISTS `asig_tmp` (
  `claveal` varchar(12) collate latin1_spanish_ci NOT NULL,
  `codigo` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci");
mysql_query("TRUNCATE TABLE asig_tmp");

$comb = mysql_query("select combasi from alma where claveal = '$clave_al'");
$combasi = mysql_fetch_array($comb);
$tr_combasi = explode(":",$combasi[0]);
foreach ($tr_combasi as $codigo){
	 mysql_query("insert into asig_tmp(claveal, codigo) VALUES ('$clave_al','$codigo')");
}

// Días de la semana 
$a=array("1"=>"Lunes","2"=>"Martes","3"=>"Miércoles","4"=>"Jueves","5"=>"Viernes");
foreach($a as $dia => $nombre) {
echo "<tr><th style='background-color:#efefef' class='text-info'>$nombre</th>";
for($i=1;$i<7;$i++) {
echo "<td>";
$sqlasig0 = "SELECT distinct  asig, c_asig, a_aula FROM  horw where a_grupo = '$unidad' and dia = '$dia' and hora = '$i' and c_asig in (select codigo from asig_tmp where claveal = '$clave_al')";
$asignaturas1 = mysql_query($sqlasig0);
 while ($rowasignaturas1 = mysql_fetch_array($asignaturas1))
{ 
echo "<p>$rowasignaturas1[0]</p>";
echo "<p class='text-success'>$rowasignaturas1[2]</p>";
}
echo "</td>";
}
echo "<tr>";
}
echo "</table>";
}
mysql_query("DROP TABLE asig_tmp");
     ?>
     </div>
	 </div>
 <? include "../pie.php"; ?>

