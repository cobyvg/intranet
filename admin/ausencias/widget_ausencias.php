
<!-- MODULO DE AUSENCIAS -->

<?php $result = mysql_query("SELECT profesor, id, tareas from ausencias where  date(inicio) <= '".date('Y-m-d')."' and date(fin) >= '".date('Y-m-d')."'"); ?>
<?php if (mysql_num_rows($result)): ?>

<div class="well well-sm">
	
	<h4><span class="fa fa-users fa-fw"></span> Profesores de baja</h4>
	
	<div class="list-group">
		<?php while ($row = mysql_fetch_array($result)): ?>
		<?php $exp_profesor = explode(',', $row['profesor']); ?>
		<?php $profesor = $exp_profesor[1].' '.$exp_profesor[0]; ?>
		
		<a class="list-group-item" href="admin/ausencias/baja.php?profe_baja=<?php echo $row['profesor']; ?>&id=<?php echo $row['id']; ?>">
			<?php if (strlen($row['tareas']) > 1): ?>
			<span class="pull-right fa fa-check-square-o fa-fw fa-lg" data-toggle="tooltip" title="Hay tareas para los alumnos"></span>
			<?php else: ?>
			<span class="pull-right fa fa-square-o fa-fw fa-lg" data-toggle="tooltip" title="No hay tareas para los alumnos"></span>
			<?php endif; ?>
			<?php echo $profesor; ?>
		</a>
		<?php endwhile; ?>
	</div>

	<a href="admin/ausencias/diario.php" class="btn btn-default btn-sm">Ver profesores ausentes</a>
</div>
<?php else: ?>

<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
<div class="well well-sm">
	
	<h4><span class="fa fa-users fa-fw"></span> Profesores de baja</h4>
	
	<div class="list-group">
		<a class="list-group-item" href="#">
			<span class="pull-right fa fa-check-square-o fa-fw fa-lg" data-toggle="tooltip" title="Hay tareas para los alumnos"></span>
			Juan Pérez
		</a>
	</div>

</div>
<?php endif; ?>

<?php endif; ?>

<!-- FIN MODULO DE AUSENCIAS -->
