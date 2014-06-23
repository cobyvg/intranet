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
?>
<?
include("../../menu.php");
include("menu.php");
if (isset($_POST['profes'])) {$profes = $_POST['profes'];}else{$profes="";}

?>
<div align="center">
<div class="page-header" align="center">
  <h2>Informes de Tutoría <small> Profesores que no redactan Informe</small></h2>
</div>
<br />
</div>
<?
$detalles = '1'; 
?>
<div class="row-fluid">
<div class="span4 offset2" align="left">   
<?
$hoy = date('Y-m-d');
//echo $hoy;
 if($detalles == '1')
{ 
echo '<h4>Detalles de cada Informe individual</h4><br />';
} 
mysql_connect($db_host, $db_user, $db_pass) or die ("Imposible conectar!");
mysql_select_db($db) or die ("Imposible seleccionar base de datos!");

//  Estructura de tabla para la tabla `infotut_temp`

mysql_query("CREATE TABLE IF NOT EXISTS `infotut_temp` (
  `id` int(11) NOT NULL auto_increment,
  `id_infotut` int(11) NOT NULL default '0',
  `asignatura` varchar(32) NOT NULL default '',
  `profesor` varchar(32) NOT NULL default '',
  `alumno` int(8) NOT NULL default '0',
  `curso` varchar(4) NOT NULL default '',
  `fecha` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`),
  KEY `id_infotut` (`id_infotut`),
  KEY `asignatura` (`asignatura`),
  KEY `profesor` (`profesor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1261");
// Control de tutores
$tut = mysql_query("select nivel, grupo from FTUTORES where tutor = '$profes'");
if (mysql_num_rows($tut)>0) {
	$tutor = mysql_fetch_array($tut);
	$tutoria = "$tutor[0]-$tutor[1]";
}
$luis1 = mysql_query("select distinct grupo from profesores where profesor like '$profes' and grupo not like '$tutoria' order by grupo");
while ($luis = mysql_fetch_array($luis1)) {
	$tr_g = explode("-",$luis[0]);
	$nivel = $tr_g[0];
	$grupo = $tr_g[1];
	echo "<h4 align='left'>Grupo: $luis[0]</h4><br />";

$query = "SELECT id, claveal, nivel, grupo, nombre, apellidos, F_ENTREV FROM infotut_alumno where nivel = '$nivel' and grupo = '$grupo' order by F_ENTREV desc";
$result = mysql_query($query);

while($row = mysql_fetch_array($result))
{
$todas = "";
$asig = "";
$inf = "select asignatura from infotut_profesor where id_alumno = '$row[0]'";
$comp = mysql_query($inf);
while($cadena = mysql_fetch_array($comp))
{
	$todas.=$cadena[0]. ";";
}
//echo $todas."<br>";

//echo "$todos<br>";
$combasi0 = "select combasi, nivel from alma where claveal = '$row[1]'";
//echo "$combasi0<br>";
$combasi1 = mysql_query($combasi0);
$combasi2 = mysql_fetch_array($combasi1);
$l_nivel = substr($combasi2[1],0,1);
$combasi = substr($combasi2[0],0,strlen($combasi2[0]) - 1);
$trozo = explode(":",$combasi);
foreach($trozo as $asignatura)
{
$nomasi0 = "select distinct nombre from asignaturas where codigo = '$asignatura' and abrev not like '%\_%' and curso like '$l_nivel%'";
//echo "$nomasi0<br>";
$nomasi1 = mysql_query($nomasi0);
while($nomasi = mysql_fetch_array($nomasi1))
{
$profesores = "";
$pos = strpos($todas,$nomasi[0]);
if($pos === FALSE)
{

$profe0 = "select distinct profesor from profesores where  profesores.grupo = '$row[2]-$row[3]' and materia like '$nomasi[0]' and profesor not in (select tutor from FTUTORES where nivel = '$row[2]' and grupo = '$row[3]') and profesor like '$profes'";

$profe1 = mysql_query($profe0);
while($profe2 = mysql_fetch_array($profe1))
{
$query = "insert into infotut_temp (id_infotut, asignatura, profesor, alumno, fecha, curso) values ('$row[0]','$nomasi[0]','$profe2[0]','$row[1]','$row[6]','$row[2]-$row[3]')";
mysql_query($query);
$profesores .= $profe2[0]."; ";
}
$profesores = substr($profesores,0,strlen($profesores) - 2);
//$query2 = "insert into infotut_temp2 (id_infotut,asignatura, alumno, fecha, profesor) values ('$row[0]','$nomasi[0]','$cadena[0]','$cadena[5]','$profesores')";
//mysql_query($query2);
if(strlen($profesores) > 0)
{
if($detalles == '1')
{  
echo "<p>$row[6] --> <span style='color:#08c'>$row[4] $row[5]</span> --> $row[2]-$row[3]</p>";
?>
<ul  class='unstyled'>
<?
echo "<li><i class='fa fa-user'> </i> $profesores ==> $nomasi[0]</li>";
echo "</ul>";
echo "<br />";
} 
}
}
}
}

}
}
?>
</div>
<div class="span4">
<?
echo '<h4>Resultados globales por Profesor</h4><br />';
$malo0 = "select profesor, count(*) as total from infotut_temp group by profesor";
//echo "$combasi0<br>";
$malo1 = mysql_query($malo0);
echo "<table class='table table-striped' style='width:auto'><tr><th>Profesor</th><th>Total</th></tr>";
while($malo2 = mysql_fetch_array($malo1))
{
echo "<tr><td>$malo2[0]</td><td>$malo2[1]</td></tr>";
}
?>
</table>
<br />
<?
echo '<h4>Resultados globales por Asignatura</h4><br />';
$malo0 = "select distinct asignatura, count(*) as total from infotut_temp where profesor like '$profes' group by asignatura";
//echo "$combasi0<br>";
$malo1 = mysql_query($malo0);
echo "<table class='table table-striped' style='width:auto'><tr><th>Profesor</th><th>Total</th></tr>";
while($malo2 = mysql_fetch_array($malo1))
{
echo "<tr><td>$malo2[0]</td><td>$malo2[1]</td></tr>";
}
?>
</table>
</div>
</div>


<? 
mysql_query("drop table infotut_temp");

include("../../pie.php");
?>
</body>
</html>