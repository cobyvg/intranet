<div class="container">

	<ul class="nav nav-tabs">
			<!-- Button trigger modal --> <a href="#"
	class="btn btn-default btn-sm pull-right" data-toggle="modal"
	data-target="#myModal"> <span class="fa fa-question fa-lg"></span> </a>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span
	aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title" id="myModalLabel">Información sobre los Libros de Texto del Departamento</h4>
</div>
<div class="modal-body">
<p>
Los Jefes de Departamento utilizan este formulario para registrar los Libros de Texto que afectan a sus asignaturas en los distintos Niveles o Grupos de alumnos. <br>
Seleccionamos el Nivel y, en su caso, los Grupos correspondientes. Los campos del formulario marcados con un asterisco rojo son obligatorios.<br>
Los Libros de Texto pueden ser consultados por todos los profesores dentro de la Intranet, pero también se trasladan a la Página del Centro, desde la cual pueden ser consultados por las Librerías y los Padres de los alumnos. La consulta puede realizarse por Nivel o por Departamento.
</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
		<li<?php echo ((strstr($_SERVER['REQUEST_URI'],'intextos.php') == true)) ? ' class="active"' : '' ; ?>><a href="intextos.php">Nuevo libro de texto</a></li>
		<li<?php echo ((strstr($_SERVER['REQUEST_URI'],'consulta') == true)) ? ' class="active"' : '' ; ?>> <a href="consulta.php">Consultar libros</a></li>
	</ul>
	
</div>
      