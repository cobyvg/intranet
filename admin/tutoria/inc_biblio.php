<?php if (! defined('INC_TUTORIA')) die ('<h1>Forbidden</h1>'); ?>

<!-- Biblioteca -->
<? if($mod_biblio=="1"): ?>
<h3 class="text-info">Devolución de Libros</h3>

<?php $grupo = $_SESSION['mod_tutoria']['unidad']; 
	  $fecha_act = date('Y-m-d');
?>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Alumno</th>
			<th class="text-center">Devolución</th>
		</tr>
	</thead>
<?
	$lista=mysqli_query($db_con, "select curso, apellidos, nombre, ejemplar, devolucion, amonestacion, id, sms from morosos where date(devolucion)<'$fecha_act' and curso='$grupo'  order by apellidos, nombre asc");

	$n=0;
	while ($list=mysqli_fetch_array($lista)){
	?>
	<tr>
		<td><span data-bs='tooltip' title='<? echo $list[3];?>'><a><? echo $list[1].', '.$list[2];   ?></a></span></td>
		<td nowrap style="text-align: center" class="text-danger"><?php echo strftime('%e %b',strtotime($list[4])); ?></td>
	</tr>
	<?	} ?>
	</tbody>
</table>
<p><small class="text-muted">En rojo la fecha en la que debería haberse devuelto el ejemplar.</small></p>

	<?php else: ?>

<p class="lead text-muted">No hay alumnos con Libros de la Biblioteca sin devolver.</p>

<?php endif; ?>
<!-- FIN Biblioteca -->
