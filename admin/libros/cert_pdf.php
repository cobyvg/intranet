<? 
include_once ("../../funciones.php");
include("../../pdf/fpdf.php");
define('FPDF_FONTPATH','../../pdf/fontsPDF/');
# creamos la clase extendida de fpdf.php 
class GranPDF extends FPDF {
function Header(){
$this->Image('../../imag/encabezado.jpg',10,10,180,'','jpg');
}
function Footer(){
$this->Image('../../imag/pie.jpg',0,240,130,'','jpg');
}
}

			# creamos el nuevo objeto partiendo de la clase ampliada
			$MiPDF=new GranPDF('P','mm',A4);
			$MiPDF->SetMargins(20,20,20);
			# ajustamos al 100% la visualizaciÃ³n
			$MiPDF->SetDisplayMode('fullpage');

	$sqlal="SELECT concat(Nombre,' ',Apellidos),Unidad,Domicilio,Localidad,codpostal,Tutor FROM alma, FTUTORES WHERE alma.nivel = FTUTORES.nivel and alma.grupo = FTUTORES.grupo and claveal='".$claveal."'";
	$resultadoal=mysql_query($sqlal);
	$registroal = mysql_fetch_row($resultadoal);
	// $nivel = substr($registroal[1],0,2);
// Alumnos no registrados en la tabla
$sqlasig0="SELECT distinct asignaturas.nombre, textos_gratis.titulo, textos_gratis.editorial, importe from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre and textos_gratis.nivel='$nivel'";
//echo $sqlasig0;
$resulasig0=mysql_query($sqlasig0);

if (mysql_num_rows($resulasig0) == "0") {
echo "<p style='border:1px solid black;padding:6px;width:450px;margin:auto;text-align:center;margin-top:35px;font-size:13px;color:brown;margin-bottom:18px;'>El Tutor no ha revisado aún los Libros de este Alumno, por lo que no puede imprimirse certificado alguno.<br>Los Libros deben ser revisados y registrados en primer lugar.</p>";
echo "<div align=center><input type=button value='Volver atrás' onClick='history.back(-1)'></div>";
exit;
}
// Libros en mal estado o perdidos
$sqlasig="SELECT distinct asignaturas.nombre, textos_gratis.titulo, textos_gratis.editorial, importe from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre and textos_gratis.nivel='$nivel' and (estado='M' or estado='N' or estado = 'S')";
$resulasig=mysql_query($sqlasig);
if (mysql_num_rows($resulasig) > "0") {
	$mal = "1";
}
//Libros en buen estado
	$sqlasig2="SELECT distinct asignaturas.nombre, estado from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre and textos_gratis.nivel='$nivel'";
	$resulasig2=mysql_query($sqlasig2);	
// Libros pendientes de Septiembre
	$sqlasig3="SELECT distinct asignaturas.nombre, estado from textos_alumnos, textos_gratis, asignaturas where textos_alumnos.claveal='$claveal' and asignaturas.codigo = textos_alumnos.materia and textos_gratis.materia=asignaturas.nombre and textos_gratis.nivel='$nivel' and estado='S'";
	$resulasig3=mysql_query($sqlasig3);
if (mysql_num_rows($resulasig3) > "0") {
echo "<p style='border:1px solid black;padding:6px;width:450px;margin:auto;text-align:center;margin-top:35px;font-size:13px;color:brown;margin-bottom:18px;'>No es posible imprimir el certificado de entrega de Libros cuando alguno de estos est&aacute marcado como pendiente hasta Septiembre.<br>Vuelve atrás y corrige los datos si están equivocados.</p>";
echo "<div align=center><input type=button value='Volver atrás' onClick='history.back(-1)'></div>";
exit;
}

#recogida de variables.
$hoy=formatea_fecha(date('Y-m-d'));
$alumno=$registroal[0];
$unidad=$registroal[1];
$domicilio=$registroal[2];
$localidad=$registroal[3];
$codigo=$registroal[4];
$tutor="Tutor/a: ".$registroal[5];
$fecha = date('d/m/Y');
$texto1=" Justificante de que el alumno ha entegado los libros de texto";
$texto2=" Se debe reponer o en su caso abonar el importe indicado ";

