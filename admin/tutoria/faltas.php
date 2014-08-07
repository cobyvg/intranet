<h3>Faltas sin justificar</h3>

<?php $exp_inicio_curso = explode('-', $inicio_curso); ?>
<?php $inicio_curso2 = $exp_inicio_curso[2].'-'.$exp_inicio_curso[1].'-'.$exp_inicio_curso[0]; ?>

<?php mysql_query("CREATE TABLE FALTASTEMP SELECT DISTINCT FALTAS.claveal, FALTAS.falta, COUNT(*) AS NUMERO, apellidos, nombre FROM FALTAS, FALUMNOS  
 WHERE FALTAS.claveal = FALUMNOS.claveal AND FALTAS.falta = 'F' AND FALTAS.unidad = '$unidad' GROUP BY FALTAS.claveal") or die(mysql_error()); ?>

<?php $result = mysql_query("SELECT FALTASTEMP.claveal, FALTASTEMP.apellidos, FALTASTEMP.nombre, FALTASTEMP.NUMERO FROM FALTASTEMP ORDER BY FALTASTEMP.numero DESC"); ?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Alumno/a</th>
			<th class="text-center">Faltas</th>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = mysql_fetch_array($result)): ?>
		<tr>
			<td><a href="../faltas/informes.php?claveal=<?php echo $row['claveal']; ?>&fecha4=<?php echo $inicio_curso2; ?>&fecha3=<?php echo date('d-m-Y'); ?>&submit2=2"><?php echo $row['apellidos'].', '.$row['nombre']; ?></a></td>
			<td class="text-center"><span class="text-info"><?php echo $row['NUMERO']; ?></span></td>
		</tr>
		<?php endwhile; ?>
		<?php mysql_free_result($result); ?>
	</tbody>
</table>

<?php mysql_query("DROP TABLE FALTASTEMP"); ?>