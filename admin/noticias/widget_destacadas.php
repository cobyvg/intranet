
<!-- MODULO DE NOTICIAS DESTACADAS -->

<br>
<h4><span class="fa fa-fire fa-fw"></span> Noticias destacadas</h4>

<?php $result = mysql_query("SELECT id, slug, timestamp, content, clase from noticias where pagina like '%1%' and fechafin > '".date('Y-m-d')."' ORDER BY timestamp DESC"); ?>
<?php if(mysql_num_rows($result)): ?>

<div class="list-group">
<?php while ($row = mysql_fetch_array($result)): ?>
<?php $fecha = date_create($row['timestamp']); ?>
	<a class="list-group-item" href="http://<?php echo $dominio; ?>/intranet/admin/noticias/noticia.php?id=<?php echo $row['id']; ?>">
		<small class="text-muted pull-right"><?php echo date_format($fecha, 'd M') ?></small>
		<span class="text-info"><?php echo $row['slug']; ?></span>
	</a>
<?php endwhile; ?>
<?php mysql_free_result($result); ?>
</div>
<?php else: ?>
<br>
<p class="lead text-center text-muted">No hay noticias destacadas</p>
<br>
<?php endif; ?>
<!-- FIN MODULO DE NOTICIAS DESTACADAS -->
