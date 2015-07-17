<?
require('../../bootstrap.php');


if ($_POST['pdf']==1) {
	require("../../pdf/fpdf.php");
	
	// Variables globales para el encabezado y pie de pagina
	$GLOBALS['CENTRO_NOMBRE'] = $nombre_del_centro;
	$GLOBALS['CENTRO_DIRECCION'] = $direccion_del_centro;
	$GLOBALS['CENTRO_CODPOSTAL'] = $codigo_postal_del_centro;
	$GLOBALS['CENTRO_LOCALIDAD'] = $localidad_del_centro;
	$GLOBALS['CENTRO_TELEFONO'] = $telefono_del_centro;
	$GLOBALS['CENTRO_FAX'] = $fax_del_centro;
	$GLOBALS['CENTRO_CORREO'] = $email_del_centro;
	
	if(substr($codigo_postal_del_centro,0,2)=="04") $GLOBALS['CENTRO_PROVINCIA'] = 'Almería';
	if(substr($codigo_postal_del_centro,0,2)=="11") $GLOBALS['CENTRO_PROVINCIA'] = 'Cádiz';
	if(substr($codigo_postal_del_centro,0,2)=="14") $GLOBALS['CENTRO_PROVINCIA'] = 'Córdoba';
	if(substr($codigo_postal_del_centro,0,2)=="18") $GLOBALS['CENTRO_PROVINCIA'] = 'Granada';
	if(substr($codigo_postal_del_centro,0,2)=="21") $GLOBALS['CENTRO_PROVINCIA'] = 'Huelva';
	if(substr($codigo_postal_del_centro,0,2)=="23") $GLOBALS['CENTRO_PROVINCIA'] = 'Jaén';
	if(substr($codigo_postal_del_centro,0,2)=="29") $GLOBALS['CENTRO_PROVINCIA'] = 'Málaga';
	if(substr($codigo_postal_del_centro,0,2)=="41") $GLOBALS['CENTRO_PROVINCIA'] = 'Sevilla';
	
	define('FPDF_FONTPATH','../../pdf/font/');
	# creamos la clase extendida de fpdf.php
	class GranPDF extends FPDF {
		function Header() {
			$this->SetTextColor(0, 122, 61);
			$this->Image( '../../img/encabezado.jpg',25,14,53,'','jpg');
			$this->SetFont('ErasDemiBT','B',10);
			$this->SetY(15);
			$this->Cell(75);
			$this->Cell(80,5,'CONSEJERÍA DE EDUCACIÓN, CULTURA Y DEPORTE',0,1);
			$this->SetFont('ErasMDBT','I',10);
			$this->Cell(75);
			$this->Cell(80,5,$GLOBALS['CENTRO_NOMBRE'],0,1);
			$this->SetTextColor(255, 255, 255);
		}
		function Footer() {
			$this->SetTextColor(0, 122, 61);
			$this->Image( '../../img/pie.jpg', 0, 245, 25, '', 'jpg' );
			$this->SetY(275);
			$this->SetFont('ErasMDBT','',8);
			$this->Cell(75);
			$this->Cell(80,4,$GLOBALS['CENTRO_DIRECCION'].'. '.$GLOBALS['CENTRO_CODPOSTAL'].', '.$GLOBALS['CENTRO_LOCALIDAD'].' ('.$GLOBALS['CENTRO_PROVINCIA'] .')',0,1);
			$this->Cell(75);
			$this->Cell(80,4,'Telf: '.$GLOBALS['CENTRO_TELEFONO'].'   Fax: '.$GLOBALS['CENTRO_FAX'],0,1);
			$this->Cell(75);
			$this->Cell(80,4,'Correo-e: '.$GLOBALS['CENTRO_CORREO'],0,1);
			$this->SetTextColor(255, 255, 255);
		}
	}
	#abre la base de datos
	# creamos el nuevo objeto partiendo de la clase ampliada
	$MiPDF=new GranPDF('P','mm','A4');
	$MiPDF->AddFont('NewsGotT','','NewsGotT.php');
	$MiPDF->AddFont('NewsGotT','B','NewsGotTb.php');
	$MiPDF->AddFont('ErasDemiBT','','ErasDemiBT.php');
	$MiPDF->AddFont('ErasDemiBT','B','ErasDemiBT.php');
	$MiPDF->AddFont('ErasMDBT','','ErasMDBT.php');
	$MiPDF->AddFont('ErasMDBT','I','ErasMDBT.php');
	$MiPDF->SetMargins(25,20,20);
	# ajustamos al 100% la visualización
	$MiPDF->SetDisplayMode('fullpage');
	#elige selección múltiple
	$grupos=substr($_POST['grupos'],0,-1);
	$tr_gr = explode(";",$grupos);
	//echo $grupos;
	foreach($tr_gr as  $valor) {
		$fila=1;
		$MiPDF->Addpage();
		$MiPDF->Ln(8);
		$MiPDF->SetFont('NewsGotT','B',12);
		$MiPDF->Multicell(0,4,"LISTA DE ALUMNOS CON ASIGNATURAS PENDIENTES",0,'J',0);
		$MiPDF->Ln(3);


			$asig = mysqli_query($db_con,"select distinct nombre, curso from asignaturas where codigo = '$valor' order by nombre");
	$asignatur = mysqli_fetch_row($asig);
	$asignatura = $asignatur[0];
	$curso = $asignatur[1];
		$tit = $asignatura.' ('.$curso.')';
		$MiPDF->SetFont('NewsGotT','B',12);
		$MiPDF->Multicell(0,4,"".$tit,0,'J',0);
		$MiPDF->Ln(3);
		
		$sql = 'SELECT distinct alma.apellidos, alma.nombre, alma.unidad, asignaturas.nombre, asignaturas.abrev, alma.curso, FALUMNOS.nc, pendientes.claveal, matriculas
FROM pendientes, asignaturas, alma, FALUMNOS
WHERE asignaturas.codigo = pendientes.codigo
AND FALUMNOS.claveal=alma.claveal
AND alma.claveal = pendientes.claveal
AND alma.unidad NOT LIKE  "%p-%"  
AND asignaturas.codigo =  "'.$valor.'" and alma.unidad not like "1%"
AND abrev LIKE  "%\_%"
ORDER BY alma.curso, alma.unidad, nc';
		
		$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  #crea la consulata

		$MiPDF->SetFont('NewsGotT','',12);
		$linea='';
		$x=0;
		$cuenta=1;
		$alumno='';
		while ($salida = mysqli_fetch_array($Recordset1)){
			$n1+=1;
//echo "$c_unidad => $c_curso<br>";
		if ($salida[8]>1) {
			$rep = "(Rep.)";
		}
		else{
			$rep='';
		}
				$alumno=$salida[0];
				$MiPDF->SetFont('NewsGotT','',12);
				if ($linea!=''){$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);}
				#$MiPDF->Text(20,35+$x,$salida[1].', '.$salida[2]);$x=$x+5;
				$linea=$salida[2].' | '.$salida[6] .'. '.$salida[0].', '.$salida[1].' '.$rep;
			

			if ($x>35){
				$x=0;
				$MiPDF->Addpage();
				$MiPDF->Ln(8);
			}		
		
		$x++;
		}#del while
		$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);



	}#del foreach de la seleccion

	$MiPDF->Output();
	mysqli_free_result($Recordset1);
}
else{
	include "../../menu.php";
	echo '<br />

<div class="page-header" align="center">
  <h2>Listas de Alumnos <small> Lista de Alumnos con asignaturas pendientes</small></h2>
</div>

<div class="container">
<div class="row">';
	foreach($_POST["select"] as  $val) {
		$grupos.=$val.";";
	}
echo "<form action='lista_pendientes.php' method='post'>";	
echo "<input type='hidden' name='grupos' value='".$grupos."' />";
echo "<input type='hidden' name='pdf' value='1' />";
echo "<button class='btn btn-primary pull-right' name='submit10' type='submit' value='Crear PDF para imprimir'><i class='fa fa-print'> Crear PDF para imprimir</i></button>";
echo "</form><br />";
echo '<div class="col-sm-6 col-sm-offset-3">';

foreach($_POST["select"] as  $valor) {
	$asig = mysqli_query($db_con,"select distinct nombre, curso from asignaturas where codigo = '$valor' order by nombre");
	$asignatur = mysqli_fetch_row($asig);
	$asignatura = $asignatur[0];
	$curso = $asignatur[1];
echo '<br><legend class="text-info" align="center"><strong>'.$asignatura.' ('.$curso.')</strong></legend><hr />';	
echo "<table class='table table-striped' align='center'><thead><th>Grupo</th><th>NC</th><th>Alumno</th><th>Asignatura</th></thead><tbody>";
//$pend = mysqli_query($db_con, "SELECT * from asignaturas where nombre='$valor' and abrev like '%\_%' and asignaturas.nombre in (select distinct materia from profesores) order by curso");
//while ($pendi = mysqli_fetch_array($pend)) {

	
	/*$sql = "SELECT distinct alma.claveal, alma.apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso, alma.unidad, FALUMNOS.nc, asignaturas.nombre
FROM alma,  pendientes , asignaturas, FALUMNOS
WHERE pendientes.codigo='".$pendi[0]."' and alma.claveal = pendientes.claveal and alma.claveal = FALUMNOS.claveal
AND asignaturas.codigo = pendientes.codigo and asignaturas.curso like '$val_nivel%' and alma.unidad like '$val_nivel%' and asignaturas.nombre not like 'Ámbito %'  ORDER BY alma.curso, unidad, nc, alma.Apellidos, alma.Nombre";*/
$sql = 'SELECT distinct alma.apellidos, alma.nombre, alma.unidad, asignaturas.nombre, asignaturas.abrev, alma.curso, FALUMNOS.nc,  pendientes.claveal, alma.matriculas
FROM pendientes, asignaturas, alma, FALUMNOS
WHERE asignaturas.codigo = pendientes.codigo
AND FALUMNOS.claveal=alma.claveal
AND alma.claveal = pendientes.claveal
AND alma.unidad NOT LIKE  "%p-%" 
AND asignaturas.codigo =  "'.$valor.'" and alma.unidad not like "1%"
AND abrev LIKE  "%\_%"
ORDER BY alma.curso, alma.unidad, nc';
		//echo $sql."<br><br>";
		$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  #crea la consulata;
		while ($salida = mysqli_fetch_array($Recordset1)){
		$val_nivel=substr($pendi[5],0,1);
		$c_unidad = substr($salida[2],0,1);
		$c_curso = substr($salida[4],-2,1);
		if ($salida[8]>1) {
			$rep = "(Rep.)";
		}
		else{
			$rep='';
		}
		$n1+=1;	
		echo "<tr><td>$salida[2]</td><td>$salida[6]</td><td nowrap><a href='//$dominio/intranet/admin/informes/index.php?claveal=$salida[7]&todos=Ver Informe Completo del Alumno'>$salida[0], $salida[1]</a> <span class='text-warning'>$rep</span></td><td>$salida[4] </td></tr>";

		}
//}

		echo "</tbody></table>";
		echo "<hr />";	

	}
}

?>
<?php include("../../pie.php"); ?>
</body>
</html>