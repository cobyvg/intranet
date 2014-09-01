<?php
$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];

$result0 = mysql_query ("select distinct apellidos, nombre, claveal from tutoria where orienta = '1' order by fecha desc");
//echo "select distinct apellidos, nombre, claveal from tutoria where orienta = '1' order by fecha asc";
$n_filas = mysql_num_rows($result0);
if($n_filas > 0) 
  {
echo '<table class="table table-striped table-bordered datatable">';
  	
echo "<thead><tr><th>Alumno</th><th>Fecha</th></tr></thead><tbody>";
  while($alumn = mysql_fetch_array($result0))
  {
 $clave=$alumn[2];
    $result = mysql_query ("select distinct apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido from tutoria where orienta = '1' and claveal = '$clave' order by fecha desc limit 1");
while($row = mysql_fetch_array($result))
{
$fecha10 = explode("-",$row[2]);
$fecha20 = "$fecha10[2]-$fecha10[1]-$fecha10[0]"; 
$id3 = $row[8];
$prohibido = $row[9];
echo "<tr><td><a href='tutor.php?id=$id3'>$row[1] $row[0]</a></div></td><td nowrap>$fecha20</td></tr>";
}	
  }
	echo "</tbody></table>";
}

  ?>
