<?
session_start();
include("../../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Generator" content="Dev-PHP 1.9.4">
<title>Grabar Nuevo Enlace</title>
<link href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css" media="screen" />
<style>
td {text-align:center;}
</style>
</head>

<body>
  <?php
include("../../../menu.php");
include("../mrecursos.php");?>
<div class='titulogeneral' style="margin-top:0px">Enlaces y Marcadores: Nuevo registro</div>	
<?php
$categoria=$_POST['cat'];
$apartado=$_POST['apart'];
$nombre=$_POST['nombre'];
$http=$_POST['http'];
$coment=$_POST['descripcion'];
$base=$db;
$tabla="direcciones";

$a=strlen($categoria);
$b=strlen($apartado);
$c=strlen($nombre);
$d=strlen($http);
$e=strlen($coment);
if ($a==0 or $b==0 or $c==1 or $d==1 or $e==1)
{
 echo "<table width='300' class='tabla' align='center'><TR>
<td id=filaprincipal> MENSAJE DE ERROR</td></TR> <TR>
<td>Has dejado algún campo vacío. Vuelve atrás y
comprueba que todos los campos están rellenos.</td></TR>
</table>";
 }
else {
 
$c=mysql_connect ($db_host, $db_user, $db_pass) or die("Imposible conectar");
mysql_select_db($base,$c) or die ("Imposible seleccionar base de datos!");
mysql_query("INSERT $tabla (categoria,apartado,nombre,http,comentario)
VALUES ('$categoria','$apartado','$nombre','$http','$coment')",
$c);
 if (mysql_errno($c)==0){
 echo "<table width='300' class='tabla' align='center'><tr>
<td id=filaprincipal> TU ENLACE HA SIDO GUARDADO.</td></tr> <TR>
<td>Si deseas grabar otro enlace
<a href='http://<? echo $dominio; ?>/intranet/admin/favoritos/index.php' target='_top'>
 PULSA AQUÍ</a></td></tr>
</table>"; 
             }
			 else{
        if (mysql_errno($c)==1062){echo "<h2>No ha podido añadirse el registro</h2>";
            }else{
            $numerror=mysql_errno($c);
            $descrerror=mysql_error($c);
            echo "Se ha producido un error nº $numerror que corresponde a: $descrerror  <br>";
        }
 }
mysql_close();
 }

?>
</body>
</html>
