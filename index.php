<?php
// COMPROBAMOS LA VERSIÓN DE PHP
if (version_compare(phpversion(), '5.3.0', '<')) die ("<h1>Versión de PHP incompatible</h1>\n<p>Necesita PHP 5.3.0 o superior para poder utilizar esta aplicación.</p>");

session_start();

// Comprobamos estado del archvo de configuraciï¿½n.
$f_config = file_get_contents('config.php');

$tam_fichero = strlen($f_config);
if (file_exists ( "config.php" ) and $tam_fichero > '10') {
}
else{
// Compatibilidad con versiones anteriores: se mueve el archivo de configuraciï¿½n al directorio raï¿½z.
// Archivo de configuraciï¿½n en antiguo directorio se mueve al raiz de la intranet
if (file_exists ("/opt/e-smith/config.php")) 
{
	$texto = fopen("config.php","w+");
	if ($texto==FALSE) {
		echo "<script>alert('Parece que tenemos un problema serio para continuar: NO es posible escribir en el directorio de la Intranet. Debes asegurarte de que sea posible escribir en ese directorio, porque la aplicación necesita modificar datos y crear archivos dentro del mismo. Utiliza un Administrador de archvos para conceder permiso de escritura en el directorio donde se encuentra la intranet. Hasta entonces me temo que no podemos continuar.')</script>";
		fclose($texto);
		exit();
	}
	else{
$lines = file('/opt/e-smith/config.php');
$Definitivo="";
foreach ($lines as $line_num => $line) {
$Definitivo.=$line;
}
$pepito=fwrite($texto,$Definitivo) or die("<script>alert('Parece que tenemos un problema serio para continuar: NO es posible escribir en el archivo de configuración de la Intranet ( config.php ). Debes asegurarte de que sea posible escribir en ese directorio, porque la aplicación necesita modificar datos y crear archivos dentro del mismo. Utiliza un Administrador de archvos para conceder permiso de escritura en el directorio donde se encuentra la intranet. Hasta entonces me temo que no podemos continuar.')</script>");
fclose ($texto);
}
}
else{
	header("location:config/index.php");
	exit();
}
}
// Archivo de configuración cargado
include_once("config.php");

// COMPROBAMOS LA SESION
if ($_SESSION['autentificado'] != 1) {
	$_SESSION = array();
	session_destroy();
	header('Location:'.'http://'.$dominio.'/intranet/salir.php');	
	exit();
}

registraPagina ( $_SERVER ['REQUEST_URI'], $db_host, $db_user, $db_pass, $db );
$pr = $_SESSION ['profi'];
// Comprobamos si da clase a alg&uacute;n grupo
$cur0 = mysql_query ( "SELECT distinct prof FROM horw where prof = '$pr'" );
$cur1 = mysql_num_rows ( $cur0 );
$_SESSION ['n_cursos'] = $cur1;
$n_curso = $_SESSION ['n_cursos'];
// Variable del cargo del Profesor
$cargo0 = mysql_query ( "select cargo, departamento, idea from departamentos where nombre = '$pr'" );
$cargo1 = mysql_fetch_array ( $cargo0 );
$_SESSION ['cargo'] = $cargo1 [0];
$carg = $_SESSION ['cargo'];
$_SESSION ['dpt'] = $cargo1 [1];
$dpto = $_SESSION ['dpt'];
if (isset($_POST['idea'])) {}
else{
$_SESSION ['ide'] = $cargo1 [2];
$idea = $_SESSION ['ide'];
}
if (stristr ( $carg, '2' ) == TRUE) {
	$result = mysql_query ( "select distinct unidad from FTUTORES where tutor = '$pr'" );
	$row = mysql_fetch_array ( $result );
	$_SESSION ['tut'] = $pr;
	$_SESSION ['s_unidad'] = $row [0];
}
?>
<? include("menu.php");?>

	<div class="container-fluid" style="padding-top: 15px;">
		
		<div class="row">
			
			<!-- COLUMNA IZQUIERDA -->
			<div class="col-sm-3">
				
				<div id="bs-tour-menulateral">
				<?php include("menu_lateral.php"); ?>
				</div>
				
				<div id="bs-tour-ausencias" class="hidden-xs">
				<?php include("admin/ausencias/widget_ausencias.php"); ?>
				</div>
				
				<div id="bs-tour-destacadas" class="hidden-xs">
				<?php include ("admin/noticias/widget_destacadas.php"); ?>
				</div>
	
			</div><!-- /.col-sm-3 -->
			
			
			<!-- COLUMNA CENTRAL -->
			<div class="col-sm-5">
				
				<?php 
				if (stristr($carg, '2' )==TRUE) {
					$_SESSION['mod_tutoria']['tutor']  = $_SESSION['tut'];
					$_SESSION['mod_tutoria']['unidad'] = $_SESSION['s_unidad'];
					
					define('INC_TUTORIA', 1);
					include("admin/tutoria/inc_pendientes.php");
				}
				?>
				<div id="bs-tour-pendientes">
				<?php include ("pendientes.php"); ?>
				</div>
				          
        <div class="bs-module">
        <?php include("admin/noticias/widget_noticias.php"); ?>
        </div>
        
        <br>
				
			</div><!-- /.col-sm-5 -->
			
			
			
			<!-- COLUMNA DERECHA -->
			<div class="col-sm-4">
				
				<div id="bs-tour-buscar">
				<?php include("buscar.php"); ?>
				</div>
				
				<br><br>
				
				<div id="bs-tour-calendario">
				<?php include("admin/calendario/index.php"); ?>
				</div>
				
				<br><br>
				
				<?php if($mod_horario and ($n_curso > 0)): ?>
				<div id="bs-tour-horario">
				<?php include("horario.php"); ?>
				</div>
				<?php endif; ?>
				
			</div><!-- /.col-sm-4 -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->

