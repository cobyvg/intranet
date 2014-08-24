<?php include("funciones.php"); ?>
<?php $idea = $_SESSION['ide']; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Intranet &middot; <?php echo $nombre_del_centro; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Intranet del <? echo $nombre_del_centro; ?>">
<meta name="author"
	content="IESMonterroso (https://github.com/IESMonterroso/intranet/)">

<!-- BOOTSTRAP CSS CORE -->
<link href="http://<? echo $dominio;?>/intranet/css/bootstrap.min.css"
	rel="stylesheet">

<!-- CUSTOM CSS THEME -->
<link href="http://<? echo $dominio;?>/intranet/css/otros.css"
	rel="stylesheet">

<!-- PLUGINS CSS -->
<link
	href="http://<? echo $dominio;?>/intranet/css/font-awesome.min.css"
	rel="stylesheet">
<link
	href="http://<? echo $dominio;?>/intranet/js/summernote/summernote.css"
	rel="stylesheet">
<link
	href="http://<? echo $dominio;?>/intranet/js/datetimepicker/bootstrap-datetimepicker.css"
	rel="stylesheet">
<?php if(isset($PLUGIN_DATATABLES) && $PLUGIN_DATATABLES): ?>
<link
	href="http://<? echo $dominio;?>/intranet/js/datatables/dataTables.bootstrap.css"
	rel="stylesheet">
<?php endif; ?>

</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top hidden-print"
	role="navigation">
<div class="container-fluid"><!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse"
	data-target="#navbar"><span class="sr-only">Cambiar navegación</span> <span
	class="icon-bar"></span> <span class="icon-bar"></span> <span
	class="icon-bar"></span></button>
<a class="navbar-brand" href="http://<?php echo $dominio; ?>/intranet/"><?php echo $nombre_del_centro; ?></a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="navbar">
<ul class="nav navbar-nav">
	<li
	<?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/index.php')) ? 'class="active"' : ''; ?>><a
		href="http://<? echo $dominio;?>/intranet/index.php">Inicio</a></li>
	<li
	<?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/upload/')) ? 'class="active"' : ''; ?>><a
		href="http://<? echo $dominio;	?>/intranet/upload/">Documentos</a></li>
	<li><a
		href="https://www.juntadeandalucia.es/educacion/portalseneca/web/seneca/inicio"
		target="_blank">Séneca</a></li>
</ul>

<div class="navbar-right">
<ul class="nav navbar-nav">
	
	<?php if (strstr($_SERVER['REQUEST_URI'],'intranet/index.php')==TRUE): ?>
	<?php
	include ("magpierss/rss_fetch.inc");
	define ( "MAGPIE_CACHE_ON", 1 );
	define ( "MAGPIE_CACHE_AGE", 60*60 );
	//define('MAGPIECACHEDIR', './cache')
	$url = "http://www.juntadeandalucia.es/educacion/www/novedades.xml";
	$num_items = 5;
	$rss = fetch_rss ( $url );
	$items = array_slice ( $rss->items, 0, $num_items );
	?>
	<li class="visible-xs"><a
		href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6">Consejería</a></li>
	<li class="dropdown hidden-xs"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown" rel="tooltip" title="<?php echo $rss->channel['title']; ?>" data-placement="bottom" data-container="body"> <span class="fa fa-rss fa-fw"></span> <b class="caret"></b> </a>
		<ul class="dropdown-menu dropdown-feed">
			<li class="dropdown-header"><h5><?php echo $rss->channel['title']; ?></h5></li>
			<li class="divider"></li>
			<?php foreach ($items as $item): ?>
			<li>
				<a href="<?php echo $item['link']; ?>">
					<span class="pull-right text-muted"><em><?php echo strftime('%e %b',strtotime($item['pubdate'])); ?></em></span>
					<?php echo $item['title']; ?>
				</a>
			</li>
			<li class="divider"></li>
			<?php endforeach; ?>
			<li><a class="text-center"
				href="http://www.juntadeandalucia.es/educacion/nav/navegacion.jsp?lista_canales=6" target="_blank"><strong>Ver
			todas las novedades <span class="fa fa-angle-right"></span></strong></a></li>
		</ul>
	</li>
	<?php endif; ?>
	
