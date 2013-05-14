<div class='well well-small'>
<p class="lead">Mensajes</p>
    <?
				$query = "SELECT ahora, asunto, id, recibidoprofe, texto from mens_profes, mens_texto where mens_texto.id = mens_profes.id_texto and profesor = '$pr' ORDER BY ahora DESC LIMIT 0, 5";
				//echo $query;
				$result = mysql_query ( $query ) or die ( "Error in query: $query. " . mysql_error () );
				
				while ( $row = mysql_fetch_array ( $result ) ) {
					$dia = explode ( " ", $row [0] );
					?>

<p><a  style="text-align:left;" 
		href="admin/mensajes/mensaje.php?id=<?
					echo $row [2];
					?>"
		 rel='tooltip' title='<? if(strlen($row[4])>599){echo substr($row[4],0,600)."...";}else{echo $row[4];}?>'><i class="icon-comment"> </i> <?
					echo $row [1];
					?></a></p>
<?
				}
				?>
<a
	href="admin/mensajes/index.php" class="btn btn-primary">Centro de
Mensajes</a>
</div>