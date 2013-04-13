<?
if($impreso){
	include("../../config.php");
	$j=0;
	foreach ($_POST as $ide => $valor) {
		if(($ide<>'impreso') and (!empty( $valor))){
			include ("../../pdf/fpdf.php");
			define ( 'FPDF_FONTPATH', '../../pdf/fontsPDF/' );
			# creamos la clase extendida de fpdf.php
			class GranPDF extends FPDF {
				function Header() {
					$this->Image ( '../../imag/encabezado.jpg', 10, 10, 180, '', 'jpg' );
				}
				function Footer() {
					$this->Image ( '../../imag/pie.jpg', 0, 240, 130, '', 'jpg' );
				}
			}
			$MiPDF = new GranPDF ( 'P', 'mm', 'a4' );

			# creamos el nuevo objeto partiendo de la clase ampliada
			$MiPDF->SetMargins ( 20, 20, 20 );
			# ajustamos al 100% la visualizaciÃƒÂ³n
			$MiPDF->SetDisplayMode ( 'fullpage' );
			$hoy= date ('d-m-Y',time());
			$tutor="Jefatura de Estudios";
			$titulo1 = "COMUNICACIÓN DE AMONESTACIÓN ESCRITA";

			for($i=0; $i <= count($valor)-1; $i++){ 
			$j+=1; //echo $valor[$i];
			$al=mysql_query ("select apellidos,nombre,curso from morosos where id=$valor[$i]") or die ("error al localizar alumno");
			while($alu=mysql_fetch_array($al)){
					
				$nombre=$alu[1];
				$apellido=$alu[0];
				$curso=$alu[2];
				// echo $nombre.'-'.$apellido;



				// aquÃ­ generamos el pdf con todas las amonestaciones
				$nombre=$nombre;
				$apellido=$apellido;
					
				$cuerpo1 = "Muy Señor/Sra. mío/a:

Pongo en su conocimiento que con  fecha $hoy su hijo/a $nombre $apellido alumno del grupo $curso ha sido amonestado/a por \"Retraso injustificado en la devolución de material a la Biblioteca del Centro\"";
				$cuerpo2 = "Asimismo, le comunico que, según contempla el Plan de Convivencia del Centro, regulado por el Decreto 327/2010 de 13 de Julio por el que se aprueba el Reglamento Orgánico de los Institutos de Educación Secundaria, de reincidir su hijo/a en este tipo de conductas contrarias a las normas de convivencia del Centro podría imponérsele otra medida de corrección que podría llegar a ser la suspensión del derecho de asistencia al Centro.";
				$cuerpo3 = "----------------------------------------------------------------------------------------------------------------------------------------------

En Estepona, a _________________________________
Firmado: El Padre/Madre/Representante legal:



D./Dña _____________________________________________________________________
D.N.I ___________________________";
				$cuerpo4 = "
----------------------------------------------------------------------------------------------------------------------------------------------

COMUNICACIÓN DE AMONESTACIÓN ESCRITA

	El alumno/a $nombre $apellido del grupo $curso, ha sido amonestado/a con fecha $hoy con falta grave, recibiendo la notificación mediante comunicación escrita de la misma para entregarla al padre/madre/representante legal.

                                           Firma del alumno/a:
	
";

				# insertamos la primera pagina del documento
				$MiPDF->Addpage ();
				#### Cabecera con direcciÃ³n
				$MiPDF->SetFont ( 'Times', '', 10 );
				$MiPDF->SetTextColor ( 0, 0, 0 );
				$MiPDF->SetTextColor ( 0, 0, 0 );
				$MiPDF->Text ( 128, 35, $nombre_del_centro );
				$MiPDF->Text ( 128, 39, $direccion_del_centro );
				$MiPDF->Text ( 128, 43, $codigo_postal_del_centro . " (" . $localidad_del_centro . ")" );
				$MiPDF->Text ( 128, 47, "Tlfno. " . $telefono_del_centro );
				#Cuerpo.
				$MiPDF->Ln ( 45 );
				$MiPDF->SetFont ( 'Times', 'B', 11 );
				$MiPDF->Multicell ( 0, 4, $titulo1, 0, 'C', 0 );
				$MiPDF->SetFont ( 'Times', '', 10 );
				$MiPDF->Ln ( 4 );
				$MiPDF->Multicell ( 0, 4, $cuerpo1, 0, 'J', 0 );
				$MiPDF->Ln ( 3 );
				$MiPDF->Multicell ( 0, 4, $cuerpo2, 0, 'J', 0 );
				$MiPDF->Ln ( 6 );
				$MiPDF->Multicell ( 0, 4, 'En ' . $localidad_del_centro . ', a ' . $hoy, 0, 'C', 0 );
				$MiPDF->Ln ( 20 );
				$MiPDF->Multicell ( 0, 4, $tutor, 0, 'C', 0 );
				$MiPDF->Ln ( 5 );
				$MiPDF->Multicell ( 0, 4, $cuerpo3, 0, 'J', 0 );
				$MiPDF->Ln ( 5 );
				$MiPDF->Multicell ( 0, 4, $cuerpo4, 0, 'J', 0 );
			}
			}
			$MiPDF->Output ();
	 }
	}
}

?>
