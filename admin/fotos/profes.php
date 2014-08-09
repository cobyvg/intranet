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
    <link href="http://<? echo $dominio;?>/intranet/css/otros.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://<? echo $dominio;?>/intranet/css/datepicker.css" rel="stylesheet">
    <link href="http://<? echo $dominio;?>/intranet/css/DataTable.bootstrap.css" rel="stylesheet">
    
    <link href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css" rel="stylesheet" >
    
    <!--[if lt IE 9]>
      <script src="http://<? echo $dominio;?>/intranet/js/html5shiv.js"></script>
    <![endif]-->
    
    <link href="http://<? echo $dominio;?>/intranet/css/imprimir.css" rel="stylesheet" media="print">
  </head>  
  <body> 
  <?
  include '../../menu.php';
  ?>
  <div align="center">
<?
if(isset($_POST['ver_todos'])){
?>
 <br />
     <div align=center>
  <div class="page-header">
  <h2><? echo $nombre_del_centro;?> <small><br />Claustro de Profesores <? echo " ($curso_actual)";?></small></h2>
</div>
<?
$dep0=mysql_query("select distinct departamento from departamentos where departamento not like 'Administracion' and departamento not like 'ADMIN' and departamento not like 'Conserjeria' order by departamento");
while ($dep = mysql_fetch_array($dep0)) {
	$n_dep = "";
	$gr0=mysql_query("select idea, nombre from departamentos where departamento = '$dep[0]'");
	$n_dep = mysql_num_rows($gr0);	
if ($n_dep<7) {
			$ancho = $n_dep*120;
		}
		else{
			$ancho = "720";
		}
$num="";

echo "<h3 style='margin-top:10px;'>";
if ($dep[0]=="Administracion" or $dep[0]=="ADMIN" or $dep[0]=="Conserjeria") {
	echo $dep[0];
}
else{
echo "Departamento de $dep[0]";	
}

echo "</h3><br />";
echo "<table class='table table-condensed table-bordered' style='width:".$ancho."px;'>";
	$gr=mysql_query("select idea, nombre from departamentos where departamento = '$dep[0]'");
	while ($al_gr=mysql_fetch_array($gr)) 
	{	
	$num=$num+1;
	if($num=="1" or $num=="7" or $num=="13"){echo "<tr>";}	
		$idea=$al_gr[0];
				$n_profe = $al_gr[1];
		echo "<td style='width:150px;' ><div style='float:left;padding:3px;'><img src='../../xml/fotos_profes/".$idea.".jpg' width='100' height='119' /><br><div style=font-size:8px;text-align:center;>$n_profe</div></div></td>";
				if($num=="6" or $num=="12"){echo "</tr>";}	
}
echo "</table>";
echo "<hr style='width:720px'>";
}
}
?>
</div></body></html>