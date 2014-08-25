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


$curso = substr($curso_actual,0,4);

include("../../menu.php");
?>
	
	<div class="container">
	
		<div class="page-header">
			<h2>Calendario escolar <small>Curso <?php echo $curso; ?> / <?php echo $curso+1; ?></small></h2>
		</div>
		
		<?php
		require('../../lib/calendar.class.php');
		$cal = new calendar();
		
		$cal->enableNonMonthDays();
		$cal->enableYear();
		
		// DIAS FESTIVOS
		$result = mysql_query("SELECT fecha, nombre FROM festivos");
		
		if (mysql_num_rows($result)) {
		
			while ($row = mysql_fetch_array($result)) {
				$fecha = explode('-', $row['fecha']);
				$fecha_anio = $fecha[0];
				substr($fecha[1],0,1)==0 ? $fecha_mes = substr($fecha[1],1,2) : $fecha_mes = $fecha[1];
				substr($fecha[2],0,1)==0 ? $fecha_dia = substr($fecha[2],1,2) : $fecha_dia = $fecha[2];
				
				$cal->addEvent($row['nombre'], $fecha_anio, $fecha_mes, $fecha_dia, '#');
			}
			
		}
		?>
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(9, $curso); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(10, $curso); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(11, $curso); ?>
		  </div>
		  
		</div><!-- ./row -->
		
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(12, $curso); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(1, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(2, $curso+1); ?>
		  </div>
		  
		</div><!-- ./row -->
		
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(3, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(4, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(5, $curso+1); ?>
		  </div>
		  
		</div><!-- ./row -->
		
		<div class="row">
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(6, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(7, $curso+1); ?>
		  </div>
		  
		  <div class="col-sm-4 col-md-4">
		    <?php $cal->display(8, $curso+1); ?>
		  </div>
		  
		</div><!-- ./row -->
		
	</div><!-- /.container -->

<?php include("../../pie.php"); ?>
  
</body>
</html>
