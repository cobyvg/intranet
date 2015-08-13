<?php
$tr = explode(" --> ",$alumno);
$al = $tr[0];
$clave = $tr[1];
$trozos = explode (", ", $al);
$apellidos = $trozos[0];
$nombre = $trozos[1];

$n_fil = mysqli_query($db_con, "select distinct apellidos, nombre, claveal from tutoria where jefatura = '1'");
$n_fil0 = mysqli_num_rows($n_fil);
$result0 = mysqli_query($db_con, "select distinct apellidos, nombre, claveal from tutoria where jefatura = '1' order by fecha desc");
$n_filas = mysqli_num_rows($result0);
if($n_filas > 0) 
  {
echo '<table class="table table-striped table-bordered datatable">';
?>
<?php
echo "<thead><tr><th>#</th><th>Alumno</th><th>Fecha</th></tr></thead><tbody>";
  while($alumn = mysqli_fetch_array($result0))
  {
    $result = mysqli_query($db_con, "select distinct apellidos, nombre, fecha, accion, causa, observaciones, unidad, tutor, id, prohibido from tutoria where jefatura = '1' and claveal = '$alumn[2]' order by fecha desc limit 1");
while($row = mysqli_fetch_array($result))
{
$id3 = $row[8];
$prohibido = $row[9];

echo "<tr><td>$row[8]</td><td><a href='index.php?id=$id3'>$row[1] $row[0]</a></div></td><td nowrap>$row[2]</td></tr>";
}	
  }
echo "</tbody></table>";
	}

  ?>
