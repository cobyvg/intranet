<?php
echo "<h3>Informes de Tutoría</h3>";

$alumno=mysql_query("SELECT APELLIDOS,NOMBRE,unidad,TUTOR,CLAVEAL, F_ENTREV, ID FROM infotut_alumno WHERE CLAVEAL = '$claveal'");

if (mysql_num_rows($alumno) < 1)
{ 
echo '<h3 class="text-muted">El alumno/a no tiene informes de tutoría.</h3>
<br>';
}
else 
{
$tuto = mysql_query("select tutor from FTUTORES where unidad = '$unidad'");
$tut = mysql_fetch_array($tuto);
$tutor = $tut[0];
echo "<h4>Tutor/a: $tutor</h4>
<br />";

while ($dalumno = mysql_fetch_array($alumno))
{
$id = $dalumno[6];
echo "<br /><h4>Fecha: $dalumno[5]</h4><br />";
$datos=mysql_query("SELECT asignatura, informe FROM infotut_profesor WHERE id_alumno = '$id'");
echo "<table class='table table-striped' style='width:95%'>
		<TR><Th nowrap>Asignatura</th>
  <Th>Informe del profesor</th></tr>";
while($informe = mysql_fetch_array($datos))
{
			    echo "<tr><td>$informe[0]</td>
			      <td>$informe[1]</td>";
				echo"</tr>";
				
				  }
echo"</table>";

				  }
				  
}
?>
