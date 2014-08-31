<?
session_start ();
include("../../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );

if(!($_POST['id'])){$id = $_GET['id'];}else{$id = $_POST['id'];}
if(!($_POST['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}
if (isset($_POST['expulsion'])) { $expulsion = $_POST['expulsion']; }
if (isset($_POST['fechainicio'])) { $fechainicio = $_POST['fechainicio']; }
if (isset($_POST['fechafin'])) { $fechafin = $_POST['fechafin']; }

$tutor = $_SESSION ['profi'];
include_once ("../../../funciones.php");
require ("../../../pdf/fpdf.php");

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
		$this->SetTextColor(0, 122, 61);
		$this->Image( '../../../img/encabezado.jpg',25,14,53,'','jpg');
		$this->SetFont('ErasDemiBT','B',10);
		$this->SetY(15);
		$this->Cell(75);
		$this->Cell(80,5,'CONSEJERÍA DE EDUCACIÓN, CULTURA Y DEPORTE',0,1);
		$this->SetFont('ErasMDBT','I',10);
		$this->Cell(75);
		$this->Cell(80,5,$GLOBALS['CENTRO_NOMBRE'],0,1);
		$this->SetTextColor(255, 255, 255);
	}
	function Footer() {
		$this->SetTextColor(0, 122, 61);
		$this->Image( '../../../img/pie.jpg', 0, 245, 25, '', 'jpg' );
		$this->SetY(275);
		$this->SetFont('ErasMDBT','',8);
		$this->Cell(75);
		$this->Cell(80,4,$GLOBALS['CENTRO_DIRECCION'].'. '.$GLOBALS['CENTRO_CODPOSTAL'].', '.$GLOBALS['CENTRO_LOCALIDAD'].' ('.$GLOBALS['CENTRO_PROVINCIA'] .')',0,1);
		$this->Cell(75);
		$this->Cell(80,4,'Telf: '.$GLOBALS['CENTRO_TELEFONO'].'   Fax: '.$GLOBALS['CENTRO_FAX'],0,1);
		$this->Cell(75);
		$this->Cell(80,4,'Correo-e: '.$GLOBALS['CENTRO_CORREO'],0,1);
		$this->SetTextColor(255, 255, 255);
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

$MiPDF->SetMargins (25, 20, 20);
$MiPDF->SetDisplayMode ( 'fullpage' );

// Consulta  en curso. 
$actualizar = "UPDATE  Fechoria SET  recibido =  '1' WHERE  Fechoria.id = '$id'";
mysql_query ( $actualizar );
$result = mysql_query ( "select FALUMNOS.apellidos, FALUMNOS.nombre, FALUMNOS.unidad, Fechoria.fecha, Fechoria.notas, Fechoria.asunto, Fechoria.informa, Fechoria.grave, Fechoria.medida, listafechorias.medidas2, Fechoria.expulsion, Fechoria.tutoria, Fechoria.claveal, alma.telefono, alma.telefonourgencia, alma.padre, alma.domicilio, alma.localidad, alma.codpostal, alma.provinciaresidencia, Fechoria.id from Fechoria, FALUMNOS, listafechorias, alma where Fechoria.claveal = FALUMNOS.claveal and listafechorias.fechoria = Fechoria.asunto and FALUMNOS.claveal = alma.claveal and Fechoria.id = '$id' order by Fechoria.fecha DESC" );
if ($row = mysql_fetch_array ( $result )) {
	$apellidos = $row [0];
	$nombre = $row [1];
	$unidad = $row [2];
	$fecha = $row [3];
	$grave = $row [7];
	$expulsion = $row [10];
	$claveal = $row [12];
	$tfno = $row [13];
	$tfno_u = $row [14];
	$padre = $row ['padre'];
	$direccion = $row ['domicilio'];
	$codpostal = $row ['codpostal'];
	$provincia = $row ['provinciaresidencia'];
}

$fecha2 = date ( 'Y-m-d' );
$hoy = strftime("%d.%m.%Y", strtotime($fecha));
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

$titulo = "Comunicación de expulsión del centro";
$cuerpo = "El Director del Instituto de Educación Secundaria $nombre_corto de $localidad_del_centro, en virtud de las facultades otorgadas por el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio en el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, una vez estudiado el expediente disciplinario de $nombre $apellidos, alumno/a del grupo $unidad.

Acuerda:

1.- Tipificar la conducta de este alumno(a) como contraria a las normas de convivencia del Centro, suponiendo falta $grave.
2.- Imponer las siguientes correcciones:
     Amonestación que constará en el expediente individual del alumno/a. 
    Suspensión del derecho de asistencia a clase por un periodo de $expulsion días lectivos, desde el $inicio1 hasta el $fin1, ambos inclusive, sin que ello implique la pérdida de evaluación. Durante esos días, el alumno/a deberá permanecer en su domicilio durante el horario escolar realizando los deberes o trabajos que tenga encomendados. La no realización de las tareas supone el incumplimiento de la corrección por lo que dicha conducta se considerará gravemente perjudicial para la convivencia y, como consecuencia, conllevaría la imposición de una nueva medida correctora.

NOTA: El padre, madre o representante legal podrá presentar en el registro de entrada del Centro, en el plazo de dos días lectivos, una reclamación dirigida a la Dirección del Centro contra las correcciones impuestas.

En $localidad_del_centro, a ".strftime("%e de %B de %Y", strtotime($fecha)).".";


	# insertamos la primera pagina del documento
	$MiPDF->Addpage ();
	
	// INFORMACION DE LA CARTA
	$MiPDF->SetY(45);
	$MiPDF->SetFont ( 'NewsGotT', '', 12 );
	$MiPDF->Cell(75, 5, 'Fecha:  '.$hoy, 0, 0, 'L', 0 );
	$MiPDF->Cell(75, 5, $padre, 0, 1, 'L', 0 );
	$MiPDF->Cell(75, 12, 'Ref.:     Fec/'.$row['id'], 0, 0, 'L', 0 );
	$MiPDF->Cell(75, 5, $direccion, 0, 1, 'L', 0 );
	$MiPDF->Cell(75, 0, '', 0, 0, 'L', 0 );
	$MiPDF->Cell(75, 5, $codpostal.' '.mb_strtoupper($provincia, 'iso-8859-1'), 0, 1, 'L', 0 );
	$MiPDF->Cell(0, 12, 'Asunto: '.$titulo, 0, 1, 'L', 0 );
	$MiPDF->Ln(10);
	
	// CUERPO DE LA CARTA
	$MiPDF->SetFont('NewsGotT', 'B', 12);
	$MiPDF->Multicell(0, 5, mb_strtoupper($titulo, 'iso-8859-1'), 0, 'C', 0 );
	$MiPDF->Ln(5);
	
	$MiPDF->SetFont('NewsGotT', '', 12);
	$MiPDF->Multicell(0, 5, $cuerpo, 0, 'L', 0 );
	$MiPDF->Ln(15);
	
	
	//FIRMAS
	$MiPDF->Cell (55, 5, 'Representante legal', 0, 0, 'L', 0 );
	$MiPDF->Cell (55, 5, 'Alumno/a', 0, 0, 'L', 0 );
	$MiPDF->Cell (55, 5, 'Director/a del centro', 0, 1, 'L', 0 );
	$MiPDF->Cell (55, 25, '', 0, 0, 'L', 0 );
	$MiPDF->Cell (55, 25, '', 0, 0, 'L', 0 );
	$MiPDF->Cell (55, 25, '', 0, 1, 'L', 0 );
	$MiPDF->SetFont('NewsGotT', '', 10);
	$MiPDF->Cell (55, 5, 'Fdo. '.$padre, 0, 0, 'L', 0 );
	$MiPDF->Cell (55, 5, 'Fdo. '.$nombre.' '.$apellidos, 0, 0, 'L', 0 );
	$MiPDF->Cell (55, 5, 'Fdo. '.mb_convert_case($director_del_centro, MB_CASE_TITLE, "iso-8859-1"), 0, 1, 'L', 0 );
  
$result1 = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '".$inicio_curso."' order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos");
$num = mysql_num_rows($result1);

$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln (15);
	$MiPDF->SetFont ( 'NewsGotT', 'B', 12);
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '".$inicio_curso."' order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos limit 0, 24");

 // print "$AUXSQL";
  while($row = mysql_fetch_array($result))
                {
$dato = "$row[0]   $row[1]";
$MiPDF->Ln ( 4 );
$MiPDF->Multicell ( 0, 4, $dato, 0, 'J', 0 );              
                }

                
if ($num > '24' and $num < '49') 
{		
$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln (15);
	$MiPDF->SetFont ( 'NewsGotT', 'B', 12);
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '".$inicio_curso."' order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos limit 25, 24");
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
$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln (15);
	$MiPDF->SetFont ( 'NewsGotT', 'B', 12);
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '".$inicio_curso."' order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos limit 50,24");
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
$tit_fech = "PROBLEMAS DE CONVIVENCIA DEL ALUMNO EN EL CURSO ACTUAL";
$MiPDF->Addpage ();
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	$MiPDF->SetTextColor ( 0, 0, 0 );
	$MiPDF->Ln (15);
	$MiPDF->SetFont ( 'NewsGotT', 'B', 12);
	$MiPDF->Multicell ( 0, 4, $tit_fech, 0, 'L', 0 );
	$MiPDF->Ln ( 3 );
	$MiPDF->SetFont ( 'NewsGotT', '', 12);
	
$result = mysql_query ("select distinct Fechoria.fecha, Fechoria.asunto, Fechoria.informa, Fechoria.claveal from Fechoria, FALUMNOS where FALUMNOS.claveal = Fechoria.claveal and FALUMNOS.claveal = $claveal and Fechoria.fecha >= '".$inicio_curso."' order by Fechoria.fecha DESC, FALUMNOS.unidad, FALUMNOS.apellidos limit 75,24");
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
