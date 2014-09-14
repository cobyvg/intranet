<?php 
session_start();
include("../../config.php");
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
?>
<?
include("../../menu.php"); 
//include("menu.php"); 

$query_Recordset1 = "SELECT * FROM asignaturas GROUP BY nombre ORDER BY nombre ASC";
$Recordset1 = mysqli_query($db_con, $query_Recordset1) or die(mysqli_error($db_con));
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 = "SELECT DISTINCT unidad, curso, SUBSTRING(unidad, 2,1) AS orden FROM alma ORDER BY orden ASC";
$Recordset2 = mysqli_query($db_con, $query_Recordset2) or die(mysqli_error($db_con));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Listado de alumnos <small>Alumnos con asignaturas pendientes</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="lista_pendientes.php">
					<fieldset>
						<legend>Listado de pendientes por asignatura</legend>
						
						<div class="form-group">
						  <select class="form-control" name="select[]" multiple size="6">
<?php 
do {  
?>
    <option><?php  echo $row_Recordset1[1]?></option>
    <?php 
} while ($row_Recordset1 = mysqli_fetch_array($Recordset1));
  $rows = mysqli_num_rows($Recordset1);
  if($rows > 0) {
      mysqli_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysqli_fetch_array($Recordset1);
  }
?>
						  </select>
						  <p class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples asignaturas.</p>
						</div>
					  
					  <button type="submit" class="btn btn-primary" name="submit1">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form method="post" action="pendientes_unidad.php">
					<fieldset>
						<legend>Listado de pendientes por grupos</legend>
						
						<div class="form-group">
					    <select class="form-control" name="select1[]" multiple size="6">
<?php 
do {  
	if (strstr($row_Recordset2['curso'],"E.S.O.") or strstr($row_Recordset2['curso'],"Bachillerato")) {	
?>
    <option value="<?php  echo $row_Recordset2['unidad']?>"><?php  echo $row_Recordset2['unidad']?> (<?php  echo $row_Recordset2['curso']?>)</option>
    <?php 
	}
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
  $rows = mysqli_num_rows($Recordset2);
  if($rows > 0) {
      mysqli_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
  }
?>
					    </select>
					    <p class="help-block">Mantén apretada la tecla <kbd>Ctrl</kbd> mientras haces click con el ratón para seleccionar múltiples grupos.</p>
					  </div>
					  
					  <button type="submit" class="btn btn-primary" name="submit2">Consultar</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>
</body>
</html>
