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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<title>Recursos Educativos</title>

<link href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>


  <?php
  include("../../../menu.php");
include("../mrecursos.php");
echo "<div class='titulin' style='margin-left:120px; color:#281;margin-top:0px;margin-bottom:15px;'>Marcadores, Enlaces, Favoritos...</div>";

?>
<div align="center">
  <?php
$categoria=$_POST['categ'];
$apartado=$_POST['apartado'];
$a=strlen($categoria);
$b=strlen($apartado);
if ($a==0 and $b==0 and empty($texto)){
 echo"<p id=texto>Debes seleccionar una categoría o introducir algún Texto como criterio de búsqueda.
</p>";
}
else{
echo "<input type='hidden' name='cat' value='$categoria'>";
echo "<input type='hidden' name='apart' value='$apartado'>";
$c=mysql_connect ($db_host, $db_user, $db_pass) or die("Imposible conectar");
mysql_select_db($db,$c) or die ("Imposible seleccionar base de datos!");

// Consulta


$query = "SELECT  nombre, comentario, http, categoria, apartado  FROM direcciones
 WHERE 1";
 if ($categoria and $apartado)
 {$query.= " and categoria = '$categoria' and apartado='$apartado'";}
  if($texto)
 {$query.=" and nombre like '%$texto%' or categoria like '%$texto%' or apartado like '%$texto%' or http like '%$texto%' or comentario like '%$texto%'";}
  $query.=" ORDER BY nombre asc";
$result = mysql_query($query,$c);
 // print $query;
// Si hay datos

if (mysql_num_rows($result) > 0)
{
 echo "<table class='tabla' cellspacing='2' width='80%'>";
echo "<tr><td id='filaprincipal'>NOMBRE</td>
<td id='filaprincipal'>CARACTERÍSTICAS DE LA WEB</td>
<td id='filaprincipal'>CATEGORÍA </td></tr>";
	while($row = mysql_fetch_object($result))
	{

   echo "<TR><TD><a href='$row->http' target='_blank'>$row->nombre </a></td>
    <td>$row->comentario</TD><td> $row->categoria <span style='color:#369'>($row->apartado)</span></td></TR>";
	}
	echo"</table>";
}
// Si no hay datos
else
{
?>
  <p id=texto>De momento, no hay enlaces disponibles en este apartado</p>
  .
  <?
}

// Cerrar conexión
mysql_close($c);
 }
 ?>

</div>
</body>
</html>
