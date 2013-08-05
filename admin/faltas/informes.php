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

if (isset($_POST['nombre'])) {
	$nombre = $_POST['nombre'];
} 
elseif (isset($_GET['nombre'])) {
	$nombre = $_GET['nombre'];
} 
else
{
$nombre="";
}
if (isset($_POST['claveal'])) {
	$claveal = $_POST['claveal'];
} 
elseif (isset($_GET['claveal'])) {
	$claveal = $_GET['claveal'];
} 
else
{
$claveal="";
}
if (isset($_POST['fechasp1'])) {
	$fechasp1 = $_POST['fechasp1'];
}
elseif (isset($_GET['fechasp1'])) {
	$fechasp1 = $_GET['fechasp1'];
} 
else
{
$fechasp1="";
}
if (isset($_POST['fechasp2'])) {
	$fechasp2 = $_POST['fechasp2'];
}
elseif (isset($_GET['fechasp2'])) {
	$fechasp2 = $_GET['fechasp2'];
} 
else
{
$fechasp2="";
}
if (isset($_POST['fecha3'])) {
	$fecha3 = $_POST['fecha3'];
}
elseif (isset($_GET['fecha3'])) {
	$fecha3 = $_GET['fecha3'];
} 
else
{
$fecha3="";
}
if (isset($_POST['fecha4'])) {
	$fecha4 = $_POST['fecha4'];
}
elseif (isset($_GET['fecha4'])) {
	$fecha4 = $_GET['fecha4'];
} 
else
{
$fecha4="";
}
if (isset($_POST['submit2'])) {
	$submit2 = $_POST['submit2'];
}
elseif (isset($_GET['submit2'])) {
	$submit2 = $_GET['submit2'];
} 
else
{
$submit2="";
}
echo "<div align='center'>";
   $claveal0 = explode(" --> ",$nombre);
  if(empty($claveal)){$claveal = $claveal0[1];} 
  if($fechasp1 or $fechasp2){}
  else{  
    $fechasp0=explode("-",$fecha4);
	$fechasp1=$fechasp0[2]."-".$fechasp0[1]."-".$fechasp0[0];
	$fechasp2=explode("-",$fecha3);
	$fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
  }
  $SQL10 = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo from FALUMNOS where   CLAVEAL = '$claveal'";

  $result10 = mysql_query($SQL10);
  $row10 = mysql_fetch_array($result10);
          echo "<div align='center'>";
          echo '<div class="page-header" align="center">
  <h2>Faltas de Asistencia <small> Informe de faltas del alumno</small></h2>
  </div>
<br />';
		echo "<table class='table table-striped' style='width:auto;'>";

                printf ("<tr><th>%s</th><th>%s</th>
				<th>%s</th><th>%s</th></tr>\n", $row10[1], $row10[2],$row10[3], $row10[4]);
        
        echo "</table>";
  // Datos del Alumno
 
if($submit2)
{
 $SQL0 = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal and FALUMNOS.CLAVEAL = '$claveal' and FALTAS.fecha >= '$fechasp1' and FALTAS.fecha <= '$fechasp3' GROUP BY FALUMNOS.apellidos";
 //echo $SQL0;
  $result0 = mysql_query($SQL0);
  $row0 = mysql_fetch_array($result0);
  // Justificadas
  $SQLJ = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal and FALUMNOS.CLAVEAL = '$claveal' and FALTAS.falta = 'J' and FALTAS.fecha >= '$fechasp1' and FALTAS.fecha <= '$fechasp3' GROUP BY FALUMNOS.apellidos";
  $resultJ = mysql_query($SQLJ);
  $rowJ = mysql_fetch_array($resultJ);
  // Sin justificar
  $SQLF = "select FALUMNOS.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta, count(*) from FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal and FALUMNOS.CLAVEAL = '$claveal' and FALTAS.falta = 'F' and FALTAS.fecha >= '$fechasp1' and FALTAS.fecha <= '$fechasp3' GROUP BY FALUMNOS.apellidos";

  $resultF = mysql_query($SQLF);
  $rowF = mysql_fetch_array($resultF);  

  if ($row0[0]=1)
        {
  	if($rowF[6]=="")
		$rowF[6]="0";
	if($rowJ[6]=="")
		$rowJ[6]="0";
		echo "<br /><h4>El Alumno tiene  <span style='color:#9d261d'>$row0[6]</span> Faltas de Asistencia en total.</h4></br />		
		<table class='table' style='width:auto;'><tr><th> No justificadas</th><td> <strong style='color:#9d261d'>$rowF[6] </strong></td></tr>
		<tr><th> Justificadas </th><td> <strong style='color:#46a546'>$rowJ[6] </strong></td></tr></table>";
        } else
        {
			echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
			No hay registros de faltas de asistencia para el alumno seleccionado.
			</div></div><br />';
        }
  $SQL = "SELECT distinct alma.CLAVEAL, alma.APELLIDOS, alma.NOMBRE, alma.NIVEL, alma.GRUPO,
  FALTAS.FECHA, FALTAS.HORA, FALTAS.CODASI, FALTAS.falta, asignaturas.abrev
  FROM alma, FALTAS, asignaturas where  alma.CLAVEAL = FALTAS.CLAVEAL and FALTAS.codasi = asignaturas.codigo and FALTAS.fecha >= '$fechasp1' and FALTAS.fecha <= '$fechasp3' and alma.CLAVEAL = '$claveal' and asignaturas.abrev not like '%\_%' order BY FALTAS.FECHA, FALTAS.HORA";
   $result = mysql_query($SQL);
echo "<br /><h4>Lista detallada de Faltas de Asistencia.</h4><br />";
   if ($rowsql = mysql_fetch_array($result))
        {
		echo "<div class='well' align='left' style='width:600px'>";
        $f = "";
        $horas = "";
                do
                   {
                if ($rowsql[5] == $f)
                        {
                         $horas .= $rowsql[6] . " " . $rowsql[9] . "(" . $rowsql[8] . ") <span style='color:#08c;font-weight:bold;'> | </span> ";
                        }
                else
                        {
                        if ($horas <> "")
                        printf ("" . $horas . "<div class=linea STYLE='margin-top:6px;'></div>");
          	$comienzo=explode("-",$rowsql[5]);
		$fechasp=$comienzo[2]."-".$comienzo[1]."-".$comienzo[0];
	 	$horas = "<span style='color:#08c;'>" . $fechasp . "</span>:&nbsp;&nbsp;&nbsp;" ."" . $rowsql[6] .  "&nbsp;" . "" . $rowsql[9] . "" . "(" . "" . $rowsql[8] . "" . ") <span style='color:#08c;font-weight:bold;'> | </span> ";
                        $f = $rowsql[5];
                        }
                        }
                while($rowsql = mysql_fetch_array($result));
                 	printf ("" . $horas . "");
					echo "</div>";
					}
                else
        {
echo '<br /><div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;text-align:left">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
			No hay registros de faltas de asistencia para el alumno seleccionado.
			</div></div><br />';	
			}
			}
  ?>
  </div>
<? include("../../pie.php");?>
</body>
</html>
