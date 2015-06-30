<div class="container">

	<ul class="nav nav-tabs">
		<li<?php echo ((strstr($_SERVER['REQUEST_URI'],'intextos.php') == true)) ? ' class="active"' : '' ; ?>><a href="intextos.php">Nuevo libro de texto</a></li>
		<li<?php echo ((strstr($_SERVER['REQUEST_URI'],'consulta') == true)) ? ' class="active"' : '' ; ?>> <a href="consulta.php">Consultar libros</a></li>
	</ul>
	
</div>
      