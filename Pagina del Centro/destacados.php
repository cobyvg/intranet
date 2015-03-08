<?
require_once("funciones.php");

// Conexión a la Base de datos
mysql_connect($host,$user,$pass) or die ("Imposible conectar con la Base de Datos! Revisa los datos de acceso en el archivo conf_pricipal.php");
mysql_select_db($db) or die ("Imposible seleccionar base de datos! Revisa los datos de acceso en el archivo conf_pricipal.php");

$hoy = date('Y-m-d');
// Consulta
$query = "SELECT id, slug, timestamp, content, clase FROM noticias where fechafin > '$hoy' and pagina like '%2%'ORDER BY timestamp DESC";
//echo $query;
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());
$n_fijas = mysql_num_rows($result);

if ($n_fijas > 0)
{
?>
<div class="well" style="background-color:#d9edf7;border-color:#bce8f1">
<?
	while($row = mysql_fetch_object($result))
	{
	?>
<blockquote><a href="noticias/story.php?id=<? echo $row->id; ?>" style="color:#3a87ad;"><? echo $row->slug; ?></a>
<small><? echo fecha_actual2($row->timestamp); ?>.</small> </blockquote> 								
<?
	}	
echo "</div>";
}
?>
<br />	
