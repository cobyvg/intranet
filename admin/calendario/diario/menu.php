<?
$activo1="";
$activo2="";
$activo3="";
if (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) {$activo1 = ' class="active" ';}
if (strstr($_SERVER['REQUEST_URI'],'index_cal.php')==TRUE){ $activo2 = ' class="active" ';}
?>

<div class="container">  
	
	<div class="pull-right">
		<a href="#" data-toggle="modal" data-target="#ayuda"><span class="fa fa-question-circle fa-lg"></span></a>
	</div>
	
	<div id="ayuda" class="modal fade">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
	        <h4 class="modal-title">Instrucciones de uso</h4>
	      </div>
	      <div class="modal-body">
	        <p>A través de esta página puedes registrar las pruebas, controles o actividades de distinto tipo para los alumnos de los Grupos a los que das clase, o bien puedes utilizar esta página para registrar entradas personales como si fuera un calendario.</p>
	        
	        <p>Los registros que estén relacionados con tus Grupos y Asignaturas aparecerán en el Calendario de la Intranet, pero también en la página personal del alumno en la Página del Centro, de tal modo que Padres y Alumnos puedan ver en todo momento las fechas de las pruebas; si la actividad no contiene Grupo alguno aparecerá sólo en el Calendario de la Intranet a modo de recordatorio.</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">De acuerdo</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
  <ul class="nav nav-tabs">
    <li<? echo $activo1;?>><a href="index.php">Nueva actividad</a></li>	
    <li<? echo $activo2;?>><a href="index_cal.php">Calendario de actividades</a></li>	
	</ul>
	
 </div>
