<?
				$hoy = date ( 'Y-m-d' );
				// Consulta
				$query = "SELECT id, slug, timestamp, content, clase from noticias where pagina = '1' and fechafin > '$hoy' ORDER BY timestamp DESC";
				//echo $query;
				$result = mysql_query ( $query ) or die ( "Error in query: $query. " . mysql_error () );
				$n_fijas = mysql_num_rows ( $result );
				if ($n_fijas > "0") {
					?>
<div class='well well-small'>
<p class="lead">Sección fija</p>
<?
				}
				
				while ( $row = mysql_fetch_object ( $result ) ) {
					//$dia = explode(" ",$row[0]);
					?>

<p><a
		href="admin/noticias/story.php?id=<?
					echo $row->id;
					?>"
		style="margin-top: 0px;"><i class="icon-bookmark"> </i> <?
					echo $row->slug;
					;
					?></a></p>
<?
				}
				if ($n_fijas > "0") {
				?>
</div>
<?
				}
				?>
