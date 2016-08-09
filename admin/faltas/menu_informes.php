<?php defined('INTRANET_DIRECTORY') OR exit('No direct script access allowed'); ?>

<div class="hidden-print">
	
	<ul class="nav nav-tabs">
		<li<?php echo (strstr($_SERVER['REQUEST_URI'],'informe_profesores.php')==TRUE) ? ' class="active"' : ''; ?>><a href="informe_profesores.php">Profesores</a></li>
		<li<?php echo (strstr($_SERVER['REQUEST_URI'],'informe_grupos')==TRUE) ? ' class="active"' : ''; ?>><a href="informe_grupos.php">Grupos</a></li>
		<li<?php echo (strstr($_SERVER['REQUEST_URI'],'informe_materias.php')==TRUE) ? ' class="active"' : ''; ?>><a href="informe_materias.php">Asignaturas</a></li>
	</ul>

</div>
