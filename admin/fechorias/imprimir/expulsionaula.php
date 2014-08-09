<?
session_start ();
include ("../../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
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
  Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.padre, alma.domicilio, alma.localidad, alma.codpostal, alma.provinciaresidencia, tutor from Fechoria, FALUMNOS, alma, listafechorias, FTUTORES where FTUTORES.unidad = alma.unidad and Fechoria.claveal = alma.claveal and Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC" );

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

require("../../../pdf/fpdf.php");

// Variables globales para el encabezado y pie de pagina
$GLOBALS['CENTRO_NOMBRE'] = $nombre_del_centro;
$GLOBALS['CENTRO_DIRECCION'] = $direccion_del_centro;
$GLOBALS['CENTRO_CODPOSTAL'] = $codigo_postal_del_centro;
$GLOBALS['CENTRO_LOCALIDAD'] = $localidad_del_centro;
$GLOBALS['CENTRO_TELEFONO'] = $telefono_del_centro;
$GLOBALS['CENTRO_FAX'] = $fax_del_centro;
$GLOBALS['CENTRO_CORREO'] = $email_del_centro;


if(substr($codigo_postal_del_centro,0,2)=="04") $GLOBALS['CENTRO_PROVINCIA'] = 'Almería';
if(substr($codigo_postal_del_centro,0,2)=="11") $GLOBALS['CENTRO_PROVINCIA'] = 'Cádiz';
if(substr($codigo_postal_del_centro,0,2)=="14") $GLOBALS['CENTRO_PROVINCIA'] = 'Córdoba';
if(substr($codigo_postal_del_centro,0,2)=="18") $GLOBALS['CENTRO_PROVINCIA'] = 'Granada';
if(substr($codigo_postal_del_centro,0,2)=="21") $GLOBALS['CENTRO_PROVINCIA'] = 'Huelva';
if(substr($codigo_postal_del_centro,0,2)=="23") $GLOBALS['CENTRO_PROVINCIA'] = 'Jaén';
if(substr($codigo_postal_del_centro,0,2)=="29") $GLOBALS['CENTRO_PROVINCIA'] = 'Málaga';
if(substr($codigo_postal_del_centro,0,2)=="41") $GLOBALS['CENTRO_PROVINCIA'] = 'Sevilla';

# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
	function Header() {
		$this->Image ( '../../../img/encabezado.jpg',15,15,50,'','jpg');
		$this->SetFont('ErasDemiBT','B',10);
		$this->SetY(15);
		$this->Cell(90);
		$this->Cell(80,4,'CONSEJERÍA DE EDUCACIÓN, CULTURA Y DEPORTE',0,1);
		$this->SetFont('ErasMDBT','I',10);
		$this->Cell(90);
		$this->Cell(80,4,$GLOBALS['CENTRO_NOMBRE'],0,1);
		$this->Ln(8);
	}
	function Footer() {
		$this->Image ( '../../../img/pie.jpg', 10, 245, 25, '', 'jpg' );
		$this->SetY(265);
		$this->SetFont('ErasMDBT','',10);
		$this->SetTextColor(156,156,156);
		$this->Cell(70);
		$this->Cell(80,4,$GLOBALS['CENTRO_DIRECCION'],0,1);
		$this->Cell(70);
		$this->Cell(80,4,$GLOBALS['CENTRO_CODPOSTAL'].', '.$GLOBALS['CENTRO_LOCALIDAD'].' ('.$GLOBALS['CENTRO_PROVINCIA'] .')',0,1);
		$this->Cell(70);
		$this->Cell(80,4,'Tlf: '.$GLOBALS['CENTRO_TELEFONO'].'   Fax: '.$GLOBALS['CENTRO_FAX'],0,1);
		$this->Cell(70);
		$this->Cell(80,4,'Correo: '.$GLOBALS['CENTRO_CORREO'],0,1);
		$this->Ln(8);
	}
}


# creamos el nuevo objeto partiendo de la clase ampliada
$A4="A4";
$MiPDF = new GranPDF ( 'P', 'mm', $A4 );
$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');
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

                                                                         Firma del alumno/a:";

for($i = 0; $i < 1; $i ++) {
	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();

	#Cuerpo.
	$MiPDF->Ln ( 15 );
	$MiPDF->SetFont ( 'NewsGotT', 'B', 10 );
	$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
	$MiPDF->SetFont ( 'NewsGotT', '', 10 );
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
