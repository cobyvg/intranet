<?
if (isset($_GET['recurso'])) {$recurso = $_GET['recurso'];}elseif (isset($_POST['recurso'])) {$recurso = $_POST['recurso'];}else{$recurso="";}
if (isset($_GET['servicio'])) {$servicio = $_GET['servicio'];}elseif (isset($_POST['servicio'])) {$servicio = $_POST['servicio'];}else{$servicio="";}
if (isset($_GET['mens'])) {$mens = $_GET['mens'];}elseif (isset($_POST['mens'])) {$mens = $_POST['mens'];}else{$mens="";}
if (isset($_GET['servicio_aula'])) {$servicio_aula = $_GET['servicio_aula'];}elseif (isset($_POST['servicio_aula'])) {$servicio_aula = $_POST['servicio_aula'];}else{$servicio_aula="";}
?>

	<div class="container">
		
		<ul class="nav nav-tabs">
		<!-- Button trigger modal --> <a href="#"
	class="btn btn-default btn-sm pull-right" data-toggle="modal"
	data-target="#myModal"> <span class="fa fa-question fa-lg"></span> </a>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">Información sobre el módulo de Reservas</h4>
</div>
<div class="modal-body">
<p>
El sistema de reservas permite controlar el uso de los medios del Centro (Dependencias, Recursos Audiovisuales, etc.). Hay tres categorías por defecto en el sistema: Aulas, Ordenadores y Medios. Se configura en la página de Administración de la Intranet donde se define el número, nombre, etc. de los recursos que se integran en la reserva.<br><br>
La reserva de Aulas y Dependencias del Centro está integrada con el módulo de Horarios. Puede funcionar sin la importación de los horarios si creamos las Aulas desde la opción del menú 'Crear/Ocultar/Eliminar Aulas/Dependencias', pero está pensado para tomar la lista de aulas desde el horario que hemos importado. Por defecto, todas las aulas del Centro aparecen en la lista como reservables. Si deseamos ocultar aulas del sistema utilizamos la opción mencionada del menú; también podemos crear aulas que no aparecen en el horario.<br>
El funcionamiento es sencillo: elegimos el aula (Recurso TIC o Medio), fecha y hora; comprobamos que no ha sido reservada anteriormente por otro profesor y procedemos a registrarla. El Aula Magna (Salón de Usos Múltiples) sólo puede ser reservado por el Equipo Directivo (si necesitamos hacerlo, debemos pedir autorización a los miembros del mismo). El resto de las aulas sólo permiten la reserva cuando en la hora correspondiente el aula no está asignada en el horario a algún profesor en tareas lectivas. Si nos hemos equivocado o queremos eliminar una reserva, seleccionamos el día de la misma y borramos nuestro nombre el día y la hora elegidos. Una vez borrado, enviamos los datos del formulario con el botón <em><b>Reservar</b></em> y desaparecerá de la lista.
<? if (strstr($_SESSION['cargo'],"1")==TRUE): ?>
<br>El Equipo directivo puede asignar el horario de las dependencias del Centro de 
varias maneras. Si el aula aparece en el Horario y este se ha importado en la 
base de datos, se presentarán las horas del aula con la asignatura que se 
imparte en ese momento con la expresión <strong>Asignada por Horario</strong>. 
El Equipo directivo puede asignar el aula a otro profesor por encima del Horario 
si por alguna razón lo considera necesario. La hora aparecerá entonces en el 
formulario con la expresión <strong>Asignada por Dirección.</strong><br>
Si el aula está vacía en ese momento cualquier profesor puede seleccionar esa 
hora para utilizar el aula.<br>
Si queremos asignar una hora a un profesor durante todo el curso escolar, 
seleccionamos al mismo en el formulario y pulsamos sobre el botón rojo 
<strong>Reservar todo el Curso</strong>. Es importante elegir un día sin reserva 
alguna de profesores para realizar la asignación permanente porque ls profesores 
que aparezcan en el formulario quedarán fijados para todo el curso escolar. Los 
campos en los que aparezca la palabra "Asignación" (bien por Horario o bien por 
Dirección) no se registran en la reserva permanete. A partir de ese momento los 
profesores verán en ese campo la expresión <strong>Asignada por 
Dirección</strong></strong> y no podrán elegir el aula en esa hora. Este 
procedimiento se puede aplicar tantas veces como queramos para aquellas 
dependencias o aulas que aparezcan en el horario.
<?php endif; ?>	
 <br><br>
Si hemos marcado la opción 'Centro TIC' en la instalación de la aplicación, aparecerá una entrada en el menú para los carritos de ordenadores o aulas TIC. Si utilizamos los carros de ordenadores mediante el sistema de reservas podemos acceder a las estadísticas de uso de los mismos dentro del menú de la página de iicio de la Intranet (Trabajo --> Centro TIC --> Estadísticas).<br><br> 
</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
			<? if ($mod_horario=="1"): ?>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index_aula')==TRUE) ? ' class="active"' : ''; ?>><a href="//<?php echo $dominio; ?>/intranet/reservas/index_aula.php?recurso=aula_grupo">Aulas y Dependencias del Centro</a></li>
			<?php endif; ?>
			<? if ($mod_tic=="1"): ?>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php?recurso=TIC_')==TRUE) ? ' class="active"' : ''; ?>><a href="//<?php echo $dominio; ?>/intranet/reservas/index.php?recurso=TIC_">Ordenadores TIC</a></li>
			<?php endif; ?>	
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php?recurso=medio')==TRUE) ? ' class="active"' : ''; ?>><a href="//<?php echo $dominio; ?>/intranet/reservas/index.php?recurso=medio">Medios audiovisuales</a></li>
			<? if ($mod_horario=="1"): ?>
			<? if (strstr($_SESSION['cargo'],"1")==TRUE): ?>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'ocultar.php')==TRUE) ? ' class="active"' : ''; ?>><a href="//<?php echo $dominio; ?>/intranet/reservas/ocultar.php">Crear / Ocultar / Eliminar Aulas/Dependencias</a></li>			
			<?php endif; ?>		
			<?php endif; ?>		
		</ul>
		
	</div>
