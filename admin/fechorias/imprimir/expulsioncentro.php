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
$MiPDF = new GranPDF ( 'P', 'mm', A4 );
$MiPDF->SetMargins ( 20, 20, 20 );
# ajustamos al 100% la visualizaciÃ³n
$MiPDF->SetDisplayMode ( 'fullpage' );

// Consulta  en curso. 
$actualizar = "UPDATE  Fechoria SET  recibido =  '1' WHERE  Fechoria.id = '$id'";
mysql_query ( $actualizar );
$result = mysql_query ( "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.nivel, FALUMNOS.grupo, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.telefono, alma.telefonourgencia from Fechoria, FALUMNOS, listafechorias, alma where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto and FALUMNOS.claveal = alma.claveal and Fechoria.id = '$id' order by Fechoria.fecha DESC" );
if ($row = mysql_fetch_array ( $result )) {
	$apellidos = $row [0];
	$nombre = $row [1];
	$nivel = $row [2];
	$grupo = $row [3];
	$fecha = $row [4];
	$grave = $row [8];
	$expulsion = $row [11];
	$claveal = $row [13];
	$tfno = $row [14];
	$tfno_u = $row [15];
}

$fecha2 = date ( 'Y-m-d' );
$hoy = formatea_fecha ( $fecha2 );
$fechaesp = explode ( "-", $fechainicio );
$fechaesp1 = explode ( "-", $fechafin );
$fecha = "$fechaesp[2]-$fechaesp[1]-$fechaesp[0]";
$fecha_fin = "$fechaesp1[2]-$fechaesp1[1]-$fechaesp1[0]";
$inicio1 = formatea_fecha ( $fecha );
$fin1 = formatea_fecha ( $fecha_fin );


$repe = mysql_query ( "select * from tareas_alumnos where claveal = '$claveal' and fecha = '$fecha'" );
if (mysql_num_rows ( $repe ) == "0") {
	 mysql_query ( "INSERT into tareas_alumnos (CLAVEAL,APELLIDOS,NOMBRE,NIVEL,GRUPO,FECHA,DURACION,PROFESOR,FIN) VALUES ('$claveal','$apellidos','$nombre','$nivel','$grupo', '$fecha','$expulsion','$tutor','$fecha_fin')" ) or die ( "Error, no se ha podido activar el informe:" . mysql_error () );
} 

$titulo1 = "COMUNICACIÓN DE EXPULSIÓN DEL CENTRO";
$cuerpo1 = "El Director del Instituto de Educación Secundaria $nombre_corto de $localidad_del_centro, en virtud de las facultades otorgadas por el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio en el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, una vez estudiado el expediente disciplinario del alumno/a $nombre $apellidos, Alumno/a del Grupo $nivel-$grupo
ACUERDA:";
$cuerpo2 = "1.- Tipificar la conducta de este alumno(a) como contraria a las normas de convivencia del Centro, suponiendo falta $grave
2.- Imponer las siguientes correcciones:
     Amonestación que constará en el expediente individual del alumno/a. 
    Suspensión del derecho de asistencia a clase por un periodo de $expulsion días lectivos, desde el $inicio1 hasta el $fin1, ambos inclusive, sin que ello implique la pérdida de evaluación. Durante esos días, el alumno/a deberá permanecer en su domicilio durante el horario escolar realizando los deberes o trabajos que tenga encomendados. La no realización de las tareas supone el incumplimiento de la corrección por lo que dicha conducta se considerará gravemente perjudicial para la convivencia y, como consecuencia, conllevaría la imposición de una nueva medida correctora.";
$importante1 = 'NOTA: El padre, madre o representante legal podrá presentar en el registro de entrada del Centro, en el plazo de dos días lectivos, una reclamación dirigida a la Dirección del Centro contra las correcciones impuestas.';
$cuerpo3 = "----------------------------------------------------------------------------------------------------------------------------------------------

En Estepona, a _________________________________
Firmado: El Padre/Madre/Representante legal:

D./Dña _____________________________________________________________________
D.N.I ___________________________";
$cuerpo4 = "----------------------------------------------------------------------------------------------------------------------------------------------

COMUNICACIÓN DE EXPULSION DEL CENTRO

	El alumno/a $nombre $apellidos del grupo $nivel-$grupo, ha sido amonestado/a con fecha $fecha con falta $grave , recibiendo la notificación mediante comunicación escrita de la misma para entregarla al padre/madre/representante legal.

                                                                         Firma del alumno/a:
	
";

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
	$MiPDF->Ln ( 29 );
	$MiPDF->SetFont ( 'Times', 'B', 11 );
	$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
	$MiPDF->SetFont ( 'Times', '', 10 );
	$MiPDF->Ln ( 4 );
	$MiPDF->Multicell ( 0, 4, $cuerpo1, 0, 'J', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 4, $cuerpo2, 0, 'J', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 4, 'En ' . $localidad_del_centro . ', a ' . $hoy, 0, 'C', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->Multicell ( 0, 4, 'Director/a:', 0, 'C', 0 );
	$MiPDF->Ln ( 10 );
	$MiPDF->Multicell ( 0, 4, $director_del_centro, 0, 'C', 0 );
	$MiPDF->Ln ( 6 );
	$MiPDF->Multicell ( 0, 4, $importante1, 0, 'J', 0 );
	$MiPDF->Ln ( 6 );
	$MiPDF->Multicell ( 0, 4, $cuerpo3, 0, 'J', 0 );
	$MiPDF->Ln ( 8 );
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
