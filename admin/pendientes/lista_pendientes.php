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
if ($_POST['pdf']==1) {
	require("../../pdf/fpdf.php");
	include_once ("../../pdf/funciones.inc.php");
	define('FPDF_FONTPATH','../../pdf/font/');
	# creamos la clase extendida de fpdf.php
	class GranPDF extends FPDF {

	}
	#abre la base de datos
	# creamos el nuevo objeto partiendo de la clase ampliada
	$MiPDF=new GranPDF('P','mm','A4');
	$MiPDF->SetMargins(20,20,20);
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
		$MiPDF->SetFont('Times','B',12);
		$MiPDF->Multicell(0,4,"Lista de alumnos con asignaturas pendientes",0,'J',0);
		$MiPDF->Ln(3);
		$MiPDF->SetFont('Times','B',14);
		$MiPDF->Multicell(0,4,"".$valor,0,'J',0);
		$MiPDF->Ln(3);
		$val_nivel=substr($valor,0,1);
		$sql = 'SELECT distinct alma.apellidos, alma.nombre, alma.unidad, asignaturas.nombre, asignaturas.abrev, alma.curso, FALUMNOS.nc
FROM pendientes, asignaturas, alma, FALUMNOS
WHERE asignaturas.codigo = pendientes.codigo
AND FALUMNOS.claveal=alma.claveal
AND alma.claveal = pendientes.claveal
AND unidad NOT LIKE  "%p-%"
AND asignaturas.nombre =  "'.$valor.'"
AND abrev LIKE  "%\_%"
ORDER BY alma.curso, unidad, nc';
		/*$sql = "SELECT alma.claveal, alma.apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso, nc
FROM alma,  pendientes , asignaturas, FALUMNOS
WHERE Unidad='$valor' and alma.claveal = pendientes.claveal and FALUMNOS.claveal = pendientes.claveal
AND asignaturas.codigo = pendientes.codigo and abrev like '%\_%' and asignaturas.curso like '$val_nivel%' ORDER BY Apellidos, Nombre";*/
			//echo $sql;
		$Recordset1 = mysql_query($sql) or die(mysql_error());  #crea la consulata

		$MiPDF->SetFont('Times','',11);
		$linea='';
		$x=0;
		$cuenta=1;
		$alumno='';
		while ($salida = mysql_fetch_array($Recordset1)){

			if ($salida[0]<>$alumno){
				$alumno=$salida[0];
				$MiPDF->SetFont('Times','',10);
				if ($linea!=''){$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);}
				#$MiPDF->Text(20,35+$x,$salida[1].', '.$salida[2]);$x=$x+5;
				$linea=$salida[2].' | '.$salida[6] .'. '.$salida[0].', '.$salida[1]." ";
			}

			if ($x>189){
				$x=0;
				$MiPDF->Addpage();
			}


		}#del while
		$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);



	}#del foreach de la seleccion

	$MiPDF->Output();
	mysql_free_result($Recordset1);
}
else{
	include "../../menu.php";
	echo '<br />
<div align=center>
<div class="page-header" align="center">
  <h2>Listas de Alumnos <small> Lista de Alumnos con asignaturas pendientes</small></h2>
</div>
</div>
<div class="container">
<div class="row-fluid"><div class="span6 offset3">';
	foreach($_POST["select"] as  $val) {
		$grupos.=$val.";";
	}
echo "<form action='lista_pendientes.php' method='post'>";	
echo "<input type='hidden' name='grupos' value='".$grupos."' />";
echo "<input type='hidden' name='pdf' value='1' />";
echo "<button class='btn btn-primary pull-right' name='submit10' type='submit' value='Crear PDF para imprimir'><i class='icon icon-print'> Crear PDF para imprimir</i></button>";
echo "</form><br />";	
foreach($_POST["select"] as  $valor) {	
echo '<legend class="text-info" align="center"><strong>'.$valor.'</strong></legend><hr />';	
echo "<table class='table table-striped' align='center'><thead><th>Grupo</th><th>NC</th><th>Alumno</th></thead><tbody>";
$pend = mysql_query("SELECT * from asignaturas where nombre='$valor' and abrev like '%\_%' and asignaturas.nombre in (select distinct materia from profesores) order by curso");
while ($pendi = mysql_fetch_array($pend)) {
		$val_nivel=substr($pendi[3],0,1);
	
	$sql = "SELECT distinct alma.claveal, alma.apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso, alma.unidad, FALUMNOS.nc
FROM alma,  pendientes , asignaturas, FALUMNOS
WHERE pendientes.codigo='".$pendi[0]."' and alma.claveal = pendientes.claveal and alma.claveal = FALUMNOS.claveal
AND asignaturas.codigo = pendientes.codigo and asignaturas.curso like '$val_nivel%' and alma.unidad like '$val_nivel%' ORDER BY alma.curso, Unidad, nc, alma.Apellidos, alma.Nombre";
		//echo $sql."<br>";
		$Recordset1 = mysql_query($sql) or die(mysql_error());  #crea la consulata;
		while ($salida = mysql_fetch_array($Recordset1)){
		
		echo "<tr><td>$salida[6]</td><td>$salida[7]</td><td nowrap><a href='http://$dominio/intranet/admin/informes/index.php?claveal=$salida[0]&todos=Ver Informe Completo del Alumno'>$salida[1], $salida[2]</a></td></tr>";
		}
}

		echo "</tbody></table>";
		echo "<hr />";	

	}
}

?>