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
include_once ("funciones.inc.php");
require_once('class.ezpdf.php');
$pdf =& new Cezpdf('a4');
$pdf->selectFont('./fonts/Helvetica.afm');
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
# hasta aquí lo del pdf
$cursos = mysql_query ("select distinct nivel,grupo from alma order by nivel, grupo");
while ($rowcursos = mysql_fetch_row($cursos))
{
$nivel = $rowcursos[0];
$grupo = $rowcursos[1];
if (empty($nivel) and empty($grupo)) {
	
}
else
{ 
$a=array("1","2","3","4","5");
foreach($a as $dia) {
  		if($dia=='1'){$dia1 = "<b>Lunes</b>";}
		if($dia=='2'){$dia1 = "<b>Martes</b>";}
		if($dia=='3'){$dia1 = "<b>Miércoles</b>";}
		if($dia=='4'){$dia1 = "<b>Jueves</b>";}
		if($dia=='5'){$dia1 = "<b>Viernes</b>";}	
			
$sqldatos="SELECT concat(apellidos,', ',nombre), NC FROM FALUMNOS WHERE nivel='$nivel' and grupo ='$grupo' ORDER BY NC";
// echo $sqldatos;
$lista= mysql_query($sqldatos );
$num=0;
unset($data);
$ixx = 0;
while($datatmp = mysql_fetch_array($lista)) { 
	$ixx = $datatmp[1];
	$data[] = array(
				'num'=>$ixx,
				'nombre'=>$datatmp[0]				
				);
}
$firma="Observaciones:\n\n\n\n\n\n\n\n";
$data[]=array(
			'num'=>'',
			'nombre'=>$firma
			);
for($i=1;$i<7;$i++){
$curso0 = $nivel."-".$grupo;
$rowasignaturas1="";
${'a'.$i}="";
$asignaturas1 = mysql_query("SELECT distinct a_asig FROM horw where  dia= '$dia' and hora = '$i' and a_grupo like '%$curso0%'");
 	while ( $rowasignaturas1 = mysql_fetch_array($asignaturas1)){	
		${'a'.$i}.= $rowasignaturas1[0]."\n"; 
 }
 ${'a'.$i}=substr(${'a'.$i},0,strlen(${'a'.$i})-1);
 } 
$titles = array(
				'num'=>'<b>Nº</b>',
				'nombre'=>'<b>Alumno</b>',
				'c1'=>$a1,
				'c2'=>$a2,
				'c3'=>$a3,
				'c4'=>$a4,
				'c5'=>$a5,
				'c6'=>$a6,
			);
$options = array(
				'showLines'=> 2,
				'shadeCol'=>array(0.94,0.94,0.94),
				'xOrientation'=>'center',
				'width'=>500,
				'fontSize'=>9,
				'innerLineThickness'=>0.5,
  				'outerLineThickness'=>0.8
			);
$txttit = "<b>Parte de faltas del Alumno</b>     <b>Grupo $nivel-$grupo</b>     $dia1      Fecha: ____/____/_________\n";
		
$pdf->ezText($txttit, 11,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n", 10);
$pdf->ezText("<b>A</b> - Ir al Aseo.<b> B</b> - Ir a beber agua.<b>F </b> - Falta de Asistencia.<b> R</b> - Retraso injustificado.<b> J</b> - Viene de Jefatura.", 9,$options_center);
$pdf->ezNewPage();
}}}
$pdf->ezStream();
?>