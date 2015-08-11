<?php 
$idea = $_SESSION['ide'];
$profi = $_SESSION['profi'];


// FEED RSS
$feed = new SimplePie();
	 
$feed->set_feed_url("http://www.juntadeandalucia.es/educacion/www/novedades.xml");
$feed->set_output_encoding('ISO-8859-1');
$feed->enable_cache(false);
$feed->set_cache_duration(600);
$feed->init();
$feed->handle_content_type();

$first_items = array();
$items_per_feed = 5;

for ($x = 0; $x < $feed->get_item_quantity($items_per_feed); $x++)
{
	$first_items[] = $feed->get_item($x);
}


// MENSAJERIA
if (isset($_GET['verifica_padres'])) {
	$verifica_padres = $_GET['verifica_padres'];
	mysqli_query($db_con, "UPDATE mensajes SET recibidotutor = '1' WHERE id = $verifica_padres");
}

if (isset($_GET['verifica'])) {
	$verifica = $_GET['verifica'];
	mysqli_query($db_con, "UPDATE mens_profes SET recibidoprofe = '1' WHERE id_profe = '$verifica'");
}

$result_mensajes = mysqli_query($db_con, "SELECT ahora, asunto, texto, profesor, id_profe, origen FROM mens_profes, mens_texto WHERE mens_texto.id = mens_profes.id_texto AND profesor='".$_SESSION['profi']."' AND recibidoprofe=0");
$mensajes_sin_leer = mysqli_num_rows($result_mensajes);
mysqli_free_result($result_mensajes);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Intranet &middot; <?php echo $config['centro_denominacion']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Intranet del <?php echo $config['centro_denominacion']; ?>">
<meta name="author"
	content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">

<!-- BOOTSTRAP CSS CORE -->

<link href="//<?php echo $config['dominio']; ?>/intranet/css/<?php echo (isset($_SESSION['tema'])) ? $_SESSION['tema'] : 'bootstrap.min.css'; ?>" rel="stylesheet">

<!-- CUSTOM CSS THEME -->
<link href="//<?php echo $config['dominio']; ?>/intranet/css/otros.css"
	rel="stylesheet">

<!-- PLUGINS CSS -->
<link
	href="//<?php echo $config['dominio']; ?>/intranet/css/font-awesome.min.css"
	rel="stylesheet">
<link
	href="//<?php echo $config['dominio']; ?>/intranet/js/summernote/summernote.css"
	rel="stylesheet">
<link
	href="//<?php echo $config['dominio']; ?>/intranet/js/datetimepicker/bootstrap-datetimepicker.css"
	rel="stylesheet">
<?php if(isset($PLUGIN_DATATABLES) && $PLUGIN_DATATABLES): ?>
<link
	href="//<?php echo $config['dominio']; ?>/intranet/js/datatables/dataTables.bootstrap.css"
	rel="stylesheet">
<?php endif; ?>
<?php if(isset($PLUGIN_COLORPICKER) && $PLUGIN_COLORPICKER): ?>
<link
	href="//<?php echo $config['dominio']; ?>/intranet/js/colorpicker/css/bootstrap-colorpicker.min.css"
	rel="stylesheet">
<?php endif; ?>
<?php if(isset($_GET['tour']) && $_GET['tour']): ?>
<link
	href="//<?php echo $config['dominio']; ?>/intranet/js/bootstrap-tour/bootstrap-tour.min.css"
	rel="stylesheet">
<?php endif; ?>
</head>
<body>

<nav class="navbar <?php echo (isset($_SESSION['fondo'])) ? $_SESSION['fondo'] : 'navbar-default'; ?> navbar-fixed-top hidden-print" role="navigation">
<div class="container-fluid"><!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse"
	data-target="#navbar"><span class="sr-only">Cambiar navegación</span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> <span
	class="icon-bar"></span></button>
<a class="navbar-brand" href="//<?php echo $config['dominio']; ?>/intranet/"><?php echo $config['centro_denominacion']; ?></a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="navbar">
<ul class="nav navbar-nav">
	<li
	<?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/index.php')) ? 'class="active"' : ''; ?>><a
		href="//<?php echo $config['dominio']; ?>/intranet/index.php">Inicio</a></li>
	<li
	<?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/upload/')) ? 'class="active"' : ''; ?>><a
		href="http://<?php echo $config['dominio'];	?>/intranet/upload/">Documentos</a></li>
	<li><a
		href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio"
		target="_blank">Séneca</a></li>
</ul>

