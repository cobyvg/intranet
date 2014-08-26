<div class="container">

	<ul class="nav nav-tabs" role="tablist">
	  <li<?php echo (strstr($_SERVER['REQUEST_URI'],'index')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php">Evaluar una unidad</a></li>
	  <li<?php echo (strstr($_SERVER['REQUEST_URI'],'consulta')==TRUE) ? ' class="active"' : ''; ?>><a href="consulta.php">Consultar sesiones</a></li>
	</ul>
	
</div>