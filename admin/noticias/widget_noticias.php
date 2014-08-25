
<!-- MODULO DE NOTICIAS -->

<h4><span class="fa fa-th-list fa-fw"></span> Noticias</h4><hr>

<?php $result = mysql_query("SELECT id, slug, content, contact, timestamp, clase FROM noticias WHERE timestamp < NOW() AND pagina LIKE '%1%' ORDER BY timestamp DESC LIMIT 8"); ?>
<?php if (mysql_num_rows($result)): ?>
	
<?php while ($row = mysql_fetch_array($result, MYSQL_ASSOC)): ?>
		
<?php $exp_profesor = explode(',', $row['contact']); ?>
<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
		
<div style="border-bottom: 1px solid #ecf0f1; margin-bottom: 15px;">
	
	<h5>
		<small class="pull-right text-muted"><?php echo strftime('%e %b',strtotime($row['timestamp'])); ?></small>
		<a href="http://<?php echo $dominio; ?>/intranet/admin/noticias/noticia.php?id=<?php echo $row['id']; ?>"><?php echo $row['slug']; ?></a>
	</h5>

	<p>
		<small>
			<span class="fa fa-user fa-fw"></span> <?php echo $profesor; ?> &nbsp;&nbsp;&middot;&nbsp;&nbsp;
			<span class="fa fa-tag fa-fw"></span> <?php echo ($row['clase']) ? $row['clase'] : 'Sin categoría'; ?>
		</small>
	</p>
</div>
		
<?php endwhile; ?>
<?php mysql_free_result($result); ?>
	
<?php else: ?>

<?php endif; ?>

<a class="btn btn-primary btn-sm" href="admin/noticias/redactar.php">Nueva noticia</a>
<a class="btn btn-default btn-sm" href="admin/noticias/">Ver noticias </a>

<!-- FIN MODULO DE NOTICIAS -->
