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
include_once("../../funciones.php");
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
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css"> 
  </head>  
  <body>
<div style="width:900px;margin:auto;">
     <?php
     
if(isset($_GET['todos'])){$todos = $_GET['todos'];}
if(isset($_GET['claveal'])){$claveal = $_GET['claveal'];}else{$claveal = $_POST['claveal'];}
if(isset($_GET['nivel'])){$nivel = $_GET['nivel'];}else{$nivel = $_POST['nivel'];}
if(isset($_GET['grupo'])){$grupo = $_GET['grupo'];}else{$grupo = $_POST['grupo'];}
if(isset($_POST['c_escolar'])){$c_escolar = $_POST['c_escolar'];}else{ $c_escolar=""; }
if(isset($_POST['nombre'])){$nombre = $_POST['nombre'];}else{ $nombre=""; }
if(isset($_POST['fecha1'])){$fecha1 = $_POST['fecha1'];}else{ $fecha1=""; }
if(isset($_POST['fecha2'])){$fecha2 = $_POST['fecha2'];}else{ $fecha2=""; }
if(isset($_POST['faltas'])){$faltas = $_POST['faltas'];}else{ $faltas=""; }
if(isset($_POST['faltasd'])){$faltasd = $_POST['faltasd'];}else{ $faltasd=""; }
if(isset($_POST['fechorias'])){$fechorias = $_POST['fechorias'];}else{ $fechorias=""; }
if(isset($_POST['notas'])){$notas = $_POST['notas'];}else{ $notas=""; }
if(isset($_POST['tutoria'])){$tutoria = $_POST['tutoria'];}else{ $tutoria=""; }
if(isset($_POST['horarios'])){$horarios = $_POST['horarios'];}else{ $horarios=""; }
if(isset($_POST['act_tutoria'])){$act_tutoria = $_POST['act_tutoria'];}else{ $act_tutoria=""; }



if (!($c_escolar==$curso_actual)) {
$an=explode("/",$c_escolar);
$c_db=$an[0]+1;
$base=$db.$c_db;	
mysql_select_db($base);
}
  if ($claveal) {
  	 $SQL1 = "select distinct alma.apellidos, alma.nombre, alma.nivel, alma.grupo, alma.claveal, claveal1 from alma
  where claveal = '$claveal' order BY alma.apellidos";
  // print ("$AUXSQL");
  $result1= mysql_query($SQL1);
  if ($row1 = mysql_fetch_array($result1))
  {
  $claveal = $row1[4];
  $nivel = $row1[2];
  $grupo = $row1[3];
  $claveal1 = $row1[5];
	$apellido = $row1[0];
	$nombrepil = $row1[1];
    } 
  }
 
    
$clave = explode(" --> ", $nombre);
if(!($claveal)){
$claveal = $clave[1];
$nombrealumno = explode(",",$clave[0]);
$apellidos = $nombrealumno[0];
$nombrepila = $nombrealumno[1];
$apellido = trim($apellidos);
$nombrepil = trim($nombrepila);
} 

if (!($c_escolar==$curso_actual)) {
    mysql_select_db($db);
    		}
    echo '<div align="center">
<div class="page-header" align="center">
  <h2>Informe del alumno <small>'. $nombrepil.' '. $apellido.' ('.$nivel.'-'.$grupo,')</small></h2>
</div>
<br />
</div>';		

$foto = '../../xml/fotos/'.$claveal.'.jpg';
	if (file_exists($foto)) {
		echo "<div class='well well-small' style='width:110px;margin:auto;'>";
		echo "<img src='$foto' border='2' width='100' height='119' class='img-polaroid'  />";
		echo "</div><br /><br />";
	}
	if (!($c_escolar==$curso_actual)) {
    mysql_select_db($base);
    		}

 $SQL2 = "select distinct alma.claveal, alma.DNI, alma.fecha, alma.domicilio, alma.telefono, alma.padre, alma.matriculas, telefonourgencia, paisnacimiento, correo, nacionalidad, edad from alma where alma.claveal= '$claveal' order BY alma.apellidos";
      //print ("$SQL2");
    $result2 = mysql_query($SQL2);
     if ($row2 = mysql_fetch_array($result2))
     {
    echo "<center><table class='table table-bordered' style='width:auto'>";
      do {
if($row2[6] > 1){  $repite = "SI";  }else{  $repite = "NO";  }
 echo "  <tr><th style='background-color:#fbfbfb'>CLAVE</th><td>$row2[0] </td><th style='background-color:#fbfbfb'>DNI</th><td>$row2[1] </td></tr>
	  <tr><th style='background-color:#fbfbfb'>FECHA</th><td>$row2[2] </td><th style='background-color:#fbfbfb'>DOMICILIO</th><td>$row2[3] </td></tr>
	  <tr><th style='background-color:#fbfbfb'>TELÉFONO</th><td>$row2[4] </td><th style='background-color:#fbfbfb'>TFNO. URGENCIAS</th><td>$row2[7] </td></tr>
	  <tr><th style='background-color:#fbfbfb'>CORREO</th><td>$row2[9] </td><th style='background-color:#fbfbfb'>TUTOR</th><td>$row2[5] </td></tr>
	  <tr><th style='background-color:#fbfbfb'>PAÍS NACIMIENTO</th><td>$row2[8] </td><th style='background-color:#fbfbfb'>NACIONALIDAD</th><td>$row2[10] </td></tr>
	  <tr><th style='background-color:#fbfbfb'>EDAD</th><td>$row2[11] </td><th style='background-color:#fbfbfb'>REPITE</th><td>$repite</td></tr>";
			      } while($row2 = mysql_fetch_array($result2));
			      echo "</table></center>";
			} else
			{
				echo '<div align="center"><div class="alert alert-warning alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
			<h5>ATENCIÓN:</h5>
No hay datos del Alumno durante el Curso escolar '.$c_escolar.'. ¿Has seleccionado alg&uacute;n alumno para ver su informe?
</div></div>';
exit;
    }
if ($faltas== "" and $todos == "")
{}
else
{
echo "<hr>";
include("faltas.php");
echo "";}

  if ($faltasd== "" and $todos == "")
  {}
  else
  {
include("faltasd.php");}

  if ($fechorias== "" and $todos == "")
  {}
  else
  {
echo "<hr>";
include("fechorias.php");
echo "";}

  if ($notas == "" and $todos == "")
  {}
  else
  {
echo "<hr>";
include("notas.php");
  echo "";}

  if ($tutoria== "" and $todos == "")
  {}
  else
  {
echo "<hr>";	  
include("tutoria.php");
echo "";}
  
  if ($horarios== "" and $todos == "")
  {}
  else
  {
echo "<hr>";  
include("horarios.php");
echo "";}

  if ($act_tutoria== "" and $todos == "")
  {}
  else
  {
  	$tutori = $_SESSION['profi'];
  	$activ = mysql_query("select * from FTUTORES where tutor='$tutori' and nivel = '$nivel' and grupo = '$grupo'");
  	if (mysql_num_rows($activ) > 0 OR stristr($_SESSION['cargo'],'1') == TRUE) {
  	  	echo "<hr>";
		include("act_tutoria.php");	
  	}
echo "<br>";}
?>
</div>
<? include("../../pie.php");?>

</BODY>
</HTML>