<?php
// Comprobamos mensajes sin leer
$result_mensajes = mysql_query("SELECT ahora, asunto, texto, profesor, id_profe, origen FROM mens_profes, mens_texto WHERE mens_texto.id = mens_profes.id_texto AND profesor='".$_SESSION['profi']."' AND recibidoprofe=0");
$mensajes_sin_leer = mysql_num_rows($result_mensajes);
mysql_free_result($result_mensajes);
?>
	<li
		class="visible-xs <?php echo (strstr($_SERVER['REQUEST_URI'],'intranet/admin/mensajes/')) ? 'active' : ''; ?>"><a
		href="http://<? echo $dominio;?>/intranet/admin/mensajes/index.php">Mensajes</a></li>
	<li class="dropdown hidden-xs"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown" rel="tooltip" title="Mensajes recibidos" data-placement="bottom" data-container="body"> <span
		class="fa fa-envelope fa-fw"></span>
	<b class="caret"></b> </a>
	<ul class="dropdown-menu dropdown-messages">
	<?php $result_mensajes = mysql_query("SELECT ahora, asunto, id, id_profe, recibidoprofe, texto, origen FROM mens_profes, mens_texto WHERE mens_texto.id = mens_profes.id_texto AND profesor='".$_SESSION['profi']."' ORDER BY ahora DESC LIMIT 0, 5"); ?>
	<?php if(mysql_num_rows($result_mensajes)): ?>
	<?php while ($row = mysql_fetch_array($result_mensajes)): ?>
		<li><a
			href="http://<?php echo $dominio; ?>/intranet/admin/mensajes/mensaje.php?id=<?php echo $row['id']; ?>&idprof=<?php echo $row['id_profe']; ?>">
		<div
		<?php echo ($row['recibidoprofe']==0) ? 'class="text-warning"' : ''; ?>>
		<span class="pull-right text-muted"><em><?php echo strftime('%e %b',strtotime($row['ahora'])); ?></em></span>
		<strong><?php echo $row['origen']; ?></strong></div>
		<div
		<?php echo ($row['recibidoprofe']==0) ? 'class="text-warning"' : ''; ?>><?php echo $row['asunto']; ?></div>
		</a></li>
		<li class="divider"></li>
		<?php endwhile; ?>
		<?php mysql_free_result($result_mensajes); ?>
		<?php endif; ?>
		<li><a class="text-center"
			href="http://<?php echo $dominio; ?>/intranet/admin/mensajes/"><strong>Ver
		todos los mensajes <span class="fa fa-angle-right"></span></strong></a></li>
	</ul>
	</li>

	<li class="dropdown"><a href="#" class="dropdown-toggle"
		data-toggle="dropdown"> <span class="fa fa-user fa-fw"></span> <? echo $idea; ?>
	<b class="caret"></b> </a>
	<ul class="dropdown-menu">
		<li><a href="http://<? echo $dominio; ?>/intranet/clave.php"><i
			class="fa fa-key fa-fw"></i> Cambiar contraseña</a></li>
		<li><a
			href="http://<? echo $dominio; ?>/intranet/admin/fotos/fotos_profes.php"><i
			class="fa fa-camera fa-fw"></i> Cambiar fotografía</a></li>
		<li><a href="http://<? echo $dominio;?>/intranet/salir.php"><i
			class="fa fa-sign-out fa-fw"></i> Cerrar sesión</a></li>
	</ul>
	</li>
</ul>
<p class="navbar-text navbar-link" style="margin-top:7px;margin-bottom:0px;">
	<small><i class="fa fa-clock-o fa-lg"></i> Última conexión:<br class="hidden-xs">
	<?php
	$time = mysql_query("select fecha from reg_intranet where profesor = '".$_SESSION['profi']."' order by fecha desc limit 2");

	while($last = mysql_fetch_array($time)) {
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