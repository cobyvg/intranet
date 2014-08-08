	<div class="container">
			
		<ul class="nav nav-tabs">
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'inbox=recibidos')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php?inbox=recibidos">Mensajes recibidos</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'inbox=enviados')==TRUE) ? ' class="active"' : ''; ?>><a href="index.php?inbox=enviados">Mensajes enviados</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'redactar.php')==TRUE) ? ' class="active"' : ''; ?>><a href="redactar.php">Redactar mensaje</a></li>
			<li<?php echo (strstr($_SERVER['REQUEST_URI'],'correo.php')==TRUE) ? ' class="active"' : ''; ?>><a href="correo.php">Redactar correo</a></li>
		</ul>
		
	</div>
