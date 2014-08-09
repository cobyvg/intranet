<?
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

// COMPROBACION DE ACCESO AL MODULO
if(!(strstr($_SESSION['cargo'],'1') == TRUE) && !(strstr($_SESSION['cargo'],'8') == TRUE)) {
	die("<h1>FORBIDDEN</h1>");
}
else {

	if (isset($_SESSION['mod_tutoria'])) {
		header('Location:'.'index.php');
	}
	
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


include("../../menu.php");
?>

	<div class="container">
		
		<!-- TITULO DE LA PAGINA -->
		<div class="page-header">
			<h2>Tutoría <small>Selección de tutoría</small></h2>
		</div>
		
		
		<!-- SCAFFOLDING -->
		<div class="row">
		
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-6 col-sm-offset-3">
				
				<div class="well">
					
					<form method="post" action="index.php">
						<fieldset>
							<legend>Seleccione tutor</legend>
							
							<div class="form-group">
						    <label for="tutor">Tutores/as de grupo</label>
						    <?php $result = mysql_query("SELECT DISTINCT unidad, tutor FROM FTUTORES ORDER BY unidad ASC"); ?>
						    <?php if(mysql_num_rows($result)): ?>
						    <select class="form-control" id="tutor" name="tutor">
						    	<?php while($row = mysql_fetch_array($result)): ?>
						    	<option value="<?php echo $row['tutor'].' ==> '.$row['unidad']; ?>"><?php echo $row['unidad'].' - '.$row['tutor']; ?></option>
						    	<?php endwhile; ?>
						    </select>
						    <?php else: ?>
						    <select class="form-control" id="tutor" name="tutor" disabled>
						    	<option value=""></option> 
						    </select>
						    <?php endif; ?>
						    <?php mysql_free_result($result); ?>
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
