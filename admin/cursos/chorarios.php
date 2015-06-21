<?
require('../../bootstrap.php');


if (!$mod_horario) header('Location:'.'http://'.$dominio.'/intranet/');

include("../../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Horarios <small>Consulta por grupos, profesores y aulas</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA 1 -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="horarios.php">
					<fieldset>
						<legend>Grupos</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT a_grupo FROM horw WHERE a_grupo NOT LIKE 'G%' AND a_grupo NOT LIKE '' ORDER BY a_grupo"); ?>
							<?php if(mysqli_num_rows($result)): ?>
					    <select class="form-control" id="curso" name="curso">
					    	<?php while($row = mysqli_fetch_array($result)): ?>
					    	<option value="<?php echo $row['a_grupo']; ?>"><?php echo $row['a_grupo']; ?></option>
					    	<?php endwhile; ?>
					    </select>
					    <?php else: ?>
					     <select class="form-control" id="curso" name="curso" disabled></select>
					    <?php endif; ?>
					    <?php mysqli_free_result($result); ?>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA 2 -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="profes.php">
					<fieldset>
						<legend>Profesores</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT prof FROM horw WHERE prof NOT LIKE '' ORDER BY prof ASC"); ?>
					    <?php if(mysqli_num_rows($result)): ?>
					    <select class="form-control" id="profeso" name="profeso">
					    	<?php while($row = mysqli_fetch_array($result)): ?>
					    	<option value="<?php echo $row['prof']; ?>"><?php echo nomprofesor($row['prof']); ?></option>
					    	<?php endwhile; ?>
					    </select>
					    <?php else: ?>
					     <select class="form-control" id="profeso" name="profeso" disabled></select>
					    <?php endif; ?>
					    <?php mysqli_free_result($result); ?>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="submit2">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA 3 -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="hor_aulas.php">
					<fieldset>
						<legend>Aulas</legend>
						
						<div class="form-group">
							<?php $result = mysqli_query($db_con, "SELECT DISTINCT n_aula FROM horw where n_aula not like 'G%' ORDER BY n_aula ASC"); ?>
						  <?php if(mysqli_num_rows($result)): ?>
						  <select class="form-control" id="aula" name="aula">
						  	<?php while($row = mysqli_fetch_array($result)): ?>
						  	<option value="<?php echo $row['n_aula']; ?>"><?php echo $row['n_aula']; ?></option>
						  	<?php endwhile; ?>
						  </select>
						  <?php else: ?>
						   <select class="form-control" id="aula" name="aula" disabled></select>
						  <?php endif; ?>
						  <?php mysqli_free_result($result); ?>
						</div>
					  
					  <button type="submit" class="btn btn-primary" name="submit3">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA 4 -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="aulas_libres.php">
					<fieldset>
						<legend>Aulas libres</legend>
						
						<div class="form-group">
							<?php $dias = array('Lunes','Martes','Miércoles','Jueves','Viernes'); ?>
					    <select class="form-control" id="n_dia" name="n_dia">
					    	<?php for($i = 0; $i < count($dias); $i++): ?>
					    	<option value="<?php echo $dias[$i]; ?>"><?php echo $dias[$i]; ?></option>
					    	<?php endfor; ?>
					    </select>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="submit4">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
