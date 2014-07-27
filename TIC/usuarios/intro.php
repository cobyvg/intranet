<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../../menu.php");
include("../menu.php");

// Si ya hemos enviado los datos, nos vamos a alumnos.php
if(isset($_POST['enviar']))
{
include("alumnos.php");
}
else
{

?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Centro TIC <small>Perfiles de alumnos</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6 col-sm-offset-3">
			
			<div class="well">
				
				<form method="post" action="">
					<fieldset>
						<legend>Perfiles de alumnos</legend>
						
						<?php if(stristr($_SESSION['cargo'],'1') == TRUE): ?>
						<div class="form-group">
					    <label for="profe">Profesor</label>
					    <?php $result = mysql_query("SELECT DISTINCT PROFESOR FROM profesores ORDER BY PROFESOR ASC"); ?>
					    <?php if(mysql_num_rows($result)): ?>
					    <select class="form-control" id="profe" name="profe" onchange="submit()">
						    <?php while($row = mysql_fetch_array($result)): ?>
						    <option value="<?php echo $row['PROFESOR']; ?>" <?php echo (isset($profe) && $profe == $row['PROFESOR']) ? 'selected' : ''; ?>><?php echo $row['PROFESOR']; ?></option>
						    <?php endwhile; ?>
						    <?php mysql_free_result($result); ?>
						   </select>
						   <?php else: ?>
						   <select class="form-control" id="profe" name="profe" disabled>
						   	<option value=""></option>
						   </select>
						   <?php endif; ?>
					  </div>
					  <?php else: ?>
					  <?php $profe = $_SESSION['profi']; ?>
					  <?php endif; ?>
					  
					  <div class="form-group">
					    <label for="curso">Unidad (Asignatura)</label>
					    
					    <?php $result = mysql_query("SELECT DISTINCT GRUPO, MATERIA, NIVEL, codigo FROM profesores, asignaturas WHERE materia = nombre AND abrev NOT LIKE '%\_%' AND PROFESOR = '$profe' AND nivel = curso ORDER BY grupo ASC"); ?>
					    <?php if(mysql_num_rows($result)): ?>
					    <select class="form-control" id="curso" name="curso">
					      <?php while($row = mysql_fetch_array($result)): ?>
					      <?php $key = $row['GRUPO'].'-->'.$row['MATERIA'].'-->'.$row['NIVEL'].'-->'.$row['codigo']; ?>
					      <option value="<?php echo $key; ?>" <?php echo (isset($curso) && $curso == $key) ? 'selected' : ''; ?>><?php echo $row['GRUPO'].' ('.$row['MATERIA'].')'; ?></option>
					      <?php endwhile; ?>
					      <?php mysql_free_result($result); ?>
					     </select>
					     <?php else: ?>
					     <select class="form-control" id="profesor" name="profesor" disabled>
					     	<option value=""></option>
					     </select>
					     <?php endif; ?>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="enviar">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>

</body>
</html>
<?php } ?>