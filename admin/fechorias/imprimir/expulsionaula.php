<?
session_start ();
include ("../../../config.php");
if ($_SESSION ['autentificado'] != '1') {
	session_destroy ();
	header ( "location:http://$dominio/intranet/salir.php" );
	exit ();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$tutor = $_SESSION ['profi'];
include_once ("../../../funciones.php");
// Consulta  en curso.

if(!($_POST['id'])){$id = $_GET['id'];}else{$id = $_POST['id'];}
if(!($_POST['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}

$actualizar = "UPDATE  Fechoria SET  recibido =  '1' WHERE  Fechoria.id = '$id'";
mysql_query ( $actualizar );
$result = mysql_query ( "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, 
  FALUMNOS.grupo, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, 
  Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.padre, alma.domicilio, alma.localidad, alma.codpostal, alma.provinciaresidencia, tutor from Fechoria, FALUMNOS, alma, listafechorias, FTUTORES where FTUTORES.nivel = alma.nivel and FTUTORES.grupo = alma.grupo and Fechoria.claveal = alma.claveal and Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC" );

if ($row = mysql_fetch_array ( $result )) {
	$apellidos = $row [0];
	$nombre = $row [1];
	$nivel = $row [2];
	$grupo = $row [3];
	$fecha = $row [4];
	$notas = $row [5];
	$asunto = $row [6];
	$informa = $row [7];
	$grave = $row [8];
	$medida = $row [9];
	$medidas2 = $row [10];
	$expulsion = $row [11];
	$tutoria = $row [12];
	$claveal = $row [13];
	$padre = $row [14];
	$direccion = $row [15];
	$localidad = $row [16];
	$codpostal = $row [17];
	$provincia = $row [18];
	$tutor = $row [19];
}
$tr_tut = explode(", ", $tutor);
$tutor = "$tr_tut[1] $tr_tut[0]";
$fecha2 = date ( 'Y-m-d' );
$hoy = formatea_fecha ( $fecha );
include ("../../../pdf/fpdf.php");
define ( 'FPDF_FONTPATH', '../../../pdf/fontsPDF/' );
# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
	function Header() {
		$this->Image ( '../../../imag/encabezado.jpg', 10, 10, 180, '', 'jpg' );
	}
	function Footer() {
		$this->Image ( '../../../imag/pie.jpg', 0, 240, 130, '', 'jpg' );
	}
}
# creamos el nuevo objeto partiendo de la clase ampliada
$A4="A4";
$MiPDF = new GranPDF ( 'P', 'mm', $A4 );
$MiPDF->SetMargins ( 20, 20, 20 );
# ajustamos al 100% la visualizaciÃ³n
$MiPDF->SetDisplayMode ( 'fullpage' );
$titulo1 = "COMUNICACIÓN DE EXPULSIÓN DEL AULA";
$cuerpo1 = "Muy Señor/Sra. mío/a:

Pongo en su conocimiento que con fecha $fecha a su hijo/a $nombre $apellidos, alumno/a del grupo $nivel-$grupo, le ha sido impuesta la suspensión del derecho de asistencia a clase tras haber sido expulsado del aula por el Profesor $informa por el siguiente motivo: \"$asunto\"";
$cuerpo2 = "Asimismo, le comunico que, según contempla el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio por el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, de reincidir su hijo/a en este tipo de conductas contrarias a las normas de convivencia del Centro podría imponérsele otra medida de corrección que podría llegar a ser la suspensión del derecho de asistencia al Centro.";
$cuerpo3 = "
----------------------------------------------------------------------------------------------------------------------------------------------

En ".$localidad_del_centro.", a _________________________________
Firmado: El Padre/Madre/Representante legal:

D./Dña _____________________________________________________________________
D.N.I ___________________________";
$cuerpo4 = "

----------------------------------------------------------------------------------------------------------------------------------------------

COMUNICACIÓN DE EXPULSION DEL AULA.

	El alumno/a $nombre $apellidos del grupo $nivel-$grupo, ha sido amonestado/a con fecha $hoy con falta $grave, recibiendo la notificación mediante comunicación escrita de la misma para entregarla al padre/madre/representante legal.

                                                                         Firma del alumno/a:
	
";
for($i = 0; $i < 1; $i ++) {
	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();
	#### Cabecera con dirección
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Text ( 128, 32, $nombre_del_centro );
	$MiPDF->Text ( 128, 36, $direccion_del_centro );
	$MiPDF->Text ( 128, 40, $codigo_postal_del_centro . " (" . $localidad_del_centro . ")" );
	$MiPDF->Text ( 128, 44, "Tlfno. " . $telefono_del_centro );
	#Cuerpo.
	$MiPDF->Ln ( 40 );
	$MiPDF->SetFont ( 'Times', 'B', 11 );
	$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->Ln ( 4 );
	$MiPDF->Multicell ( 0, 4, $cuerpo1, 0, 'J', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 4, $cuerpo2, 0, 'J', 0 );
	$MiPDF->Ln ( 6 );
	$MiPDF->Multicell ( 0, 4, 'En ' . $localidad_del_centro . ', a ' . $hoy, 0, 'C', 0 );
	$MiPDF->Ln ( 6 );
	$MiPDF->Multicell ( 0, 4, 'Tutor/a:', 0, 'C', 0 );
	$MiPDF->Ln ( 16 );
	$MiPDF->Multicell ( 0, 4, $tutor, 0, 'C', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->Multicell ( 0, 4, $cuerpo3, 0, 'J', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->Multicell ( 0, 4, $cuerpo4, 0, 'J', 0 );
}

$MiPDF->Output ();

?>
