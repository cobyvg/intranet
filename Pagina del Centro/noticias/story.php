<?  include("../conf_principal.php"); ?>
<?  include("../cabecera.php"); ?>
<?  include("../menu.php"); ?>
<?
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
?>
<div class="span9">
<br>
<div class="span10 offset1">
<h3 align="center"><i class='icon icon-list-alt'> </i> Notas, Noticias, Novedades ...</h3>
<hr />
		  <?
// includes
include("../conf_principal.php");
include("../funciones.php");

mysql_connect($host, $user, $pass) or die ("Imposible conectar!");

mysql_select_db($db) or die ("Imposible seleccionar base de datos!");

$query = "SELECT slug, content, contact, timestamp FROM noticias WHERE id = '$id' and pagina != '1'";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

$row = mysql_fetch_object($result);

if ($row)
{

?>
  <p class="lead text-info"><? print $row->slug; ?></p>
  <hr />
  <blockquote><? print stripslashes($row->content);?></blockquote>    
  <footer class="footer well well-small">                                      
  <p class="muted">Publicada el <? echo formatea_fecha($row->timestamp); ?>.</p>
  </footer>
    <?
}
else
{
?>
  <div class="alert alert-warning" style="width:500px;margin:auto;"><p>Lo sentimos, pero esa noticia no se encuentra en la base de datos.</p></div>
  <?
}
?>
</div>
</div>
<?  include ("../pie.php"); ?>

