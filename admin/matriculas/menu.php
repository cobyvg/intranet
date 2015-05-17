<?php
if (isset($_GET['curso'])) {$curso = $_GET['curso'];}elseif (isset($_POST['curso'])) {$curso = $_POST['curso'];}else{$curso="";}
if (isset($_GET['dni'])) {$dni = $_GET['dni'];}elseif (isset($_POST['dni'])) {$dni = $_POST['dni'];}else{$dni="";}
if (isset($_GET['enviar'])) {$enviar = $_GET['enviar'];}elseif (isset($_POST['enviar'])) {$enviar = $_POST['enviar'];}else{$enviar="";}
if (isset($_GET['id'])) {$id = $_GET['id'];}elseif (isset($_POST['id'])) {$id = $_POST['id'];}else{$id="";}
if (isset($_GET['listados'])) {$listados = $_GET['listados'];}elseif (isset($_POST['listados'])) {$listados = $_POST['listados'];}else{$listados="";}
if (isset($_GET['listado_total'])) {$listado_total = $_GET['listado_total'];}elseif (isset($_POST['listado_total'])) {$listado_total = $_POST['listado_total'];}else{$listado_total="";}
if (isset($_GET['imprimir'])) {$imprimir = $_GET['imprimir'];}elseif (isset($_POST['imprimir'])) {$imprimir = $_POST['imprimir'];}else{$imprimir="";}
if (isset($_GET['cambios'])) {$cambios = $_GET['cambios'];}elseif (isset($_POST['cambios'])) {$cambios = $_POST['cambios'];}else{$cambios="";}
if (isset($_GET['sin_matricula'])) {$sin_matricula = $_GET['sin_matricula'];}elseif (isset($_POST['sin_matricula'])) {$sin_matricula = $_POST['sin_matricula'];}else{$sin_matricula="";}
?>
	
	<div class="container">
		
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'previsiones.php')==TRUE) ? ' class="active"' : ''; ?>><a href="previsiones.php">Previsiones de matrícula</a></li>
			<li class="dropdown<?php echo (strstr($_SERVER['REQUEST_URI'],'consultas')==TRUE) ? ' active' : ''; ?>">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			    Consultas <span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="consultas.php">Matriculas de ESO</a></li>
			    <li><a href="consultas_bach.php">Matriculas de Bachillerato</a></li>
			  </ul>
			</li>
			<li class="dropdown<?php echo (strstr($_SERVER['REQUEST_URI'],'index')==TRUE) ? ' active' : ''; ?>">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			    Matriculación <span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="index.php">Matricular en ESO</a></li>
			    <li><a href="index_bach.php">Matricular en Bachillerato</a></li>
			  </ul>
			</li>
			<li class="dropdown<?php echo (strstr($_SERVER['REQUEST_URI'],'importar')==TRUE) ? ' active' : ''; ?>">
			  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			    Herramientas <span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="index_primaria.php">Importar Alumnado de Primaria</a></li>
			  	<li><a href="index_secundaria.php">Importar Alumnado de ESO</a></li>
			  	<li><a href="activar_matriculas.php?activar=1">Activar matriculación</a></li>
			  	<li><a href="activar_matriculas.php?activar=2">Desactivar matriculación</a></li>
			  </ul>
			</li>
			<li><a href="consulta_transito.php">Informes de Tránsito</a></li>
			<li>
			<!-- Button trigger modal -->
<a href="#" data-toggle="modal" data-target="#myModal">
 <span class="fa fa-question-circle fa-lg"></span>
