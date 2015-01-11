<?
session_start();
include("../config.php");
include_once('../config/version.php');
// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/salir.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/salir.php');
		exit();
	}
}

if($_SESSION['cambiar_clave']) {
	if(isset($_SERVER['HTTPS'])) {
	    if ($_SERVER["HTTPS"] == "on") {
	        header('Location:'.'https://'.$dominio.'/intranet/clave.php');
	        exit();
	    } 
	}
	else {
		header('Location:'.'http://'.$dominio.'/intranet/clave.php');
		exit();
	}
}


registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);



if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header('Location:'.'http://'.$dominio.'/intranet/salir.php');
exit;	
}
?>
<?
include("../menu.php");
?>

<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Funciones, configuración, importación de datos,...</small></h2>
	</div>
	
	
	<div class="row">
		
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-4">
		
			<div class="well">
			<?php include("menu.php");?>
			</div>
			
		</div><!-- /.col-sm-4 -->
		
		
		<!-- COLUMNA DERECHA -->
		<div class="col-sm-8">
			
			<h3>Descripción de los módulos e instrucciones.</h3>
			
			<div class="text-justify">
			<p>	
			Esta es la pagina de Administración de la Intranet y de las Bases de Datos de la misma. A continuación siguen algunas explicaciones sobre la mayoría de los módulos que componen la aplicación.</p>
			<hr>
			<p>La <strong>primera opción (<span class="text-info">Cambiar la Configuración</span>)</strong> permite editar y modificar los datos de la configuración que se crearon cuando se instaló la Intranet.</p> 
			
			<hr>
			<p>	
			El <strong>segundo grupo de opciones (<span class="text-info">A Principio de curso...</span>)</strong> crea las tablas principales: Alumnos, Profesores, Asignaturas, Calificaciones y Horarios. Hay que tener a mano varios archivos que descargamos de Seneca y Horw: </p>
			<ul>
			
			<li>Los Alumnos, Asignaturas y Sistemas de Calificaciones se crean una sola vez a comienzo de curso, aunque luego podemos actualizarlos cuando queramos. En este proceso se crean las tablas de Alumnos y se les asigna un número de aula. También se generan dos archivos preparados para el Alta masiva de Alumnos y Profesores en Gesuser (los coloca en intranet/xml/jefe/TIC/). Necesitamos dos archivos de Séneca: 
			<ul>
			  <li>el de los alumnos. Lo descargamos desde Séneca. Alumnado --&gt; Alumnado --&gt; Alumnado del Centro --&gt; Aceptar (arriba a la derecha) --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano. El archivo que se descarga se llama RelPerCen.txt</li>
			  <li>el de las evaluaciones. Se descarga de Seneca desde &quot;Intercambio de Información --&gt; Exportación desde Seneca --&gt; Exportación de Calificaciones&quot;. Arriba a la derecha hay un icono para crear un nuevo documento con los datos de las evaluaciones; seleccionar todos los grupos del Centro para una evaluación (la primera vale, por ejemplo) y añadirlos a la lista. Cuando hayáis terminado, haced click en el icono de confirmación y al cabo de un minuto volved a la página de exportación de calificaciones y veréis que se ha generado un archivo comprimido que podéis descargaros. </li>
			</ul>
			</li>
			<li>Los datos generales del Centro. Este módulo se encarga de importar la relación de <strong>cursos</strong> y <strong>unidades</strong> del Centro registrados en Séneca, así como la relación de <strong>materias</strong> que se imparten y <strong>actividades</strong> del personal docente. Se importará también la relación de <strong>dependencias</strong>, que se utilizará para realizar reservas de aulas o consultar el horario de aulas.</li>
			  <li>Los profesores. Se descarga desde Séneca --&gt; Personal --&gt; Personal del centro --&gt; Unidades y Materias  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
			  <li>Los Horarios (que generamos con Horw). Requiere el archivo con extensión XML que se genera con el programa generador de horarios para subir los datos del Horario a Séneca. Este módulo también se encarga de preparar el archivo para exportar a Séneca que crean los programas de Horarios (Horw, etc.), evitando tener que registrar manualmente los horarios de cada profesor. La adaptación que realiza este módulo es conveniente, ya que la compatibilidad con Séneca de los generadores de horarios tiene limitaciones (Código único de las asignaturas de Bachillerato, Diversificación, etc.). Es necesario tener a mano el archivo en formato XML que se exporta desde Horw o cualquier otro generador de Horarios. 
