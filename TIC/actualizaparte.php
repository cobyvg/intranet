<?
session_start();
include("../config.php");
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


?>
<html>
<head>
<title>Página TIC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>

<?
include("../menu.php");
 
mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db);
?>
<div align=center>
<div class="page-header">
  <h2>Centro TIC <small> Actualizar incidencia</small></h2>
</div>
<br />
<?
	
// generate and execute query
$query = "UPDATE partestic SET unidad = '$unidad', carro = '$carrito', nserie = '$numeroserie', fecha = '$fecha', hora = '$hora', alumno = '$alumno', profesor = '$profesor', descripcion = '$descripcion', estado = '$estado', nincidencia = '$nincidencia' WHERE parte = '$parte'";
$result = mysql_query($query) or die ("Error en la actualización: $query. " . mysql_error());
if($result == "1")
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la incidencia se han cambiado correctamente.
		</div></div>';
?>
</div>
<script language="javascript">
<? 
// Redireccionamos al Cuaderno    
$mens = "clista.php";
?>
setTimeout("window.location='<? echo $mens; ?>'", 1500) 
</script>
</body>
</html>
