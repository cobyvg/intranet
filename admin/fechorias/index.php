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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Problemas de Convivencia y Faltas de Disciplina.</title>
<link rel="stylesheet" href="http://<? echo $dominio; ?>/<? echo $css1; ?>">
<link rel="stylesheet" href="http://<? echo $dominio; ?>/<? echo $css2; ?>">


</head>

<body>
<?
include("../../menu.php");
echo "<br>";

include("menu.php");
echo "<br>";
?>
</body>
</html>