Es posible importar los horarios con el archivo de tipo DL que se genera con Horwin, pero esta opción sólo debe utilizarse excepcionalmente. La opción preferida y más completa es el archivo XML.</li>
			  <li>Los Departamentos. Se descarga desde Séneca --&gt; Personal --&gt; Personal del centro  --&gt; Exportar (arriba a la izquierda) --&gt; Exportar datos al formato: Texto plano.</li>
			  <li>Los Horarios (que generamos con Horw). Solo se genera una vez a principio de Curso. Las instrucciones de la descarga están en el formulario correspondiente, al pinchar en el enlace.</li>
			 <li>La importación de alumnos pendientes permite crear una tabla con los alumnos con asignaturas pendientes de cursos anteriores, que posteriormente puede consultarse en Consultas --> Listas de alumnos. </li>
			</ul>
			</p>
			<hr>
			<p>
			El <strong>tercer grupo de opciones</strong> afecta a los <strong><span class="text-info">Profesores</span></strong>. 
			 Una vez se han creado los Departamentos y Profesores, es necesario seleccionar los <span class="text-info">Perfiles de los Profesores</span> para que la aplicación se ajuste a las funciones propias de cada profesor ( Tutor, Dirección, Jefe de Departamento, etc. ). También desde aquí se puede <span class="text-info">Restablecer las contraseñas</span> de los profesores que se hayan olvidado de la misma. Al restablecer, el profesor deberá entrar de nuevo con el DNI como contraseña, lo que le llevará a la página desde la que tendrá que cambiarla con los criterios de Séneca. La última opción, <span class="text-info">Copiar datos de un profesor a otro</span> cambia el horario de un profesor que ha sido sustituido al profesor que lo sustituye, de tal manera que el nuevo profesor pueda entrar en la Intranet con su usuario IdEA normalmente.
			 </p>
			 <hr>
			<p>
			    El <strong>cuarto grupo (<span class="text-info">Actualización</span>)</strong> permite actualizar los datos de Alumnos, Profesores y Departamentos del Centro. Esta pensado para la actualización de los alumnos que se van matriculando a lo largo del Curso, así como para la puesta al día de la lista de Profesores y Departamentos. Necesita el archivo de alumnos y el de la evaluación correspondiente como en la primera opción, ambos actualizados. Los módulos de Profesores y Departamentos, así como el de Horarios, requieren de sus respectivos archivos, especificados en su propia página. Es importante tener en cuenta que después de actualizar los horarios deben actualizarse los profesores para garantizar la compatibilidad de los datos de Horw con Séneca. La última opción, Limpiar Horarios, se debe ejecutar cuando los cambios en los horarios se han dado por terminados y se encuentran en perfecto estado en Séneca. Supone que los profesores se encuentran actualizados.</p>
			    <hr>
			<p>	
			El <strong>quinto grupo (<span class="text-info">Notas de Evaluación</span>)</strong> crea y actualiza la tabla de las Notas de Evaluación que aparecen en los Informes de la Intranet, pero también presenta las Calificaciones del alumno en la pagina principal. Los archivos necesarios se descargan de Séneca desde &quot;Intercambio de Información --&gt; Exportación desde Seneca --&gt; Exportación de Calificaciones&quot;.</p>
			<hr>
			<p>El <strong>sexto grupo <span class="text-info">(Faltas de asistencia</span>)</strong> contiene un grupo de funciones que aparecen si el módulo de Faltas de asistencia ha sido activado en la página de Configuración de la intranet.</p>
			<ul>
			  <li>&quot;Alumnos Absentistas&quot; da entrada al módulo de Absentismo, desde el cual se registran los alumnos y permite al Tutor, Dirección y Orientación informar sobre los mismos. </li>
			  <li>El &quot;Parte de Faltas completo&quot; genera todos los partes de aula de Faltas de Asistencia para todas las clases,  todos los días de la semana. </li>
			  <li>El &quot;Informe de Faltas para Padres&quot; presenta las cartas que se envían a los papás con las faltas del nene,
			    preparadas para imprimir, pero solo en aquellos casos para los que no se envíen SMS con la siguiente opción, &quot;SMS de Faltas para Padres&quot;. </li>
			  <li>&quot;Horario de faltas para profesores&quot; crea los horarios que los profesores necesitan para registrar las faltas de asistencia de los alumnos. Cada profesor marca en su horario el número de clase de los alumnos ausentes en una semana, y, o bien las registra posteriormente en el módulo de &quot;Poner faltas&quot;, o bien lo entrega para que los Tutores de Faltas lo hagan.</li>
			  <li>&quot;SMS de faltas para los Padres&quot; permite enviar regularmente un SMS de faltas a los padres de modo masivo. Se envían SMS a los padres de todos los alumnos que tengan un mínimo de una falta de asistencia en el plazo de tiempo seleccionado.</li>
			</ul>
			<hr>
			<p>El <strong>séptimo grupo <span class="text-info">(Alumnos)</span></strong> toca asuntos varios relacionados con los mismos. </p>
			<ul>
			 <li>Las Listas de Grupos. Supone que se han realizado todas las tareas anteriores (Horario, Profesores, Alumnos, etc.). Presenta la lista de todos los Grupos del Centro preparada para ser imprimida y entregada a los Profesores a principios de Curso. </li>
			<li>"Carnet de los Alumnos" permite generar los carnet de los alumnos del Centro preparados para ser imprimidos. Este módulo supone que se han subido las fotos de los alumnos a la intranet utilizando el enlace "Subir fotos de alumnos", a continuación.</li>
			<li>"Subir fotos de alumnos" permite hacer una subida en bloque de todas las fotos de los alumnos para se utilizadas por los distintos módulos de la Intranet. Para ello, necesitaremos crear un archivo comprimido ( .zip ) con todos los archivos de fotos de los alumnos. Cada archivo de foto tiene como nombre el NIE de Séneca (el Número de Identificación que Séneca asigna a cada alumno ) seguido de la extensión .jpg o .jpeg. El nombre típico de un archivo de foto quedaría por ejemplo así: 1526530.jpg. Las fotos de los profesores se suben del mismo modo, pero el nombre se construye a partir del usuario IdEA ( mgargon732.jpg, por ejemplo).</li>
			  <li>&quot;Libros de Texto gratuitos&quot; es un conjunto de páginas pensadas para registrar el estado de los libros de cada alumno dentro del Programa de Ayudas al Estudio de la Junta, e imprimir los certificados correspondientes (incluidas las facturas en caso de mal estado o pérdida del material).</li>
			    <li>&quot;Matriculación de alumnos&quot; es un módulo que permite matricular a los alumnos a través de la intranet o, en su caso, a través de internet (si el módulo se ha incorporado a la página principal del Centro). Los tutores, a final de curso, ayudan a los alumnos a matricularse en una sesión de tutoría. Posteriormente el Centro imprime los formularios de la matrícula y se los entregan a los alumnos para ser firmados por sus padres y entregados de nuevo en el IES. El Equipo directivo cuenta entonces con la ventaja de poder administrar los datos fácilmente para formar los grupos de acuerdo a una gran variedad de criterios. El módulo incluye una página que realiza previsiones de matriculación de alumnos en las distintas evaluaciones.</li> 
			    </ul>
			<hr>
			<p>El <strong>último grupo <span class="text-info">(Base de datos)</span></strong> permite realizar copias de seguridad de las bases de datos que contienen los datos esenciales de la Intranet. La copia de seguridad crea un archivo, comprimido o en formato texto (SQL), en un directorio de la aplicación ( /intranet/xml/jefe/copia_db/ ). Esta copia puede ser descargada una vez creada. También podemos restaurar la copia de seguridad seleccionando el archivo que hemos creado anteriormente. </p>
			
			    
			  <!--   <li>&quot;Registro de Fotocopias&quot; es un módulo que permite a los Conserjes y Dirección registrar las fotocopias que se hacen en el centro. La Dirección también puede ver estadísticas por profesor y departamento.</li>
			    
			<li>&quot;Importar fotos de alumnos&quot; permite insertar o reemplazar fotos de alumnos en la tabla <em>Fotos</em> de la Base de datos general. El directorio donde se encuentran las fotos debe ser registrado en la página de Administración de la intranet, y es conveniente que se encuentre dentro del alcance de PHP. El nombre de los archivos de las fotos debe contener como primera parte el identificador Personal del Alumno en Séneca (<strong>claveal</strong> en la tabla <strong>Alma</strong>, por ejemplo), seguido del formato de imagen (<em>.jpeg</em> o <em>.jpg</em>). Una vez insertadas o actualizadas las fotos, pueden ser consultadas desde varios módulos de la Intranet. </li>-->
			
		</div><!-- /.col-sm-8 -->
		
	</div><!-- /.row -->

</div><!-- /.container -->


<? include("../pie.php");?>  
</body>
</html>
