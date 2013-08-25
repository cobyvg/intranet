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
$tutor = $_SESSION['profi'];
include_once ("../../funciones.php"); 
if (isset($_GET['nivel'])) {$nivel = $_GET['nivel'];}elseif (isset($_POST['nivel'])) {$nivel = $_POST['nivel'];}else{$nivel="";}
if (isset($_GET['grupo'])) {$grupo = $_GET['grupo'];}elseif (isset($_POST['grupo'])) {$grupo = $_POST['grupo'];}else{$grupo="";}
if (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];}elseif (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];}else{$nombre="";}
if (isset($_GET['fecha12'])) {$fecha12 = $_GET['fecha12'];}elseif (isset($_POST['fecha12'])) {$fecha12 = $_POST['fecha12'];}else{$fecha12="";}
if (isset($_GET['fecha22'])) {$fecha22 = $_GET['fecha22'];}elseif (isset($_POST['fecha22'])) {$fecha22 = $_POST['fecha22'];}else{$fecha22="";}
if (isset($_GET['numero'])) {$numero = $_GET['numero'];}elseif (isset($_POST['numero'])) {$numero = $_POST['numero'];}else{$numero="";}
// PDF
$fecha2 = date('Y-m-d');
$hoy = formatea_fecha($fecha);
include("../../pdf/fpdf.php");
define('FPDF_FONTPATH','../../pdf/font/');
# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
function Header(){
$this->Image('../../img/encabezado.jpg',10,10,180,'','jpg');
}
function Footer(){
$this->Image('../../img/pie.jpg',0,240,130,'','jpg');
}
}
			# creamos el nuevo objeto partiendo de la clase ampliada
			$MiPDF=new GranPDF('P','mm',A4);
			$MiPDF->SetMargins(20,20,20);
			# ajustamos al 100% la visualizacion
			$MiPDF->SetDisplayMode('fullpage');

// Consulta  en curso.

foreach($nombre as $val)
{
$trozos = explode(" --> ",$val);
$claveal0 .= "claveal = '".$trozos[1]."' or ";
}
$claveal1 = substr($claveal0,0,strlen($claveal0)-4);

 mysql_query($SQLDELF);
 mysql_query($SQLDELJ);
// Creación de la tabla temporal donde guardar los registros. La variable para el bucle es 10224;
 // $fechasp0=explode("-",$fecha12);
  $fechasp1=cambia_fecha($fecha12);
  $fechasp3=cambia_fecha($fecha22);
