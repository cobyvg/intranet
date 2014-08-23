
<!-- MODULO DE NOTICIAS -->

<h4><span class="fa fa-th-list fa-fw"></span> Noticias</h4><hr>

<?php $result = mysql_query("SELECT id, slug, content, contact, timestamp, clase FROM noticias WHERE timestamp < NOW() AND pagina LIKE '%1%' ORDER BY timestamp DESC LIMIT 8"); ?>
<?php if (mysql_num_rows($result)): ?>
	
<?php while ($row = mysql_fetch_array($result, MYSQL_ASSOC)): ?>
		
<?php $exp_profesor = explode(',', $row['contact']); ?>
<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
		
<div style="border-bottom: 1px solid #ecf0f1; margin-bottom: 15px;">
	<h5><a href="http://<?php echo $dominio; ?>/intranet/admin/noticias/noticia.php?id=<?php echo $row['id']; ?>"><?php echo $row['slug']; ?></a></h5>
	<p><small>Por <?php echo $profesor; ?> &middot; Categoria: <?php echo ($row['clase']) ? $row['clase'] : 'Sin categoría'; ?></small></p>
</div>
		
<?php endwhile; ?>
<?php mysql_free_result($result); ?>
	
<?php else: ?>

<?php endif; ?>

<a class="btn btn-primary btn-sm" href="admin/noticias/redactar.php">Nueva noticia</a>
<a class="btn btn-default btn-sm" href="admin/noticias/">Ver noticias </a>

<!-- FIN MODULO DE NOTICIAS -->
