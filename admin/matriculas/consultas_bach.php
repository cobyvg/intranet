<?
ini_set("session.cookie_lifetime",1800);
ini_set("session.gc_maxlifetime",1800);
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'7') == TRUE or stristr($_SESSION['cargo'],'8') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
//include("../../funciones.php");
//variables();
if ($listados=="Listado en PDF") {
	include("listados_bach.php");
	exit();
}

if ($listado_total=="Listado PDF total") {
	include("listado_total_bach.php");
	exit();
}

if ($imprimir=="Imprimir") {
	mysql_query("drop table if exists matriculas_bach_temp");
	mysql_query("CREATE TABLE  `matriculas_bach_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
		//echo "$key => $val<br>";
		$tr = explode("-",$key);
		$id_submit = $tr[1];
		$col = $tr[0];
		if (is_numeric($id_submit)) {
			mysql_query("insert into matriculas_bach_temp VALUES ('$id_submit')");
		}
	}
	include("imprimir_bach.php");
	exit();
}

//echo $_POST['imprimir_caratulas'];
if ($caratulas == "Imprimir Carátulas") {
	mysql_query("drop table if exists matriculas_bach_temp");
	mysql_query("CREATE TABLE  `matriculas_bach_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
		$tr = explode("-",$key);
		$id_submit = $tr[1];
		$col = $tr[0];
		if (is_numeric($id_submit)) {

			mysql_query("insert into matriculas_bach_temp VALUES ('$id_submit')");
		}
	}
	include("caratulas_bach.php");
	exit();
}

if ($cambios=="Ver cambios en datos") {
	include("../../menu.php");
	include("menu.php");
	mysql_query("drop table if exists matriculas_bach_temp");
	mysql_query("CREATE TABLE  `matriculas_bach_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
		$tr = explode("-",$key);
		$id_submit = $tr[1];
		$col = $tr[0];
		if (is_numeric($id_submit)) {
			mysql_query("insert into matriculas_bach_temp VALUES ('$id_submit')");
		}
	}

	$camb = mysql_query("select distinct id_matriculas from matriculas_bach_temp");
	echo '<h3 align="center">Alumnos de <span style="color:#08c">'.$curso.'</span> con datos cambiados.</h3><br /><br />';
	echo "<div class='well-2 well-large' style='width:520px;margin:auto;'>";
	while ($cam = mysql_fetch_array($camb)) {
		$id_cambios = $cam[0];
		if ($curso == "1BACH") {
			$c_clave = mysql_query("select * fom alma, matriculas_bach where alma.claveal = matriculas_bach.claveal and id = '$id_cambios'");
			if(mysql_num_rows($c_clave)>0){
			$alma="alma";
			}
			else{
			$alma="alma_secundaria";
			}
		}
		else{
			$alma="alma";
		}
		$contr = mysql_query("select matriculas_bach.apellidos, $alma.apellidos, matriculas_bach.nombre, $alma.nombre, matriculas_bach.domicilio, $alma.domicilio, matriculas_bach.dni, $alma.dni, matriculas_bach.padre, concat(primerapellidotutor,' ',segundoapellidotutor,', ',nombretutor), matriculas_bach.dnitutor, $alma.dnitutor, matriculas_bach.telefono1, $alma.telefono, matriculas_bach.telefono2, $alma.telefonourgencia, $alma.claveal from matriculas_bach, $alma where $alma.claveal=matriculas_bach.claveal and id = '$id_cambios'");
		//$col_datos = array()
		$control = mysql_fetch_array($contr);
		echo "<p style='color:#08c'>$control[16]: $control[0], $control[2]</p>";
		for ($i = 0; $i < 18; $i++) {
			if ($i%2) {
				if ($i=="5" and strstr($control[$i], $control[$i-1])==TRUE) {}
				elseif ($i=="17") {}
				else{
					if ($control[$i]==$control[$i-1]) {}else{
						echo "<li>Séneca: ".$control[$i]." ==> Matrícula: ".$control[$i-1]."</li>";
					}
				}
			}
		}
		echo "<hr>";

	}
	echo "</div>";
	exit();
}



