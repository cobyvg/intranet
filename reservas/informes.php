<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../menu.php");
include("../TIC/menu.php");
?>
<div align="center">
<div class="page-header" align="center">
  <h1>Centro TIC <small> Estadísticas de uso de Portátiles</small></h1>
</div>

 <div class="row-fluid">
 <div class="span2"></div>
<div class="span3">
<h3>Datos de Carritos</h3><br />
<div class="well-2 well-large">
 
  
		<?
$conn = mysql_connect($db_host, $db_user, $db_pass) or die("Imposible conectar con la Base de datos!");
mysql_select_db($db_reservas, $conn);
// Datos generales
$trozos = explode("-",$inicio_curso);
$fecha_usuario = "$trozos[2]-$trozos[1]-$trozos[0]";
for($i=1;$i<$num_carrito+1;$i++){
$query = "select eventdate from carrito$i where date(eventdate) > '$fecha_usuario'";
// echo "$query<br>";
$result = mysql_query($query) or die ("Error en la Consulta: $query. " . mysql_error());
$n_dias = mysql_num_rows($result);
echo "<table class='table' style='width:auto'>";
echo "<tr><th colspan='2'><h6>Carrito Nº ".$i."</h6></th></tr>";
echo "<tr><th style='color:#08c;'>Nº de Días de Uso</th><td>".$n_dias."</td></tr>";
if ($n_dias > 0)
{
	while($row = mysql_fetch_array($result))
	{
	
$dia = $row[0];
$query1 = "select * from carrito$i where eventdate = '$dia'";
// echo "$query1<br>";
$result1 = mysql_query($query1) or die ("Error in query: $query. " . mysql_error());
$row1 = mysql_fetch_row($result1);
for($z=3;$z<10;$z++){
if(!(empty($row1[$z])))
{
$global[$i] = $global[$i] + 1;
}
}
}
}	
echo "<tr><th style='color:#08c;'>Horas</th><td>$global[$i]</td></tr>";
echo "</table>";	
	
	}
?>
</div>
</div>
<div class="span5 pull-left">
  <h3>Datos de Profesores</h3><br />
  <div class="well-2 well-large">
<?	
// Datos de uso de los profesores en sus carritos
mysql_query("truncate table usuario");
$query4 = "select distinct profesor from profesores order by profesor";
$result4 = mysql_query($query4);
while ($row4 = mysql_fetch_array($result4))
{
$profesor2 = $row4[0];

for($i=1;$i<$num_carrito+1;$i++)
{
$query5 = "select eventdate from carrito$i where date(eventdate) > '$fecha_usuario' and (event1 = '$profesor2' or event2 = '$profesor2' or event3 = '$profesor2' or event4 = '$profesor2' or event5= '$profesor2' or event6 = '$profesor2' or event7 = '$profesor2')";
$result5 = mysql_query($query5) or die ("Error in query: $query. " . mysql_error());
$dias_profe2 = mysql_num_rows($result5);	
if($dias_profe2 > 0)
{
$query6 = "select profesor from usuario where profesor = '$profesor2'";
$result6 = mysql_query($query6);
$global6[$i] = $global6[$i] + $dias_profe2;
if (mysql_num_rows($result6) == 0)
{
mysql_query("insert into usuario set profesor='$profesor2', c$i = '$dias_profe2'");
}
else
{
mysql_query("update usuario set c$i = '$dias_profe2' where profesor='$profesor2'");
}
}
}
}

$query7 = "select * from usuario";
$result7 = mysql_query($query7);
echo "<table class='table table-striped' style='width:auto'>";
echo "<tr><th>Profesor</th>";
for($i=1;$i<$num_carrito+1;$i++)
{

echo "<th>C$i</th>";
}
echo "</tr>";
while($row7 = mysql_fetch_array($result7))
{
echo "<tr><td><span style='color:#08c'>$row7[0]</span></td>"; 

for($z=1;$z<$num_carrito+1;$z++)
{
echo "<td>$row7[$z]</td>";
}
echo "</tr>";
}

echo "</table>";
?>
</div>
</div>
</div>
<?php
include("../pie.php");
?>
</body>
</html>
