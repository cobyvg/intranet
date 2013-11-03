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
if(stristr($_SESSION['cargo'],'1') == TRUE or stristr($_SESSION['cargo'],'c') == TRUE){}
else
{
header("location:http://$dominio/intranet/salir.php");
exit;
}  
?>
<?php
 include("../../menu.php");
?>
<br />
<div align="center">
<div class="page-header">
  <h2>Biblioteca del centro <small> Importación de libros desde Abbies</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row-fluid">
<div class='well well-large span6 offset3'>          
            <p>El archivo que se solicita es el informe en modo texto con delimitadores que 
	genera el programa Abbies siguiendo los siguientes pasos:</p>
	<ul class="text-info">
	<li>En Abbies vamos a Catalogo-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes: Autor, Titulo, Editorial, ISBN, TipoFondo, anoEdicion, extension, serie, lugaredicion, tipoEjemplar, Ubicacion. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
	<li>Para que el informe se pueda importar se deben borrar los datos que aparecen al principio del texto y asegurarse que cada registro termina con el fin de línea (LF). Esto se debe realizar con un editor de textos potente. 
	</ul>
	<hr />
	<form enctype="multipart/form-data" action="importa_biblio.php" method="post">
				<div class="control-group">
				<label class="control-label" for="archivo">Archivo de datos:</label>
				<div class="controls">
  				<input type="file" name="archivo" class="input input-file span4" id="file">
  				</div>
				</div>
				<hr />
           		<input class='btn btn-primary btn-block' type="submit" name="enviar" value="Aceptar" />
    </form>
</div>
<?php include('../../pie.php');?>