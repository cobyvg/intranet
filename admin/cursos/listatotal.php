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
	$nivel="";
  	$grupo="";
  // Cursos en total
$cursos = mysql_query ("select distinct nivel, grupo from FALUMNOS order by nivel, grupo");
while ($rowcursos = mysql_fetch_row($cursos))
{
$nivel = $rowcursos[0];
$grupo = $rowcursos[1];	
if (empty($nivel) and empty($grupo)) {
	
}
else
{ 	
$options_center = array(
				'justification' => 'center'
			);
$options_right = array(
				'justification' => 'right'
			);
$options_left = array(
				'justification' => 'left'
					);
$sqldatos="SELECT concat(apellidos,', ',nombre), nc FROM FALUMNOS WHERE nivel='".$nivel."' and grupo='".$grupo."' ORDER BY apellidos,nombre";
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
$txttit = "Lista del Grupo $nivel-$grupo\n";
$txttit.= $nombre_del_centro.". Curso ".$curso_actual.".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10,$options_right);
$pdf->ezNewPage();
}}
$pdf->ezStream();
?>