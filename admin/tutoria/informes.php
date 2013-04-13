<h4>Visitas de los Padres</h4>
  <br />
<?php
// Consulta
$hoy = date('Y'). "-" .date('m'). "-" .date('d');
$query = "SELECT ID, CLAVEAL, APELLIDOS, NOMBRE, F_ENTREV FROM infotut_alumno where nivel = '$nivel' and grupo = '$grupo' ORDER BY id desc";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

if (mysql_num_rows($result) > 0)
{
// Si hay datos
  echo "<table class='table table-striped table-condensed' style='width:100%'>";
		?>
<?
echo "<tr>
		<th>Alumno</th>
		<th>Fecha</th>
</TR>";
	while($row = mysql_fetch_object($result))
	{
$fecha11 = explode("-",$row->F_ENTREV);
$fecha21 = "$fecha11[2]-$fecha11[1]-$fecha11[0]"; 
$id = $row->ID;
  printf ("<tr height='25'>
   <TD bgcolor='#FFFFFF'><A HREF='../infotutoria/infocompleto.php?id=$id' style='color:#269;'><div align=left>$row->APELLIDOS, $row->NOMBRE</div></a></TD>
   <TD bgcolor='#FFFFFF'>$fecha21</TD>");
	}
echo " </TR></table>";
}
else{
echo "No hay Informes de Tutoría activos en este momento.";
}
?>  

