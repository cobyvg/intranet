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

$pr = $_SESSION['profi'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<LINK href="http://<? echo $dominio; ?>/<? echo $css1; ?>" rel="stylesheet" type="text/css">
<LINK href="http://<? echo $dominio; ?>/<? echo $css2; ?>" rel="stylesheet" type="text/css">

<title>Centro de Mensajes</title>
</head>

<body bgcolor="#FFFFFF">
<? 
?>

<div style="width:98%;">
<?
include("../../menu.php");
?>
<div class="titulogeneral">Mensajes de Tutoría</div>
</div>
<?
 
mysql_connect($db_host, $db_user, $db_pass) or die ("Imposible conectar!");
mysql_select_db($db) or die ("Imposible seleccionar base de datos!");
$query = "SELECT ahora, asunto, texto FROM mensajes where id = '$id'";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$row = mysql_fetch_array($result);

if ($row)
{?>
<?
echo "<div align='CENTER'> <table class='tabla' style='width:800px;'>
            <tr valign=Top> 
            <td id='filaprincipal' style='line-height:22px;text-align:center;font-size:1.1em;'>$row[1]
				</td>
              </tr>
           <tr> 
            <td style='padding:10px;'><span class='textonoticia' style='font-size:1.0em'>$row[2]</span>";
echo '<div align="left" style="margin-top:12px;"><a href="../mensajes/index.php?padres=1&asunto='.$row[1].'&origen='.$alumno.'" target="_top" style="padding:2px 10px; border:1px solid #ccc;background-color:#555;color:white;font-size:10px;">Responder</a></div>';
echo "</td>
             </tr>
         <tr>";
		 ?>
            <td style='padding:10px;' colspan=2>Alumno: <span style="color:#281"><? echo $alumno; ?></span> <br />Enviada: <span style="color:#281"><? echo fecha_actual($row[0]); ?></span>
              </td></tr>
              <tr><td colspan="2" style=" background-color:#eeffef"><div align="center" style="padding:4px;"><input type="button" value="Volver al resumen de Tutoría" style="padding:4px;font-size:1.1em;" onclick="history.back(1)"></div></td>
              </tr>
              </table></div>
							 
  <?
}
else
{
?>
<p>El Mensaje no se encuentra en la base de datos.</p>
<?
}

// close database connection

?>
</body>
</html>
