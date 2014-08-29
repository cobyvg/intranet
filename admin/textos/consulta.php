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

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if (isset($_POST['nivel'])) $nivel = $_POST['nivel'];
if (isset($_POST['departamento'])) $departamento = $_POST['departamento'];

$sql_where = "";
if ($nivel != '' || $departamento != '') {
	$sql_where .= "WHERE ";
	
	if ($nivel != '') $sql_where .= "nivel='$nivel'";
	if ($departamento != '') {
		if ($nivel != '') $sql_where .= " AND ";
		$sql_where .= "departamento='$departamento'";
	}
}


// ELIMINAR UN LIBRO
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
	$result = mysql_query("DELETE FROM Textos WHERE id='$id' LIMIT 1");
	
	if (!$result) $msg_error = "No se ha podido eliminar el libro de texto. Error: ".mysql_error();
	else $msg_success = "El libro de texto ha sido eliminado.";
}


include("../../menu.php");
include 'menu.php';
?>
<div class="container">
<<<<<<< HEAD
<div class="row">
<div class="page-header">
  <h2>Libros de Texto <small> Consulta de Textos</small></h2>
</div>
<div class="col-sm-6 col-sm-offset-3">
<br />
    <div class="well well-lg" align="left">
      <form method="post" action="textos.php">
      <div class="form-group">
      <label>Nivel</label>
        <select name="nivel" id="select6" class="form-control">
          <?
  $tipo = "select distinct curso from alma order by curso";
  $tipo1 = mysql_query($tipo);
  while($tipo2 = mysql_fetch_array($tipo1))
        {
$completo = $tipo2[0];
echo "<option>$completo</option>";
} ?>
        </select>
      </div>

<div class="form-group">
<label>Departamento:</label>
        <select name="departamento" id="select7"  value ="Todos ..." onChange="submit()" class="form-control">
          <option></option>
          <?
  $profe = mysql_query(" SELECT distinct departamento FROM departamentos order by departamento asc");
  while($filaprofe = mysql_fetch_array($profe))
	{
	$departamen = $filaprofe[0]; 
	$opcion1 = printf ("<OPTION>$departamen</OPTION>");
	echo "$opcion1";
	} 
	?>
        </select>
      </div>
      <input type="submit" name="enviar2" value="Buscar Textos" alt="Introducir" class="btn btn-primary btn-block">
            </form>
      
    </div>
  </form>
</div>
</div>
</div>
</div>
<?php
	include("../../pie.php");
?>

=======
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
	  <h2>Libros de texto <small>Consulta de libros de texto</small></h2>
	</div>
	
	<!-- MENSAJES -->
	<?php if (isset($msg_error)): ?>
	<div class="alert alert-danger">
		<?php echo $msg_error; ?>
	</div>
	<?php endif; ?>
	
	<?php if (isset($msg_success)): ?>
	<div class="alert alert-success">
		<?php echo $msg_success; ?>
	</div>
	<?php endif; ?>
	
	<!-- SCAFFOLDING -->
	<div class="row">
		
		<?php if (!isset($_POST['submit'])): ?>
		
		<div class="col-sm-6 col-sm-offset-3">
		
    	<div class="well">
    
      	<form method="post" action="">
      		
      		<fieldset>
      			<legend>Criterios de búsqueda</legend>
      			
      			<div class="form-group">
      				<label for="nivel">Curso</label>
      					<select class="form-control" id="nivel" name="nivel">
      					<option value=""></option>
      					<?php $result = mysql_query("SELECT DISTINCT curso FROM alma ORDER BY curso ASC"); ?>
      					<?php while($row = mysql_fetch_array($result)): ?>
      					<option value="<?php echo $row['curso']; ?>" <?php echo (isset($nivel) && $nivel == $row['curso']) ? 'selected' : ''; ?>><?php echo $row['curso']; ?></option>
      					<?php endwhile; ?>
      				</select>
      			</div>
      			
      			<div class="form-group">
      				<label for="departamento">Departamento</label>
      				<select class="form-control" id="departamento" name="departamento">
      					<option value=""></option>
								<?php $result = mysql_query("SELECT DISTINCT departamento FROM departamentos ORDER BY departamento ASC"); ?>
								<?php while ($row = mysql_fetch_array($result)) : ?>
								<option value="<?php echo $row['departamento']; ?>" <?php echo (isset($departamento) && $departamento == $row['departamento']) ? 'selected' : ''; ?>><?php echo $row['departamento']; ?></option>
								<?php endwhile; ?>
							</select>
						</div>
      			
      		</fieldset>
      		
      		<button type="submit" class="btn btn-primary" name="submit">Consultar</button>
      	
      	</form>
      	
      </div><!-- /.well -->
		
		</div><!-- /.col-sm-6 -->
		
		<?php else: ?>
		
		<div class="col-sm-12">
			<?php $result = mysql_query("SELECT DISTINCT id, departamento, asignatura, autor, titulo, editorial, notas, nivel, grupo FROM Textos $sql_where ORDER BY asignatura") or die (mysql_error()); ?>
			
			<h3 class="text-info"><?php echo ($nivel != '') ? $nivel : 'Todos los cursos'; ?> <?php echo ($departamento != '') ? '('.$departamento.')' : ''; ?></h3>
			<br>
			
			<?php if (mysql_num_rows($result)): ?>
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Título</th>
							<th>Autor</th>
							<th>Editorial</th>
							<th>Departamento</th>
							<th>Asignatura</th>
							<th>Grupos</th>
							<?php if((stristr($_SESSION['cargo'],'1') == true) || ((stristr($_SESSION['cargo'],'4') == true) && ($_SESSION['depto'] == $row['departamento']))): ?>
							<th></th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysql_fetch_array($result)): ?>
						<tr>
							<td nowrap><?php echo $row['titulo']; ?></td>
							<td><?php echo $row['autor']; ?></td>
							<td><?php echo $row['editorial']; ?></td>
							<td><?php echo $row['departamento']; ?></td>
							<td><?php echo $row['asignatura']; ?></td>
							<td><?php echo $row['grupo']; ?></td>
							<?php if((stristr($_SESSION['cargo'],'1') == true) || ((stristr($_SESSION['cargo'],'4') == true) && ($_SESSION['depto'] == $row['departamento']))): ?>
							<td nowrap>
								<a href="editextos.php?id=<?php echo $row['id']; ?>" rel="tooltip" title="Editar"><span class="fa fa-pencil fa-fw fa-lg"></span></a>
								<a href="textos.php?action=delete&id=<?php echo $row['id']; ?>" rel="tooltip" title="Eliminar" data-bb='confirm-delete'><span class="fa fa-trash-o fa-fw fa-lg"></span></a>
							</td>
							<?php endif; ?>
						</tr>
						<?php endwhile; ?>
						<?php mysql_num_rows($result); ?>
					</tbody>
				</table>
			</div>
			<?php else: ?>
			
			<h3>No se han encontrado resultados según los criterios de búsqueda.</h3>
			<br>
			<br>
			
			<?php endif; ?>
			
			<div class="hidden-print">
				<a href="#" class="btn btn-primary" onclick="javascript:print();">Imprimir</a>
				<a href="consulta.php" class="btn btn-default">Nueva búsqueda</a>
			</div>
			
		</div><!-- /.col-sm-12 -->
		<?php endif; ?>
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>

</body>
</html>
>>>>>>> FETCH_HEAD