if ($sin_matricula=="Alumnos sin matricular") {
	include("../../menu.php");
	include("menu.php");

	$cur_monterroso = substr($curso, 0, 2);
	$camb = mysql_query("select distinct apellidos, nombre, unidad, telefono, telefonourgencia from alma where claveal not in (select claveal from matriculas_bach) and nivel = '$cur_monterroso' order by unidad, apellidos, nombre");
	echo '<h3 align="center">Alumnos de '.$curso.' sin matricular.</h3><br /><br />';
	echo "<div class='well-2 well-large' style='width:520px;margin:auto;'><ul class='unstyled'>";
	while ($cam = mysql_fetch_array($camb)) {

		echo "<li><i class='icon icon-user'></i> &nbsp;<span style='color:#08c'>$cam[0], $cam[1]</span> --> <strong style='color:#9d261d'>$cam[2]</strong> : $cam[3] - $cam[4]</li>";

	}
	echo "</ul></div>";
	exit();
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<title>Intranet</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Intranet del http://<? echo $nombre_del_centro;?>/">
<meta name="author" content="">

<!-- Le styles -->

<link href="http://<? echo $dominio;?>/intranet/css/bootstrap.css"
	rel="stylesheet">
<link href="http://<? echo $dominio;?>/intranet/css/otros_index.css"
	rel="stylesheet">
<link
	href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css"
	rel="stylesheet">
<link href="http://<? echo $dominio;?>/intranet/css/imprimir.css"
	rel="stylesheet" media="print">
</head>
<body>
<?
include("../../menu.php");
include("./menu.php");
?>
<div align=center>
<div class="page-header" align="center">
<h1>Matriculación de Alumnos <small> Consultas en Bachillerato</small></h1>
</div>


<?
// Asignaturas y Modalidades
$it11 = array("Bachillerato de Ciencias y Tecnología", "Vía de Ciencias e Ingeniería", "Vía de Ciencias de la Naturaleza y la Salud", "Ciencias y Tecnología");
$it12 = array("Bachillerato de Humanidades y Ciencias Sociales", "Vía de Humanidades", "Vía de Ciencias Sociales", "Humanidades y Ciencias Sociales");
$opt11=array("DBT11" => "Dibujo Técnico", "TIN11" => "Tecnología", "BYG11"=>"Biología y Geología");
$opt12=array("GRI12-LAT12" => "Griego, Latín", "GRI12-ECO12" => "Griego, Economía", "MCS12-ECO12"=>"Matemáticas de Ciencias Sociales, Economía", "MCS12-LAT12"=>"Matemáticas de Ciencias Sociales, Latín");

$it21 = array("Bachillerato de Ciencias y Tecnología", "Vía de Ciencias e Ingeniería", "Vía de Ciencias de la Naturaleza y la Salud", "Ciencias y Tecnología");
$it22 = array("Bachillerato de Humanidades y Ciencias Sociales", "Vía de Humanidades", "Vía de Ciencias Sociales", "Humanidades y Ciencias Sociales");
$opt21=array("FIS21_DBT21" => "Física, Dibujo Técnico", "FIS21_TIN21" => "Física, Tecnología", "FIS21_QUI21" => "Física, Química", "BIO21_QUI21" => "Biología, Química");
$opt22=array("HAR22_LAT22_GRI22" => "Historia del Arte, Latín, Griego", "HAR22_LAT22_MCS22" => "Historia del Arte, Latín, Matemáticas de las C. Sociales", "HAR22_ECO22_GRI22" => "Historia del Arte, Economía, Griego", "HAR22_ECO22_MCS22" => "Historia del Arte, Economía, Matemáticas de las C. Sociales", "GEO22_ECO22_MCS22" => "Geografía, Economía, Matemáticas de las C. Sociales", "GEO22_ECO22_GRI22" => "Geografía, Economía, Griego", "GEO22_LAT22_MCS22" => "Geografía, Latín, Matemáticas de las C. Sociales", "GEO22_LAT22_GRI22" => "Geografía, Latín, Griego");
$opt23 =array("ingles_25" => "Inglés 2º Idioma","aleman_25" => "Alemán 2º Idioma", "frances_25" => "Francés 2º Idioma", "tic_25" => "T.I.C.", "ciencias_25" => "Ciencias de la Tierra y Medioambientales", "musica_25" => "Historia de la Música y la Danza", "literatura_25" => "Literatura Universal", "edfisica_25"=>"Educación Física", "estadistica_25"=>"Estadística", "salud_25"=>"Introducción a las Ciencias de la Salud");
echo '<div  class="no_imprimir">';

$n_curso = substr($curso, 0, 1);
include 'filtro_bach.php';

echo "</div>";
if ($borrar=='1') {
	mysql_query("insert into matriculas_bach_backup (select * from matriculas_bach where id = '$id')");
	mysql_query("delete from matriculas_bach where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El alumno ha sido borrado de la tabla de matrículas. Se ha creado una copia de respaldo de us datos en la tabla matriculas_bach_backup.
</div></div><br />' ;
}
if ($copia=='1') {
	mysql_query("delete from matriculas_bach where id='$id'");
	mysql_query("insert into matriculas_bach(select * from matriculas_bach_backup where id = '$id')");
	mysql_query("delete from matriculas_bach_backup where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos originales de la matrícula del alumno han sido correctamente restaurados.
</div></div><br />' ;
}
if ($consulta) {

	if ($curso) {$extra=" curso='$curso' ";}else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has seleccionado el Nivel. Así no podemos seguir...
</div></div>' ;
		exit();
	}
}

if ($optativ) { $extra.=" and optativa".$n_curso." = '".$optativ."'";}
if ($itinerari) { $extra.=" and itinerario$n_curso = '$itinerari'";}
if ($religio) { $extra.=" and religion = '$religio'";}
if ($letra_grup) { $extra.=" and letra_grupo = '$letra_grup'";}
if ($_POST['grupo_actua']) {

	$extra.=" and ( ";
	foreach ($_POST['grupo_actua'] as $grup_actua){
		if($grup_actua=="Ninguno"){$extra.=" grupo_actual is null or";}
		else{
			$extra.=" grupo_actual = '$grup_actua' or";
		}
	}
	$extra = substr($extra,0,strlen($extra)-2);
	$extra.=")";

}
//if ($grupo_actua) { if($grupo_actua=="Ninguno"){$extra.=" and grupo_actual = ''";} else{  $extra.=" and grupo_actual = '$grupo_actua'";}}
if ($colegi) { $extra.=" and colegio = '$colegi'";}
if ($transport == "ruta_este") { $extra.=" and ruta_este != ''";}
if ($transport == "ruta_oeste") { $extra.=" and ruta_oeste != ''";}
if (strlen($dn)>5) {$extra.=" and dni = '$dn'";}
if (strlen($apellid)>2) {$extra.=" and apellidos like '%$apellid%'";}
if (strlen($nombr)>2) {$extra.=" and nombre like '%$nombr%'";}

if ($promocion=="SI") { $extra.=" and promociona = '1'";}
if ($promocion=="NO") { $extra.=" and promociona = '2'";}
if ($promocion=="3/4") { $extra.=" and promociona = '3'";}

if (!($orden)) {
	$orden=" ";
	if ($curso=="1BACH") {
		// En Junio puede interesar ordenar por colegio
		if (date('m')>'05' and date('m')<'09'){
			$orden.="colegio, ";
		}
		else{
			$orden.="";
		}
	}

	include 'procesado_bach.php';

	$sql = "select id, apellidos, nombre, curso, letra_grupo, colegio, otrocolegio, confirmado, grupo_actual, observaciones, religion, itinerario1, itinerario2, promociona, claveal, ruta_este, ruta_oeste, revisado, optativa1, optativa2 ";

	if ($curso=="2BACH"){
		for ($i=1;$i<11;$i++)
		{
			$sql.=", optativa2b$i";
		}
	}
	$sql.=", repite from matriculas_bach where ". $extra ." order by ". $orden ."curso, grupo_actual, apellidos, nombre ";
	//echo $sql;
	$cons = mysql_query($sql);
	if(mysql_num_rows($cons) < 1){
		echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hay alumnos que se ajusten a ese criterio. Prueba de nuevo.
</div></div><br />' ;
	}
	else{
		if ($curso) {
			?>
<h3><? if($_POST['grupo_actua']){ 
	echo $curso." ";
	foreach ($_POST['grupo_actua'] as $grup_actua){
		echo $grup_actua." ";
	}
} else{ echo $n_curso."º de Bachillerato";}?></h3>
<br />
<form action="consultas_bach.php?curso=<? echo $curso;?>&consulta=1"
	name="form1" method="post">
<table class="table table-striped table-condensed" align="center"
	style="width: auto">
	<tr>
		<th colspan="2"></th>
		<th>Nombre</th>
		<th>Curso</th>
		<th>Gr1</th>
		<th>Gr2</th>
		<?
		echo '<th>Centro</th>';
		echo '<th>Rel.</th>';
		echo '<th>Transporte</th>';
		echo '<th>Mod.</th>';
		echo "<th>Opt_Mod".$n_curso."</th>";
		if ($n_curso>1) {
			for ($i = 1; $i < 11; $i++) {
				echo '<th>O'.$i.'</th>';
			}
		}
		?>
		<?
		echo '<th class="no_imprimir" style="align:center">Sí NO 3/4</th>';
		echo '<th class="no_imprimir">Rev.</th>';
		echo '<th class="no_imprimir"></th>';
		?>
	</tr>
	<?
	while($datos_ya = mysql_fetch_object($cons)){
		$backup="";
		$respaldo='1';
		$naci = explode("-",$datos_ya->nacimiento);
		$nacimiento = "$naci[2]-$naci[1]-$naci[0]";
		$apellidos = $datos_ya->apellidos; $id = $datos_ya->id; $nombre = $datos_ya->nombre; $nacido = $datos_ya->nacimiento; $provincia = $datos_ya->provincia; $domicilio = $datos_ya->domicilio; $localidad = $datos_ya->localidad; $dni = $datos_ya->dni; $padre = $datos_ya->padre; $dnitutor = $datos_ya->dnitutor; $madre = $datos_ya->madre; $dnitutor2 = $datos_ya->dnitutor2; $telefono1 = $datos_ya->telefono1; $telefono2 = $datos_ya->telefono2; $colegio = $datos_ya->colegio; $correo = $datos_ya->correo; $otrocolegio = $datos_ya->otrocolegio; $letra_grupo = $datos_ya->letra_grupo; $religion = $datos_ya->religion; $observaciones = $datos_ya->observaciones; $promociona = $datos_ya->promociona; $transporte = $datos_ya->transporte; $ruta_este = $datos_ya->ruta_este; $ruta_oeste = $datos_ya->ruta_oeste; $sexo = $datos_ya->sexo; $hermanos = $datos_ya->hermanos; $nacionalidad = $datos_ya->nacionalidad; $claveal = $datos_ya->claveal; $curso = $datos_ya->curso;  $itinerario1 = $datos_ya->itinerario1; $itinerario2 = $datos_ya->itinerario2; $optativa1 = $datos_ya->optativa1; $optativa2 = $datos_ya->optativa2; $optativa2b1 = $datos_ya->optativa2b1; $optativa2b2 = $datos_ya->optativa2b2; $optativa2b3 = $datos_ya->optativa2b3; $optativa2b4 = $datos_ya->optativa2b4; $optativa2b5 = $datos_ya->optativa2b5; $optativa2b6 = $datos_ya->optativa2b6; $optativa2b7 = $datos_ya->optativa2b7; $optativa2b8 = $datos_ya->optativa2b8; $optativa2b9 = $datos_ya->optativa2b9; $optativa2b10 = $datos_ya->optativa2b10; $repetidor = $datos_ya->repite;$revisado = $datos_ya->revisado; $confirmado = $datos_ya->confirmado; $grupo_actual = $datos_ya->grupo_actual;
		$back = mysql_query("select id from matriculas_bach_backup where id = '$id'");
		if (mysql_num_rows($back)>0) {
			$respaldo = '1';
			$backup="<a href='consultas_bach.php?copia=1&id=$id&curso=$curso&consulta=1'><i class='icon icon-refresh' rel='Tooltip' title='Restaurar datos originales de la matrícula del alumno '> </i></a>";
		}

		echo '<tr>

	<td><input value="1" name="confirmado-'. $id .'" type="checkbox"';
		if ($confirmado=="1") { echo " checked";}
		echo ' onClick="submit()"/></td><td>'.$num_al.'</td>
	<td><a href="matriculas_bach.php?id='. $id .'" target="_blank">'.$apellidos.', '.$nombre.'</a></td>
	<td>'.$curso.'</td>
	<td>'.$letra_grupo.'</td>
	<td><input name="grupo_actual-'. $id .'" type="text" class="input-mini" style="width:12px;" value="'. $grupo_actual .'" /></td>';
		echo '<td>'. $otrocolegio .'</td>';
		$color_rel = "";
		if (strstr($religion,"Cat")==TRUE) {
			$color_rel = " style='background-color:#FFFF99;'";
		}
		if (strstr($religion,"Atenci")==TRUE) {
			$color_rel = " style='background-color:#cdecab'";
		}
		echo '<td '.$color_rel.'>'.$religion.'</td>';
		$trans = "";
		if($ruta_este){$trans = substr($ruta_este, 0, 10).".";}
		if($ruta_oeste){$trans = substr($ruta_oeste, 0, 10).".";}
		echo '<td> '.$trans.'</td>';
		echo '<td>'.${itinerario.$n_curso}.'</td>';
		//if ($optativa1 == '0') {${optativa.$i}="";}
		echo "<td align='center'";
		//if($optativa1=='1'){echo " style='background-color:#efdefd;'";}
		echo ">".${optativa.$n_curso}."</td>";
		if ($n_curso>1) {
			for ($i = 1; $i < 11; $i++) {
				echo '<td>'.${optativa2b.$i}.'</td>';
			}
		}

		// Promocionan o no
		if ($n_curso) {
			echo "<td class='no_imprimir' style='background-color:#efeefd;text-align:center;'>";
			if (!($promociona =='') and !($promociona == '0')) {
						echo '<input type="radio" name = "promociona-'. $id .'" value="1" ';
						if($promociona == "1"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="2" ';
						if($promociona == "2"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="3" ';
						if($promociona == "3"){echo " checked";}
						echo " />";
			}
			else{
				if (date('m')>'04' and date('m')<'09'){
				$val_notas="";
				$not = mysql_query("select notas3, notas4 from notas, alma where alma.claveal1=notas.claveal and alma.claveal=".$claveal."");
				$nota = mysql_fetch_array($not);
				$tr_not = explode(";", $nota[0]);
				$num_ord="";
				$num_ord1="";
				foreach ($tr_not as $val_asig) {
					$tr_notas = explode(":", $val_asig);
					foreach ($tr_notas as $key_nota=>$val_nota) {
						$num_ord+=1;
						if($key_nota == "1" and $val_nota<'427' and $val_nota !=="439" and $val_nota !==""){
							$val_notas=$val_notas+1;
						}
					}
				}
				}
				elseif (date('m')=='09'){
				$val_notas="";
				$tr_not2 = explode(";", $nota[1]);
				foreach ($tr_not2 as $val_asig) {
					$tr_notas = explode(":", $val_asig);
					foreach ($tr_notas as $key_nota=>$val_nota) {
						$num_ord1+=1;
						if($key_nota == "1" and $val_nota<'427' and $val_nota !=="439" and $val_nota !==""){
							$val_notas=$val_notas+1;
						}
					}
				}
				}
				
			if ($n_curso == "1") {
			// Junio
				if (date('m')>'04' and date('m')<'09'){
					if ($val_notas==0 and $num_ord>1) {$promociona="1";}
						echo '<input type="radio" name = "promociona-'. $id .'" value="1" ';
						if($promociona == "1"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="2" ';
						if($promociona == "2"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="3" ';
						if($promociona == "3"){echo " checked";}
						echo " />";
				}
				// Septiembre
				elseif (date('m')=='09'){
					if ($val_notas>0 and $num_ord1>1) {$promociona="2";}else{$promociona="1";}
						echo '<input type="radio" name = "promociona-'. $id .'" value="1" ';
						if($promociona == "1"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="2" ';
						if($promociona == "2"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="3" ';
						if($promociona == "3"){echo " checked";}
						echo " />";
					}	
				}
				else{
				if ($n_curso == "2") {
			// Junio
				if (date('m')>'04' and date('m')<'09'){					
					if ($val_notas<1 and $num_ord>1) {$promociona="1";}
						echo '<input type="radio" name = "promociona-'. $id .'" value="1" ';
						if($promociona == "1"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="2" ';
						if($promociona == "2"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="3" ';
						if($promociona == "3"){echo " checked";}
						echo " />";
						//echo "$num_ord";
				}
				// Septiembre
				elseif (date('m')=='09' and $num_ord1>1){
					if ($val_notas<1) {$promociona="1";}elseif($val_notas>2 and $val_notas<5) {$promociona="3";}else{$promociona="2";}					
						echo '<input type="radio" name = "promociona-'. $id .'" value="1" ';
						if($promociona == "1"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="2" ';
						if($promociona == "2"){echo " checked";}
						echo " />";
						echo '&nbsp;&nbsp;<input type="radio" name = "promociona-'. $id .'" value="3" ';
						if($promociona == "3"){echo " checked";}
						echo " />";
						}	
					}	
				}
				
			}
			echo "</td>";
		}
		echo '<td class="no_imprimir"><input name="revisado-'. $id .'" type="checkbox" value="1"';
		if($revisado=="1"){echo " checked";}
		echo ' /></td>';
		echo '<td class="no_imprimir" style="text-align:right">';
		if (!($colegio == "IES Monterroso")) {$alma="alma_secundaria";}else{$alma="alma";}
		$contr = mysql_query("select matriculas_bach.apellidos, $alma.apellidos, matriculas_bach.nombre, $alma.nombre, matriculas_bach.domicilio, $alma.domicilio, matriculas_bach.dni, $alma.dni, matriculas_bach.padre, concat(primerapellidotutor,' ',segundoapellidotutor,', ',nombretutor), matriculas_bach.dnitutor, $alma.dnitutor, matriculas_bach.telefono1, $alma.telefono, matriculas_bach.telefono2, $alma.telefonourgencia from matriculas_bach, $alma where $alma.claveal=matriculas_bach.claveal and id = '$id'");
		$control = mysql_fetch_array($contr);
		for ($i = 0; $i < 16; $i++) {
			if ($i%2) {
				if ($i=="5" and strstr($control[$i], $control[$i-1])==TRUE) {}
				else{
					if ($control[$i]==$control[$i-1]) {}else{
						echo "<i class='icon icon-info-sign' rel='Tooltip' title='".$control[$i]." --> ".$control[$i-1]."'> </i>&nbsp;&nbsp;";
					}
				}
			}
			//echo "$control[$i] --> ";
		}
		if ($observaciones) { echo "<i class='icon icon-bookmark' rel='Tooltip' title='Tiene observaciones en la matrícula' > </i>";}

		if ($respaldo=='1') {
			echo "&nbsp;".$backup;
		}
		echo "&nbsp;<a href='consultas_bach.php?borrar=1&id=$id&curso=$curso&consulta=1'><i class='icon icon-trash' rel='Tooltip' title='Eliminar alumno de la tabla'> </i></a>";
		echo "</td></div>";
		echo '
	</tr>';	
	}

	echo "</table>";
	echo "<div align='center'>
<input type='hidden' name='extra' value='$extra' />
<input type='submit' name='enviar' value='Enviar datos' class='btn btn-primary no_imprimir' /><br><br>
<input type='submit' name='imprimir' value='Imprimir'  class='btn btn-success no_imprimir' />&nbsp;&nbsp;
<input type='submit' name='caratulas' value='Imprimir Carátulas' class='btn btn-success no_imprimir' />&nbsp;&nbsp;
<input type='submit' name='cambios' value='Ver cambios en datos' class='btn btn-warning no_imprimir' />&nbsp;&nbsp;
<input type='submit' name='sin_matricula' value='Alumnos sin matricular' class='btn btn-danger no_imprimir' />";
	if(count($grupo_actua)=='1'){ echo "
	<input type='hidden' name='grupo_actual' value='$grupo_actua' />&nbsp;&nbsp;
	<input type='submit' name='listados' value='Listado en PDF' class='btn btn-inverse no_imprimir' />";} 
	else{ 
	echo "&nbsp;&nbsp;
	<input type='submit' name='listado_total' value='Listado PDF total' class='btn btn-inverse no_imprimir' />";
	}
	echo "</div></form>";
	?>
	<?
	if ($curso) {
		if (count($grupo_actua)=='1') {
			$extra = "and grupo_actual = '$grupo_actual'";
		}
		else{
			$extra="";	
		}
		$rel = mysql_query("select religion from matriculas_bach where curso = '$curso' $extra and religion like 'Rel%'");
		//echo "select religion from matriculas_bach where curso = '$curso' and grupo_actual = '$grupo_actual' and religion like 'Rel%'";
		$num_rel = mysql_num_rows($rel);
		//echo $num_rel;
		if ($curso=="2BACH"){		
		for ($i=1;$i<11;$i++){
			${optativ.$i} = mysql_query("select optativa2b$i from matriculas_bach where curso = '$curso' $extra and optativa2b$i = '1'");
			${optativb.$i} = mysql_num_rows(${optativ.$i});
		}
		}
		$promo = mysql_query("select promociona from matriculas_bach where curso = '$curso' $extra and promociona = '1'");
		$num_promo = mysql_num_rows($promo);
		$pil = mysql_query("select promociona from matriculas_bach where curso = '$curso' $extra and promociona = '3'");
		$num_34 = mysql_num_rows($pil);
		$an_bd = substr($curso_actual,0,4);
		$repit = mysql_query("select promociona from matriculas_bach where curso = '$curso' $extra and promociona = '2'");
		$num_repit = mysql_num_rows($repit);
		$it_1 = mysql_query("select itinerario1 from matriculas_bach where curso = '$curso' $extra and itinerario1 = '1'");
		$num_it1 = mysql_num_rows($it_1);
		$it_2 = mysql_query("select itinerario2 from matriculas_bach where curso = '$curso' $extra and itinerario2 = '2'");
		$num_it2 = mysql_num_rows($it_2);
		?>
	<br />
	<table class="table table-striped table-bordered" align="center"
		style="width: auto">
		<tr>
		<?
		echo "<th>Religión</td>";

		//echo "<th>Optativa$n_curso</th>";

		echo "<th>Promociona</th>";
		echo "<th>Repite</th>";
		if ($curso=="2BACH"){
		echo "<th>3/4</th>";
		}
		echo "<th>Itinerario1</th>";
		echo "<th>Itinerario2</th>";
		if ($curso=="2BACH"){
		for ($i=1;$i<11;$i++){
			echo "<td>Opt.$i</td>";
		}
		}
		?>
		</tr>
		<tr>
		<?
		echo "<td>$num_rel</td>";
		echo "<td>$num_promo</td>";
		echo "<td>$num_repit</td>";		
		if ($curso=="2BACH"){
		echo "<th>$num_34</th>";
		}
		echo "<td>$num_it1</td>";
		echo "<td>$num_it2</td>";
		if ($curso=="2BACH"){
		for ($i=1;$i<11;$i++){
			echo "<td>${optativb.$i}</td>";
	}
	}
	
	?>
		</tr>
	</table>
	<?
		}
		?>

	<br />
	<table class="table table-striped table-bordered no_imprimir"
		align="center" style="width:500px;">
		<tr>
			<td><?
			if ($curso=="2BACH") {
			foreach ($opt23 as $valor){
				$n_index+=1;
				$nom_opt.="<span style='color:#08c;'>Opt.".$n_index."</span> = ".$valor."; ";
				}
			
			}
			
				
			echo substr($nom_opt,0,-2);
			?></td>
		</tr>
	</table>
	<?
}
	}
	}
?>
	</div>
	<? include("../../pie.php"); ?>

</body>
</html>
