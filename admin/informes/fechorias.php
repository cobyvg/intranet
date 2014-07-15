
  <?php
echo "<br /><h3>Problemas de Convivencia</h3><br />";

// Consulta del aï¿½ en curso.
  
  $fechoria = mysql_query ("select distinct Fechoria.claveal from Fechoria where Fechoria.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha");
$fech = mysql_fetch_array($fechoria);

if ($fech[0] == "")
{ 
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El Alumno no tiene Problemas de Convivencia</div></div>';
}
else {

  $result = mysql_query ("select distinct FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, Fechoria.fecha, 
  Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.claveal, grave from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal
   and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.unidad, 
   FALUMNOS.apellidos");
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
		$rowcurso = $row[2];
        $rowalumno = $row[0].",&nbsp;".$row[1];
		printf ("<tr><td nowrap>%s</td><td>%s</td><td>%s</td>
		<td width='250'>%s</td></tr>",  $row[3], $row[8], $row[5], $row[6]);
        } while($row = mysql_fetch_array($result));
        echo "</table></center>\n";
        }
        
    

// Consulta de Expulsiones.
  $exp = mysql_query ("select expulsion, inicio, fin, asunto, aula_conv, inicio_aula, fin_aula from Fechoria where Fechoria.claveal = '$claveal' and (expulsion > '0' or aula_conv>0) and Fechoria.fecha >= '$inicio_curso' order by Fechoria.fecha");
if (mysql_num_rows($exp) > "0") {

echo "<h4>Expulsiones del Alumno</h4><br />";
		echo "<table class='table table-striped' style=''>
		<TR><th></th>
		<th nowrap>Inicio</th>
		<th>Final</th><th 
		 nowrapth>Asunto</th></tr>";
while($row = mysql_fetch_array($exp)) {
		if ($row[0]>1) {
	$f_inicio = cambia_fecha($row[1]);
	$f_final = cambia_fecha($row[2]);
		echo "<tr><td>Expulsión del Centro</td><td>$f_inicio</td><td>$f_final</td>
		<td >$row[3]</td></tr>";
	}
	else{
	$f_inicio0 = cambia_fecha($row[5]);
	$f_final0 = cambia_fecha($row[6]);
		echo "<tr><td>Aula de Convivencia</td><td>$f_inicio0</td><td>$f_final0</td>
		<td >$row[3]</td></tr>";

	}

        } 
        echo "</table>";	
	}
  ?>