$titulo1="CERTIFICACIÓN DE ENTREGA DE LIBROS";
$cuerpo11="D. $secretario_del_centro, como Secretario del centro $nombre_del_centro, y con el visto bueno de la Direccción, ";
$cuerpo12="CERTIFICO que el/la alumno/a: $alumno matriculado/a en el curso $unidad, con fecha $fecha ha hecho entrega de los libros que se le asignaron con cargo al Programa de Gratuidad de Libros de Texto, en el estado de conservación que se indica: ";
$importante1='Importante: los libros prestados para Septiembre deben ser devueltos el día de la Convocatoria Extraordinaria ';
$importante1.='en buen estado.';
$titulo2="NOTIFICACIÓN DE REPOSICION DE LIBROS DE TEXTO";
$cuerpo21="D. $secretario_del_centro, como Secretario del centro $nombre_del_centro, y con el visto bueno de la Direccción, ";
$cuerpo22="CERTIFICA que el/la alumno/a: $alumno matriculado/a en el curso $unidad, revisados sus libros con fecha $fecha, debe ";
$cuerpo22.="reponer (o en su caso abonar el importe segun tarifa marcada por la Junta de Andalucía) los siguientes libros: ";
$importante2='En caso de no atender a este requerimiento el/la alumno/a no podrá disfrutar del programa de gratuidad el curso próximo.'; 
##########################################
# insertamos la primera pÃ¡gina del documento
$MiPDF->Addpage();
#### Cabecera con dirección
$MiPDF->SetFont('Times','',11);
$MiPDF->SetTextColor(0,0,0);
$MiPDF->Text(96,55,$tutor);
$MiPDF->Text(120,60,$domicilio);
$MiPDF->Text(120,65,$codigo." (".$localidad.")");
###

if (!($mal=='1')){
	#Cuerpo de la devolución.
	$MiPDF->Ln(60);
	$MiPDF->SetFont('Times','B',12);
	$MiPDF->Multicell(0,4,$titulo1,0,'C',0);
	$MiPDF->SetFont('Times','',11);
	$MiPDF->Ln(4);
	$MiPDF->Multicell(0,4,$cuerpo11,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->Multicell(0,4,$cuerpo12,0,'J',0);
	$MiPDF->Ln(3);
	$MiPDF->SetFont('Times','I',11);
	$MiPDF->SetX(50);
	$nota=0;
	while($regasig2=mysql_fetch_row($resulasig2)){
		$MiPDF->SetX(50);
		if ($regasig2[1]=='B') {$est=' en buen estado';}
		if ($regasig2[1]=='R') {$est=' en un estado pasable';}		
		if ($regasig2[1]=='S') {$est=' prestado para septiembre';$nota=1;}
	$MiPDF->Multicell(0,4,'- '.$regasig2[0].$est,0,'I',0);
	}#del while
	mysql_query("update textos_alumnos set devuelto = '1', fecha = now() where claveal = '$claveal'");		
	$MiPDF->SetX(20);
		$MiPDF->SetFont('Times','',11);
	$MiPDF->Ln(6);
	$MiPDF->Multicell(0,4,'En '.$localidad_del_centro.', a '.$hoy,0,'C',0);
	$MiPDF->Ln(6);
	$MiPDF->Multicell(0,4,'Secretario/a:                        Sello del Centro                         Director/a:',0,'C',0);
	$MiPDF->Ln(16);
	$MiPDF->Multicell(0,4,$secretario_del_centro.'                                             '.$director_del_centro,0,'C',0);
	$MiPDF->Ln(10);
	if ($nota==1) {$MiPDF->Multicell(0,4,$importante1,0,'J',0);
	}
	
}else{
	#Cuerpo de la reclamaciÃ³n de reposiciÃ³n
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
	

#	$MiPDF->Multicell(0,4,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -',0,'C',0);
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

