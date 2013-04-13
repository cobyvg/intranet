<?php
?>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped tabladatos">
<?
echo "<thead><tr><th>Alumno</th><th>Fecha</th></tr></thead><tbody>";
// echo "select distinct apellidos, nombre, claveal from tutoria where  nivel = '$nivel' and grupo = '$grupo' and date(fecha) > '$inicio_curso' order by apellidos, nombre<br>";
  $al0 = mysql_query("select distinct apellidos, nombre, claveal from tutoria where  nivel = '$nivel' and grupo = '$grupo' and date(fecha) > '$inicio_curso' order by apellidos, nombre");
  while($al1 = mysql_fetch_array($al0))
  
  {
  $nombre = $al1[1];
  $apellidos = $al1[0];
  $clave = $al1[2];
$result = mysql_query ("select fecha, id from tutoria where claveal = '$clave' and prohibido = '0' and nivel = '$nivel' and grupo = '$grupo' and date(fecha)> '$inicio_curso' order by fecha desc limit 1");
// echo "select fecha, id from tutoria where claveal = '$clave' and (tutor = '$tutor' and prohibido = '0') and nivel = '$nivel' and grupo = '$grupo' and date(fecha)> '$inicio_curso' order by fecha desc limit 1<br>";
while($row = mysql_fetch_array($result))

{
$fecha10 = explode("-",$row[0]);
$fecha20 = "$fecha10[2]-$fecha10[1]-$fecha10[0]"; 
$id = $row[1];
if($apellido =="Todos") {
	$completo="Todos";}
else{
	$completo="$apellidos, $nombre";}

echo "<tr height='25'><td><a href='tutor.php?id=$id&tutor=$tutor'>$completo</a></td><td nowrap>$fecha20</td></tr>";
}
}
echo "</tbody></table>";
?>
