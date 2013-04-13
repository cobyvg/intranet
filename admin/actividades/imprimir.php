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
// PDF
$fecha2 = date('Y-m-d');
$hoy = formatea_fecha($fecha);
include("../../pdf/fpdf.php");
define('FPDF_FONTPATH','../../pdf/fontsPDF/');
# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
function Header(){
$this->Image('../../imag/encabezado.jpg',10,10,180,'','jpg');
}
function Footer(){
$this->Image('../../imag/pie.jpg',0,240,130,'','jpg');
}
}
			# creamos el nuevo objeto partiendo de la clase
			$MiPDF=new GranPDF('P','mm',A4);
			$MiPDF->SetMargins(20,20,20);
			# ajustamos al 100% la visualizacion
			$MiPDF->SetDisplayMode('fullpage');
 
  
  $fecha1 = explode("-",$fecha);
  $dia = $fecha[0];
  $mes = $fecha[1];
  $ano = $fecha[2];
  foreach($_POST as $key => $value)
  { 
//  echo "$key --> $value<br>";
if(is_numeric(trim($key))){

$alumnos0 = "select alma.nombre, alma.apellidos, padre, domicilio, codpostal, localidad, provinciaresidencia, NC, dnitutor, alma.nivel, alma.grupo from alma, FALUMNOS where alma.claveal = FALUMNOS.claveal and alma.claveal = '$value'";
$alumnos1 = mysql_query($alumnos0);
while($alumno = mysql_fetch_array($alumnos1))
{
mysql_query("insert into actividadalumno (claveal,cod_actividad) values ('".$value."','".$id."')");
# insertamos la primera pagina del documento
$MiPDF->Addpage();
$cuerpo1="		$alumno[2], con D.N.I número $alumno[8], padre, madre o tutor/a legal de  $alumno[0] $alumno[1], alumno/a del curso $alumno[9]-$alumno[10] de este Centro, se hace cargo bajo su responsabilidad de que su hijo/a participe en la siguiente actividad extraescolar o complementaria: ";
$cuerpo2="		Fecha: $fecha.
		Horario: $horario.
		Actividad: $actividad.
		Descripción: $descripcion.
		Profesor responsable de la actividad: $profesor.";	
$cuerpo3 = "



						(ejemplar para los padres o tutores)
----------------------------------------------------------------------------------------------------------------------------------------------	
						(ejemplar para el profesor responsable de la actividad)

";
$cuerpo4 = "	
	ACUSE DE RECIBO
   
	Yo, $alumno[2], Autorizo a mi hijo/a  $alumno[0] $alumno[1], alumno/a del curso $alumno[9] -$alumno[10] a que participe en la actividad complementaria siguiente:
   
		Fecha: $fecha.
		Horario: $horario.
		Actividad: $actividad.
		Descripción: $descripcion. 
   ";

#### Cabecera con direcciÃ³n
	$MiPDF->SetFont('Times','',10);
	$MiPDF->SetTextColor(0,0,0);
	$MiPDF->Text(120,45,$alumno[2]);
	$MiPDF->Text(120,49,$alumno[3]);
	$MiPDF->Text(120,53,$alumno[4]." ".$alumno[5]);
	$MiPDF->Text(120,57,"MÃ¡laga");
	
	#Cuerpo.
	$MiPDF->Ln(45);
	$MiPDF->SetFont('Times','',10);
	$MiPDF->Multicell(0,4,$cuerpo1,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->Multicell(0,4,$cuerpo2,0,'J',0);
	$MiPDF->Ln(1);
	$MiPDF->Multicell(0,4,$cuerpo3,0,'C',0);
	$MiPDF->Ln(1);
	$MiPDF->Multicell(0,4,$cuerpo4,0,'J',0);	$MiPDF->Ln(6);
	}
}
}
$MiPDF->Output();	

?>
