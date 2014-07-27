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
		
		$sql = "SELECT alma.claveal, alma.apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso, nc
FROM alma,  pendientes , asignaturas, FALUMNOS
WHERE Unidad='$valor' and alma.claveal = pendientes.claveal and FALUMNOS.claveal = pendientes.claveal
AND asignaturas.codigo = pendientes.codigo and abrev like '%\_%' and asignaturas.curso like '$val_nivel%' ORDER BY Apellidos, Nombre";
		//	echo $sql;
		$Recordset1 = mysql_query($sql) or die(mysql_error());  #crea la consulata

		$MiPDF->SetFont('Times','',11);
		$linea='';
		$x=0;
		$cuenta=1;
		$alumno='';
		while ($salida = mysql_fetch_array($Recordset1)){
	$uni = mysql_query("select combasi from alma where claveal = '$salida[0]' and (combasi like '%25227%' or combasi like '%252276' or combasi like '%25205%' or combasi like '%25204%')");
	if (mysql_num_rows($uni)>0) {}
			else{
			if ($salida[0]<>$alumno){
				$alumno=$salida[0];
				$MiPDF->SetFont('Times','',10);
				if ($linea!=''){$MiPDF->ln(2);$MiPDF->Multicell(0,4,$linea,0,'J',0);}
				#$MiPDF->Text(20,35+$x,$salida[1].', '.$salida[2]);$x=$x+5;
				$linea=$salida[6] .'. '.$salida[1].', '.$salida[2].": ";
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
	echo '<br />
<div align=center>
<div class="page-header" align="center">
  <h2>Listas de Alumnos <small> Lista de Alumnos con asignaturas pendientes</small></h2>
</div>
</div>
<div class="container">
<div class="row"><div class="col-sm-8 col-sm-offset-2">';
	foreach($_POST["select1"] as  $val) {
		$grupos.=$val.";";
	}
echo "<form action='pendientes_unidad.php' method='post'>";	
echo "<input type='hidden' name='grupos' value='".$grupos."' />";
echo "<input type='hidden' name='pdf' value='1' />";
echo "<button class='btn btn-primary pull-right' name='submit10' type='submit' value='Crear PDF para imprimir'><i class='fa fa-print'> Crear PDF para imprimir</i></button>";
echo "</form><br />";	
	foreach($_POST["select1"] as  $valor) {
echo '<legend class="text-info" align="center"><strong>'.$valor.'</strong></legend><hr />';
		if (strstr($valor,"1")==TRUE) {
			   echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Parece que estás intentando ver la lista de asignaturas pendientes de los alumnos de 1º ESO o 1º BACHILLERATO, y eso no es posible.
</div></div><br />';
		}
		else{	
echo "<table class='table table-striped' align='center'><thead><th></th><th>Alumno</th><th>Pendientes</th></thead><tbody>";
$val_nivel=substr($valor,0,1);
$pend = mysql_query("select distinct pendientes.claveal, alma.apellidos, alma.nombre, nc from pendientes, alma, FALUMNOS where pendientes.claveal=alma.claveal and alma.claveal = FALUMNOS.claveal  and alma.unidad = '$valor' order by nc, apellidos, nombre");
$n1="";
while ($pendi = mysql_fetch_array($pend)) {
	$uni = mysql_query("select combasi from alma where claveal = '$pendi[0]' and (combasi like '%2522%' or combasi like '%25227%' or combasi like '%25205%' or combasi like '%25204%')");
	if (mysql_num_rows($uni)>0) {}
			else{
	echo "<tr><td>$pendi[3]</td><td nowrap><a href='http://$dominio/intranet/admin/informes/index.php?claveal=$pendi[0]&todos=Ver Informe Completo del Alumno'>$pendi[1], $pendi[2]</a></td><td>";
		$sql = "SELECT alma.claveal, apellidos, alma.nombre, alma.curso, abrev, asignaturas.curso
FROM alma,  pendientes , asignaturas
WHERE alma.claveal='".$pendi[0]."' and alma.claveal = pendientes.claveal
AND asignaturas.codigo = pendientes.codigo and abrev like '%\_%' and asignaturas.curso like '$val_nivel%' and alma.unidad not like '%P-%' ORDER BY Apellidos, Nombre";
			//echo $sql."<br>";
		$Recordset1 = mysql_query($sql) or die(mysql_error());  #crea la consulata;
		if (mysql_num_rows($Recordset1)>0) {
		while ($salida = mysql_fetch_array($Recordset1)){	
		//	echo "select combasi from alma where claveal = '$pendi[0]' and (combasi like '%25227%' or combasi like '%252276' or combasi like '%25205%' or combasi like '%25204%')";
						
			echo " $salida[4]|  ";
							
		}
		}
		else{
			echo "<em>Repetidor</em>";
		}
		echo "</td></tr>";
}
}
		echo "</tbody></table><p class='muted' align='center'><small>(*) Los alumnos de la lista sin asignaturas son los repetidores.</small></p>";
		echo "<hr />";			
		}

	}
}

?>