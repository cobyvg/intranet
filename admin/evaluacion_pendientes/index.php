<?
if (isset($_POST['poner'])) {
	include 'lista_pendientes.php';
	exit();
}
if (isset($_POST['consultar'])) {
	include 'consulta_pendientes.php';
	exit();
}
?>
<?php 
session_start();
include("../../config.php");
include_once('../../config/version.php');

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

$check=mysqli_query($db_con,"select * from evalua_pendientes");
if ($check) {}else{
mysqli_query($db_con,"CREATE TABLE IF NOT EXISTS `evalua_pendientes` (
`id` int(11) NOT NULL auto_increment,
  `evaluacion` tinyint(1) NOT NULL,
  `claveal` varchar(8) NOT NULL,
  `codigo` int(6) NOT NULL,
  `materia` varchar(8) NOT NULL,
  `nota` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;");
}

$depto = $_SESSION ['dpt'];
$profe_dep = $_SESSION ['profi'];
if(stristr($_SESSION['cargo'],'1') == TRUE){
$query_Recordset1 = "SELECT distinct pendientes.codigo FROM pendientes order by codigo";
}
elseif (stristr ( $_SESSION ['cargo'], '4' ) == TRUE)
{
$query_Recordset1 = "select distinct codigo from 
profesores, asignaturas where asignaturas.nombre = materia and profesor in (select distinct departamentos.nombre from departamentos where departamento = '$depto') and abrev like '%\_%' and codigo in (SELECT distinct pendientes.codigo FROM pendientes order by codigo)";
}
else{
$query_Recordset1 = "select distinct codigo from 
profesores, asignaturas where asignaturas.nombre = materia and profesor in (select distinct departamentos.nombre from departamentos where departamento = '$depto') and abrev like '%\_%' and codigo in (SELECT distinct pendientes.codigo FROM pendientes where grupo in (select distinct grupo from profesores where profesor = '$profe_dep') order by codigo)";	
}

$Recordset1 = mysqli_query($db_con, $query_Recordset1) or die(mysqli_error($db_con));
$row_Recordset1 = mysqli_fetch_array($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Evaluación de Pendientes <small>Listado de pendientes por asignatura</small></h2>
	</div>
	
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-5 col-sm-offset-1">
			
			<div class="well">
				
				<form method="post" action="index.php">
					<fieldset>
						<legend>Registro de Calificaciones de Pendientes</legend>
						
						<div class="form-group">
						  <select class="form-control" name="select">
<?php 
do {  
	$asig = mysqli_query($db_con,"select distinct nombre, curso from asignaturas where codigo = '$row_Recordset1[0]' order by curso, nombre");
	$asignatur = mysqli_fetch_row($asig);
	$asignatura = $asignatur[0];
	$curso = $asignatur[1];
?>
    <option value='<?php  echo $row_Recordset1[0];?>'><?php  echo $curso." => ".$asignatura;?></option>
    <?php 
} while ($row_Recordset1 = mysqli_fetch_array($Recordset1));
  $rows = mysqli_num_rows($Recordset1);
?>
						  </select>
						</div>
					  
					  <button type="submit" class="btn btn-primary" name="poner">Registrar Calificaciones</button>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		<div class="col-sm-5">
			
			<div class="well">
			
			<form method="post" action="index.php">
					<fieldset>
						<legend>Consulta de Calificaciones</legend>
						
						<div class="form-group">
						  <select class="form-control" name="curso">
<?php 
	$asig2 = mysqli_query($db_con,"select distinct curso from alma, cursos where curso=nomcurso and unidad in (select distinct unidad from pendientes) and curso not like '1%' order by idcurso");
	while($asignatur2 = mysqli_fetch_row($asig2)){
	$curso1 = $asignatur2[0];
?>
    <option><?php  echo $curso1;?></option>
    <?php 
	}
?>
						  </select>
						</div>
					  	<div class="form-group">
						  <select class="form-control" name="evaluacion">

    <option value='1'>1ª Evaluación</option>
     <option value='2'>2ª Evaluación</option>
      <option value='3'>Evaluación Ordinaria</option>
       <option value='4'>Evaluación Extraordinaria</option>

						  </select>
						</div>
					  <button type="submit" class="btn btn-primary" name="consultar">Consultar Calificaciones</button>
				  </fieldset>
				</form>
				
			</div>
			
			</div>
	
	</div><!-- /.row -->
	
</div><!-- /.container -->

<?php include("../../pie.php"); ?>
</body>
</html>
