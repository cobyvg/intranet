<p class='lead'>Faltas de asistencia sin justificar</p>
<?php
 echo "<table class='table table-striped table-condensed' style='width:100%'>";
		?>
                    
<?
 $SQLTEMP = "create table FALTASTEMP select distinct FALTAS.claveal, FALTAS.falta, count(*) as NUMERO, apellidos, nombre from FALTAS, FALUMNOS  
 where FALTAS .claveal = FALUMNOS .claveal and FALTAS.falta = 'F' and FALTAS.nivel = '$nivel' and FALTAS.grupo = '$grupo' group BY FALTAS.claveal";
 
//echo $SQLTEMP;
$resultTEMP= mysql_query($SQLTEMP);
$SQL = "select FALTASTEMP.claveal, FALTASTEMP.apellidos, FALTASTEMP.nombre, FALTASTEMP.NUMERO from FALTASTEMP order BY FALTASTEMP.numero desc";
$result = mysql_query($SQL);

  if ($row = mysql_fetch_array($result))
        {
	$hoy = date("d"). "-" . date("m") . "-" . date("Y");
        echo "<tr><th>Alumno
        </th><th>TOTAL</th></tr>";
                do {
	$claveal = $row[0];
	$comienzo=explode("-",$inicio_curso);
	$comienzo_curso=$comienzo[2]."/".$comienzo[1]."/".$comienzo[0];
                printf ("<tr align='left'><td ><A HREF='../faltas/informes.php?claveal=$claveal&fecha4=$inicio_curso&fecha3=$hoy&submit2=2'>%s, %s</a></td><td style='color:#9d261d'>%s</td></tr>", $row[1], $row[2],$row[3]);
        } while($row = mysql_fetch_array($result));
        }
		        echo "</table></center>\n";
 // Eliminar Tabla temporal
 $SQLDEL = "DROP table `FALTASTEMP`";
 mysql_query($SQLDEL);
  ?>

