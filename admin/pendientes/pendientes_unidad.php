<?php
require('../../bootstrap.php');


if ($_POST['pdf']==1) {
	require("../../pdf/fpdf.php");
	
	// Variables globales para el encabezado y pie de pagina
	$GLOBALS['CENTRO_NOMBRE'] = $config['centro_denominacion'];
	$GLOBALS['CENTRO_DIRECCION'] = $config['centro_direccion'];
	$GLOBALS['CENTRO_CODPOSTAL'] = $config['centro_codpostal'];
	$GLOBALS['CENTRO_LOCALIDAD'] = $config['centro_localidad'];
	$GLOBALS['CENTRO_TELEFONO'] = $config['centro_telefono'];
	$GLOBALS['CENTRO_FAX'] = $config['centro_fax'];
	$GLOBALS['CENTRO_CORREO'] = $config['centro_email'];
	$GLOBALS['CENTRO_PROVINCIA'] = $config['centro_provincia'];
	
	define('FPDF_FONTPATH','../../pdf/font/');
	# creamos la clase extendida de fpdf.php
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
		$MiPDF->SetFont('NewsGotT','B',14);
		$MiPDF->Multicell(0,4,"".$valor,0,'J',0);
		$MiPDF->Ln(3);

		
		$sql = "SELECT alma.claveal, alma.apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso, nc, matriculas
FROM alma,  pendientes , asignaturas, FALUMNOS
WHERE alma.unidad='$valor' and alma.claveal = pendientes.claveal and FALUMNOS.claveal = pendientes.claveal
AND asignaturas.codigo = pendientes.codigo and abrev like '%\_%' ORDER BY Apellidos, Nombre";
		//	echo $sql;
		$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  #crea la consulata

		$MiPDF->SetFont('NewsGotT','',12);
		$linea='';
		$x=0;
		$cuenta=1;
		$alumno='';
		while ($salida = mysqli_fetch_array($Recordset1)){
	$uni = mysqli_query($db_con, "select combasi from alma where claveal = '$salida[0]' and (combasi like '%25227%' or combasi like '%252276' or combasi like '%25205%' or combasi like '%25204%')");
	if (mysqli_num_rows($uni)>0) {}
			else{
			if ($salida[0]<>$alumno){
				$alumno=$salida[0];
				$MiPDF->SetFont('NewsGotT','',12);
				if ($linea!=''){$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);}
		if ($salida[7]>1) {
			$rep = " (Rep.)";
		}
		else{
			$rep='';
		}
		
				$linea=$salida[6] .'. '.$salida[1].', '.$salida[2].$rep.": ";
			}
			$linea.=' '.$salida[4]." | ";


			if ($x>189){
				$x=0;
				$MiPDF->Addpage();
			}


		}
		}#del while
		$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);


		
	}#del foreach de la seleccion

	$MiPDF->Output();
}
else{
	include "../../menu.php";
	
	foreach($_POST["select1"] as  $val) {
		$grupos.=$val.";";
	}
	
	echo '
<div class="container">

	<div class="page-header">
	  <h2 style="display: inline;">Listas de Alumnos <small> Lista de Alumnos con asignaturas pendientes</small></h2>';
	  echo "<form class=\"pull-right\" action='pendientes_unidad.php' method='post'>";	
	  echo "<input type='hidden' name='grupos' value='".$grupos."' />";
	  echo "<input type='hidden' name='pdf' value='1' />";
	  echo "<button class='btn btn-primary pull-right' name='submit10' type='submit' formtarget='_blank'><i class='fa fa-print fa-fw'></i> Imprimir</button>";
	  echo "</form>";
	echo '
	</div>

	<div class="row">
	<div class="col-sm-8 col-sm-offset-2">';
	
	foreach($_POST["select1"] as  $valor) {
echo '<legend class="text-info" align="center"><strong>'.$valor.'</strong></legend><hr />';
		if (strstr($valor,"1")==TRUE) {
			   echo '<div align="center"><div class="alert alert-warning alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Parece que estás intentando ver la lista de asignaturas pendientes de los alumnos de 1º ESO o 1º BACHILLERATO, y eso no es posible.
</div></div><br />';
		}
		else{	
echo "<table class='table table-striped' align='center'><thead><th></th><th>Alumno</th><th>Pendientes</th></thead><tbody>";
$val_nivel=substr($valor,0,1);
$pend = mysqli_query($db_con, "select distinct pendientes.claveal, alma.apellidos, alma.nombre, nc, matriculas from pendientes, alma, FALUMNOS where pendientes.claveal=alma.claveal and alma.claveal = FALUMNOS.claveal  and alma.unidad = '$valor' order by nc, apellidos, nombre");
$n1="";
while ($pendi = mysqli_fetch_array($pend)) {
	$uni = mysqli_query($db_con, "select combasi from alma where claveal = '$pendi[0]' and (combasi like '%2522%' or combasi like '%25227%' or combasi like '%25205%' or combasi like '%25204%')");
	if (mysqli_num_rows($uni)>0) {}
			else{
	if ($pendi[4]>1) {
			$rep = " (Rep.)";
		}
		else{
			$rep='';
		}
	echo "<tr><td>$pendi[3]</td><td nowrap><a href='//".$config['dominio']."/intranet/admin/informes/index.php?claveal=$pendi[0]&todos=Ver Informe Completo del Alumno'>$pendi[1], $pendi[2] </a><span class='text-warning'>$rep</span></td><td>";
		$sql = "SELECT alma.claveal, apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso
FROM alma,  pendientes , asignaturas
WHERE alma.claveal='".$pendi[0]."' and alma.claveal = pendientes.claveal
AND asignaturas.codigo = pendientes.codigo and abrev like '%\_%' and asignaturas.curso like '$val_nivel%' and alma.unidad not like '%P-%' ORDER BY Apellidos, Nombre";
			//echo $sql."<br>";
		$Recordset1 = mysqli_query($db_con, $sql) or die(mysqli_error($db_con));  #crea la consulata;
		if (mysqli_num_rows($Recordset1)>0) {
		while ($salida = mysqli_fetch_array($Recordset1)){	
		//	echo "select combasi from alma where claveal = '$pendi[0]' and (combasi like '%25227%' or combasi like '%252276' or combasi like '%25205%' or combasi like '%25204%')";
						
			echo " $salida[4]|  ";
							
		}
		}
		echo "</td></tr>";
}
}
		echo "</tbody></table>";		
		}

	}
}

?>
</div>
</div>
</div>

	<?php include("../../pie.php"); ?>
</body>
</html>
