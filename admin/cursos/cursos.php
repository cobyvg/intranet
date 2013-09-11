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
include_once ("../../pdf/funciones.inc.php");
require_once('../../pdf/class.ezpdf.php');
$pdf =& new Cezpdf('a4');
$pdf->selectFont('../../pdf/fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
# hasta aquí lo del pdf
$options_center = array(
				'justification' => 'center'
			);
$options_right = array(
				'justification' => 'right'
			);
$options_left = array(
				'justification' => 'left'
					);
$codasig= mysql_query("SELECT codigo, abrev, curso FROM asignaturas");
while($asigtmp = mysql_fetch_array($codasig)) {
	$asignatura[$asigtmp[0]] = $asigtmp[1].'('.substr($asigtmp[2],0,2).')';
	} 
	
foreach ($_POST['unidad'] as $unidad){
	
if($_POST['asignaturas']==""){
$sqldatos="SELECT concat(FALUMNOS.apellidos,', ',FALUMNOS.nombre), nc FROM FALUMNOS, alma WHERE alma.claveal=FALUMNOS.claveal and unidad='".$unidad."' ORDER BY nc, FALUMNOS.apellidos, FALUMNOS.nombre";
$lista= mysql_query($sqldatos );
$num=0;
unset($data);
while($datatmp = mysql_fetch_array($lista)) { 
	$data[] = array(
				'num'=>$datatmp[1],
				'nombre'=>$datatmp[0],
				);
}
$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c1'=>'   ',
				'c2'=>'   ',
				'c3'=>'   ',
				'c4'=>'   ',
				'c5'=>'   ',
				'c6'=>'   ',
				'c7'=>'   ',
				'c8'=>'   ',
				'c9'=>'   ',
				'c10'=>'   '
			);
$options = array(
				'textCol' => array(0.2,0.2,0.2),
				 'innerLineThickness'=>0.5,
				 'outerLineThickness'=>0.7,
				'showLines'=> 2,
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
$txttit = "Lista del Grupo $unidad\n";
$txttit.= $nombre_del_centro.". Curso ".$curso_actual.".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
$pdf->ezNewPage();
}

if ($_POST['asignaturas']=='1'){

$sqldatos="SELECT concat(alma.apellidos,', ',alma.nombre),combasi, NC, alma.unidad FROM FALUMNOS, alma WHERE  alma.claveal = FALUMNOS.claveal and Unidad='".$unidad."' ORDER BY NC";
//echo $sqldatos;
$lista= mysql_query($sqldatos);
$num=0;
unset($data);
while($datatmp = mysql_fetch_array($lista)) { 
	$unidadn = substr($datatmp[3],0,1);
	$mat="";
	$asignat = substr($datatmp[1],0,strlen($datatmp[1])-1);
	$asignat = $datatmp[1];
	$asig0 = explode(":",$asignat);
		foreach($asig0 as $asignatura){			
		$consulta = "select distinct abrev, curso from asignaturas where codigo = '$asignatura' and curso like '%$unidadn%' limit 1";
		// echo $consulta."<br>";
		$abrev = mysql_query($consulta);		
		$abrev0 = mysql_fetch_array($abrev);
		$curs=substr($abrev0[1],0,2);
		$mat.=$abrev0[0]."; ";
		}
//	echo $mat."<br>";		
	$ixx = $datatmp[2];
	$data[] = array(
				'num'=>$ixx,
				'nombre'=>$datatmp[0],
				'asig'=>$mat
				);
}
$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'asig'=>'<b>Asignaturas</b>'
			);
$options = array(
				'showLines'=> 2,
				'shadeCol'=>array(0.9,0.9,0.9),
				'xOrientation'=>'center',
				'fontSize' => 8,
				'width'=>500
			);
$txttit = "<b>Alumnos del grupo: $unidad</b>\n";
	
$pdf->ezText($txttit, 12,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 9,$options_right);
$pdf->ezNewPage();
} 
}
$pdf->ezStream();
?>