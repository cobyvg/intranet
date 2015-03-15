<?  include("../conf_principal.php"); ?>
<?  include("../cabecera.php"); ?>
<?  include("../menu.php"); ?>
<? include("../funciones.php"); ?>

<div class="span9">
<br>
<div class="span10 offset1">
<h3 align="center"><i class='icon icon-list-alt'> </i> Notas, Noticias, Novedades ...</h3><hr />
<p class="lead muted" style="display:inline">Registro de noticias en iesmonterroso.org
<form class="form-search pull-right" action="buscar.php">       
    <div class="input-append">
    <input class="search-query" type="text" name="expresion" placeholder="Buscar en las Noticias" />
    <button type="submit" class="btn btn-primary">Buscar</button>
  </div>
</form> 
</p>
<hr />	
<?
mysql_connect($host, $user, $pass) or die ("Imposible conectar!");
mysql_select_db($db) or die ("Imposible seleccionar base de adtos!");
if(!(isset($pag))) {$pag = "0";} else {$pag = $pag + 50;}
$query = "SELECT id, slug, timestamp, content FROM noticias where pagina like '%2%' ORDER BY timestamp DESC limit $pag,50";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

if (mysql_num_rows($result) > 0)
{
	echo '<TABLE class="table table-striped">';
	while($row = mysql_fetch_object($result))
	{	
	?>
          <TR> 
		<TD nowrap style="text-align:right;"><? echo fecha_sin($row->timestamp); ?></td>        
        <TD><a href="story.php?id=<? echo $row->id;?>">
	<? echo $row->slug; ?></a></td></TR>
	<?
	}
}
?>
</table>
<div align="center">
  <a href="list.php?pag=<? echo $pag;?>" class="btn btn-primary"><i class="icon icon-plus-sign icon-large"> </i> Siguientes 50 Noticias</a>
  </div><br />
</div>
</div>
<?  include("../pie.php"); ?>
