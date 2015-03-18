	<div class="container hidden-print">
	
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'index.php')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php">Nueva incidencia</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'incidencias.php')==TRUE) ? ' class="active"' : ''; ?>><a href="incidencias.php">Listado de incidencias</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'perfiles_alumnos.php')==TRUE) ? ' class="active"' : ''; ?>><a href="perfiles_alumnos.php">Perfiles alumnos</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'perfiles_profesores.php')==TRUE) ? ' class="active"' : ''; ?>><a href="perfiles_profesores.php">Perfiles profesores</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'protocolo.php')==TRUE) ? ' class="active"' : ''; ?>><a href="protocolo.php">Protocolo de uso</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'estadisticas.php')==TRUE) ? ' class="active"' : ''; ?>><a href="estadisticas.php">Estadísticas TIC</a></li>
		</ul>
		
	</div>
