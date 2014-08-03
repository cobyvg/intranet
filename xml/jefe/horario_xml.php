<?
session_start();
include("../../config.php");
if($_SESSION['autentificado']!='1')
{
	session_destroy();
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

if($_SESSION['cambiar_clave']) {
	header('Location:'.'http://'.$dominio.'/intranet/clave.php');
}

registraPagina($_SERVER['REQUEST_URI'],$db_host,$db_user,$db_pass,$db);


if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}
?>
<?
if(!(stristr($_SESSION['cargo'],'1') == TRUE))
{
	header("location:http://$dominio/intranet/salir.php");
	exit;
}

//echo $mens;
if(isset($_POST['enviar'])){	
	
	$uploads_dir = '../../varios/';
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["archivo"]["tmp_name"];
        $name = $_FILES["archivo"]["name"];
        move_uploaded_file($tmp_name, $uploads_dir.$name);
    }
$dep = $_POST['depurar'];	
header("Location:"."exportarHorariosSeneca.php?horarios=1&archivo_origen=$name&depurar=$dep"); 
break;
	}
	

include("../../menu.php");

?>


<div class="container">
	
	<!-- TITULO DE LA PAGINA -->
	<div class="page-header">
		<h2>Administración <small>Preparación de la importación del horario a Séneca</small></h2>
	</div>
	
	<!-- SCAFFOLDING -->
	<div class="row">
	
		<!-- COLUMNA IZQUIERDA -->
		<div class="col-sm-6">
			
			<div class="well">
				
				<form enctype="multipart/form-data" method="post" action="">
					<fieldset>
						<legend>Preparación de la importación del horario a Séneca</legend>
						
						<div class="form-group">
						  <label for="archivo"><span class="text-info">ExportacionHorarios.xml</span></label>
						  <input type="file" id="archivo" name="archivo" accept="text/xml">
						</div>
						
						<div class="checkbox">
						  <label>
						  	<input type="checkbox" id="depurar" name="depurar">
						  	Modo depuración
						  </label>
						</div>
						
						<br>
						
					  <button type="submit" class="btn btn-primary" name="enviar">Aceptar</button>
					  <a class="btn btn-default" href="../index.php">Cancelar</a>
				  </fieldset>
				</form>
				
			</div><!-- /.well -->
			
		</div><!-- /.col-sm-6 -->
		
		
		<div class="col-sm-6">
			
			<h3>Información sobre la importación</h3>
			
			<p>Este módulo se encarga de preparar el archivo de importación que genera la aplicación de horarios para subirlo a Séneca, evitando tener que registrar manualmente los horarios de cada profesor. La adaptación que realiza este módulo es conveniente, ya que la compatibilidad con Séneca de los generadores de horarios tiene limitaciones (código único de las asignaturas de Bachillerato, Diversificación, etc.). Es necesario tener el fichero en formato XML que se exporta desde Horw.</p>
			
			<p>La opción <strong>Modo depuración</strong> permite ver los mensajes de error y advertencias que afectan al horario de Horw. También se mostrará los cambios que se han realizado para adaptado a las necesidades de Séneca. Es conveniente consultar los cambios antes de subir el horario a Séneca. Si la opción está marcada no generará ningún fichero de descarga.</p>
			
		</div>
		
	
	</div><!-- /.row -->
	
</div><!-- /.container -->
  
<?php include("../../pie.php"); ?>
	
</body>
</html>
