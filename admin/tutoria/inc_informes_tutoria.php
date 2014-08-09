<?php if (! defined('INC_TUTORIA')) die ('<h1>Forbidden</h1>'); ?>

<!-- INFORMES DE TUTORIA -->

<h3>Informes de tutoría</h3>

<?php $result = mysql_query("SELECT id, claveal, apellidos, nombre, f_entrev FROM infotut_alumno WHERE unidad='".$_SESSION['mod_tutoria']['unidad']."' ORDER BY f_entrev DESC"); ?>
<?php if (mysql_num_rows($result)): ?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th>Visita</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysql_fetch_array($result)): ?>
		<tr>
			<td><a href="../infotutoria/infocompleto.php?id=<?php echo $row['id']; ?>"><?php echo $row['nombre'].' '.$row['apellidos']; ?></a></td>
			<td><?php echo strftime('%e %b',strtotime($row['f_entrev'])); ?></td>
		</tr>
		<?php endwhile; ?>
		<?php mysql_free_result($result); ?>
	</tbody>
</table>

<?php else: ?>

<br>
<p class="lead text-muted">No hay informes de tutoría registradas para esta unidad.</p>
<br>

<?php endif; ?>

<!-- FIN INFORMES DE TUTORIA -->