//  $fechasp11=$fechasp0[0]."-".$fechasp0[1]."-".$fechasp0[2];
//  $fechasp2=explode("-",$fecha22);
//  $fechasp3=$fechasp2[2]."-".$fechasp2[1]."-".$fechasp2[0];
//  $fechasp31=$fechasp2[0]."-".$fechasp2[1]."-".$fechasp2[2];
  if(strlen($claveal1) > 5){$alum = " and (".$claveal1.")";}else{$alum = "";}
  mysql_query("drop table faltastemp2");
  mysql_query("drop table faltastemp3");
  $SQLTEMP = "create table faltastemp2 SELECT CLAVEAL, falta, (count(*)) AS numero
  FROM  FALTAS where falta = 'F' and date(FALTAS.fecha) >= '$fechasp1' and date(FALTAS.fecha)
	<= '$fechasp3' $alum group by claveal";
  // echo $SQLTEMP."<br>";
  $resultTEMP= mysql_query($SQLTEMP);
  mysql_query("ALTER TABLE faltastemp2 ADD INDEX ( claveal ) ");
  $SQLTEMPJ = "create table faltastemp3 SELECT CLAVEAL, falta, (count(*)) AS numero
	  FROM  FALTAS where falta = 'J' and date(FALTAS.fecha) >= '$fechasp1' and date(FALTAS.fecha)
	<= '$fechasp3' group by claveal";
  $resultTEMPJ = mysql_query($SQLTEMPJ);
  	mysql_query("ALTER TABLE faltastemp3 ADD INDEX ( claveal ) ");
    $SQL0 = "SELECT CLAVEAL  FROM  faltastemp2 WHERE falta = 'F' and numero >= '$numero'";
   
  $result0 = mysql_query($SQL0);
  if(mysql_num_rows($result0)>"0"){
while  ($row0 = mysql_fetch_array($result0)):
$claveal = $row0[0];
// Justificadas
$SQLJ = "select faltastemp3.claveal, FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, FALTAS.falta,  faltastemp3.numero from faltastemp3, FALTAS, FALUMNOS where FALUMNOS.claveal = FALTAS.claveal and faltastemp3.claveal = FALTAS.claveal and FALTAS.falta = 'J' and FALTAS.claveal = '$claveal' GROUP BY FALUMNOS.apellidos";
  	$resultJ = mysql_query($SQLJ);
  	$rowJ = mysql_fetch_array($resultJ);
// No justificadas
 $SQLF = "select faltastemp2.claveal, alma.apellidos, alma.nombre, alma.nivel, alma.grupo,
FALTAS.falta,  faltastemp2.numero, alma.DOMICILIO, alma.CODPOSTAL, alma.LOCALIDAD,
alma.PADRE from faltastemp2, FALTAS, alma where alma.claveal = FALTAS.claveal and faltastemp2.claveal =
FALTAS.claveal and FALTAS.claveal = '$claveal' and FALTAS.falta = 'F' GROUP BY alma.apellidos";
  $resultF = mysql_query($SQLF);
//Fecha del día
$fhoy=date('Y-m-d');;
$fecha = formatea_fecha($fhoy);
// Bucle de Consulta.
  if ($rowF = mysql_fetch_array($resultF))
        {
$justidias = "";
$nojustidias = "";
	$padre = $rowF[10];
	$direcion =  $rowF[7];
	$localidad = $rowF[8]." ".$rowF[9];
// Días con Faltas Justificadas
$SQL2 = "SELECT distinct FALTAS.fecha from FALTAS where FALTAS.CLAVEAL = '$claveal' and FALTAS.falta = 'J' and date(FALTAS.fecha )>= '$fechasp1' and date(FALTAS.fecha) <= '$fechasp3' order by fecha";
		$result3 = mysql_query($SQL2);
		$justi = mysql_fetch_array($result3);
		if ($justi[0] == "")
		{
		$justi1 = "Su hijo no ha justificado faltas de asistencia al Centro entre los días $fecha12 y $fecha22.";}
		else
		{
		$result2 = mysql_query($SQL2);
		$justi1 = "El Alumno ha justificado su falta de asistencia al Centro los siguientes días entre el $fechasp11 y el $fechasp31: ";
		while ($rowsql = mysql_fetch_array($result2)):
		$fechaj = explode("-", $rowsql[0]);
		$fecha2 = $fechaj[2]."-".$fechaj[1]."-".$fechaj[0];
		$justidias.=$fecha2." ";
		endwhile;
		}
		$justi2=$justidias;
// Días con Faltas No Justificadas
$SQL3 = "SELECT distinct FALTAS.fecha from FALTAS where FALTAS.CLAVEAL = '$claveal' and FALTAS.falta = 'F' and date(FALTAS.fecha) >= '$fechasp1' and date(FALTAS.fecha) <= '$fechasp3' order by fecha";
	$justi3 = "Los días en los que el Alumno no ha justificado su ausencia del Centro son los siguientes:";
    $result3 = mysql_query($SQL3);
    while ($rowsql3 = mysql_fetch_array($result3)):
    $fecha3 = explode("-", $rowsql3[0]);
    $fecha4 = $fecha3[2]."-".$fecha3[1]."-".$fecha3[0];
    $nojustidias.=$fecha4." ";
endwhile;
$justi4 = $nojustidias;
	}
	
# insertamos la primera pagina del documento
$MiPDF->Addpage();
$cuerpo1="											
Muy Señor/Sra. mío/a:
Nos dirigimos a usted para enviarle un informe completo sobre las faltas de asistencia al Centro de su hijo/a, $rowF[2] $rowF[1], perteneciente al Grupo $rowF[3]-$rowF[4].";
	if($justi1=="Su hijo no ha justificado ninguno de los días en los que no ha asistido al Centro")
	{
$cuerpo2="$justi1
$justi3
";	
	}
	else
	{
$cuerpo2="$justi1
$justi2

$justi3
";	
	}
$cuerpo3 = "Rogamos que se ponga en contacto, a la mayor brevedad, con el tutor o tutora del grupo. El tutor o tutora puede atenderle los lunes de 17 a 18 horas. Aconsejamos que, previamente, concierte una cita con el o ella a través de su hijo/a o llamando por teléfono a la Conserjería del Instituto. 
Asimismo, le recordamos que: 
 - Si su hijo o hija es menor de dieciséis años, tenemos la obligación de enviar el informe de faltas a la Delegación de Asuntos Sociales del Ayuntamiento para que tome las medidas legales oportunas.
 - En E.S.O., si el número de faltas de asistencia injustificadas es muy elevado, se podría no firmar la escolarización correspondiente a este curso.
 - En cualquier curso y, en especial, en Bachillerato y Ciclos Formativos, el alumno con un número elevado de faltas de asistencia puede perder el derecho a la evaluación continua.
 
Atentamente le saluda la Dirección del Centro.
";

#### Cabecera con dirección
	$MiPDF->SetFont('Times','',10);
	$MiPDF->SetTextColor(0,0,0);
	$MiPDF->Text(120,35,$padre);
	$MiPDF->Text(120,39,$direcion);
	$MiPDF->Text(120,43,$localidad);
	$MiPDF->Text(120,47,"Málaga");
	$MiPDF->Text(120,58,$fecha);
	
	#Cuerpo.
	$MiPDF->Ln(35);
	$MiPDF->SetFont('Times','',10);
	$MiPDF->Ln(4);
	$MiPDF->Multicell(0,4,$cuerpo1,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->Multicell(0,4,$cuerpo2,0,'J',0);
	$MiPDF->Ln(1);
	$MiPDF->SetFont('Times','',10);
	$MiPDF->Multicell(0,4,$justi4,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->SetFont('Times','',10);
	$MiPDF->Multicell(0,4,$cuerpo3,0,'J',0);
	$MiPDF->Ln(6);
	$MiPDF->Multicell(0,4,'En '.$localidad_del_centro.', a '.$fecha,0,'C',0);
	$MiPDF->Ln(6);
	$MiPDF->Multicell(0,4,'Jefe de Estudios:                    Sello del Centro                   Director/a:',0,'C',0);
	$MiPDF->Ln(16);
	$MiPDF->Multicell(0,4,$jefatura_de_estudios.'                                             '.$director_del_centro,0,'C',0);
	endwhile;
	}
	$MiPDF->Output();
	// Eliminar Tabla temporal
 mysql_query("DROP table `faltastemp2`");
 mysql_query("DROP table `faltastemp3`");
?>
