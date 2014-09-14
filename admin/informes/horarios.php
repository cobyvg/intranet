<!-- MODULO HORARIO Y PROFESORES -->

<a name="horario"></a>
<h3>Horario de la unidad</h3>
<br>

<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Lunes</th>
				<th>Martes</th>
				<th>Miércoles</th>
				<th>Jueves</th>
				<th>Viernes</th>
			</tr>
		</thead>
		<tbody>
			<?php $horas = array(1 => "1ª", 2 => "2ª", 3 => "3ª", 4 => "4ª", 5 => "5ª", 6 => "6ª" ); ?>
			<?php foreach($horas as $hora => $desc): ?>
			<tr>
				<th><?php echo $desc; ?></th>
				<?php for($i = 1; $i < 6; $i++): ?>
				<td width="20%">
					<?php $result = mysqli_query($db_con, "SELECT DISTINCT asig, c_asig FROM horw WHERE a_grupo='$unidad' AND dia='$i' AND hora='$hora'"); ?>
					<?php while($row = mysqli_fetch_array($result)): ?>
					<?php echo $row[0]."<br>\n"; ?>
					<?php endwhile; ?>
				</td>
				<?php endfor; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<br>
<h3>Equipo educativo</h3>
<br>

<?php $result = mysqli_query($db_con, "SELECT DISTINCT MATERIA, PROFESOR FROM profesores WHERE grupo='$unidad'"); ?>
<?php if(mysqli_num_rows($result)): ?>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-sm-4">Asignatura</th>
				<th class="col-sm-8">Profesor/a</th>
			</tr>
		</thead>
		<tbody>
		<?php while($row = mysqli_fetch_array($result)): ?>
			<tr>
				<td><?php echo $row[0]; ?></td>
				<td><?php echo $row[1]; ?></td>
			</tr>
		<?php endwhile; ?>
		<?php mysqli_free_result($result); ?>
		</tbody>
	</table>
</div>
<?php endif; ?>


<!-- FIN MODULO HORARIO Y PROFESORES -->
