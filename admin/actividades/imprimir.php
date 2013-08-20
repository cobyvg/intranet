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

if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['eliminar'])) {$id = $_GET['eliminar'];}elseif (isset($_POST['eliminar'])) {$eliminar = $_POST['eliminar'];}else{$eliminar="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['crear'])) {$crear = $_GET['crear'];}elseif (isset($_POST['crear'])) {$crear = $_POST['crear'];}else{$crear="";}
if (isset($_GET['buscar'])) {$buscar = $_GET['buscar'];}elseif (isset($_POST['buscar'])) {$buscar = $_POST['buscar'];}else{$buscar="";}

if (isset($_GET['calendario'])) {$calendario = $_GET['calendario'];}elseif (isset($_POST['calendario'])) {$calendario = $_POST['calendario'];}else{$calendario="";}
if (isset($_GET['act_calendario'])) {$act_calendario = $_GET['act_calendario'];}elseif (isset($_POST['act_calendario'])) {$act_calendario = $_POST['act_calendario'];}else{$act_calendario="";}
if (isset($_GET['confirmado'])) {$confirmado = $_GET['confirmado'];}elseif (isset($_POST['confirmado'])) {$confirmado = $_POST['confirmado'];}else{$confirmado="";}
if (isset($_GET['detalles'])) {$detalles = $_GET['detalles'];}elseif (isset($_POST['detalles'])) {$detalles = $_POST['detalles'];}else{$detalles="";}
if (isset($_GET['fecha'])) {$fecha = $_GET['fecha'];}elseif (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}else{$fecha="";}
if (isset($_GET['horario'])) {$horario = $_GET['horario'];}elseif (isset($_POST['horario'])) {$horario = $_POST['horario'];}else{$horario="";}
if (isset($_GET['profesor'])) {$profesor = $_GET['profesor'];}elseif (isset($_POST['profesor'])) {$profesor = $_POST['profesor'];}else{$profesor="";}
if (isset($_GET['actividad'])) {$actividad = $_GET['actividad'];}elseif (isset($_POST['actividad'])) {$actividad = $_POST['actividad'];}else{$actividad="";}
if (isset($_GET['descripcion'])) {$descripcion = $_GET['descripcion'];}elseif (isset($_POST['descripcion'])) {$descripcion = $_POST['descripcion'];}else{$descripcion="";}

include_once ("../../funciones.php"); 
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
