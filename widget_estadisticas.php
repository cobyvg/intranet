<?php if (! defined('INC_DIRECCION')) die ('<h1>Forbidden</h1>'); ?>

<div class="bs-module hidden-xs">

	<h4><span class="fa fa-pie-chart fa-fw"></span> Estad�sticas del d�a</h4>
	
	<div class="row">
	
		<div class="col-sm-3">
			<?php $result = mysqli_query($db_con, "SELECT alma.apellidos, alma.nombre, alma.claveal, Fechoria.id, Fechoria.asunto, Fechoria.informa FROM Fechoria JOIN alma ON Fechoria.claveal = alma.claveal WHERE Fechoria.fecha = CURDATE() ORDER BY Fechoria.fecha DESC"); ?>
			<h4 class="text-center">
				<a href="#" data-toggle="modal" data-target="#fechoria">
					<span class="lead"><?php echo mysqli_num_rows($result); ?></span><br>
					<small class="text-uppercase text-muted">Problemas convivencia</small>
				</a>
			</h4>
			
			<!-- MODAL FECHORIAS -->
			<div id="fechoria" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
							<h4 class="modal-title">Problemas de convivencia</h4>
						</div>
						
						<div class="modal-body">
							<?php if (mysqli_num_rows($result)): ?>
							<table class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th>Alumno/a</th>
										<th>Problema</th>
										<th>Profesor/a</th>
									</tr>
								</thead>
								<tbody>
									<?php while($row = mysqli_fetch_array($result)): ?>
									<tr onclick="window.location.href='admin/fechorias/detfechorias.php?id=<?php echo $row['id']; ?>&claveal=<?php echo $row['claveal']; ?>'" style="cursor: pointer; font-size: 0.9em;">
										<td nowrap><?php echo $row['nombre'].' '.$row['apellidos']; ?></td>
										<td><?php echo $row['asunto']; ?></td>
										<td nowrap><?php echo nomprofesor($row['informa']); ?></td>
									</tr>
									<?php endwhile; ?>
								</tbody>
								
							</table>
							<?php else: ?>
							
							<p class="lead text-center text-muted">No se han registrado problemas de convivencia hoy</p>
							
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
			<!-- FIN MODAL FECHORIAS -->
			<?php mysqli_free_result($result); ?>
			
		</div><!-- /.col-sm-3 -->
		
		
		<div class="col-sm-3">
			<?php $result = mysqli_query($db_con, "SELECT alma.apellidos, alma.nombre, alma.unidad, Fechoria.id, Fechoria.asunto, Fechoria.informa, Fechoria.inicio, Fechoria.fin FROM Fechoria JOIN alma ON Fechoria.claveal = alma.claveal WHERE expulsion > 0 AND inicio < CURDATE() AND fin >= CURDATE()"); ?>
			<?   $ayer = date('Y') . "-" . date('m') . "-" . (date('d') - 1);?>
			<?php $result1 = mysqli_query($db_con, "SELECT alma.apellidos, alma.nombre, alma.unidad, Fechoria.id, Fechoria.asunto, Fechoria.informa, Fechoria.inicio, Fechoria.fin FROM Fechoria JOIN alma ON Fechoria.claveal = alma.claveal WHERE expulsion > 0 AND fin = '$ayer'"); ?>
			
			<h4 class="text-center">
				<a href="#" data-toggle="modal" data-target="#expulsiones">
					<span class="lead"> <?php echo mysqli_num_rows($result); ?> / <?php echo mysqli_num_rows($result1); ?></span><br>
					<small class="text-uppercase text-muted">Expulsiones Reingresos</small>
				</a>
			</h4>
			
			<!-- MODAL EXPULSIONES Y REINGRESOS -->
			<div id="expulsiones" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
							<h4 class="modal-title">Expulsiones y reingresos</h4>
						</div>
						
						<div class="modal-body">
							<h4 class="text-info">Alumnos expulsados</h4>
							<?php if (mysqli_num_rows($result)): ?>
							<table class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th>Alumno/a</th>
										<th>Unidad</th>
										<th>Problema</th>
										<th>Inicio</th>
										<th>Fin</th>
									</tr>
								</thead>
								<tbody>
									<?php while($row = mysqli_fetch_array($result)): ?>
									<tr onclick="window.location.href='admin/fechorias/detfechorias.php?id=<?php echo $row['id']; ?>&claveal=<?php echo $row['claveal']; ?>'" style="cursor: pointer; font-size: 0.9em;">
										<td nowrap><?php echo $row['nombre'].' '.$row['apellidos']; ?></td>
										<td><?php echo $row['unidad']; ?></td>
										<td><?php echo $row['asunto']; ?></td>
										<td nowrap><?php echo strftime('%e %b',strtotime($row['inicio'])); ?></td>
										<td nowrap><?php echo strftime('%e %b',strtotime($row['fin'])); ?></td>
									</tr>
									<?php endwhile; ?>
								</tbody>
								
							</table>
							<?php else: ?>
							
							<p class="lead text-center text-muted">No hay alumnos expulsados actualmente</p>
							
							<?php endif; ?>	
							
							<hr>
							
							<h4 class="text-info">Alumnos que se reincorporan</h4>
							<?php if (mysqli_num_rows($result1)): ?>
							<table class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th>Alumno/a</th>
										<th>Unidad</th>
										<th>Problema</th>
										<th>Inicio</th>
										<th>Fin</th>
									</tr>
								</thead>
								<tbody>
									<?php while($row1 = mysqli_fetch_array($result1)): ?>
									<tr onclick="window.location.href='admin/fechorias/detfechorias.php?id=<?php echo $row1['id']; ?>&claveal=<?php echo $row1['claveal']; ?>'" style="cursor: pointer; font-size: 0.9em;">
										<td nowrap><?php echo $row1['nombre'].' '.$row1['apellidos']; ?></td>
										<td><?php echo $row1['unidad']; ?></td>
										<td><?php echo $row1['asunto']; ?></td>
										<td nowrap><?php echo strftime('%e %b',strtotime($row1['inicio'])); ?></td>
										<td nowrap><?php echo strftime('%e %b',strtotime($row1['fin'])); ?></td>
									</tr>
									<?php endwhile; ?>
								</tbody>
								
							</table>
							<?php else: ?>
							
							<p class="lead text-center text-muted">No hay alumnos que se reincorporen hoy</p>
							
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
			<!-- FIN MODAL EXPULSIONES Y REINGRESOS -->
			<?php mysqli_free_result($result); ?>
			<?php mysqli_free_result($result1); ?>
			
		</div><!-- /.col-sm-3 -->
		
		
		<div class="col-sm-3">
			<?php $result = mysqli_query($db_con, "SELECT id, apellidos, nombre, unidad, tutor FROM infotut_alumno WHERE F_ENTREV = CURDATE()"); ?>
			
			<h4 class="text-center">
				<a href="#" data-toggle="modal" data-target="#visitas">
					<span class="lead"><?php echo mysqli_num_rows($result); ?></span><br>
					<small class="text-uppercase text-muted">Visitas de padres</small>
				</a>
			</h4>
			
			<!-- MODAL VISITAS PADRES -->
			<div id="visitas" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
							<h4 class="modal-title">Visitas de padres</h4>
						</div>
						
						<div class="modal-body">
							<?php if (mysqli_num_rows($result)): ?>
							<table class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th>Alumno/a</th>
										<th>Unidad</th>
										<th>Tutor</th>
									</tr>
								</thead>
								<tbody>
									<?php while($row = mysqli_fetch_array($result)): ?>
									<tr onclick="window.location.href='admin/infotutoria/infocompleto.php?id=<?php echo $row['id']; ?>'" style="cursor: pointer; font-size: 0.9em;">
										<td nowrap><?php echo $row['nombre'].' '.$row['apellidos']; ?></td>
										<td><?php echo $row['unidad']; ?></td>
										<td nowrap><?php echo nomprofesor($row['tutor']); ?></td>
									</tr>
									<?php endwhile; ?>
								</tbody>
								
							</table>
							<?php else: ?>
							
							<p class="lead text-center text-muted">No hay visitas previstas para hoy</p>
							
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
			<!-- FIN MODAL VISITAS PADRES -->
			<?php mysqli_free_result($result); ?>
			
		</div><!-- /.col-sm-3 -->
		
		
		<div class="col-sm-3">
			<?php mysqli_query($db_con, "CREATE TABLE tmp_accesos SELECT DISTINCT profesor FROM reg_intranet WHERE fecha LIKE CONCAT(CURDATE(),'%') AND profesor IN (SELECT nombre FROM departamentos WHERE departamento NOT LIKE 'Administracion' AND departamento NOT LIKE 'Admin' AND departamento NOT LIKE 'Conserjeria') ORDER BY profesor ASC"); ?>
			
			<?php $result = mysqli_query($db_con, "SELECT nombre, departamento FROM departamentos WHERE departamento NOT LIKE 'Administracion' AND departamento NOT LIKE 'Admin' AND departamento NOT LIKE 'Conserjeria' AND nombre NOT IN (SELECT profesor FROM tmp_accesos) ORDER BY nombre ASC"); ?>
			
			<?php $result1 = mysqli_query($db_con, "SELECT * FROM departamentos WHERE departamento NOT LIKE 'Administracion' AND departamento NOT LIKE 'Admin' AND departamento NOT LIKE 'Conserjeria'"); ?>
			
			<h4 class="text-center">
				<a href="#" data-toggle="modal" data-target="#accesos">
					<span class="lead"><?php echo mysqli_num_rows($result); ?> <span class="text-muted">(<?php echo mysqli_num_rows($result1); ?>)</span></span><br>
					<small class="text-uppercase text-muted">Profesores sin entrar</small>
				</a>
			</h4>
			
			<!-- MODAL ACCESOS -->
			<div id="accesos" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
							<h4 class="modal-title">Profesores que no han accedido hoy</h4>
						</div>
						
						<div class="modal-body">
							<?php if (mysqli_num_rows($result)): ?>
							<table class="table table-condensed table-hover table-striped">
								<thead>
									<tr>
										<th>Profesor/a</th>
										<th>Departamento</th>
										<th>Total accesos</th>
										<th>�ltimo acceso</th>
									</tr>
								</thead>
								<tbody>
									<?php while($row = mysqli_fetch_array($result)): ?>
									<?php $result2 = mysqli_query($db_con, "SELECT COUNT(*) AS accesos, (SELECT fecha FROM reg_intranet WHERE profesor='".$row['nombre']."' ORDER BY fecha DESC LIMIT 1) AS ultimo_acceso FROM reg_intranet GROUP BY profesor HAVING profesor = '".$row['nombre']."' LIMIT 1"); ?>
									<?php $row2 = mysqli_fetch_array($result2); ?>
									<tr style="font-size: 0.9em;">
										<td nowrap><?php echo nomprofesor($row['nombre']); ?></td>
										<td><?php echo $row['departamento']; ?></td>
										<td><?php echo ($row2['accesos']) ? $row2['accesos'] : '0' ; ?></td>
										<td nowrap><?php echo ($row2['ultimo_acceso']) ? $row2['ultimo_acceso'] : 'Nunca'; ?></td>
									</tr>
									<?php endwhile; ?>
								</tbody>
								
							</table>
							<?php else: ?>
							
							<p class="lead text-center text-muted">
								<span class="fa fa-thumbs-o-up fa-5x"></span><br>
								�Genial! Todos los profesores han accedido hoy
							</p>
							
							<?php endif; ?>	
						</div>
					</div>
				</div>
			</div>
			<!-- FIN MODAL ACCESOS -->
			<?php mysqli_query($db_con,"drop table tmp_accesos"); ?>
			<?php mysqli_free_result($result); ?>
			<?php mysqli_free_result($result1); ?>
			
		</div><!-- /.col-sm-3 -->
	
	</div><!-- /.row -->
	
</div><!-- /.bs-module -->
	
<br>