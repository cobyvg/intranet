

<legend class="muted">Notas, Noticias, Novedades ...</legend>
<?
include("destacados.php");
?>
			<?
// Consulta
$n_n = 9 - $n_fijas;
$query = "SELECT id, slug, timestamp, content FROM noticias where fechafin <= '$hoy' and pagina like '%2%' ORDER BY timestamp DESC LIMIT 0, $n_n";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

if (mysql_num_rows($result) > 0)
{
	while($row = mysql_fetch_object($result))
	{
	?>
<blockquote><a href="noticias/story.php?id=<? echo $row->id; ?>"><? echo $row->slug; ?></a>
<small><? echo fecha_actual2($row->timestamp); ?>.</small> </blockquote> 
                          <? 
	}	
}
?>
<hr />   
 <form class="form-search" action="noticias/buscar.php">       
<a href="noticias/list.php" class="btn btn-success">Más Noticias</a>
    <div class="input-append pull-right">
    <input class="span9 search-query" type="text" name="expresion" placeholder="Buscar en las Noticias" />
    <button type="submit" class="btn btn-success">Buscar</button>
  </div>
</form> 	
<br />
<? if ($monterroso==1) { ?>

<div class="well">
<a href="varios/erasmus.php"><img class="img-polaroid" src="./img/erasmus_charter.jpg" /></a> 
</div>		

<? } ?>
    


