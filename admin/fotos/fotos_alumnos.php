<?php
ini_set("memory_limit","1024M");

session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);

// VARIABLES DEL FORMULARIO
$curso = explode('-',$_POST['curso']);
$nivel = $curso[0];
$grupo = $curso[1];

require('../../pdf/mc_table.php');

$pdf = new PDF_MC_Table();
$pdf->Open();
$pdf->SetMargins(20,10,20);
$pdf->SetDisplayMode('fullpage');

// Cargamos las fuentes corporativas
$pdf->AddFont('NewsGotT','','NewsGotT.php');
$pdf->AddFont('NewsGotT','B','NewsGotTb.php');

// En el caso de haber seleccionado una unidad, se muestra el listado de alumnos de dicha unidad,
// en otro caso mostramos el listado de faltas de todas las unidades.
$query = "SELECT DISTINCT NIVEL, GRUPO FROM FALUMNOS";
if ($nivel && $grupo) $query .= " WHERE NIVEL='$nivel' AND GRUPO='$grupo'";


$unidades = mysql_query($query);

while ($unidad = mysql_fetch_array($unidades)) {
	
	$nivel = $unidad[0];
	$grupo = $unidad[1];

	$pdf->AddPage('P','A4');
	
	// CABECERA DEL DOCUMENTO
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->Cell(170,5,"FOTOS DE ALUMNOS DEL GRUPO $nivel-$grupo",0,1,'C');
	
	$pdf->Ln(5);
	
	// Consultamos los alumnos del grupo seleccionado
	$result = mysql_query("SELECT claveal, apellidos, nombre FROM FALUMNOS WHERE NIVEL='$nivel' AND GRUPO='$grupo'");
	
	$i=1;
	$x_texto1=36;
	$y_texto1=47;
	$x_image=29;
	$y_image=21;
	while ($alumno = mysql_fetch_object($result)) {
		if($i%5==0) $ln=1; else $ln=0;
		
		//$pdf->Cell(34,33,'',1,$ln,'C'); // Dibuja una cuadrícula
		
		$foto = "../../xml/fotos/$alumno->claveal.jpg";
		if (file_exists($foto)) {
			$pdf->Image($foto,$x_image,$y_image,17,23,'JPG');
		}
		$pdf->SetFont('NewsGotT','B',8);
		$pdf->Text($x_texto1-strlen($alumno->apellidos)/2,$y_texto1,$alumno->apellidos);
		$pdf->SetFont('NewsGotT','',8);
		$pdf->Text($x_texto1-strlen($alumno->nombre)/2,$y_texto1+3,$alumno->nombre);
		
		// Texto
		$x_texto1+=34;
		if($ln) { $x_texto1=36; $y_texto1+=33; }
		
		// Imagen
		$x_image+=34;
		if($ln) { $x_image=29; $y_image+=33; }
		
		$i++;
	}
	
	mysql_free_result($result);
		
}

$pdf->Output('Fotos de alumnos.pdf','I');
?>