<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);



if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

	if ($_GET['depurar']==1) {
		include_once '../../menu.php';
		echo '<br />
<div class="page-header">
<h2>Administración. <small> Preparación de la Importación del Horario a Séneca</small></h2>
</div>
<br />
<div class="container">

<div class="row">

<div class="span6 offset3">';
				echo "<legend align='center'>Errores y Advertencias sobre el Horario.</legend>";
		
		echo  "<div align'center><div class='alert alert-error alert-block fade in'><br />
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
El archivo generado por Horwin ha sido procesado y se ha creado una copia modificada preparada para subir a Séneca. 
<br>Los mesajes que aparecen más abajo indican los cambios realizados y las advertencias sobre problemas que podrías encontrar al importar los datos a Séneca.
</div></div>";		
	}
	$doc = new DOMDocument('1.0', 'utf-8');
	
	$doc->load( "horario_xml2.xml" ) or die("No se ha podido leer el archivo para ser procesado.");

	mysql_query("truncate table horw_prueba");
	
	$profes = $doc->getElementsByTagName( "grupo_datos");
?>
<table class="table">

<?
$num_prof = 0;
	foreach ($profes as $materia) {
		//$texto="";
		$codigos = $materia->getElementsByTagName( "dato" );

		$N_DIASEMANA=$codigos->item(0)->nodeValue;
		if (strlen($N_DIASEMANA)>4) {
		$COD_PROF = $N_DIASEMANA;
		$num_prof+=1;
		}
		elseif (strlen($N_DIASEMANA)==1){
		$DIASEMANA = $N_DIASEMANA;	
		}
		
		if (strlen($codigos->item(1)->nodeValue)<9 and strlen($codigos->item(1)->nodeValue)>0) {
		$X_TRAMO=$codigos->item(1)->nodeValue;
		}
		else{
			$X_TRAMO="";
		}
		$X_DEPENDENCIA=$codigos->item(2)->nodeValue;
		$X_UNIDAD=$codigos->item(3)->nodeValue;
		$X_OFERTAMATRIG=$codigos->item(4)->nodeValue;
		if ($codigos->item(5)->nodeValue =="") {
			$X_MATERIAOMG="";
		}else{
		$X_MATERIAOMG=$codigos->item(5)->nodeValue;	
		}
		$F_INICIO=$codigos->item(6)->nodeValue;
		$F_FIN=$codigos->item(7)->nodeValue;
		$N_HORINI=$codigos->item(8)->nodeValue;
		$N_HORFIN=$codigos->item(9)->nodeValue;
		$X_ACTIVIDAD=$codigos->item(10)->nodeValue;
		
		if (strlen($codigos->item(1)->nodeValue)<9 and strlen($codigos->item(1)->nodeValue)>0) {
		$n_i+=1;
	//	echo "<tr><td>$n_i</td><td>$COD_PROF</td><td>$DIASEMANA</td><td>$X_TRAMO</td><td>$X_DEPENDENCIA</td><td>$X_UNIDAD</td><td>$X_OFERTAMATRIG</td><td>$X_MATERIAOMG</td><td>$F_INICIO</td><td>$F_FIN</td><td>$N_HORINI</td><td>$N_HORFIN</td><td>$X_ACTIVIDAD</td></tr>";
		
		$tramos = mysql_query("select hora from tramos where tramo = '$X_TRAMO'");
		$tramo = mysql_fetch_row($tramos);
		$nom_asig = mysql_query("select abrev, nombre from asignaturas where codigo = '$X_MATERIAOMG' and abrev not like '%\_%'");
		$nom_asigna = mysql_fetch_row($nom_asig);
		$nom_prof = mysql_query("select concat(ape1profesor,' ',ape2profesor,', ',nomprofesor) from profesores_seneca where idprofesor = '$COD_PROF'");
		$nom_profe = mysql_fetch_row($nom_prof);
		$unid = mysql_query("select nomunidad from unidades where idunidad = '$X_UNIDAD'");
		$unidad = mysql_fetch_row($unid);
		$sql = "INSERT INTO `horw_prueba` VALUES('$n_i', '$DIASEMANA', '$tramo[0]', '$nom_asigna[0]', '$nom_asigna[1]', '$X_MATERIAOMG', '$nom_profe[0]', '$num_prof', '$COD_PROF', '$X_DEPENDENCIA', '$X_DEPENDENCIA', '$unidad[0]', '', '', '')";
		mysql_query($sql);
		echo "$sql<br>";
		}
		
	}
?>
</table>
<?
	if ($_GET['depurar']==1) {
		echo "<hr /><legend align='center'>Texto del archivo XML resultante</legend>";
	}

	

?>