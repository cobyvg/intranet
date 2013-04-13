
  <?php
echo "<br /><h3>Problemas de Convivencia</h3><br />";

// Consulta del a� en curso.
  
  $fechoria = mysql_query ("select distinct Fechoria.claveal from Fechoria where Fechoria.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha");
$fech = mysql_fetch_array($fechoria);

if ($fech[0] == "")
{ 
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Alumno no tiene Problemas de Convivencia</div></div>';
}
else {

  $result = mysql_query ("select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, 
  Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.claveal, grave from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal
   and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.nivel, 
   FALUMNOS.grupo, FALUMNOS.apellidos");
 // print "$AUXSQL";
  if ($row = mysql_fetch_array($result))

	$fecha1 = (date("d").-date("m").-date("Y"));
		echo "<table class='table table-striped'>
		<TR><Th nowrap>Fecha</th>
		<th>Gravedad</th>
		<th width=250>Tipo</th>
		<th nowrap>Informa</th></tr>";

                do {
		
//	$claveal = $row[8];
	// print $claveal;
		$numero = mysql_query ("select claveal from Fechoria where claveal = '$claveal' and Fechoria.fecha >= '2005-09-01'"); 
		// $numero1 = "select claveal from Fechoria where claveal = '$claveal' and Fechoria.fecha >= '2005-09-01' "; 
		// print $numero1;
		$rownumero= mysql_num_rows($numero);
		$rowcurso = $row[2]."-".$row[3];
        $rowalumno = $row[0].",&nbsp;".$row[1];
		printf ("<tr><td nowrap>%s</td><td>%s</td><td>%s</td>
		<td width='250'>%s</td></tr>",  $row[4], $row[9], $row[6], $row[7]);
        } while($row = mysql_fetch_array($result));
        echo "</table></center>\n";
        }
        
    

// Consulta de Expulsiones.
  $exp = mysql_query ("select distinct expulsion, inicio, fin, asunto from Fechoria where Fechoria.claveal = '$claveal' and expulsion > '0' and Fechoria.fecha >= '$inicio_curso' order by Fechoria.fecha");
if (mysql_num_rows($exp) > "0") {
echo "h4>EXPULSIONES DEL CENTRO</h4><br />";
		echo "<table class='table table-striped' style=''>
		<TR><th nowrap>Inicio</th>
		<th>Final</th><th 
		 nowrapth>Asunto</th></tr>";
while($row = mysql_fetch_array($exp)) {
	$f_inicio = cambia_fecha($row[1]);
	$f_final = cambia_fecha($row[2]);
		printf ("<tr><td>%s</td><td>%s</td>
		<td >%s</td></tr>",  $f_inicio, $f_final, $row[3]);
        } 
        echo "</table>";	
	}
  ?>

