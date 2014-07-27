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
 include("menu.php");
 ?>
<br />
<div align="center">
<div class="page-header">
  <h2>Biblioteca del centro <small> Importación de datos desde Abbies</small></h2>
</div>
</div>
<div class="container-fluid">
<div class="row">
<div class='well col-sm-4'>  
<p class='lead text-info'>Catálogo de Fondos</p>
	<form enctype="multipart/form-data" action="importa_biblio.php" method="post">
				<div class="form-group">
				<div class="controls">
  				<input type="file" name="archivo1" class="input input-file col-sm-4" id="file">
  				</div>
				</div>
				<hr />
           		<input class='btn btn-primary btn-block' type="submit" name="enviar1" value="Aceptar" />
    </form>
   <p>La importación de los Fondos de la Biblioteca permite consultar en la Intranet, pero también en la página pública del Centro, los fondos de la Biblioteca del Centro.  El archivo que se solicita es el informe del <b>Catálogo</b> que 
	genera el programa Abbies siguiendo los siguientes pasos:</p>
	<ul class="">
	<li>En Abbies vamos a Catalogo-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes: Autor, Titulo, Editorial, ISBN, TipoFondo, anoEdicion, extension, serie, lugaredicion, tipoEjemplar, Ubicacion. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
	</ul>
	<hr />
</div>
<div class='well col-sm-4'>      
<p class='lead text-info'>Lectores de la Biblioteca</p>        
	<form enctype="multipart/form-data" action="importa_biblio.php" method="post">
				<div class="form-group">
				<div class="controls">
  				<input type="file" name="archivo2" class="input input-file col-sm-4" id="file">
  				</div>
				</div>
				<hr />
           		<input class='btn btn-primary btn-block' type="submit" name="enviar2" value="Aceptar" />
    </form>
            <p>La importación de los Lectores permite incorporar el codigo del alumno en su Carnet, de tal modo que se pueda utilizar el Carnet también en la Biblioteca del Centro. El archivo que se solicita es el informe  de <b>Lectores</b> que 
	genera el programa Abbies siguiendo los siguientes pasos:</p>
	<ul class="">
	<li>En Abbies vamos a Lectores-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes: Código, DNI, Apellidos, Nombre, Grupo. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
	</ul>
	<p class="text-warning">Es importante tener en cuenta que al importar los <b>Lectores de la Biblioteca</b> a la Base de datos, <em><b>el Carnet del Alumno 
	incorporará	el Código de la Biblioteca tras el NIE</b></em>. De este modo, se genera un Carnet que es válido también para su suo en la Biblioteca del Centro.
	</p>
	<hr />
</div>
<div class=" well col-sm-4">
<p class='lead text-info'>Préstamos de Ejemplares</p>
<FORM ENCTYPE="multipart/form-data" ACTION="morosos.php" METHOD="post" class="form-inline">
  <input type="file" name="archivo">
  <hr>
  <div align="center">
    <INPUT type="submit" name="enviar" value="Aceptar" class="btn btn-primary btn-block">
  </div>
  <br />
    <div  class="form-group success" style="width:auto;">
             <p>La importación de los Préstamos de ejemplares permite gestionar las Devoluciones de los libros como asuntos de Disciplina (considerar elretraso en la devolución como falta grave, enviar SMS de advertencia, etc.) en <em>Gestón de Préstamos</em>.El archivo que se solicita es el informe  de <b>Préstamos</b> que 
	genera el programa Abbies siguiendo los siguientes pasos:</p>
	<ul class="">
	<li>En Abbies vamos a Préstamos-Informes y una vez en el asistente de creación de informes pulsamos Siguiente.</li>
	<li>Seleccionamos de la lista de campos disponibles los siguientes: Curso, Apellidos, Nombre, Título, Devolución. Pulsamos Siguiente.</li>
	<li>En la siguiente pantalla elegimos "Archivo de Texto (campos delimitados) dejando el punto y coma como delimitador. Siguiente.</li>
	<li>Esta pantalla podemos dejarla como está y pulsamos Siguiente.</li>
	<li>Finalizamos guardando el documento generado en formato .txt.</li>
	</ul>
	
  </div>
  </div>
</FORM>
<?php include('../../pie.php');?>