<div class="navbar-right">
<ul class="nav navbar-nav">
	<li class="visible-xs"><a
		href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6">Consejería</a></li>
	<li class="dropdown hidden-xs" id="bs-tour-consejeria"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown" data-bs="tooltip" title="<?php echo $feed->get_title(); ?>" data-placement="bottom" data-container="body"> <span class="fa fa-rss fa-fw"></span> <b class="caret"></b> </a>
		<ul class="dropdown-menu dropdown-feed">
			<li class="dropdown-header"><h5><?php echo ($feed->get_title()) ? $feed->get_title() : 'Novedades - Consejería Educación'; ?></h5></li>
			<li class="divider"></li>
			<?php if (count($first_items)): ?>
			<?php foreach ($first_items as $item): ?>
			<li>
				<a href="<?php echo $item->get_permalink(); ?>">
					<span class="pull-right text-muted"><em><?php echo strftime('%e %b',strtotime($item->get_date('j M Y, g:i a'))); ?></em></span>
					<?php echo $item->get_title(); ?>
				</a>
			</li>
			<li class="divider"></li>
			<?php endforeach; ?>
			<?php else: ?>
			<li><p class="text-center text-muted">Este módulo no está disponible en estos momentos. Disculpen las molestias.</p></li>
			<li class="divider"></li>
			<?php endif; ?>
			<li><a class="text-center"
				href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6" target="_blank"><strong>Ver
			todas las novedades <span class="fa fa-angle-right"></span></strong></a></li>
		</ul>
	</li>
	<li
		class="visible-xs <?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/admin/mensajes/')) ? 'active' : ''; ?>"><a
		href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/index.php">Mensajes</a></li>
	<li class="dropdown hidden-xs" id="bs-tour-mensajes"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown" data-bs="tooltip" title="Mensajes recibidos" data-placement="bottom" data-container="body"> <span
		class="fa fa-envelope fa-fw <?php echo ($mensajes_sin_leer) ? 'text-warning"' : ''; ?>"></span>
	<b class="caret"></b> </a>
	<ul class="dropdown-menu dropdown-messages">
		<li class="dropdown-header"><h5>Últimos mensajes</h5></li>
		<li class="divider"></li>
		<?php $result_mensajes = mysqli_query($db_con, "SELECT ahora, asunto, id, id_profe, recibidoprofe, texto, origen FROM mens_profes, mens_texto WHERE mens_texto.id = mens_profes.id_texto AND profesor='".$_SESSION['profi']."' ORDER BY ahora DESC LIMIT 0, 5"); ?>
		<?php if(mysqli_num_rows($result_mensajes)): ?>
		<?php while ($row_mens = mysqli_fetch_array($result_mensajes)): ?>
		<li><a
			href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/mensaje.php?id=<?php echo $row_mens['id']; ?>&idprof=<?php echo $row['id_profe']; ?>">
		<div
		<?php echo ($row_mens['recibidoprofe']==0) ? 'class="text-warning"' : ''; ?>>
		<span class="pull-right text-muted"><em><?php echo strftime('%e %b',strtotime($row_mens['ahora'])); ?></em></span>
		<strong><?php echo nomprofesor($row_mens['origen']); ?></strong></div>
		<div
		<?php echo ($row_mens['recibidoprofe']==0) ? 'class="text-warning"' : ''; ?>><?php echo substr($row_mens['asunto'],0,96); ?></div>
		</a></li>
		<li class="divider"></li>
		<?php endwhile; ?>
		<?php mysqli_free_result($result_mensajes); ?>
		<?php else: ?>
		<li><p class="text-center text-muted">No tienes mensajes pendientes.</p></li>
		<li class="divider"></li>
		<?php endif; ?>
		<li><a class="text-center" href="//<?php echo $config['dominio']; ?>/intranet/admin/mensajes/"><strong>Ver todos los mensajes <span class="fa fa-angle-right"></span></strong></a></li>
	</ul>
	</li>

	<li class="dropdown" id="bs-tour-usermenu"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"> <span class="fa fa-user fa-fw"></span> <?php echo $idea; ?>
	<b class="caret"></b> </a>
	<ul class="dropdown-menu">
		<li><a href="//<?php echo $config['dominio']; ?>/intranet/clave.php"><i
			class="fa fa-key fa-fw"></i> Cambiar contraseña</a></li>
		<li><a
			href="//<?php echo $config['dominio']; ?>/intranet/admin/fotos/fotos_profes.php"><i
			class="fa fa-camera fa-fw"></i> Cambiar fotografía</a></li>
		<li><a
			href="//<?php echo $config['dominio']; ?>/intranet/xml/jefe/index_temas.php"><i
			class="fa fa-eye fa-fw"></i> Aspecto visual</a></li>	
		<li><a href="//<?php echo $config['dominio']; ?>/intranet/salir.php"><i
			class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
	</ul>
	</li>
</ul>
<p class="navbar-text navbar-link" style="margin-top:7px;margin-bottom:0px;">
	<small><i class="fa fa-clock-o fa-lg"></i> Última conexión:<br class="hidden-xs">
	<?php
	$time = mysqli_query($db_con, "select fecha from reg_intranet where profesor = '".$profi."' order by fecha desc limit 2");
	
	$num = 0;
	while($last = mysqli_fetch_array($time)) {
		$num+=1;
			
		if($num == 2) {
			$t_r0 = explode(" ",$last[0]);
			$dia_hora = cambia_fecha($t_r0[0]);
			echo "$dia_hora &nbsp; $t_r0[1]";
		}
	}
	?></small></p>


</div>

</div>
<!-- /.navbar-collapse --></div>
<!-- /.container-fluid --></nav>