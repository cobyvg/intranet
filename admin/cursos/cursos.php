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
$pdf = new Cezpdf('a4');
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
$libd12 = "
LIBD1: Ref. Lengua; LIBD2: Ref. Matemáticas; LIBD3: Ref. Inglés; LIBD4: Taller TIC; LIBD5: Taller Teatro.
";
$lc3 = "
OPLC1: TALLER TIC; OPLC2: TALLER CERÁMICA; OPLC3: TALLER TEATRO.
";
$lc1b = "
OPLC1: Ed. Física; OPLC2: Estadística; OPLC3: Francés.
";
if (isset($_GET['unidad'])) {
$tr_uni = explode("-",$_GET['unidad']);	
if (strlen($tr_uni[1])>1) {
		$text = " and (combasi like '%30562%' or combasi like '%31322%') ";
	}	
$sqldatos="SELECT concat(FALUMNOS.apellidos,', ',FALUMNOS.nombre), nc, matriculas, alma.claveal FROM FALUMNOS, alma WHERE alma.claveal=FALUMNOS.claveal and unidad='".$unidad."' $texto ORDER BY nc, FALUMNOS.apellidos, FALUMNOS.nombre";
$lista= mysql_query($sqldatos );
$num=0;
unset($data);
while($datatmp = mysql_fetch_array($lista)) { 
	if ($datatmp[2]>1) {
		$datatmp[0]=$datatmp[0]." (R)";
	}
	if(strstr($unidad,"E-")==TRUE){
	$m_ex = "select exencion from matriculas where claveal = '$datatmp[3]'";
	$m_exen = mysql_query($m_ex);
	$m_exento = mysql_fetch_array($m_exen);
	if($m_exento[0]=="1"){
	$datatmp[0]=$datatmp[0]." (Ex)";
	}
	}
	
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
$txttit = "Lista del Grupo $unida\n";
$txttit.= $nombre_del_centro.". Curso ".$curso_actual.".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
$pdf->ezNewPage();
	}
	
	
	
foreach ($_POST['unidad'] as $unida){
		//echo "$unida<br>";
$tr_c = explode(" -> ",$unida);
$tr_unidad = $tr_c[0];
$tr_codasi = explode("-",$tr_c[2]);
$n_uni+=1;
$cuenta = count($_POST['unidad']);
if($_POST['asignaturas']==""){
	
	$tr_uni = explode("-",$tr_unidad);	
	if (strlen($tr_uni[1])>1) {
		$text = " and (combasi like '%30562%' or combasi like '%31322%') ";
		$tr_unidad = substr($tr_unidad,0,-1);
		$text2 = "Diversificación";
	}	
	
$sqldatos="SELECT concat(FALUMNOS.apellidos,', ',FALUMNOS.nombre), nc, matriculas, FALUMNOS.claveal FROM FALUMNOS, alma WHERE alma.claveal=FALUMNOS.claveal";
if(strlen($tr_codasi[0])>1 and strlen($tr_codasi[1])>1){
$sqldatos.=" and (combasi like '%$tr_codasi[0]%' or combasi like '%$tr_codasi[1]%')";
	} 
	else{
$sqldatos.=" and combasi like '%$tr_codasi[0]%'";		
	}
$sqldatos.=" $text and unidad='".$tr_unidad."' ORDER BY nc, FALUMNOS.apellidos, FALUMNOS.nombre";
//echo $sqldatos;
$lista= mysql_query($sqldatos );
$num=0;
unset($data);
while($datatmp = mysql_fetch_array($lista)) { 
	if ($datatmp[2]>1) {
		$datatmp[0]=$datatmp[0]." (R)";
	}
	if(strstr($tr_unidad,"E-")==TRUE){
	$m_ex = "select exencion from matriculas where claveal = '$datatmp[3]'";
	$m_exen = mysql_query($m_ex);
	$m_exento = mysql_fetch_array($m_exen);
	if($m_exento[0]=="1"){
	$datatmp[0]=$datatmp[0]." (Ex)";
	}
	}
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
$txttit = "Lista del Grupo $tr_unidad $text2\n";
$txttit.= $nombre_del_centro.". Curso ".$curso_actual.".\n";
	
$pdf->ezText($txttit, 13,$options_center);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10,$options_right);
//echo "Cuenta = $cuenta; grupos = $n_uni;<br>";
if ($cuenta>1) {
	if ($n_uni==$cuenta) {
	}
	else{
	$pdf->ezNewPage();			
	}
		
}
}

if ($_POST['asignaturas']=='1'){
	$tr_uni = explode("-",$tr_unidad);	
	if (strlen($tr_uni[1])>1) {
		$text = " and (combasi like '%30562%' or combasi like '%31322%') ";
		$tr_unidad = substr($tr_unidad,0,-1);
		$text2 = "Diversificación";
	}	
$sqldatos="SELECT concat(alma.apellidos,', ',alma.nombre),combasi, NC, alma.unidad, matriculas, FALUMNOS.claveal FROM FALUMNOS, alma WHERE  alma.claveal = FALUMNOS.claveal";
if(strlen($tr_codasi[0])>1 and strlen($tr_codasi[1])>1){
$sqldatos.=" and (combasi like '%$tr_codasi[0]%' or combasi like '%$tr_codasi[1]%')";
	} 
	else{
$sqldatos.=" and combasi like '%$tr_codasi[0]%'";		
	}
$sqldatos.=" $text and unidad='".$tr_unidad."' ORDER BY nc, FALUMNOS.apellidos, FALUMNOS.nombre";

//echo $sqldatos;
$lista= mysql_query($sqldatos);
$num=0;
unset($data);
while($datatmp = mysql_fetch_array($lista)) { 
	if ($datatmp[4]>1) {
		$datatmp[0]=$datatmp[0]." (R)";
	}
	if(strstr($tr_unidad,"E-")==TRUE){
	$m_ex = "select exencion from matriculas where claveal = '$datatmp[5]'";
	$m_exen = mysql_query($m_ex);
	$m_exento = mysql_fetch_array($m_exen);
	if($m_exento[0]=="1"){
	$datatmp[0]=$datatmp[0]." (Ex)";
	}
	}
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
$txttit = "<b>Alumnos del grupo: $tr_unidad $text2</b>\n";
$txttit.= $nombre_del_centro.". Curso ".$curso_actual.".\n";	
$pdf->ezText($txttit, 12,$options_center);

$pdf->ezTable($data, $titles, '', $options);

if (strstr($tr_unidad,"1E")==TRUE or strstr($tr_unidad,"2E")==TRUE) {
	$pdf->ezText($libd12, 9,$options);
	$pdf->ezText("\n\n\n", 5);
}

if (strstr($tr_unidad,"3E")==TRUE) {
	$pdf->ezText($lc3, 9,$options);
	$pdf->ezText("\n\n\n", 5);
}

if (strstr($tr_unidad,"1B")==TRUE) {
	$pdf->ezText($lc1b, 9,$options);
	$pdf->ezText("\n\n\n", 5);
}
else{
	$pdf->ezText("\n\n\n", 10);
}

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 9,$options_right);
if ($cuenta>1) {
	if ($n_uni==$cuenta) {
	}
	else{
	$pdf->ezNewPage();			
	}
}
} 
}
$pdf->ezStream();
?>