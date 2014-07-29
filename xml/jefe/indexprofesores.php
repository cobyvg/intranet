<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
session_destroy();
header("location:http://$dominio/intranet/salir.php");	
exit;
}
registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);
$profe = $_SESSION['profi'];
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
header("location:http://$dominio/intranet/salir.php");
exit;	
}

include("../../menu.php");
?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Importación de profesores</small></h2>
	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="profesores.php">
					<fieldset>
						<legend>Importación de profesores</legend>
						
						<div class="form-group">
						  <label for="archivo"><span class="text-info">RelMatProUni.txt</span></label>
						  <input type="file" id="archivo" name="archivo" accept="text/plain">
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Importar</button>
					  <a class="btn btn-default" href="../index.php">Cancelar</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Este apartado se encarga de importar la relación de <strong>profesores, aulas y asignaturas</strong> que imparten. Esto permitirá comprobar incoherencias en el horario de Horw y Séneca.</p>
			
			<p>Para obtener el archivo de exportación de alumnos debe dirigirse al apartado <strong>Personal</strong>, <strong>Personal del centro</strong>, <strong>Unidades y materias</strong> <em>(icono arriba a la derecha)</em>. Muestre todos los profesores y haga clic en el botón <strong>Exportar datos</strong>. El formato de exportación debe ser <strong>Texto plano</strong>.</p>

		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
