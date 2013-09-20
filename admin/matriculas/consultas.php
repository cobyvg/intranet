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
if (isset($_GET['curso'])) {$curso = $_GET['curso'];}elseif (isset($_POST['curso'])) {$curso = $_POST['curso'];}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}
if (isset($_GET['consulta'])) {$consulta = $_GET['consulta'];}elseif (isset($_POST['consulta'])) {$consulta = $_POST['consulta'];}

if (isset($_POST['listados'])) {
foreach ($_POST as $key=>$val)
	{
		if (strlen($val)==1 and !(is_numeric($val))) {
			$cur_actual=$val;
		}
	}
	include("listados.php");
	exit();
}

if (isset($_POST['listado_total'])) {
	include("listado_total.php");
	exit();
}
if (isset($_POST['imprimir'])) {
	mysql_query("drop table if exists matriculas_temp");
	mysql_query("CREATE TABLE  `matriculas_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
			$tr = explode("-",$key);
			$id_submit = $tr[1];
			$col = $tr[0];
			if (is_numeric($id_submit)) {

				mysql_query("insert into matriculas_temp VALUES ('$id_submit')");
			}
	}
	include("imprimir.php");
	exit();
}

if (isset($_POST['caratulas'])) {
	mysql_query("drop table if exists matriculas_temp");
	mysql_query("CREATE TABLE  `matriculas_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
			$tr = explode("-",$key);
			$id_submit = $tr[1];
			$col = $tr[0];
			if (is_numeric($id_submit)) {

				mysql_query("insert into matriculas_temp VALUES ('$id_submit')");
			}
	}
	include("caratulas.php");
	exit();
}
	


if (isset($_POST['cambios'])) {
	include("../../menu.php");
	include("menu.php");
	mysql_query("drop table if exists matriculas_temp");
	mysql_query("CREATE TABLE  `matriculas_temp` (
 `id_matriculas` INT NOT NULL ,
INDEX (  `id_matriculas` )
)");
	foreach ($_POST as $key=>$val)
	{
			$tr = explode("-",$key);
			$id_submit = $tr[1];
			$col = $tr[0];
			if (is_numeric($id_submit)) {

				mysql_query("insert into matriculas_temp VALUES ('$id_submit')");
			}
	}
	
	$camb = mysql_query("select distinct id_matriculas from matriculas_temp");
	echo '<h3 align="center">Alumnos de <span style="color:#08c">'.$curso.'</span> con datos cambiados.</h3><br /><br />';
		echo "<div class='well well-large' style='width:520px;margin:auto;'>";
	while ($cam = mysql_fetch_array($camb)) {
		$id_cambios = $cam[0];
		if ($curso == "1ESO") {$alma="alma_primaria";}else{$alma="alma";}
	$contr = mysql_query("select matriculas.apellidos, $alma.apellidos, matriculas.nombre, $alma.nombre, matriculas.domicilio, $alma.domicilio, matriculas.dni, $alma.dni, matriculas.padre, concat(primerapellidotutor,' ',segundoapellidotutor,', ',nombretutor), matriculas.dnitutor, $alma.dnitutor, matriculas.telefono1, $alma.telefono, matriculas.telefono2, $alma.telefonourgencia, $alma.claveal from matriculas, $alma where $alma.claveal=matriculas.claveal and id = '$id_cambios'");
	//$col_datos = array()
	$control = mysql_fetch_array($contr);
	echo "<p style='color:#08c'>$control[16]: $control[0], $control[2]</p>";
for ($i = 0; $i < 18; $i++) {
	if ($i%2) {
	if ($i=="5" and strstr($control[$i], $control[$i-1])==TRUE) {}
	elseif ($i=="17") {}
	else{
		if ($control[$i]==$control[$i-1]) {}else{		
						echo "<li><span class='text-error'>Séneca:</span> ".$control[$i]." ==> <span class='text-error'>Matrícula:</span> ".$control[$i-1]."</li>";
					}
	}
	}
}
		echo "<hr>";

}
echo "</div>";
	mysql_query("drop table matriculas_temp");
exit();
	}
	