<?php include("pie.php"); ?>
	
	<?php if (isset($_GET['tour']) && $_GET['tour']): ?>
	<script>
	// Instance the tour
	var tour = new Tour({
		
		onEnd: function() {
		  return window.location.href = 'http://<?php echo $dominio; ?>/intranet/index.php';
		},
		
		keyboard: true,
		template: "<div class='popover tour'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default btn-sm' data-role='prev'>« Anterior</button>&nbsp;<button class='btn btn-default btn-sm' data-role='next'>Siguiente »</button><button class='btn btn-default btn-sm' data-role='end'>Terminar</button></div></nav></div>",
		
	  steps: [
	  {
	    title: "<h1>Bienvenido a la Intranet</h1>",
	    content: "<p class='lead'>Antes de comenzar, realice un tour por la portada de la Intranet para conocer las características de los módulos que la componen y la información de la que dispone.</p><p>Haga click en <strong>Siguiente</strong> para continuar o haga click en <strong>Omitir</strong> para saltarse el tour.",
	    container: "body",
	    template: "<div class='popover tour' style='max-width: 600px !important;'><div class='arrow'></div><h3 class='popover-title'></h3><div class='popover-content'></div><div class='popover-navigation'><button class='btn btn-default btn-sm' data-role='next'>Siguiente »</button><button class='btn btn-default btn-sm' data-role='end'>Omitir</button></div></nav></div>",
	    orphan: true,
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-usermenu",
	    title: "Menú de usuario",
	    content: "Desde este menú podrás volver a cambiar la contraseña, correo electrónico y la fotografía.",
	    container: "body",
	    placement: "bottom",
	    backdrop: false,
	  },
	  {
	    element: "#bs-tour-consejeria",
	    title: "Novedades de la Consejería",
	    content: "Consulta las últimas novedades de la Consejería de Educación, Cultura y Deporte de la Junta de Andalucía. Este icono solo será visible desde la portada de la Intranet.",
	    container: "body",
	    placement: "bottom",
	    backdrop: false,
	  },
	  {
	    element: "#bs-tour-mensajes",
	    title: "Mensajes",
	    content: "Consulta los últimos mensajes recibidos. Cuando recibas un mensaje, el icono cambiará de color para avisarte. Para leer el mensaje haz click en este icono o dirígete a la portada de la Intranet para ver todos los avisos.",
	    container: "body",
	    placement: "bottom",
	    backdrop: false,
	  },
	  {
	    element: "#bs-tour-menulateral",
	    title: "Menú de opciones",
	    content: "Según tu perfil de trabajo tendrás un menú con las opciones que necesitas en tu día a día.<br>Desde el menú <strong>Consultas</strong> tendrás acceso a la información de los alumnos, horarios, estadísticas y fondos de la Biblioteca del centro.<br>El menú <strong>Trabajo</strong> contiene las acciones de registro de Problemas de Convivencia, Faltas de Asistencia, Reservas de aulas y medios audiovisuales, Actividades evaluables, etc.<br>El menú <strong>Departamento</strong> contiene las opciones necesarias para la gestión de tu departamento.<br>Y por último, <strong>Páginas de interes</strong> contiene enlaces a páginas externas de información y recursos educativos.",
	    container: "body",
	    placement: "right",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-ausencias",
	    title: "Profesores de baja",
	    content: "Este módulo ofrece información sobre los profesores que están de baja en el día. Si el profesor ha indicado tareas para los alumnos aparecerá marcado con el icono chequeado. Para registrar una ausencia debe dirigirse al menú <strong>Trabajo</strong>, <strong>Profesores ausentes</strong>.",
	    container: "body",
	    placement: "right",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-destacadas",
	    title: "Noticias destacadas",
	    content: "Este módulo ofrece un listado de las noticias mas importantes. Puede aparecer durante varios días, según lo establezca el Equipo directivo.",
	    container: "body",
	    placement: "right",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-pendientes",
	    title: "Tareas pendientes",
	    content: "Aquí aparecerán los avisos de tareas pendientes que tienes pendientes por realizar.",
	    container: "body",
	    placement: "bottom",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-buscar",
	    title: "Buscar alumnos y noticias",
	    content: "Este buscador te permite buscar alumnos para consultar su expediente o realizar alguna acción como registrar un Problema de Convivencia o Intervención. Puedes buscar tanto por nombre como apellidos. <br>Si presionas la tecla <kbd>Intro</kbd> buscará coincidencias en las noticias publicadas.",
	    container: "body",
	    placement: "left",
	    backdrop: true,
	  },
	  {
	    element: "#bs-tour-calendario",
	    title: "Calendario del centro y Calendario personal",
	    content: "En la parte inferior del calendario aparecerá las actividades de los próximos 7 días. Si el texto está marcado en color naranja quiere decir que dicha actividad afecta a su horario. También aparecerá su <em>Calendario personal</em> con aquellas actividades evaluables que haya registrado desde el menú <strong>Trabajo</strong>, <strong>Actividades evaluables</strong>.",
	    container: "body",
	    placement: "left",
	    backdrop: true,
	  }],
	 	});
	
	// Initialize the tour
	tour.init();
	
	// Start the tour
	tour.start(true);
	</script>
	<?php endif; ?>

</body>
</html>
