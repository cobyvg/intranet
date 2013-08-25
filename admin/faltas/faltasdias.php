<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>  
 <? 
 include("../../menu.php");
include("../../faltas/menu.php");
$imprimir_activado = true;
  $fechasq0=explode("-",$fecha10);
  $fechasq1=$fechasq0[2]."-".$fechasq0[1]."-".$fechasq0[0];
  $fechasq2=explode("-",$fecha20);
  $fechasq3=$fechasq2[2]."-".$fechasq2[1]."-".$fechasq2[0];
  echo '<div class="container">
  <div class="row-fluid">
  <div class="span2"></div>
  <div class="span8">';
  echo '<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Informe de faltas</small></h2>
  </div>
';
        echo "<h4 align='center'>Alumnos con más de $numero faltas de asistencia sin justificar<br> entre los días $fechasq1 y $fechasq3</h4><br />
		<table class='table table-striped tabladatos' style='width:100%;'>";
        echo "<thead><tr><th>Alumno</th><th>Curso</th>
        <th>Nº faltas</th><th>Nº días</th></tr></thead><tbody>";

// Creación de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;  
  $SQLTEMP = "create table faltastemp2 SELECT CLAVEAL, falta, (count(*)) AS numero, nivel, grupo FROM FALTAS where falta = 'F' and FALTAS.fecha >= '$fechasq1' and FALTAS.fecha <= '$fechasq3'  group by claveal";
  $resultTEMP= mysql_query($SQLTEMP);
  mysql_query("ALTER TABLE faltastemp2 ADD INDEX (CLAVEAL)");
  $SQL0 = "SELECT CLAVEAL  FROM  faltastemp2 WHERE falta = 'F' and numero > '$numero' order by nivel, grupo";
  $result0 = mysql_query($SQL0);
 while  ($row0 = mysql_fetch_array($result0)){
$claveal = $row0[0];
// No justificadas
  $SQLF = "select faltastemp2.claveal, alma.apellidos, alma.nombre, alma.nivel, alma.grupo,
  FALTAS.falta,  faltastemp2.numero, alma.DOMICILIO, alma.CODPOSTAL, alma.LOCALIDAD  
  from faltastemp2, FALTAS, alma where alma.claveal = FALTAS.claveal  
  and faltastemp2.claveal = FALTAS.claveal and FALTAS.claveal like '$claveal' 
  and FALTAS.falta = 'F' GROUP BY alma.apellidos";
  $resultF = mysql_query($SQLF);	
//Fecha del día
$fhoy=getdate();
$fecha=$fhoy[mday]."-".$fhoy[mon]."-".$fhoy[year];
// Bucle de Consulta.
  if ($rowF = mysql_fetch_array($resultF))
        {
	echo "<tr><td >$rowF[2] $rowF[1]</td><td>$rowF[3]-$rowF[4]</td>
	<td><strong style='color:#9d261d'>$rowF[6]</strong></td>";
# Segunda parte.

  $SQL2 = "SELECT distinct FALTAS.fecha from FALTAS where FALTAS.CLAVEAL like '$claveal' and FALTAS.fecha >= '$fechasq1' and FALTAS.fecha <= '$fechasq3'";
 // print $SQL2;
  $result2 = mysql_query($SQL2);
  $rowsql = mysql_num_rows($result2);
//  print $rowsql;
  echo "<td><strong style='color:#46a546'>$rowsql</strong></td></tr>";
//  	endwhile;
	}     
	}
       
// Eliminar Tabla temporal
 mysql_query("DROP table `faltastemp2`");
  ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<? include("../../pie.php");?>
</body>
</html>

