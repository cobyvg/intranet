<h3><span class="fa fa-search fa-fw"></span> Buscar...</h3>

<form action="admin/noticias/buscar.php" method="POST">
	<input name="expresion" type="text" class="form-control" id="buscarAlumnos" onkeyup="javascript:buscar('resAlumnos',this.value);" placeholder="Buscar...">
</form>
<div id="resAlumnos"></div>