<?php $result = mysql_query("SELECT id, slug, timestamp, content, clase from noticias where pagina like '%1%' and fechafin > '".date('Y-m-d')."' ORDER BY timestamp DESC"); ?>
<?php if(mysql_num_rows($result)): ?>

<h3><span class="fa fa-fire fa-fw"></span> Noticias destacadas</h3>

<table class="table table-striped">
	<tbody>
		<?php while ($row = mysql_fetch_array($result)): ?>
		<?php $fecha = date_create($row['timestamp']); ?>
		<tr>
			<td>
				<small class="text-muted pull-right"><?php echo date_format($fecha, 'd M') ?></small>
				<a href="admin/noticias/story.php?id=<?php echo $row['id']; ?>"><?php echo $row['slug']; ?></a>
			</td>
		</tr>
		<?php endwhile; ?>
		<?php mysql_free_result($result); ?>
	</tbody>
</table>
<?php else: ?>
<br>
<p class="lead text-center text-muted">No hay noticias destacadas</p>
<br>
<?php endif; ?>