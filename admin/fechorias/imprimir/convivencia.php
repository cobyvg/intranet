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

if(!($_POST['id'])){$id = $_GET['id'];}else{$id = $_POST['id'];}
if(!($_POST['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}
if (isset($_POST['expulsion'])) { $expulsion = $_POST['expulsion']; }
if (isset($_POST['fechainicio'])) { $fechainicio = $_POST['fechainicio']; }
if (isset($_POST['fechafin'])) { $fechafin = $_POST['fechafin']; }

// Consulta  en curso.
$fechaesp = explode ( "-", $fechainicio );
$inicio_aula = "$fechaesp[2]-$fechaesp[1]-$fechaesp[0]";
$fechaesp1 = explode ( "-", $fechafin );
$fin_aula = "$fechaesp1[2]-$fechaesp1[1]-$fechaesp1[0]";
$actualizar = "UPDATE  Fechoria SET  recibido =  '1' WHERE  Fechoria.id = '$id'";
// echo $actualizar;
mysql_query ( $actualizar );
$result = mysql_query ( "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, 
  FALUMNOS.grupo, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, 
  Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.padre, alma.domicilio, alma.localidad, alma.codpostal, alma.provinciaresidencia,  alma.telefono, alma.telefonourgencia from Fechoria, FALUMNOS, alma, listafechorias where Fechoria.claveal = alma.claveal and Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto  and Fechoria.id = '$id' order by Fechoria.fecha DESC" );

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
	$tfno = $row [19];
	$tfno_u = $row [20];
}
$fechaesp = explode ( "/", $inicio_aula );
$hoy = formatea_fecha ( $fecha );
$inicio1 = formatea_fecha ( $inicio_aula );
$fin1 = formatea_fecha ( $fin_aula );
$tutor = "Jefatura de Estudios";

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
$titulo1 = "COMUNICACIÓN DE EXPULSIÓN AL AULA DE CONVIVENCIA";
$cuerpo1 = "Muy Señor/Sra. mío/a:

Pongo en su conocimiento que con fecha $hoy a su hijo/a $nombre $apellidos, alumno/a del grupo $nivel-$grupo, se le ha impuesto la corrección de suspensión del derecho de asistencia a clase  desde el día $inicio1 hasta el día $fin1, ambos inclusive, como consecuencia de su comportamiento en el Centro. Deberá permanecer en el Aula de Convivencia durante el tiempo de expulsión realizando las tareas encomendadas. En caso de que no las realice, se tomarán nuevas medidas disciplinarias. ";
$cuerpo2 = "Asimismo, le comunico que, según contempla el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio por el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, de reincidir su hijo/a en este tipo de conductas contrarias a las normas de convivencia del Centro podría imponérsele otra medida de corrección que podría llegar a ser la suspensión del derecho de asistencia al Centro.";
$cuerpo3 = "----------------------------------------------------------------------------------------------------------------------------------------------

En ".$localidad_del_centro.", a _________________________________
Firmado: El Padre/Madre/Representante legal:


D./Dña _____________________________________________________________________
D.N.I ___________________________";
$cuerpo4 = "
----------------------------------------------------------------------------------------------------------------------------------------------

COMUNICACIÓN DE EXPULSION AL AULA DE CONVIVENCIA.

	El alumno/a $nombre $apellidos del grupo $nivel-$grupo, ha sido amonestado/a con fecha $hoy con falta $grave, recibiendo la notificación mediante comunicación escrita de la misma para entregarla al padre/madre/representante legal.

                                                                         Firma del alumno/a:
	
";

	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();
	#### Cabecera con dirección
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Text ( 128, 35, $nombre_del_centro );
	$MiPDF->Text ( 128, 39, $direccion_del_centro );
	$MiPDF->Text ( 128, 43, $codigo_postal_del_centro . " (" . $localidad_del_centro . ")" );
	$MiPDF->Text ( 128, 47, "Tlfno. " . $telefono_del_centro );
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
	$MiPDF->Multicell ( 0, 4, 'Director/a:', 0, 'C', 0 );
	$MiPDF->Ln ( 16 );
	$MiPDF->Multicell ( 0, 4, $director_del_centro, 0, 'C', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->Multicell ( 0, 4, $cuerpo3, 0, 'J', 0 );
	$MiPDF->Ln ( 5 );
	$MiPDF->Multicell ( 0, 4, $cuerpo4, 0, 'J', 0 );

  
$result1 = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos");
$num = mysql_num_rows($result1);

$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln ( 20 );
	$MiPDF->SetFont ( 'Times', 'B', 11 );
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'C', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos limit 0, 24");

 // print "$AUXSQL";
  while($row = mysql_fetch_array($result))
                {
$dato = "$row[0]   $row[1]";
$MiPDF->Ln ( 4 );
$MiPDF->Multicell ( 0, 4, $dato, 0, 'J', 0 );              
                }

                
if ($num > '24' and $num < '49') 
{		
$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL 2";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln ( 20 );
	$MiPDF->SetFont ( 'Times', 'B', 11 );
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'C', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos limit 25, 24");
 // print "$AUXSQL";
  while($row = mysql_fetch_array($result))
                {
$pr = explode(", ",$row[2]);
$dato = "$row[0]   $row[1]";
$MiPDF->Ln ( 4 );
$MiPDF->Multicell ( 0, 4, $dato, 0, 'J', 0 );             
                }
}


if ($num > '48' and $num < '73') 
{		
$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL 3";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln ( 20 );
	$MiPDF->SetFont ( 'Times', 'B', 11 );
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'C', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos limit 50,24");
 // print "$AUXSQL";
  while($row = mysql_fetch_array($result))
                {
$pr = explode(", ",$row[2]);
$dato = "$row[0]   $row[1]";
$MiPDF->Ln ( 4 );
$MiPDF->Multicell ( 0, 4, $dato, 0, 'J', 0 );              
                }
}


if ($num > '74' and $num < '24') 
{		
$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL 3";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln ( 20 );
	$MiPDF->SetFont ( 'Times', 'B', 11 );
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'C', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '2005-09-01' order by Fechoria.fecha DESC, FALUMNOS.nivel, FALUMNOS.grupo, FALUMNOS.apellidos limit 75,24");
 // print "$AUXSQL";
  while($row = mysql_fetch_array($result))
                {
$pr = explode(", ",$row[2]);
$dato = "$row[0]   $row[1]";
$MiPDF->Ln ( 4 );
$MiPDF->Multicell ( 0, 4, $dato, 0, 'J', 0 );              
                }
}
   
$MiPDF->Output ();

?>
