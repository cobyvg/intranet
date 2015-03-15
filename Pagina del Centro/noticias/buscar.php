<?  include("../conf_principal.php"); ?>
<? include("../cabecera.php"); ?>
<? include("../menu.php"); ?>
<? include("../funciones.php"); ?>

<div class="span9">
<br>
<div class="span10 offset1">
<h3 align="center"><i class='icon icon-list-alt'> </i> Notas, Noticias, Novedades ...</h3><hr />

<?
$expresion = $_GET['expresion'];
if($expresion == "")
{
	echo '<p class="lead muted" style="display:inline">Búsqueda en las noticias
<form class="form-search pull-right" action="buscar.php">       
    <div class="input-append">
    <input class="search-query" type="text" name="expresion" placeholder="Buscar en las Noticias" />
    <button type="submit" class="btn btn-primary"><i class="icon icon-search"></i></button>
  </div>
</form> 
</p>
<hr />';
	echo '<br /><div align="center"><div class="alert alert-block fade in" style="max-width:500px">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>ATENCIÓN:</h4>No has introducido ningún texto en el formulario.<br>Inténtalo de nuevo. 
          </div></div>';
}
else
{
// open database connection
mysql_connect($host, $user, $pass) or die ("Imposible conectar!");

mysql_select_db($db) or die ("Imposible seleccionar la base de datos!");

$query = "SELECT distinctrow id, slug, content, timestamp, content FROM noticias where pagina like '%2%' and slug like '%$expresion%' or content like '%$expresion%' order BY id DESC";
$result = mysql_query($query) or die ("Error in query: $query. " . mysql_error());

// if records present
if (mysql_num_rows($result) > 0)
{
	echo  "<p class='lead text-info'>Noticias que contienen la expresión  <span class='muted'>\"". $expresion."\"</span></p>";
	echo '<form class="form-search pull-right" action="buscar.php">       
    <div class="input-append">
    <input class="search-query" type="text" name="expresion" placeholder="Buscar en las Noticias" />
    <button type="submit" class="btn btn-primary"><i class="icon icon-search"></i></button>
  </div>
</form> ';
	echo " </p><hr />";
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
else
{
		echo '<p class="lead muted" style="display:inline">Búsqueda en las noticias
<form class="form-search pull-right" action="buscar.php">       
    <div class="input-append">
    <input class="search-query" type="text" name="expresion" placeholder="Buscar en las Noticias" />
    <button type="submit" class="btn btn-primary">Buscar</button>
  </div>
</form> 
</p>
<hr />';
	echo '<br /><div align="center"><div class="alert alert-block fade in" style="max-width:500px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>ATENCIÓN:</h4>Lo sentimos, pero no hay noticias que concuerden con el texto introducido.
          </div></div>';
}
}
	?>		
    </div>
    </div>
<? //include("../pie.php"); ?>
