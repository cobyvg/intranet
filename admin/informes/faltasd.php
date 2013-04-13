
<?php
    
    
     $SQLT = "select DISTINCTROW FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.NIVEL, FALUMNOS.GRUPO, FALTAS.fecha, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal and FALTAS.falta = 'F' and FALUMNOS.claveal = $claveal GROUP BY FALUMNOS.apellidos";
     $SQLTJ = "select DISTINCTROW FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.NIVEL, FALUMNOS.GRUPO, FALTAS.fecha, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal
     and FALTAS.falta = 'J' and  FALUMNOS.claveal = $claveal GROUP BY FALUMNOS.apellidos";
 
     $resultt = mysql_query($SQLT);
     $rowt = mysql_fetch_array($resultt);
     $resulttj = mysql_query($SQLTJ);
     $rowtj = mysql_fetch_array($resulttj);
  
    ?>
   <?php
  	$fechasp0=explode("-",$fecha1);
	$fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
	$fechasp2=explode("-",$fecha2);
	$fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
  // Datos del Alumno
 // print $claveal;
  $SQL0 = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal and FALUMNOS.claveal = $claveal  and FALTAS.fecha >= '2005-09-15' GROUP BY FALUMNOS.apellidos";
   
  $result0 = mysql_query($SQL0);
  $row0 = mysql_fetch_array($result0);
  $numF = mysql_num_rows($result0);
  // Justificadas
  $SQLJ = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal 
  and FALUMNOS.claveal = $claveal  and FALTAS.fecha >= '2005-09-15'
  and FALTAS.falta = 'J' GROUP BY FALUMNOS.apellidos";

  $resultJ = mysql_query($SQLJ);
  $rowJ = mysql_fetch_array($resultJ);
  $numJ = mysql_num_rows($resultJ);
  // Sin justificar
  $SQLF = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal 
  and FALUMNOS.claveal = $claveal  and FALTAS.fecha >= '2005-09-15'
  and FALTAS.falta = 'F' GROUP BY FALUMNOS.apellidos";

  $resultF = mysql_query($SQLF);
  $rowF = mysql_fetch_array($resultF);  

  if ($numF > 0 or $numJ > 0)
        {
echo "<br /><h4>Informe completo de horas y asignaturas</h4>";

  $SQL = "SELECT distinct alma.CLAVEAL, alma.APELLIDOS, alma.NOMBRE, alma.NIVEL, alma.GRUPO,
  FALTAS.FECHA, FALTAS.HORA, asignaturas.abrev, FALTAS.falta FROM alma, FALTAS, asignaturas where  alma.CLAVEAL = FALTAS.CLAVEAL and FALTAS.codasi = asignaturas.codigo  and alma.claveal = $claveal  and FALTAS.fecha >= '2005-09-15' and asignaturas.abrev not like '%\_%' order BY FALTAS.FECHA, FALTAS.HORA";
 //print $SQL;
   $result = mysql_query($SQL);
echo "<BR><p>";
  if ($rowsql = mysql_fetch_array($result))
        {

        $f = "";
        $horas = "";
                do
                   {
	$fechasp=explode("-",$rowsql[5]);
	$fechasp1=$fechasp[2]."-".$fechasp[1]."-".$fechasp[0];
                if ($fechasp1 == $f)
                        {
                         $horas .= $rowsql[6] . "&nbsp;" . $rowsql[7] . " (" . $rowsql[8] . ") - ";
                        }
                else
                        {
                        if ($horas <> "")
                        printf ("" . $horas . "<br>");
                        $horas = "<b>" . $fechasp1 . "</b>:&nbsp;&nbsp;&nbsp;" ." " . $rowsql[6] .  "&nbsp;" . "" . $rowsql[7] . " </span> " . "(" . " " . $rowsql[8] . "" . ") - ";
                        $f = $fechasp1;
                        }
                        }
                while($rowsql = mysql_fetch_array($result));
                 	printf (" " . $horas . "<br>");
               }
}
echo "</p>";
  ?>
