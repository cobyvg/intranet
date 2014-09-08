<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if(!(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'2') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}
if (isset($_POST['nivel'])) {
	$nivel = $_POST['nivel'];
} 
elseif (isset($_GET['nivel'])) {
	$nivel = $_GET['nivel'];
} 
else
{
$nivel="";
}
if (isset($_POST['unidad'])) {
	$unidad = $_POST['unidad'];
} 
elseif (isset($_GET['unidad'])) {
	$unidad = $_GET['unidad'];
} 
else
{
$unidad="";
}

if (isset($_POST['claveal'])) {
	$claveal = $_POST['claveal'];
}
elseif (isset($_GET['claveal'])) {
	$claveal = $_GET['claveal'];
} 
else
{
$claveal="";
}
if (isset($_POST['tutor'])) {
	$tutor = $_POST['tutor'];
}
elseif (isset($_GET['tutor'])) {
	$tutor = $_GET['tutor'];
} 
else
{
$tutor="";
}

if(isset($_GET['imprimir']) and $_GET['imprimir'] == "si")
{
	include("cert_pdf.php");
	exit;
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
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">   
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
    <link href="http://<? echo $dominio;?>/intranet/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet">  
    <link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css"> 
    <SCRIPT LANGUAGE=javascript>

function wait(){
string="document.forms.libros.submit();";
setInterval(string,540000);
}

</SCRIPT>
  </head>  
<body onload=wait()>
<?
include("../../menu.php");

$lista = mysql_list_fields($db,"textos_alumnos");
$col_curso = mysql_field_name($lista,6);
if ($col_curso=="curso") { }else{
	mysql_query("ALTER TABLE  `textos_alumnos` ADD  `curso` VARCHAR( 7 ) NOT NULL ");
}
?>

<div class="container">
<div class="page-header">
  <h2>Programa de Ayudas al Estudio <small>Informe sobre el estado de los Libros</small></h2>
  <h3 class="text-info"><? echo $nivel;?></h3>
</div>
<br />
<?
$tarari="";
foreach($_POST as $key0 => $val0)
{
if(strlen($val0) > "0"){$tarari=$tarari+1;}
}
if($tarari>"0"){
foreach($_POST as $key => $val)
{
//	echo "$key --> $val <br>";
$trozos = explode("-",$key);
$claveal = $trozos[0];
if($val == "B" or $val == "R" or $val == "M" or $val == "N" or $val == "S"){$asignatura = $trozos[1];$fila_asig = $fila_asig + "1";}

if(is_numeric($claveal) and ($val == "B" or $val == "R" or $val == "M" or $val == "N" or $val == "S"))
{
		$query = "select estado from textos_alumnos where claveal = '$claveal' and materia = '$asignatura' and curso = '$curso_actual'";
		//echo $query;
		$edit = mysql_query($query);
		$estado0 = mysql_fetch_array($edit);
		$estado = $estado0[0];
		if(strlen($estado) > 0){
		mysql_query("update textos_alumnos set estado = '$val' where claveal = '$claveal' and materia = '$asignatura'");		
		}
		else{
		mysql_query("insert into textos_alumnos (claveal, materia, estado, fecha,curso) values ('$claveal','$asignatura','$val',now(),'$curso_actual')");
		}
}
}
if(isset($_POST['procesar']) and $_POST['procesar'] == "Enviar"){
	echo '<div align="center"><div class="alert alert-success alert-block fade in">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos se han actualizado correctamente en la base de datos.
</div></div><br />';
}
}
$claveal = "";
?>
<form action="libros.php" method="post" name="libros" class="formu">
<p class="help-block">OPCIONES: <span class="label label-info">B</span> = Bien, <span class="label label-warning">R</span> = Regular, <span class="label label-danger">M</span> = Mal, <span class="label label-default">N</span> = No hay Libro, <span class="label label-success">S</span> = Septiembre.</p>
<?
$curso = $nivel;
//$fila_asig = $fila_asig + 1;

echo "<br /><table class='table table-bordered'>";

if(stristr($_SESSION['cargo'],'1') == TRUE){
echo "<thead><tr><th></th>";
}
$asignaturas0 = "select distinct nombre, codigo, abrev from asignaturas where (curso like '".$curso."') and abrev not like '%\_%' and nombre in (select distinct materia from textos_gratis where textos_gratis.nivel = '".$curso."') order by codigo";
//echo $asignaturas0;
$num_col = 1;
$asignaturas1 = mysql_query($asignaturas0);
$num_asig = mysql_num_rows($asignaturas1);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	
	$col{$num_col} = $asignaturas[1];
	echo "<th>$asignaturas[2]</th>";
	$num_col = $num_col + 1;
}
if(!(empty($unidad))){
	$extra=" and FALUMNOS.unidad = '$unidad'";
	$un = mysql_query("select distinct alma.curso from alma where unidad = '$unidad'");
	$cur = mysql_fetch_array($un);
	$nivel = $cur[0];
	$curso = $nivel;
	$fila=1;
}
if(stristr($_SESSION['cargo'],'1') == TRUE){
	$jefe=1;
	$fila=0;
	echo "<th>Estado</th></tr></thead><tbody>";
}

