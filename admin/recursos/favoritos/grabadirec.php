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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="stylesheet" href="http://<? echo $dominio; ?>/<? echo $css1; ?>">
<link rel="stylesheet" href="http://<? echo $dominio; ?>/<? echo $css2; ?>">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Generator" content="Dev-PHP 1.9.4">
<title>Grabar enlace en base de datos</title>
</head>
<body>
  <?php
include("../../menu.php");
echo "<br>";
?>	
<br><br>

<?php
$categoria=$_POST['cat'];
$apartado=$_POST['apart'];
$nombre=$_POST['nombre'];
$http=$_POST['http'];
$coment=$_POST['descripcion'];
$base="faltas";
$tabla="direcciones";

$a=strlen($categoria);
$b=strlen($apartado);
$c=strlen($nombre);
$d=strlen($http);
$e=strlen($coment);
if ($a==0 or $b==0 or $c==1 or $d==1 or $e==1)
{echo"<table align=center border=1  bgcolor='#F0FFFF'>";
echo"<td> <font size='3'> <center> MENSAJE DE ERROR </TD> <TR>";
echo " <td> <font size='2'> Ha dejado algún campo vacío, vuelva hacia atrás y
compruebe que todos los campos están rellenos.</font></td>";
echo "</table>"; }
else {
 
$c=mysql_connect ($db_host, $db_user, $db_pass) or die("Imposible conectar");
mysql_select_db($base,$c) or die ("Imposible seleccionar base de datos!");
mysql_query("INSERT $tabla (categoria,apartado,nombre,http,comentario)
VALUES ('$categoria','$apartado','$nombre','$http','$coment')",
$c);
 if (mysql_errno($c)==0){echo"<table align=center border=1  bgcolor='#F0FFFF'>";
echo"<td> <font size='3'> <center> SU ENLACE HA SIDO GUARDADO </TD> <TR>";
echo " <td> <font size='2' color='#FF0000'> Si desea grabar otro enlace
<a href='http://<? echo $dominio; ?>/intranet/admin/favoritos/index.php' target='_top' class='content'>
 PULSE AQUÍ</font></td>";
echo "</table>";
             }else{
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
