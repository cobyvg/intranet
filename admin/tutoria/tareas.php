<p class='lead'>Tareas y Expulsiones</p>
  <br />
            <?php

// Conexión al Servidor
$query0 = "SELECT ID, FECHA, DURACION
  FROM tareas_alumnos where nivel = '$nivel' and grupo = '$grupo' ORDER BY FECHA desc";


$result0 = mysql_query($query0) or die ("Error in query: $query. " . mysql_error());
if($result1 = mysql_fetch_array($result0) and mysql_num_rows($result0) > 0)
{
  echo "<table class='table table-striped table-condensed' style='width:100%'>";
	?>		
<?
echo "<tr>
		<th>Alumno</th>
		<th>Fecha</th>
</TR>";
do{
$id = $result1[0];
$fecha0 = $result1[1];
$duracion = $result1[2];
$fechafin = mktime($fecha1[0], $fecha1[1],$fecha1[2], date("m")  , date("d")+$duracion, date("Y"));
$fechafin1 = getdate($fechafin);
$fechafin0 = $fechafin1[year]."-".$fechafin1[mon]."-".$fechafin1[mday];

$hoy = date('Y'). "-" .date('m'). "-" .date('d');
if ($fechafin0 >= $hoy)
{
$query = "SELECT ID, CLAVEAL, APELLIDOS, NOMBRE, FECHA, DURACION
  FROM tareas_alumnos where id = '$id' ORDER BY FECHA desc";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

if (mysql_num_rows($result) > 0)
{
// Si hay datos


	while($row = mysql_fetch_object($result))
	{
	$fecha11 = explode("-",$row->FECHA);
$fecha21 = "$fecha11[2]-$fecha11[1]-$fecha11[0]"; 
$id = $row->ID;
  printf ("<tr height='25'>
   <TD bgcolor='#FFFFFF'><A HREF='../tareas/infocompleto.php?id=$id' style='color:#269'>$row->APELLIDOS, $row->NOMBRE</a></TD>
   <TD bgcolor='#FFFFFF'>$fecha21</TD>");
	}

}
}
}while($result1 = mysql_fetch_array($result0));
echo " </TR></table>";
}
else{
echo "No hay Tareas activas ni Alumnos expulsados en este momento.";
}
?>
            
        