if (isset($_POST['sin_matricula'])) {
	include("../../menu.php");
	include("menu.php");
if ($curso=="4ESO") {
	$tabla ='matriculas_bach';
}
else{
	$tabla = 'matriculas';
}
	$cur_monterroso = substr($curso, 0, 2);
	$camb = mysql_query("select distinct apellidos, nombre, unidad, telefono, telefonourgencia, fecha from alma where claveal not in (select claveal from $tabla) and nivel = '$cur_monterroso' order by unidad, apellidos, nombre");
	echo '<h3 align="center">Alumnos de '.$curso.' sin matricular.</h3><br />';
			echo "<div class='well well-large' style='width:600px;margin:auto;'><ul class='unstyled'>";
	while ($cam = mysql_fetch_array($camb)) {
				
			echo "<li><i class='icon icon-user'></i> &nbsp;<span style='color:#08c'>$cam[0], $cam[1]</span> --> <strong style='color:#9d261d'>$cam[2]</strong> : $cam[3] - $cam[4] ==> $cam[5]</li>";
		
}
echo "</ul></div><br />";

	$canf = mysql_query("select distinct alma.apellidos, alma.nombre, alma.unidad, alma.telefono, alma.telefonourgencia, alma.fecha from alma, matriculas where alma.claveal=matriculas.claveal  and alma.nivel = '$cur_monterroso' and confirmado = '0' order by unidad, apellidos, nombre");
	echo '<h3 align="center">Alumnos de '.$curso.' prematriculados sin confirmar.</h3><br />';
			echo "<div class='well well-large' style='width:600px;margin:auto;'><ul class='unstyled'>";
	while ($cam2 = mysql_fetch_array($canf)) {
				
			echo "<li><i class='icon icon-user'></i> &nbsp;<span style='color:#08c'>$cam2[0], $cam2[1]</span> --> <strong style='color:#9d261d'>$cam2[2]</strong> : $cam2[3] - $cam2[4] ==> $cam2[5]</li>";
		
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
    <meta name="description" content="Intranet del http://<? echo $nombre_del_centro;?>/">  
    <meta name="author" content="">  
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">   
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <link href="http://<? echo $dominio;?>/intranet/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link rel="stylesheet" href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css">  
<script language="javascript">
function desactivaOpcion(){ 
    with (document.form2){ 
     switch (curso.selectedIndex){ 
      case 1: 
       itinerari.disabled = true; 
       matematica4.disabled = true;
       diversificacio.disabled = true;
       promocion.disabled = true;
       actividade.disabled = false;
       exencio.disabled = false;
       break; 
      case 2: 
       itinerari.disabled = true; 
       matematica4.disabled = true;
       diversificacio.disabled = true;
       promocion.disabled = false;
       actividade.disabled = false;
       exencio.disabled = false;
       break; 
      case 3: 
    	  itinerari.disabled = true; 
          matematica4.disabled = true;
          actividade.disabled = true;
          exencio.disabled = true;
          diversificacio.disabled = false;
          promocion.disabled = false;
       break; 
      case 4: 
    	  actividade.disabled = true;
          exencio.disabled = true;
          bilinguism.disabled = true;
          itinerari.disabled = false; 
          matematica4.disabled = false;
          diversificacio.disabled = false;
          promocion.disabled = false;         
       break; 
     } 
    } 
   } 	
 </script>
</head>
<body>

  <? 
 include("../../menu_solo.php");
 include("./menu.php");
 
 foreach($_POST as $key => $val)
	{
		${$key} = $val;
	}
  ?>
<div align=center>
<div class="page-header" align="center">
  <h2>Matriculación de Alumnos <small> Consultas</small></h2>
</div>

<h3 class="no_imprimir">Alumnos matriculados</h3>

<? 
echo '<div  class="no_imprimir">';
include 'filtro.php';
echo "</div>";
if (isset($_GET['borrar'])) {
	mysql_query("insert into matriculas_backup (select * from matriculas where id = '$id')");
	mysql_query("delete from matriculas where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
El alumno ha sido borrado de la tabla de matrículas. Se ha creado una copia de respaldo de us datos en la tabla matriculas_backup.
</div></div><br />' ;
}
if (isset($_GET['copia'])) {
	mysql_query("delete from matriculas where id='$id'");
	mysql_query("insert into matriculas (select * from matriculas_backup where id = '$id')");
	mysql_query("delete from matriculas_backup where id='$id'");
	echo '<div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos originales de la matrícula del alumno han sido correctamente restaurados.
</div></div><br />' ;
}
if (isset($_GET['consulta']) or isset($_POST['consulta'])) {

	if ($curso) {$extra=" curso='$curso' ";}else{
		echo '<div align="center"><div class="alert alert-danger alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No has seleccionado el Nivel. Así no podemos seguir...
</div></div>' ;
		exit();
	}	
	}
	
	$n_curso = substr($curso, 0, 1);
	
	if ($diversificacio=="Si") { $extra.=" and diversificacion = '1'";	}elseif ($diversificacio=="No"){ $extra.=" and diversificacion = '0'"; }
	if ($exencio=="Si") { $extra.=" and exencion = '1'";	}elseif ($exencio=="No") { $extra.=" and exencion = '0'"; }
	if ($promocion=="Promociona") { $extra.=" and promociona = '1'";	}elseif($promocion=="PIL"){ $extra.=" and promociona = '2'"; }elseif($promocion=="Repite"){$extra.=" and promociona = '3'";}
    if ($optativ) { $extra.=" and $optativ = '1'";}
	if ($religio) { $extra.=" and religion = '$religio'";}
	if ($letra_grup) { $extra.=" and letra_grupo = '$letra_grup'";}
	if ($_POST['grupo_actua']) {
			
			$extra.=" and ( ";
		foreach ($_POST['grupo_actua'] as $grup_actua){
			if($grup_actua=="Ninguno"){$extra.=" grupo_actual = '' or";}
			else{
			  $extra.=" grupo_actual = '$grup_actua' or";
			}
		}
		$extra = substr($extra,0,strlen($extra)-2);
		$extra.=")";
	
	}
//if ($grupo_actua) { if($grupo_actua=="Ninguno"){$extra.=" and grupo_actual = ''";} else{  $extra.=" and grupo_actual = '$grupo_actua'";}}
	if ($colegi) { $extra.=" and colegio = '$colegi'";}
    if ($actividade) { $extra.=" and act1 = '$actividade'";}
    if ($itinerari and $n_curso=='4') { $extra.=" and itinerario = '$itinerari'";}
    if ($matematica4 and $n_curso=='4') { $extra.=" and matematicas4 = '$matematica4'";}
	if ($transport == "ruta_este") { $extra.=" and ruta_este != ''";}
	if ($transport == "ruta_oeste") { $extra.=" and ruta_oeste != ''";}
	if ($bilinguism == "Si") { $extra.=" and bilinguismo = 'Si'";}
	if ($bilinguism == "No") { $extra.=" and bilinguismo = ''";}
	if ($itinerario == "0") { $itinerario = "";	}
	if (strlen($dn)>5) {$extra.=" and dni = '$dn'";}
	if (strlen($apellid)>1) {$extra.=" and apellidos like '%$apellid%'";}
	if (strlen($nombr)>1) {$extra.=" and nombre like '%$nombr%'";}
	if (!($orden)) {
		$orden=" ";
		if ($curso=="1ESO") {
			// En Junio puede interesar ordenar por colegio
			if (date('m')>'05' and date('m')<'09'){
				$orden.="colegio, ";
			}	
			else{
				$orden.="";
			}
		}
		
	include 'procesado.php';
	
	// Optativas de ESO
	$opt1 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Tecnología Aplicada");
	$opt2 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Métodos de la Ciencia");
	$opt3 = array("Alemán 2º Idioma","Cambios Sociales y Género", "Francés 2º Idioma","Cultura Clásica", "Taller T.I.C. III", "Taller de Cerámica", "Taller de Teatro");
	$opt41=array("Alemán2_1" => "Alemán 2º Idioma", "Francés2_1" => "Francés 2º Idioma", "Informatica_1" => "Informática");
	$opt42=array("Alemán2_2" => "Alemán 2º Idioma", "Francés2_2" => "Francés 2º Idioma", "Informatica_2" => "Informática", "EdPlástica_2" => "Ed. Plástica y Visual");
	$opt43=array("Alemán2_3" => "Alemán 2º Idioma", "Francés2_3" => "Francés 2º Idioma", "Informatica_3" => "Informática", "EdPlástica_3" => "Ed. Plástica y Visual");
	$opt44=array("Alemán2_4" => "Alemán 2º Idioma", "Francés2_4" => "Francés 2º Idioma", "Tecnología_4" => "Tecnología");
//	$a1 = array("Actividades de refuerzo de Lengua Castellana", "Actividades de refuerzo de Matemáticas", "Actividades de refuerzo de Inglés", "Ampliación: Taller T.I.C.", "Ampliación: Taller de Teatro");
	$a1 = array("Actividades de refuerzo de Lengua Castellana", "Actividades de refuerzo de Matemáticas", "Actividades de refuerzo de Inglés", "Ampliación: Taller T.I.C.", "Ampliación: Taller de Teatro");
	$a2 = array("Actividades de refuerzo de Lengua Castellana ", "Actividades de refuerzo de Matemáticas", "Actividades de refuerzo de Inglés", "Ampliación: Taller T.I.C. II", "Ampliación: Taller de Teatro II");
	
	
$sql = "select matriculas.id, matriculas.apellidos, matriculas.nombre, matriculas.curso, letra_grupo, colegio, bilinguismo, diversificacion, act1, confirmado, grupo_actual, observaciones, exencion, religion, itinerario, matematicas4, promociona, claveal, ruta_este, ruta_oeste, revisado";

if ($curso=="3ESO"){$num_opt = "7";}else{$num_opt = "4";}
for ($i=1;$i<$num_opt+1;$i++)
		{
			$sql.=", optativa$i";		
		}

$sql.=" from matriculas where ". $extra ." order by ". $orden ."curso, grupo_actual, apellidos, nombre ";
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
	} else{ echo $curso;}?></h3><br />
<form action="consultas.php?curso=<? echo $curso;?>&consulta=1" name="form1" method="post">
<table class="table table-striped table-condensed" align="center" style="width:auto">
<thead><th colspan="2"></th><th>Nombre</th><th>Curso</th><th>Gr1</th><th>Gr2</th>
<?
if ($curso=="1ESO") {
echo '<th>Colegio</th>';
		}
echo '<th>Rel.</th>';
echo '<th>Transporte</th>';
if ($n_curso<4) {
echo '<th>Bil.</th>';
		}
		if ($n_curso<3) {
echo '<th>Ex.</th>';
		}
		if ($n_curso>2) {
echo '<th>Div.</th>';
		}
		if ($n_curso=="4") {
echo '<th>Itin.</th>';
		}
for ($i=1;$i<$num_opt+1;$i++)
		{
			echo "<th>Opt".$i."</th>";		
		}
		if ($n_curso<3) {
echo '<th>Act.</th>';
		}	
?>

<th class="no_imprimir">Opciones</th>
<?
		if ($n_curso>1) {
echo '<th class="no_imprimir">SI |PIL |NO </th>';
		}	
		echo '<th class="no_imprimir">Rev.</th>';
		echo '<th class="no_imprimir">Copia</th>';
		echo '<th class="no_imprimir">Borrar</th>';
?>
<th class="no_imprimir">Conv.</th>
</thead>
<tbody>
<?
	while($consul = mysql_fetch_array($cons)){
	$backup="";
	$respaldo='1';
	$id = $consul[0];
	$apellidos = $consul[1];
	$nombre= $consul[2];
	$letra_grupo = $consul[4];
	$colegio = $consul[5];
	$bilinguismo = $consul[6];
	$diversificacion = $consul[7];
	$act1 = $consul[8];
	$confirmado = $consul[9];
	$grupo_actual = $consul[10];
	$observaciones = $consul[11];
	$exencion = $consul[12];
	$religion = $consul[13];
	$itinerario = $consul[14];
	$matematicas4 = $consul[15];
	$promociona = $consul[16];
	$claveal = $consul[17];
	$ruta_este = $consul[18];
	$ruta_oeste = $consul[19];
	$revisado = $consul[20];
	$back = mysql_query("select id from matriculas_backup where id = '$id'");
	if (mysql_num_rows($back)>0) {
			$respaldo = '1';
			$backup="<a href='consultas.php?copia=1&id=$id&curso=$curso&consulta=1'><i class='icon icon-refresh' rel='Tooltip' title='Restaurar datos originales de la matrícula del alumno '> </i></a>";
	}
		//echo $ruta_este;
for ($i=1;$i<$num_opt+1;$i++)
		{
			${optativa.$i} = $consul[$i+20];		
		}
		
// Problemas de Convivencia
$n_fechorias="";
$fechorias = mysql_query("select * from Fechoria where claveal='".$claveal."'");
$n_fechorias = mysql_num_rows($fechorias);
//$fechori="16 --> 1000";
if (!(isset($fechori)) or $fechori=="") {
	$fechori1="0";
	$fechori2="1000";
}
else{
	if ($fechori=="Sin problemas") {
	$fechori1="0";
	$fechori2="1";
	}
	else{
	$tr_fech = explode(" --> ",$fechori);
	$fechori1=$tr_fech[0];
	$fechori2=$tr_fech[1];		
	}
}
if ($n_fechorias >= $fechori1 and $n_fechorias < $fechori2) {	
	$num_al+=1;
	echo '<tr>

	<td><input value="1" name="confirmado-'. $id .'" type="checkbox"';
		if ($confirmado=="1") { echo " checked";}
	echo ' onClick="submit()"/></td><td>'.$num_al.'</td>
	<td><a href="matriculas.php?id='. $id .'" target="_blank">'.$apellidos.', '.$nombre.'</a></td>
	<td>'.$curso.'</td>
	<td>'.$letra_grupo.'</td>
	<td><input name="grupo_actual-'. $id .'" type="text" class="input-mini" style="width:12px;" value="'. $grupo_actual .'" /></td>';
	if ($curso=="1ESO") {
		echo '<td>'. $colegio .'</td>';
		}
	if (strstr($religion,"Cat")==TRUE) {
			$color_rel = " style='background-color:#FFFF99;'";
		}
	if (strstr($religion,"Atenci")==TRUE) {
			$color_rel = " style='background-color:#cdecab'";
		}
echo '<td '.$color_rel.'></td>';
$trans = "";
if($ruta_este){$trans = substr($ruta_este, 0, 10).".";}
if($ruta_oeste){$trans = substr($ruta_oeste, 0, 10).".";}
echo '<td> '.$trans.'</td>';

		if ($n_curso<4) {	
echo '<td><input name="bilinguismo-'. $id .'" type="checkbox" value="Si"';
 if($bilinguismo=="Si"){echo " checked";} 
 echo ' /></td>';
		}
		if ($n_curso<3) {
			 if ($exencion=="0") {$exencion="";}
echo '<td><input name="exencion-'. $id .'" type="checkbox" value="1"';
 if($exencion=="1"){echo " checked";} 
 echo ' /></td>';
		}

		if ($n_curso>2) {
echo '<td><input name="diversificacion-'. $id .'" type="checkbox" value="1"';
 if($diversificacion=="1"){echo " checked";} 
 echo ' /></td>';
		}
		if ($n_curso=="4") {
			if ($itinerario == '0'){$itinerario="";}
			if ($itinerario == '3') {$it = $itinerario."".$matematicas4."";}else{$it=$itinerario;}
echo '<td>'.$it.'</td>';
		}
for ($i=1;$i<$num_opt+1;$i++)
		{
			if (${optativa.$i} == '0') {${optativa.$i}="";}
			echo "<td align='center'";
			if(${optativa.$i}=='1'){echo " style='background-color:#efdefd;'";}
			echo ">".${optativa.$i}."</td>";		
		}
		
	if ($n_curso<3) {
		if ($act1==0) {
			$act1="";
		}
echo '<td><input name="act1-'. $id .'" type="text" style="width:10px;" value="'. $act1 .'" /></td>';
		}	
	echo '<td class="no_imprimir">';
	if ($curso == "1ESO") {$alma="alma_primaria";}else{$alma="alma";}
	$contr = mysql_query("select matriculas.apellidos, $alma.apellidos, matriculas.nombre, $alma.nombre, matriculas.domicilio, $alma.domicilio, matriculas.dni, $alma.dni, matriculas.padre, concat(primerapellidotutor,' ',segundoapellidotutor,', ',nombretutor), matriculas.dnitutor, $alma.dnitutor, matriculas.telefono1, $alma.telefono, matriculas.telefono2, $alma.telefonourgencia from matriculas, $alma where $alma.claveal=matriculas.claveal and id = '$id'");
	$control = mysql_fetch_array($contr);
	
for ($i = 0; $i < 16; $i++) {
	if ($i%2) {
	if ($i=="5" and strstr($control[$i], $control[$i-1])==TRUE) {}
	else{
		$text_contr="";
		if ($control[$i]==$control[$i-1]) {$icon="";}else{	
			if ($control[$i-1]<>0) {
						$icon="icon icon-info-sign";
						$text_contr.= $control[$i]." --> ".$control[$i-1]."; ";					
				}	
		}
	}
	}
	//echo "$control[$i] --> ";
}	
		echo "<i class='$icon' rel='Tooltip' title='$text_contr'> </i>&nbsp;&nbsp;";

	if ($observaciones) { echo "<i class='icon icon-bookmark' rel='Tooltip' title='Tiene observaciones en la matrícula' > </i>";}
	echo '</td>';
	
	// Promocionan o no
	if ($n_curso>1) {
		echo "<td style='background-color:#efeefd' class='no_imprimir' nowrap>";
		if (!($promociona =='') and !($promociona == '0')) {
		for ($i=1;$i<4;$i++){	
		echo '<input type="radio" name = "promociona-'. $id .'" value="'.$i.'"';
					if($promociona == $i){echo " checked";}
		echo " />&nbsp;&nbsp;";
		}
		}
		else{
	$val_notas="";
	$not = mysql_query("select notas3, notas4 from notas, alma where alma.claveal1=notas.claveal and alma.claveal='".$claveal."'");
	$nota = mysql_fetch_array($not);
	$tr_not = explode(";", $nota[0]);
	
	foreach ($tr_not as $val_asig) {
		$tr_notas = explode(":", $val_asig);
		foreach ($tr_notas as $key_nota=>$val_nota) {
			if($key_nota == "1" and ($val_nota<'347' and $val_nota !=="339" and $val_nota !=="") or $val_nota == '397' ){
			$val_notas=$val_notas+1;
		}
		}
	}
	
	$tr_not2 = explode(";", $nota[1]);
		foreach ($tr_not2 as $val_asig) {
		$tr_notas = explode(":", $val_asig);
		foreach ($tr_notas as $key_nota=>$val_nota) {
			if($key_nota == "1" and ($val_nota<'347' and $val_nota !=="339" and $val_nota !=="") or $val_nota == '397' ){
			$val_notas=$val_notas+1;
		}
		}
		
	}
	// Junio
	if (date('m')>'05' and date('m')<'09'){
	if ($val_notas<3) {$promociona="1";}
	echo "<span class='muted'> $val_notas&nbsp;</span>";
	for ($i=1;$i<4;$i++){
	echo '<input type="radio" name = "promociona-'. $id .'" value="'.$i.'" ';
					if($promociona == $i){echo " checked";}
	echo " />&nbsp;&nbsp; ";	
	}
	}
	// Septiembre
	elseif (date('m')=='09'){
	if ($val_notas>2) {$promociona="3";}else{$promociona="1";}
	echo "<span class='muted'> $val_notas&nbsp;</span>";
	for ($i=1;$i<4;$i++){
	echo '<input type="radio" name = "promociona-'. $id .'" value="'.$i.'" ';
					if($promociona == $i){echo " checked";}
	echo " />&nbsp;&nbsp;";	
	}
	}
	}
	echo "</td>";
	}
echo '<td class="no_imprimir"><input name="revisado-'. $id .'" type="checkbox" value="1"';
 if($revisado=="1"){echo " checked";} 
 echo ' /></td>';
 echo "<td class='no_imprimir'>";
 if ($respaldo=='1') { 
 	echo $backup;
 }
 echo "</td><td class='no_imprimir'>";
 echo "<a href='consultas.php?borrar=1&id=$id&curso=$curso&consulta=1'><i class='icon icon-trash' rel='Tooltip' title='Eliminar alumno de la tabla'> </i></a>";
 echo "</td>";
echo "<td class='no_imprimir'>";
// Problemas de Convivencia
if($n_fechorias >= 15){ echo "<a href='../fechorias/fechorias.php?claveal=$claveal&submit1=1' target='blank'><span class='badge badge-important'>$n_fechorias</span></a>";}
elseif($n_fechorias > 4 and $n_fechorias < 15){ echo "<a href='../fechorias/fechorias.php?claveal=$claveal&submit1=1' target='blank'><span class='badge badge-warning'>$n_fechorias</span></a>";}
elseif($n_fechorias < 5 and $n_fechorias > 0){ echo "<a href='../fechorias/fechorias.php?claveal=$claveal&submit1=1' target='blank'><span class='badge badge-info'>$n_fechorias</span></a>";}
// Fin de Convivencia.
echo "</td>";

	echo '
	</tr>';	
}
}
echo "</table>";
echo "<div align='center'>
<input type='hidden' name='extra' value='$extra' />
<input type='submit' name='enviar' value='Enviar datos' class='btn btn-primary no_imprimir' /><br><br><input type='submit' name='imprimir' value='Imprimir'  class='btn btn-success no_imprimir' />&nbsp;&nbsp;<input type='submit' name='caratulas' value='Imprimir Carátulas' class='btn btn-success no_imprimir' />&nbsp;&nbsp;<input type='submit' name='cambios' value='Ver cambios en datos' class='btn btn-warning no_imprimir' />&nbsp;&nbsp;<input type='submit' name='sin_matricula' value='Alumnos sin matricular' class='btn btn-danger no_imprimir' />";
if(count($grupo_actua)=='1'){ echo "<input type='hidden' name='grupo_actual' value='$grupo_actua' />&nbsp;&nbsp;<input type='submit' name='listados' value='Listado en PDF' class='btn btn-inverse no_imprimir' />";} else{ echo "&nbsp;&nbsp;<input type='submit' name='listado_total' value='Listado PDF total' class='btn btn-inverse no_imprimir' />";} 
echo "</div></form>";
echo count($grupo_actua);
?>
<?
if ($curso) {
		if (count($grupo_actua)=='1') {
			$extra = "and grupo_actual = '$grupo_actual'";
		}
		else{
			$extra="";	
		}
if ($curso=="1ESO" OR $curso=="2ESO"){
	$exen = mysql_query("select exencion from matriculas where curso = '$curso' $extra and exencion ='1'");
	$num_exen = mysql_num_rows($exen);
	
if ($curso=="1ESO"){$num_acti = "5";}else{$num_acti = "4";}
for ($i=1;$i<$num_acti+1;$i++){
	${acti.$i} = mysql_query("select act1 from matriculas where curso = '$curso' $extra and act1 = '$i'");
	${num_act.$i} = mysql_num_rows(${acti.$i});
}
}
$rel = mysql_query("select religion from matriculas where curso = '$curso' $extra and religion like '%Católica%'");
//echo "select religion from matriculas where curso = '$curso' and grupo_actual = '$grupo_actual' and religion like 'Rel%'";
$num_rel = mysql_num_rows($rel);
//echo $num_rel;
if ($curso=="3ESO"){$num_opta = "7";}else{$num_opta = "4";}
for ($i=1;$i<$num_opta+1;$i++){
	${opta.$i} = mysql_query("select optativa$i from matriculas where curso = '$curso' $extra and optativa$i = '1'");
	${num_opta.$i} = mysql_num_rows(${opta.$i});
}

if ($curso=="3ESO" OR $curso=="4ESO"){
	$diver = mysql_query("select diversificacion from matriculas where curso = '$curso' $extra and diversificacion = '1'");
	$num_diver = mysql_num_rows($diver);
}
$promo = mysql_query("select promociona from matriculas where curso = '$curso' $extra and promociona = '1'");
$num_promo = mysql_num_rows($promo);
	
$pil = mysql_query("select promociona from matriculas where curso = '$curso' $extra and promociona = '2'");
$num_pil = mysql_num_rows($pil);
	
$an_bd = substr($curso_actual,0,4);
$repit = mysql_query("select * from matriculas_bach, ".$db.$an_bd.".alma where ".$db.$an_bd.".alma.claveal = matriculas_bach.claveal and matriculas_bach.curso = '$curso' and ".$db.$an_bd.".alma.unidad like '$n_curso%'");
$num_repit = mysql_num_rows($repit);
?>
<br />
<table class="table table-striped table-bordered" align="center" style="width:auto">
<tr>
<? 
echo "<th>Religión</th>";
if ($curso=="1ESO" OR $curso=="2ESO"){
	echo "<th>Exención</th>";
}
if ($curso=="3ESO" OR $curso=="4ESO"){
	echo "<th>Diversificación</th>";
}
if ($curso=="3ESO"){$num_opta = "7";}else{$num_opta = "4";}
for ($i=1;$i<$num_opta+1;$i++){
	echo "<th>Optativa$i</th>";
}
if ($curso=="1ESO" or $curso=="2ESO"){
	$num_acti = "5";
	for ($i=1;$i<$num_acti+1;$i++){
	echo "<th>Act$i</th>";
}
}

echo "<th>Promociona</th>";
echo "<th>PIL</th>";
echo "<th>Repite</th>";
?>
</tr>
<tr>
<? 
echo "<td>$num_rel</td>";
if ($curso=="1ESO" OR $curso=="2ESO"){
	echo "<td>$num_exen</td>";
}
if ($curso=="3ESO" OR $curso=="4ESO"){
	echo "<td>$num_diver</td>";
}
if ($curso=="3ESO"){$num_opta = "7";}else{$num_opta = "4";}
for ($i=1;$i<$num_opta+1;$i++){
	echo "<td>${num_opta.$i}</td>";
}
if ($curso=="1ESO" OR $curso=="2ESO"){
if ($curso=="1ESO"){$num_acti = "5";}else{$num_acti = "5";}
for ($i=1;$i<$num_acti+1;$i++){
	echo "<td>${num_act.$i}</td>";
}
}
echo "<td>$num_promo</td>";
echo "<td>$num_pil</td>";
echo "<td>$num_repit</td>";
?>
</tr>
</table>
<?
}
?>

<br />
<table class="table table-striped table-bordered no_imprimir" align="center" style="width:auto"><tr>
<td>
<?
if ($curso=="4ESO") {

	for ($i=1;$i<$num_opt;$i++){	
	$nombre_optativa = "";
	$nom_opt.= "<span style='font-weight:bold;color:#9d261d;'>Itinerario $i: </span>";
	foreach (${opt4.$i} as $nombre_opt => $valor){
		
	$nombre_optativa=$nombre_optativa+1;
	$nom_opt.="<span style='color:#08c;'>Opt".$nombre_optativa."</span> = ".$valor."; ";
}
//echo substr($nom_opt,0,-2);
$nom_opt.= "<br>";
	}
	
		}
else{
	foreach (${opt.$n_curso} as $nombre_opt => $valor){
	$nombre_optativa=$nombre_opt+1;
	$nom_opt.="<span style='color:#08c;'>Opt".$nombre_optativa."</span> = ".$valor."; ";
}
}
echo substr($nom_opt,0,-2);
?>
</td></tr></table>
<?
if ($n_curso<3){
	echo '<table class="table table-striped table-bordered no_imprimir" align="center" style="width:auto"><tr>
<td>';
	foreach (${a.$n_curso} as $nombre_a => $valora){
	$nombre_act=$nombre_a+1;
	$nom_a.="<span style='color:#08c;'>Act ".$nombre_act."</span> = ".$valora."; ";
}
echo substr($nom_a,0,-2).'</td></tr></table>';
}
}
	}
	}
?>
</div>
 <? include("../../pie.php"); ?>
</body>
</html>
