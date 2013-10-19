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
if (isset($_POST['unidad'])) {$unidad = $_POST['unidad'];} elseif (isset($_GET['unidad'])) {$unidad = $_GET['unidad'];} else{$unidad="";}
if (isset($_POST['nombre'])) {$nombre = $_POST['nombre'];} elseif (isset($_GET['nombre'])) {$nombre = $_GET['nombre'];} else{$nombre="";}
if (isset($_POST['apellidos'])) {$apellidos = $_POST['apellidos'];} elseif (isset($_GET['apellidos'])) {$apellidos = $_GET['apellidos'];} else{$apellidos="";}
if (isset($_GET['clave_al'])) {$clave_al = $_GET['clave_al'];} else{$clave_al="";}
?>
<?php 
# para el pdf
include('../../funciones.php');
require_once('../../pdf/class.ezpdf.php');
$pdf =& new Cezpdf('a4','landscape');

$pdf->selectFont('../../pdf/fonts/helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);

$options_center = array(
				'justification' => 'center'
			);
$options_right = array(
				'justification' => 'right'
			);
$options_left = array(
				'justification' => 'left'
					);

// Número de grupo para los saltos de página
$numg=0;
$grupo=$_POST['unidad'];
$n=count($grupo);
foreach ($grupo as $grupo1)
{ 
$numg++;
//$g=$grupo[$i];

$sqldatos="SELECT concat(alma.apellidos,', ',alma.nombre),Fecha,matriculas,Sexo,padre,Domicilio,Telefonourgencia,alma.claveal, Telefono, nc FROM alma, FALUMNOS WHERE FALUMNOS.claveal=alma.claveal and Unidad='".$grupo1."' ORDER BY nc";
//echo $sqldatos;
$lista= mysql_query($sqldatos);
$num=0;
unset($data);
$ixx = 0;
while($datatmp = mysql_fetch_array($lista)) { 
	$ixx = $ixx+1;
	$tels = $datatmp[6]." ".$datatmp[8];
	$data[] = array(
				'num'=>$datatmp[9],
				'nombre'=>$datatmp[0],
				'fecha'=>cambia_fecha($datatmp[1]),
				'Repite'=>$datatmp[2],
				'NIE'=>$datatmp[7],
				'Tutor'=>$datatmp[4],
				'Domicilio'=>$datatmp[5],
				'Telefonos'=>$tels
				);
}
$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'fecha'=>'<b>Fecha:</b>',
				'Repite'=>'<b>Rep:</b>',
				'NIE'=>'<b>NIE:</b>',
				'Tutor'=>'<b>Padre/Madre:</b>',
				'Domicilio'=>'<b>Direccion</b>',
				'Telefonos'=>'<b>Teléfono(s)</b>'
				#'direccion'=>'<b>Direccion</b>',
				#'telefono'=>'<b>Telefono</b>'
			);
$options = array(
				'showLines'=> 2,
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'fontSize' => 8,
				'width'=>775
			);
$txttit = "<b>Datos del Grupo ".$grupo1."</b>\n";
	
$pdf->ezText($txttit, 14,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n", 4);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
#####  Hasta aquí la lista con cuadrícula

//echo $numg;
if ($numg!=$n){$pdf->ezNewPage();unset($data);unset($titles);}
} #del for
$pdf->ezStream();
?>
