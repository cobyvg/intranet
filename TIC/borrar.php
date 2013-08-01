<?
session_start();
include("../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<html>
<head>
<title>Páginas TIC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">
</head>
<body>
<?
include("../menu.php");
include("menu.php");
?>
<div align=center>
  <div class="page-header" align="center">
  <h2>Centro TIC <small> Borrar incidencia</small></h2>
</div>
<br />
<?
// base de datos.
 

		$borrar = "DELETE FROM `partestic` WHERE `parte` = $parte";
		//echo $borrar;
		$result1 = mysql_query($borrar);
		if($result1 == "1")
		{
echo '<br /><div align="center"><div class="alert alert-success alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
Los datos de la incidencia se han borrado correctamente.
		</div></div>';
		}


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
