<legend><i class="icon icon-pencil"> </i> Noticias</legend> 
<?
$query = "SELECT id, slug, timestamp, content, clase, contact from noticias where pagina like '%1%' ORDER BY timestamp DESC LIMIT 0, 5";
$result = mysql_query ( $query ) or die ( "Error in query: $query. " . mysql_error () );
if (mysql_num_rows ( $result ) > 0) {
	while ( $row = mysql_fetch_object ( $result ) ) {
		$url = 'admin/noticias/story.php';
		$url .= '?id=' . $row->id;
		?>
<p><span class="lead"><small><a href="admin/noticias/story.php?id=<?
		echo $row->id;
		?>">  
<?
		echo $row->slug;
		?>
</a>
</small>
</span>
<br />
<small>
Fecha: <?
		echo fecha_actual2 ( $row->timestamp );
		?>.
<?
		if ($row->clase == "") {
			?>

Autor: <?
			echo " " . $row->contact . " ";
			?>
	<?
		} else {
			?>

Categoría:  <?
			echo " " . $row->clase . " ";
			?>
	<?
		}
		?>
        </small></p>
<?
	}
}

?>
<br />
 <a href="admin/noticias/add.php" class="btn btn-primary"><i class="icon icon-plus-sign icon-white"></i>&nbsp;Añadir</a>&nbsp;&nbsp;&nbsp;

<a href="admin/noticias/list.php" class="btn btn-primary"><i class="icon icon-list-alt icon-white"></i>&nbsp;M&aacute;s Noticias </a>
    <hr /><br /> 