<?
if (isset($_GET['recurso'])) {$recurso = $_GET['recurso'];}elseif (isset($_POST['recurso'])) {$recurso = $_POST['recurso'];}else{$recurso="";}
if (isset($_GET['servicio'])) {$servicio = $_GET['servicio'];}elseif (isset($_POST['servicio'])) {$servicio = $_POST['servicio'];}else{$servicio="";}
if (isset($_GET['mens'])) {$mens = $_GET['mens'];}elseif (isset($_POST['mens'])) {$mens = $_POST['mens'];}else{$mens="";}
if (isset($_GET['servicio_aula'])) {$servicio_aula = $_GET['servicio_aula'];}elseif (isset($_POST['servicio_aula'])) {$servicio_aula = $_POST['servicio_aula'];}else{$servicio_aula="";}
?>

	<div class="container">
		
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php?recurso=aula')==TRUE) ? ' class="active"' : ''; ?>><a href="http://<?php echo $dominio; ?>/intranet/reservas/index.php?recurso=aula">Aulas compartidas</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index_aula.php?recurso=aula_grupo')==TRUE) ? ' class="active"' : ''; ?>><a href="http://<?php echo $dominio; ?>/intranet/reservas/index_aula.php?recurso=aula_grupo">Aulas de grupo</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php?recurso=carrito')==TRUE) ? ' class="active"' : ''; ?>><a href="http://<?php echo $dominio; ?>/intranet/reservas/index.php?recurso=carrito">Carritos TIC</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php?recurso=medio')==TRUE) ? ' class="active"' : ''; ?>><a href="http://<?php echo $dominio; ?>/intranet/reservas/index.php?recurso=medio">Medios audiovisuales</a></li>
		</ul>
		
	</div>
