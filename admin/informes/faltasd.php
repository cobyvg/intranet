<!-- MODULO DETALLADO FALTAS DE ASISTENCIA -->

<?php
function tipo_falta($falta) {
	
	switch ($falta) {
		case 'J' : $tipo = 'Justificada'; break;
		case 'F' : $tipo = 'Injustificada'; break;
		case 'I' : $tipo = 'Injustificada'; break;
		case 'R' : $tipo = 'Retraso'; break;
	}
	
	return $tipo;
}
?>

<h3>Informe detallado de faltas de asistencia</h3>
<br>

<?php
$result = mysqli_query($db_con, "SELECT distinct alma.CLAVEAL, alma.APELLIDOS, alma.NOMBRE, alma.unidad, FALTAS.fecha, FALTAS.hora, asignaturas.nombre, FALTAS.falta FROM alma, FALTAS, asignaturas where  alma.CLAVEAL = FALTAS.CLAVEAL and FALTAS.codasi = asignaturas.codigo  and alma.claveal = $claveal and asignaturas.abrev not like '%\_%' order BY FALTAS.fecha, FALTAS.hora"); ?>
<?php if (mysqli_num_rows($result)): ?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover datatable1">
		<thead>
			<tr>
				<th>Día</th>
				<th>Hora</th>
				<th>Asignatura</th>
				<th>Tipo</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)): ?>
			<tr>
				<td><?php echo $row['fecha']; ?></td>
				<td><?php echo $row['hora']; ?>ª</td>
				<td><?php echo $row['nombre']; ?></td>
				<td><?php echo tipo_falta($row['falta']); ?></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>

<!-- FIN MODULO DETALLADO FALTAS DE ASISTENCIA -->
