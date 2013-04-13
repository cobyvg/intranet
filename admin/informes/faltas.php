 <?php
//include("../../menu.php");
 
  
  $SQLT = "select DISTINCTROW FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.NIVEL, FALUMNOS.GRUPO,
  FALTAS.fecha, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal
  and FALTAS.falta = 'F' and FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos";
  $SQLTJ = "select DISTINCTROW FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.NIVEL, FALUMNOS.GRUPO, 
  FALTAS.fecha, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal
  and FALTAS.falta = 'J' and  FALUMNOS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos";
 //print $SQLT;
  $resultt = mysql_query($SQLT);
  $rowt = mysql_fetch_array($resultt);
  $resulttj = mysql_query($SQLTJ);
  $rowtj = mysql_fetch_array($resulttj);

  if (mysql_num_rows($resultt) >'0' OR mysql_num_rows($resulttj) >'0')
             {
echo "<br /><h3>Faltas de asistencia al Centro</h3><br>";

		do {
  	if($rowt[5]=="")
		$rowt[5]="0";
		  	if($rowtj[5]=="")
		$rowtj[5]="0";
		echo "<h4>Faltas de asistencia al Centro</h4><br />";
		printf ("<p>Número de faltas sin justificar desde principio de curso: %s<br />", $rowt[5]);
		printf ("Número de faltas justificadas desde principio de curso: %s</p>", $rowtj[5]);
        } while($rowt = mysql_fetch_array($resultt) or $rowtj = mysql_fetch_array($resulttj));
        }
	$fechasp0=explode("-",$fecha1);
	$fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
	$fechasp2=explode("-",$fecha2);
	$fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
  $SQLF = "SELECT distinct FALUMNOS.APELLIDOS, FALUMNOS.NOMBRE, FALUMNOS.NIVEL, FALUMNOS.GRUPO, FALTAS.falta, FALTAS.fecha FROM FALUMNOS, FALTAS where FALUMNOS.CLAVEAL = FALTAS.CLAVEAL and FALTAS.falta = 'F' and  FALUMNOS.claveal = $claveal group by FALUMNOS.APELLIDOS, FALTAS.fecha";
 // print $SQLF;
  $resultf = mysql_query($SQLF);
  $rowf = mysql_fetch_array($resultf);
   if(mysql_num_rows($resultf) >'0')
	{
	$nf = "";
$numdias=mysql_num_rows($resultf);
	echo "<br /><h4>Días con faltas de asistencia injustificadas <span  style='display:inline;color:#9d261d'>(".$numdias.")</h4><br />";
		echo "<p>";
					do {
			$nf = $nf + 1;		
	$fechar=explode("-",$rowf[5]);
	$fechar1=$fechar[2]."-".$fechar[1]."-".$fechar[0];
				printf ("".$fechar1."&nbsp;");
				for($i=0;$i<$numdias;$i=$i+11){
				if($nf == $i) echo "<br>";}
		} while($rowf = mysql_fetch_array($resultf));
		
        echo "</p>";}
		      
    ?>
