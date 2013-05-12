<div class="widget widget-nopad stacked visible-desktop">
						
	<div class="widget-header">
		<i class="icon icon-search"></i>
		<h3>Buscar alumnos</h3>
	</div> <!-- /widget-header -->
	
	<div class="widget-content">
		
		<form class="buscarAlumnos" action="admin/datos/datos.php" method="GET">
			<input name="buscarAlumnos" type="text" class="input-block-level" id="buscarAlumnos" onkeyup="javascript:buscar('search-results',this.value);" placeholder="Buscar alumnos...">
		</form>
		
		<div id="search-results"></div>
		
	</div> <!-- /widget-content -->
	
</div> <!-- /widget -->	