</a>

 <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Instrucciones de uso.</h4>
      </div>
      <div class="modal-body">
		<p class="help-block">
		El módulo de Matriculación de Alumnos permite la matriculación de los alumnos en ESO o Bachillerato a través de la Página del Centro (o bien de la Intranet). La Página pública del Centro contiene, dentro de la sección privada <b>"Acceso para los Alumnos"</b>, un formulario de matriculación que se activa en el mes de Junio. Los padres o los alumnos (en una sesión de Tutoría y acompañados por el Tutor) registran en primer lugar los datos de la matrícula. A continuación, el Centro imprime los papeles de la matrícula y se le entregan al alumno para que sus padres los firmen y presenten posteriormente en la Administración dentro de las fechas elegidas por el Centro. </p>
		<p class="help-block"> 
		La sección <b>"Matriculación"</b> presenta un formulario semejante al que hay en la Página del Centro. Permite matricular a los alumnos desde la Intranet.</p>
		<p class="help-block">
		La sección <b>"Consultas"</b> presenta los datos de los alumnos matriculados de forma estucturada en una tabla. Los datos pueden ser filtrados y ordenados de múltiples maneras, en función de las opciones propias de cada nivel. El primer campo de verificación que nos encontramos en la tabla debe ser marcado por el personal de Administración o Equipo directivo cuando el alumno entrega la matrícula, para así diferenciar entre los alumnos que se han matyriculado y los que han entregado efectivamente la matrícula. El campo "GR2" permite asigna la letra del grupo al alumno para generar posteriormente los listados de grupos de una forma fácil. Las casillas "Bil" y "Div" se utilizan para seleccionar a los alumnos Bilingues y de Diversificación.<br> 
		Los botones de radio asociados al Promoción (SI/PIL/NO en ESO; SI/NO/3-4 en Bachillerato) son el elmento decisivo de la consulta. Cuando se han subido las calificaciones de la Evaluación Ordinaria, la aplicación aplica los criterios de promoción habitulaes en cada nivel y marca el boton de radio correspondiente. Es entonces cuando se pueden "Enviar lo datos" con el botón que hay al final de la tabla de consultas. Sin embargo, hay que tener en cuenta que hay alumnos que pueden promocionar por imperativo legal, o con más de 2 asignaturas suspensas, etc. Estos alumnos anómalos deben ser seleccionados antes de enviar los datos para que la aplicación no seleccione la opción equivocada. Hay que tener en cuenta que en Junio sólo paracerán seleccionados los alumnos que promocionan. Los alumnos que tengan materias pendientes para Septiembre aparecen sin ninguna opción de promoción marcada hasta que las calificaciones de la Evaluación Extraordinaria se importan en la Intranet, cuando habrá que enviar los datos una vez contempladas las anomalías mencionadas antes.<br>
		Al final de la tabla aparece un conjunto de botones con funciones específicas. El botón <b>"Imprimir"</b> manda a la impresora el documento PDF de todos los alumnos del nivel que estamos consultando, la misma función asignada al botón <b>"Carátulas"</b> (para pegar en la portada del sobre o carpeta donde se guardan los documentos impresos de la matrícula). El botón <b>"Ver cambios en datos"</b> facilita al personal de Administración la tarea de saber qué alumnos han modificado datos importantes de la matrícula respecto a la del curso anterior (Dirección, Teléfonos, etc.). El botón <b>"Alumnos sin matricular"</b> nos informa sobre los alumnos de Centro que no han registrado los datos en el formulario. El último botón genera un PDF con las listas de alumnos por grupo asignado, y sólo presenta los datos de los alumnos cunado estos han sido asignados a un grupo en el campo "GR2".<br>
		La Consulta contiene al final una tabla con estadísticas de la matriculación en diferentes campos dependiendo del nivel.
		</p>
		<p class="help-block">
		La sección <b>"Herramientas"</b> del menú permite <em>importar los datos de los alumnos pertenecientes a Centros adscritos</em>, tanto de Primaria como de Secundaria. La página de importación da información concreta sobre el proceso a seguir para realizarla, tanto en Primaria como en Secundaria (si procede). Esto permite extender los beneficios de la matriculación a los alumnos de los mismos. Estos acceden al formulario de matriculación del mismo modo que los propios alumnos del Centro, a través del enlace <b>"Acceso para Alumnos"</b> en la Página del Centro. Se identifican con el DNI o NIF del Tutor legal en los campos "Clave del Centro" y "Clave del Alumno".<br>
		Los alumnos del Centro se identifican mediante el NIE de Séneca en los campos <em>"Clave del Centro" y "Clave del Alumno"</em>. El Tutor les entrega normalmente el NIE en la sesión de Tutoría dedicada a la matriculación. Para poder matricularse, es necesario <b>"Activar la matriculación"</b>. Al hacerlo, se modifica la tabla de contraseñas que los Padres utilizan para acceder a las páginas privadas del alumno en la Página pública del Centro, de tal modo que el acceso se haga con el NIE. Una vez terminado el proceso, hay que <b>"Desactivar la matriculación"</b> para restaurar las contraseñas de los Padres y estos puedan volver a entrar normalmente.</p>      
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
			</li>
		</ul>
		
	</div>
	