$alumnos0 = "select nc, FALUMNOS.apellidos, FALUMNOS.nombre, combasi, FALUMNOS.claveal, FALUMNOS.unidad from FALUMNOS, alma where alma.claveal = FALUMNOS.claveal and alma.curso = '$nivel' $extra order by FALUMNOS.apellidos, FALUMNOS.nombre, nc"; 
//echo $alumnos0;
$fila_asig=0;
$alumnos1 = mysql_query($alumnos0);
while ($alumnos = mysql_fetch_array($alumnos1)) {
	if(empty($jefe)){$nc="$alumnos[0]. $alumnos[1], $alumnos[2]";}else{$nc="$alumnos[1], $alumnos[2] ($alumnos[5])";}
	
	$fila_asig+=1;
	if(stristr($_SESSION['cargo'],'1') == TRUE){}else{}
	if($fila_asig == $fila or $fila_asig == "5" or $fila_asig == "10" or $fila_asig == "15" or $fila_asig == "20" or $fila_asig == "25" or $fila_asig == "30" or $fila_asig == "35" or $fila_asig == "40")
{
echo "</thead><tbody><tr><td style='background-color:#eee'></td>";
$asignaturas0 = "select distinct nombre, codigo, abrev from asignaturas where curso like '".$curso."' and abrev not like '%\_%' and nombre in (select distinct materia from textos_gratis where textos_gratis.nivel = '".$curso."') order by codigo";
// echo $asignaturas0."<br>";
$num_col = 1;
$asignaturas1 = mysql_query($asignaturas0);
$num_asig = mysql_num_rows($asignaturas1);
while ($asignaturas = mysql_fetch_array($asignaturas1)) {	
	$col{$num_col} = $asignaturas[1];
	echo "<th style='background-color:#eee'>$asignaturas[2]</th>";
	$num_col = $num_col + 1;
}
if(stristr($_SESSION['cargo'],'1')){$extra=" order by apellidos";}else{$extra=" and FALUMNOS.unidad = '$unidad' order by nc";}
if(stristr($_SESSION['cargo'],'1')){echo "<th style='background-color:#eee'>Estado</th></tr>";}
}

	echo "<tr><td>$nc";
$clave = $alumnos[4];
   	$foto = '../../xml/fotos/'.$clave.'.jpg';
	if (file_exists($foto)) {
		echo "<br /><img class='img-thumbnail' src='../../xml/fotos/$clave.jpg' width='64' alt=''>";
	}           	
	echo "</td>";
	for ($i=1;$i<$num_asig+1;$i++){
		echo "<td nowrap>";
		//echo $col{$i}."-";
		if(strstr($alumnos[3], $col{$i}))
		{
		$r_nombre = $alumnos[4]."-".$col{$i};
		$trozos = explode("-",$r_nombre);
		$claveal = $trozos[0];
		$asignatura = $trozos[1];
		$query = "select estado from textos_alumnos where claveal = '$claveal' and materia like '$asignatura' and curso = '$curso_actual'";
		//echo $query;
		$edit = mysql_query($query);
		$estado0 = mysql_fetch_array($edit);
		$estado = $estado0[0];
?>
	<div class="radio">
		<label style="color:black;">
    	<input type="radio" name="<? echo $r_nombre;?>" <? echo "checked=\"checked\""; ?> value="N" id="botones_3" /> <span class="label label-default">N</span>
    </label>
  </div>
  <div class="radio">
    <label style="color:#3a87ad;">
    	<input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "B"){echo "checked=\"checked\"";} ?> value="B" id="botones_0" /> <span class="label label-info">B</span>
    </label>
  </div>
  <div class="radio">
    <label style="color:#f89406;">
   	 <input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "R"){echo "checked=\"checked\"";} ?> value="R" id="botones_1" /> <span class="label label-warning">B</span>
   	</label>
  </div>
  <div class="radio">
    <label style="color:#9d261d;">
    	<input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "M"){echo "checked=\"checked\"";} ?> value="M" id="botones_2" /> <span class="label label-danger">B</span>
    </label>
  </div>
  <div class="radio">
    <label style="color:#46a546;">
    	<input type="radio" name="<? echo $r_nombre;?>" <? if($estado == "S"){echo "checked=\"checked\"";} ?> value="S" id="botones_4" /> <span class="label label-success">B</span>
    </label>
  </div>
    	
<?
//			echo $col{$i};
		}
		echo "</td>";
		
	}
	
		$query2 = "select devuelto from textos_alumnos where claveal = '$claveal' and curso = '$curso_actual'";
		$edit2 = mysql_query($query2);
		$estado2 = mysql_fetch_array($edit2);
		$estadoP = $estado2[0];
	if(stristr($_SESSION['cargo'],'1'))
	{
				echo '<td>';

?>
<a  href="libros.php?claveal=<? echo $claveal;?>&imprimir=si&nivel=<? echo $nivel;?>" class="btn btn-primary btn-block" target="_blank"><i class="fa fa-print " title="imprimir"> </i></a> <br><br>
<?
	if($estadoP == "1" ){ echo '<button class="btn btn-success"><i class="fa fa-check " title="Devueltos"> </i> </button>';}
	echo "</td>";
	}

echo "</tr>";
	}
echo "</table>";
?>
<br />
<input type="hidden" name="nivel" value="<? echo $nivel;?>" />
<input type="hidden" name="grupo" value="<? echo $grupo;?>" />
<input type="submit" name="procesar" value="Enviar" class="btn btn-primary btn-large" />
</form>
</div>
<? include("../../pie.php");?>		
</body>
</html>