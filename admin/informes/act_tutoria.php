<?php
$tuto = mysql_query("select tutor from FTUTORES where unidad = '$unidad'");
$tut = mysql_fetch_array($tuto);
$tutor = $tut[0];
if (stristr($_SESSION['cargo'],'1') or stristr($_SESSION['cargo'],'8') or $_SESSION['profi']==$tutor) {
echo "<br /><h3>Acciones de Tutoría</h3>";
if (stristr($_SESSION['cargo'],'1') or stristr($_SESSION['cargo'],'8')) {$prohibido="";}else{$prohibido=" and prohibido = '0'";}
$alumno=mysql_query("select tutoria.fecha, accion, causa, tutoria.observaciones from tutoria where tutoria.claveal = '$claveal' $prohibido");

if (mysql_num_rows($alumno) < 1)
{ 
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Alumno no tiene Acciones de Tutoría registradas
</div></div>';
}
else 
{
echo "<h4>Tutor/a: $tutor</h4><br />";

  
echo "<table class='table table-striped' style='width:auto;'>\n";  	
echo "<tr>
<th>Fecha</th>
<th>Clase</th>
<th>Causa</th>
</tr>";
while($row = mysql_fetch_array($alumno)){
  $obs=$row[3];
  $dia3 = explode("-",$row[0]);
  $fecha3 = "$dia3[2]-$dia3[1]-$dia3[0]";
echo "<tr><td nowrap><strong>$fecha3</strong></td><td>$row[1]</td><td width='120'>$row[2]</td></tr>";
}
echo "</table>";				  
}
}
?>
