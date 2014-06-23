<?
$hoy = date ( 'Y-m-d' );
// Consulta
$query = "SELECT id, slug, timestamp, content, clase from noticias where pagina like '%1%' and fechafin > '$hoy' ORDER BY timestamp DESC";
//echo $query;
$result = mysql_query ( $query ) or die ( "Error in query: $query. " . mysql_error () );
$n_fijas = mysql_num_rows ( $result );
if ($n_fijas > "0") {
	?>
<div class='well'>
<legend><i class="fa fa-bookmark"> </i> Sección fija</legend>
	<?
}

while ( $row = mysql_fetch_object ( $result ) ) {
	//$dia = explode(" ",$row[0]);
	?>

<p><a href="admin/noticias/story.php?id=<?
					echo $row->id;
					?>"
	style="margin-top: 0px;"> <?
	echo $row->slug;
	;
	?></a></p>
	<?
}
if ($n_fijas > "0") {
	?></div><br />
	<?
}
?>
