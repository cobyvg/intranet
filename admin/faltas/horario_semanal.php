<?php
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
$nivel = $_POST['nivel'];
$grupo = $_POST['grupo'];

require('../../pdf/mc_table.php');

$pdf = new PDF_MC_Table();
$pdf->Open();
$pdf->SetMargins(11,10,11);
$pdf->SetDisplayMode('fullpage');

// En el caso de haber seleccionado una unidad, se muestra el listado de alumnos de dicha unidad,
// en otro caso mostramos el listado de faltas de todas las unidades.
if ($nivel && $grupo) {

	$unidad = $nivel.'-'.$grupo; // Unimos el nivel y el grupo
	
	$pdf->AddPage('L','A4');
	
	// Cargamos las fuentes corporativas
	$pdf->AddFont('NewsGotT','','NewsGotT.php');
	$pdf->AddFont('NewsGotT','B','NewsGotTb.php');
	
	// CABECERA DEL DOCUMENTO
	
	// Obtenemos la fecha inicial y final de la semana en curso
	list($anio, $mes, $dia, $semana, $sdia) = explode(':', date('Y:m:d:W:w'));
	$inicio = strtotime("$anio-$mes-$dia 12:00am");
	$inicio += (1 - $sdia) * 86400;
	$fin = $inicio + (6 * 86400);
	$inicio = date('d-m-Y', $inicio);
	$fin = date('d-m-Y', $fin);
	
	// Consultamos el tutor del grupo
	$result = mysql_query("SELECT TUTOR FROM FTUTORES WHERE NIVEL='$nivel' AND GRUPO='$grupo'");
	$tutor = mysql_fetch_array($result);
	mysql_free_result($result);
	
	// Impresión de la cabecera
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->Cell(96,5,'PARTE DE FALTAS DEL GRUPO '.$unidad,0,0,'L');
	$pdf->Cell(81,5,'SEMANA: '.$inicio.' - '.$fin,0,0,'C');
	$pdf->Cell(96,5,'TUTOR/A: '.$tutor[0],0,1,'R');
	$pdf->Ln(3);
	
	
	// PRIMERA FILA
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->SetWidths(array(63,42,42,42,42,42));
	$pdf->SetAligns(array('L','C','C','C','C','C'));
	$pdf->Row(array('','LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'));
	
	// SEGUNDA FILA
	$pdf->SetWidths(array(8,55,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7));
	$pdf->SetAligns(array('C','L','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C'));
	$pdf->Row(array('#','Alumno/a','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6'));
	
	// RESTO DE LA TABLA
	$pdf->SetFont('NewsGotT','',10);
	$pdf->SetFillColor(239,240,239);	// Color de sombreado
	
	// Consultamos los alumnos del grupo seleccionado
	$result = mysql_query("SELECT nc, CONCAT(apellidos,', ',nombre) AS alumno FROM FALUMNOS WHERE grupo='$grupo' AND nivel='$nivel' ORDER BY nc ASC");
	
	$i=0;
	while ($alumno = mysql_fetch_array($result)) {
		if ($i%2==0) $somb='DF'; else $somb='';
		$pdf->Row(array($alumno['nc'],$alumno['alumno'],'','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),$somb);
		$i++;
	}
	
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->SetWidths(array(63,42,42,42,42,42));
	$pdf->SetAligns(array('L','C','C','C','C','C'));
	$pdf->Row(array("OBSERVACIONES:\n\n\n\n\n\n\n",'','','','',''));
	
	
	// FIN DE LA PÁGINA
	$pdf->Ln(3);
	$pdf->SetFont('NewsGotT','B',10);
	$pdf->Cell(273,5,"A - Ir al Aseo. B - Ir a beber agua. F - Falta de Asistencia. R - Retraso injustificado. J - Viene de Jefatura.",0,0,'C');
	
	mysql_free_result($result);
	
	$pdf->Output('Parte de faltas '.$unidad.' Semana '.$inicio.'.pdf','I');
}
else {
	// Consultamos las distintas unidades del Centro
	$unidades = mysql_query("SELECT DISTINCT NIVEL, GRUPO FROM FALUMNOS");
	
	while ($unidad = mysql_fetch_array($unidades)) {
		
		$nivel = $unidad[0];
		$grupo = $unidad[1];
	
		$pdf->AddPage('L','A4');
		
		// Cargamos las fuentes corporativas
		$pdf->AddFont('NewsGotT','','NewsGotT.php');
		$pdf->AddFont('NewsGotT','B','NewsGotTb.php');
		
		// CABECERA DEL DOCUMENTO
		
		// Obtenemos la fecha inicial y final de la semana en curso
		list($anio, $mes, $dia, $semana, $sdia) = explode(':', date('Y:m:d:W:w'));
		$inicio = strtotime("$anio-$mes-$dia 12:00am");
		$inicio += (1 - $sdia) * 86400;
		$fin = $inicio + (6 * 86400);
		$inicio = date('d-m-Y', $inicio);
		$fin = date('d-m-Y', $fin);
		
		// Consultamos el tutor del grupo
		$result = mysql_query("SELECT TUTOR FROM FTUTORES WHERE NIVEL='$nivel' AND GRUPO='$grupo'");
		$tutor = mysql_fetch_array($result);
		mysql_free_result($result);
		
		// Impresión de la cabecera
		$pdf->SetFont('NewsGotT','B',10);
		$pdf->Cell(96,5,"PARTE DE FALTAS DEL GRUPO $nivel-$grupo",0,0,'L');
		$pdf->Cell(81,5,"SEMANA: $inicio - $fin",0,0,'C');
		$pdf->Cell(96,5,"TUTOR/A: $tutor[0]",0,1,'R');
		$pdf->Ln(3);
		
		
		// PRIMERA FILA
		$pdf->SetFont('NewsGotT','B',10);
		$pdf->SetWidths(array(63,42,42,42,42,42));
		$pdf->SetAligns(array('L','C','C','C','C','C'));
		$pdf->Row(array('','LUNES','MARTES','MIERCOLES','JUEVES','VIERNES'));
		
		// SEGUNDA FILA
		$pdf->SetWidths(array(8,55,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7));
		$pdf->SetAligns(array('C','L','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C','C'));
		$pdf->Row(array('#','Alumno/a','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6','1','2','3','4','5','6'));
		
		// RESTO DE LA TABLA
		$pdf->SetFont('NewsGotT','',10);
		$pdf->SetFillColor(239,240,239);	// Color de sombreado
		
		// Consultamos los alumnos del grupo seleccionado
		$result = mysql_query("SELECT nc, CONCAT(apellidos,', ',nombre) AS alumno FROM FALUMNOS WHERE grupo='$grupo' AND nivel='$nivel' ORDER BY nc ASC");
		
		$i=0;
		while ($alumno = mysql_fetch_array($result)) {
			if ($i%2==0) $somb='DF'; else $somb='';
			$pdf->Row(array($alumno['nc'],$alumno['alumno'],'','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),$somb);
			$i++;
		}
		
		$pdf->SetFont('NewsGotT','B',10);
		$pdf->SetWidths(array(63,42,42,42,42,42));
		$pdf->SetAligns(array('L','C','C','C','C','C'));
		$pdf->Row(array("OBSERVACIONES:\n\n\n\n\n\n\n",'','','','',''));
		
		
		// FIN DE LA PÁGINA
		$pdf->Ln(3);
		$pdf->SetFont('NewsGotT','B',10);
		$pdf->Cell(273,5,"A - Ir al Aseo. B - Ir a beber agua. F - Falta de Asistencia. R - Retraso injustificado. J - Viene de Jefatura.",0,0,'C');
		
		mysql_free_result($result);
		
	}
	$pdf->Output('Parte de faltas completo semana '.$inicio.'.pdf','I');
}
?>