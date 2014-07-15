  <p class='lead'>Problemas de Convivencia</p>
  <?php
  $alumn = "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.claveal from FALUMNOS where unidad = '$unidad'";
  $alumn0 = mysql_query($alumn);

  echo "<table class='table table-striped table-condensed' style='width:100%'>";
			?>
       
<?
echo "<tr>
		<th>Alumno</th>
		<th>Fecha</th>
		<th>Gravedad</th>
		<th><center>Número</center></th></tr>";
  while($alumn1 = mysql_fetch_array($alumn0))
  {
  	$apellidos = $alumn1[0];
	$nombre = $alumn1[1];
  	$claveal = $alumn1[2];

  $result = mysql_query ("select distinct Fechoria.fecha, Fechoria.grave from Fechoria where claveal = '$claveal' order by Fechoria.fecha DESC limit 1");     
$fecha1 = (date("d").-date("m").-date("Y"));
while($row = mysql_fetch_array($result))
        {		
		$fecha10 = explode("-",$row[0]);
		$fecha = "$fecha10[2]-$fecha10[1]-$fecha10[0]";
		$grave = $row[1];
		$numero = mysql_query ("select Fechoria.claveal from Fechoria where Fechoria.claveal 
		like '%$claveal%' order by Fechoria.fecha"); 
		$rownumero= mysql_num_rows($numero);
		$bgcolor="white";
		echo "<tr height='24' bgcolor='$bgcolor'>
		<td style=text-align:left;><A HREF='../fechorias/fechorias.php?claveal=$claveal&submit1=1' style='color:#269'>$apellidos, $nombre</A></td>
		<td nowrap>$fecha</td>
		<td>$grave</td>
		<td><center><font color='#CC0000'>$rownumero</center></td>";
        }
 }
 		        echo "</table></center>\n";


  ?>


