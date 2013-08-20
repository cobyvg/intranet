<? 
include ("../../config.php"); 
if (isset($_POST['niv'])) {$niv = $_POST['niv'];}else{$niv="";}	
include_once ("../../funciones.php"); 
include("../../pdf/fpdf.php");
define('FPDF_FONTPATH','../../pdf/font/');
# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
function Header(){
$this->Image('../../img/encabezado.jpg',10,10,180,'','jpg');
}
function Footer(){
$this->Image('../../img/pie.jpg',0,240,130,'','jpg');
}
}
	# creamos el nuevo objeto partiendo de la clase ampliada
	$MiPDF=new GranPDF('P','mm',A4);
	$MiPDF->SetMargins(20,20,20);
	$MiPDF->SetDisplayMode('fullpage');

// Alumnos que deben reponer libros
$repo1 = "select distinct textos_alumnos.claveal from textos_alumnos, FALUMNOS where FALUMNOS.claveal = textos_alumnos.claveal and nivel = '$niv' and (estado = 'M' or estado = 'N') and devuelto = '1' order by nivel, grupo";
$repo0 = mysql_query($repo1);
while ($repo = mysql_fetch_array($repo0)) {
	$claveal = $repo[0];
// Datos del alumno	
	$sqlal="SELECT concat(Nombre,' ',Apellidos),Unidad,Domicilio,Localidad,codpostal,Tutor FROM alma, FTUTORES WHERE alma.nivel = FTUTORES.nivel and alma.grupo = FTUTORES.grupo and claveal='".$claveal."'";
	$resultadoal = mysql_query($sqlal);
	$registroal = mysql_fetch_row($resultadoal);
	$nivel = substr($registroal[1],0,2);

// Libros en mal estado o perdidos
$sqlasig="SELECT distinct asignaturas.nombre, textos_gratis.titulo, textos_gratis.editorial, importe from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre and (estado = 'M' or estado = 'N')  and textos_gratis.nivel='$nivel'";
$resulasig=mysql_query($sqlasig);
#recogida de variables.
$hoy=formatea_fecha(date('Y-m-d'));
$alumno=$registroal[0];
$unidad=$registroal[1];
$domicilio=$registroal[2];
$localidad=$registroal[3];
$codigo=$registroal[4];
$tutor="Tutor/a: ".$registroal[5];
$director_del_centro='Francisco Medina Infante';
$jefatura_de_estudios='Francisco Javier Márquez Garcia';
$secretario_del_centro='María Lourdes Barrutia Navarrete';
$direccion_del_centro='Dirección del Centro';
$fecha = date('d/m/Y');
$texto2=" Se debe reponer o en su caso abonar el importe indicado ";

$titulo2="NOTIFICACIÓN DE REPOSICIÓN DE LIBROS DE TEXTO";
$cuerpo21="D. $secretario_del_centro, como Secretario del centro $nombre_del_centro, y con el visto bueno de la Direccción, ";
$cuerpo22="CERTIFICA que el/la alumno/a: $alumno matriculado/a en el curso $unidad, revisados sus libros con fecha $fecha, debe ";
$cuerpo22.="reponer (o en su caso abonar el importe segun tarifa marcada por la Junta de Andalucía) los siguientes libros: ";
$importante2='En caso de no atender a este requerimiento el/la alumno/a no podrá disfrutar del programa de gratuidad el curso próximo.'; 

# insertamos la primera página del documento
$MiPDF->Addpage();
#### Cabecera con direcciÃ³n
$MiPDF->SetFont('Times','',11);
$MiPDF->SetTextColor(0,0,0);
$MiPDF->Text(96,55,$tutor);
$MiPDF->Text(120,60,$domicilio);
$MiPDF->Text(120,65,$codigo." (".$localidad.")");

	$total=0;
	$MiPDF->Ln(60);
	$MiPDF->SetFont('Times','B',12);
	$MiPDF->Multicell(0,4,$titulo2,0,'C',0);
	$MiPDF->SetFont('Times','',11);
	$MiPDF->Ln(4);
	$MiPDF->Multicell(0,4,$cuerpo21,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->Multicell(0,4,$cuerpo22,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->SetFont('Times','I',10);
	$MiPDF->Ln(2);
	while($regasig=mysql_fetch_row($resulasig)){
		$MiPDF->SetFont('Times','I',10);
		$MiPDF->SetX(170);
		$MiPDF->cell(0,4,$regasig[3].' Euros',0,'D',0);
	$MiPDF->SetX(20);
	$MiPDF->Multicell(150,4,'- '.$regasig[0].' --> Título: '.$regasig[1].' ('.$regasig[2].')',0,'I',0);
	
	$total=$total+$regasig[3];
	}#del while
	mysql_query("update textos_alumnos set devuelto = '1', fecha = now() where claveal = '$claveal'");		
		$MiPDF->SetFont('Times','BI',10);
		$MiPDF->SetX(158);
	$MiPDF->Multicell(0,4,' Total: '.$total.' Euros',0,'D',0);
		$MiPDF->SetFont('Times','',11);
	$MiPDF->Ln(5);
	$MiPDF->Multicell(0,4,'En '.$localidad_del_centro.', a '.$hoy,0,'C',0);
	$MiPDF->Ln(5);
	$MiPDF->Multicell(0,4,'Secretario/a:                        Sello del Centro                         Director/a:',0,'C',0);
	$MiPDF->Ln(14);
	$MiPDF->Multicell(0,4,$secretario_del_centro.'                                             '.$director_del_centro,0,'C',0);
	$MiPDF->Ln(4);
	$MiPDF->Multicell(0,4,$importante2,0,'J',0);
	
}

$MiPDF->Output();
			
?>

